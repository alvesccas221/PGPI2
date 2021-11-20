<?php

if (!defined('WC_VAT_COMPLIANCE_DIR')) die('No direct access');

// Purpose: provide a report on VAT paid, using the configured reporting currencies and exchange rates

if (!class_exists('WC_VAT_Compliance_Reports_UI')) require_once(WC_VAT_COMPLIANCE_DIR.'/includes/reports-ui.php');

class WC_EU_VAT_Compliance_Reports extends WC_VAT_Compliance_Reports_UI {

	// Public: is used in the CSV download code
	public $reporting_currency = '';
	public $conversion_providers = array();
	protected $reporting_currencies = array();
	public $last_rate_used = 1;
	protected $fallback_conversion_rates = array();
	protected $fallback_conversion_providers = array();
	
	public $chart_groupby;
	
	protected $pre_wc22_order_parsed = array();
	
	// Public: Used in HMRC reporting
	public $format_num_decimals;

	public $start_date;
	public $end_date;

	/**
	 * Class constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get the total sales to the indicated VAT region in the year-to-date (excluding sales to the base country; i.e. cross-border sales only)
	 *
	 * @param String  $vat_region_code
	 * @param Boolean $can_use_transient - set to 'false' to force updating of the transient
	 *
	 * @return Array - keyed in a similar way to self::get_tabulated_results() - the first keys are the month (numeric, starting from 1), then order status codes, then country codes, then currency codes, then tax codes, then tax details (vat, vat_shipping, sales, vat_refunded)
	 */
	public function get_year_to_date_region_totals($vat_region_code, $can_use_transient = true) {
	
		$current_time = current_time('timestamp');
	
		$end = date('Y-m-d', 86400 + $current_time);

		$transient_key = 'wc_vat_year_to_date_'.$vat_region_code;
		
		if ($can_use_transient) {
			$transient_value = get_transient($transient_key);
			if (is_array($transient_value) && $transient_value['end'] == $end && isset($transient_value['results'])) {
				return $transient_value['results'];
			}
		}
		
		$this_year = (int) date('Y', $current_time);
		$this_month = (int) date('m', $current_time);
		
		$data_by_months = array();
		$results = array();
		
		$compliance = WooCommerce_EU_VAT_Compliance();
		$region_object = $compliance->get_vat_region_object($vat_region_code);
		$region_country_codes = $region_object->get_countries();
		
		// By default, unlisted statuses are included, on the assumption that when a shop adds its own manual statuses, these are post-payment statuses.
		$skip_statuses = apply_filters('wc_vat_compliance_report_year_to_date_totals_exclude_statuses', array('pending', 'cancelled', 'refunded', 'failed', 'authentication_required'));
		
		$keys_to_add = array('vat', 'vat_shipping', 'sales', 'vat_refunded');
		
		// We go in units of months to reduce the risk of timing out due to excessive data in one go
		for ($month = 1; $month <= $this_month; $month++) {
			$month_transient_key = $transient_key.$this_year.$month;
			$month_transient_value = get_transient($month_transient_key);
			if (is_array($month_transient_value)) {
				$data_by_months[$month] = $month_transient_value;
				continue;
			}
			// No transient data found; need to fetch it
			$month_start = date('Y-'.sprintf('%02d', $month).'-01', $current_time);
			$month_end = date('Y-'.sprintf('%02d', $month).'-'.sprintf('%02d', cal_days_in_month(CAL_GREGORIAN, $month, $this_year)));
			$month_results = $this->get_tabulated_results($month_start, $month_end, 'taxation');
			
			foreach ($month_results as $status => $status_results) {
				if (in_array($status, $skip_statuses)) {
					unset($month_results[$status]);
					continue;
				}
				foreach ($status_results as $country_code => $country_results) {
					if (!in_array($country_code, $region_country_codes)) {
						unset($status_results[$country_code]);
						$month_results[$status] = $status_results;
					}
				}
			}
			
			$data_by_months[$month] = $month_results;
			// We cache for longer the further back it goes, as the further in the past, the less likely a refund or other change is. Shop owners can always trigger a full recalculation by clearing all transients.
			$transient_expiry = ($month == $this_month) ? 40000 : (($month == $this_month - 1) ? 80000 : 172800);
			set_transient($month_transient_key, $month_results, 86400);
			
			// Now, amalgamate the results into the final results (this isn't really necessary now that we key by month
			foreach ($month_results as $status => $status_results) {
				foreach ($status_results as $country_code => $country_results) {
					foreach ($country_results as $currency_code => $currency_results) {
						foreach ($currency_results as $tax_code => $tax_details) {
						
							if (!isset($results[$month][$status][$country_code][$currency_code][$tax_code])) {
								$default = array();
								foreach ($keys_to_add as $key) {
									$default[$key] = 0;
								}
								$results[$month][$status][$country_code][$currency_code][$tax_code] = $default;
							}
							
							foreach ($keys_to_add as $key) {
								if (!isset($tax_details[$key])) continue;
								$results[$month][$status][$country_code][$currency_code][$tax_code][$key] += $tax_details[$key];
							}
						}
					}
				}
			}
			
		}
		
		// Though it can be used until then, hopefully 
		set_transient($transient_key, array('end' => $end, 'results' => $results), 86400);
		
		return $results;
	
	}
	
	/**
	 * Get data on taxes paid, by tax type, on items within the specified range for the specified status
	 *
	 * @param String $start_date
	 * @param String $end_date
	 * @param String $status
	 *
	 * @return Array
	 */
	protected function get_items_data($start_date, $end_date, $status) {
		global $wpdb;

		$fetch_more = true;
		$page = 0;
		$page_size = defined('WC_VAT_COMPLIANCE_ITEMS_PAGE_SIZE') ? WC_VAT_COMPLIANCE_ITEMS_PAGE_SIZE : 2880;

		$found_items = array();
		$final_results = array();
		
		$current_order_id = false;
		$current_order_item_id = false;
		$current_total = false;
		$current_line_tax_data = false;
		$subscriptio_potential_bug_case = false;

		while ($fetch_more) {
			$page_start = $page_size * $page;
			$results_this_time = 0;
			$sql = $this->get_items_sql($page_start, $page_size, $start_date, $end_date, $status);
			if (empty($sql)) break;
			$results = $wpdb->get_results($sql);
			if (!empty($results)) {
				$page++;

				foreach ($results as $r) {
					// Don't check on empty($r->v) - this causes orders 100% discounted (_line_total = 0) to be detected as non-WC-2.2 orders, as $current_total then never gets off (bool)false.
					if (empty($r->ID) || empty($r->k) || empty($r->oi)) continue;

					if ($r->oi != $current_order_item_id && $current_order_item_id !== false) {
						// A new order has begun: process the previous order
						$final_results = $this->add_order_to_final_results($final_results, $current_order_id, $current_line_tax_data, $current_total, $subscriptio_potential_bug_case);
					}
					
					$current_order_id = $r->ID;
					$current_order_item_id = $r->oi;
					
					if (!isset($found_items[$current_order_id][$current_order_item_id])) {
						$current_total = false;
						$current_line_tax_data = false;
						$found_items[$current_order_id][$current_order_item_id] = true;
						$subscriptio_potential_bug_case = false;
					}

					if ('_line_total' == $r->k) {
						$current_total = $r->v;
					} elseif ('_line_tax_data' == $r->k) {
						$current_line_tax_data = maybe_unserialize($r->v);
						// Don't skip - we want to know that some data was there (detecting pre-WC2.2 orders)
// 						if (empty($current_line_tax_data['total'])) continue;
					} elseif ('_line_tax' == $r->k) {
						// Added 9-Jan-2016 - the only use of this meta key/value is to detect a problem with Subscriptio (up to at least 2.1.3). If that is ever fixed, this can be removed (and the SELECTing of this key removed from the get_items_sql() method of this class, to improve performance).
						// Subscriptio can blank this out this value in repeat orders (instead of numerical zero), or put a zero
						// Only 'potential' at this stage, because what we're detecting ultimately is a missing _line_tax_data line - which is irrelevant if there was zero tax, and not something that needs warning about. Note that this will also cause the warning to suppress for actual pre-WC-2.2 orders; which is fine, as there's no need to worry the user about something that made no difference.
						$subscriptio_potential_bug_case = empty($r->v) ? true : false;
					}

				}
				
			} else {
				$fetch_more = false;
			}
			
		}
		
		if (false !== $current_order_item_id) $final_results = $this->add_order_to_final_results($final_results, $current_order_id, $current_line_tax_data, $current_total, $subscriptio_potential_bug_case);

		// Parse results further
		foreach ($found_items as $order_id => $order_items) {
			if (!isset($final_results[$order_id])) {
				$this->pre_wc22_order_parsed[] = $order_id;
			}
		}

		return $final_results;

	}

	protected function add_order_to_final_results($final_results, $current_order_id, $current_line_tax_data, $current_total, $subscriptio_potential_bug_case = false) {
	
		if (false !== $current_total && is_array($current_line_tax_data)) {
			$total = $current_line_tax_data['total'];
			if (empty($total)) {
				// Record something - it's used to confirm that all orders had data, later
				if (!isset($final_results[$current_order_id])) $final_results[$current_order_id] = array();
			} else {
				foreach ($total as $tax_rate_id => $item_amount) {
// 							if (!isset($final_results[$tax_rate_id])) $final_results[$tax_rate_id] = 0;
// 							$final_results[$tax_rate_id] += $current_total;
					// Needs to still be broken down by ID so that it can then be linked back to country
					if (!isset($final_results[$current_order_id][$tax_rate_id])) $final_results[$current_order_id][$tax_rate_id] = 0;
					$final_results[$current_order_id][$tax_rate_id] += $current_total;
				}
			}
		} elseif (false === $current_line_tax_data && !empty($subscriptio_potential_bug_case)) {
			// Set this, so that the "order from WC 2.1 or earlier (and hence no detailed tax data)" warning isn't triggered
			if (!isset($final_results[$current_order_id])) $final_results[$current_order_id] = array();
		}
	
		return $final_results;
	}
	
	// WC 2.2+ only (the _line_tax_data itemmeta only exists here)
	protected function get_items_sql($page_start, $page_size, $start_date, $end_date, $status) {

		global $table_prefix, $wpdb;

		// '_order_tax_base_currency', '_order_total_base_currency', 
// 			,item_meta.meta_key

		// N.B. 2016-Jan-09: The '_line_tax' meta key was added to enable detection of zero-tax repeat orders created by Subscriptio - because Subscriptio erroneously blanks the _line_tax (instead of putting (int)0), and fails to copy the _line_tax_data array (which leads to the order being wrongly detected as a pre-WC-2.2 order)
		$sql = "SELECT
			orders.ID
			,items.order_item_id AS oi
			,item_meta.meta_key AS k
			,item_meta.meta_value AS v
		FROM
			".$wpdb->posts." AS orders
		LEFT JOIN
			${table_prefix}woocommerce_order_items AS items ON
				(orders.ID = items.order_id)
		LEFT JOIN
			${table_prefix}woocommerce_order_itemmeta AS item_meta ON
				(item_meta.order_item_id = items.order_item_id)
		WHERE
			(orders.post_type = 'shop_order')
			AND orders.post_status = 'wc-$status'
			AND orders.post_date >= '$start_date 00:00:00'
			AND orders.post_date <= '$end_date 23:59:59'
			AND items.order_item_type = 'line_item'
			AND item_meta.meta_key IN('_line_tax_data', '_line_total', '_line_tax')
		ORDER BY orders.ID ASC
		LIMIT $page_start, $page_size
		";

		if (!$sql) return false;

		return $sql;
	}

	// WC 2.2+ only (the _line_tax_data itemmeta only exists here, and order refunds were a new feature in 2.2)
	protected function get_refunds_sql($page_start, $page_size, $start_date, $end_date, $order_status = false) {

		global $table_prefix, $wpdb;

// , '_refunded_item_id'

		// '_order_tax_base_currency', '_order_total_base_currency', 
// 			,item_meta.meta_key
// 			orders.ID
// 			,items.order_item_type AS ty

		// This does not work: refunds *always* have order status wc-completed: they do *not* reflect the order status of the parent order.
// 		$status_extra = ($order_status !== false) ? "\t\t\tAND orders.post_status = 'wc-$order_status'" : '';
		$status_extra = '';

		// N.B. The secondary sorting by oid is relied upon by the consumer
		$sql = "SELECT
			orders.post_parent AS id
			,items.order_item_id AS oid
			,item_meta.meta_key AS k
			,item_meta.meta_value AS v
		FROM
			".$wpdb->posts." AS orders
		LEFT JOIN
			${table_prefix}woocommerce_order_items AS items ON
				(orders.ID = items.order_id)
		LEFT JOIN
			${table_prefix}woocommerce_order_itemmeta AS item_meta ON
				(item_meta.order_item_id = items.order_item_id)
		WHERE
			(orders.post_type = 'shop_order_refund')
			AND orders.post_date >= '$start_date 00:00:00'
			$status_extra
			AND orders.post_date <= '$end_date 23:59:59'
			AND item_meta.meta_key IN('tax_amount', 'shipping_tax_amount', 'rate_id')
			AND items.order_item_type IN('tax')
			AND item_meta.meta_value != '0'
		ORDER BY
			id ASC, oid ASC, v ASC
		";

		if ($page_start !== false && $page_size !== false) $sql .= "		LIMIT $page_start, $page_size";

		if (!$sql) return false;

		return $sql;
	}

	protected function get_report_sql($page_start, $page_size, $start_date, $end_date, $sql_meta_fields_fetch_extra, $select_extra) {

		global $table_prefix, $wpdb;

		// Redundant, unless there are other statuses; and incompatible with plugins adding other statuses: AND (term.slug IN ('completed', 'processing', 'on-hold', 'pending', 'refunded', 'cancelled', 'failed'))
		
		// _order_number_formatted is from Sequential Order Numbers Pro
		
		// '_order_tax_base_currency', '_order_total_base_currency', 
		// This SQL is valid from WooCommerce 2.2 onwards
		$sql = "SELECT
			orders.ID
			$select_extra
			,orders.post_date_gmt
			,order_meta.meta_key
			,order_meta.meta_value
			,orders.post_status AS order_status
		FROM
			".$wpdb->posts." AS orders
		LEFT JOIN
			".$wpdb->postmeta." AS order_meta ON
				(order_meta.post_id = orders.ID)
		WHERE
			(orders.post_type = 'shop_order')
			AND orders.post_date >= '$start_date 00:00:00'
			AND orders.post_date <= '$end_date 23:59:59'
			AND order_meta.meta_key IN ('_billing_state', '_billing_country', '_order_currency', '_order_tax', '_order_total', 'vat_compliance_country_info', 'vat_compliance_vat_paid', 'Valid VAT Number', 'VAT Number', 'VAT number validated', '_order_number_formatted', 'order_time_order_number', 'wceuvat_conversion_rates' $sql_meta_fields_fetch_extra)
		ORDER BY
			orders.ID desc
		LIMIT $page_start, $page_size
		";
		// Apr 2018: Used to also order by (secondarily) order_meta.meta_key, but I do not see any reason why.
	
		return $sql;
	}

	// We assume that the total number of refunds won't be enough to cause memory problems - so, we just get them all and then filter them afterwards
	// Returns an array of arrays of arrays: keys: $order_id -> $tax_rate_id -> (string)"items_vat"|"shipping_vat" -> (numeric)amount - or, in combined format, the last array is dropped out and you just get a total amount.
	// We used to have an $order_status parameter, but refunds always have status "wc-completed", and to get the status of the parent order (i.e. the order that the refund was against), it's better for the caller to do its own processing
	public function get_refund_report_results($start_date, $end_date, $combined_format = false) {

		global $wpdb;

		$compliance = WooCommerce_EU_VAT_Compliance();

		$normalised_results = array();

		// N.B. The previously-used order_status parameter here does nothing, as the order status for a refund is always wc-completed. So, the returned results need filtering later, rather than being able to get the order status at this stage with a single piece of SQL (which is what we're using for efficiency)
		$sql = $this->get_refunds_sql(false, false, $start_date, $end_date);

		if (!$sql) return array();

		$results = $wpdb->get_results($sql);
		if (!is_array($results)) return array();

		$current_order_item_id = false;

		// This forces the loop to go round oen more time, so that the last object in the DB results gets processed
		$res_terminator = new stdClass;
		$res_terminator->oid = -1;
		$res_terminator->id = -1;
		$res_terminator->v = false;
		$res_terminator->k = false;
		$results[] = $res_terminator;

		$default_result = ($combined_format) ? 0 : array('items_vat' => 0, 'shipping_vat' => 0);
		// The search results are sorted by order item ID (oid) and then by meta_key. We rely on both these facts in the following loop.
		foreach ($results as $res) {
			$order_id = $res->id;
			$order_item_id = $res->oid;
			$meta_value = $res->v;
			$meta_key = $res->k;

			if ($current_order_item_id !== $order_item_id) {
				if ($current_order_item_id !== false) {
					// Process previous record
					if (false !== $current_rate_id) {
						if (false != $current_tax_amount) {
							if (!isset($normalised_results[$current_order_id][$current_rate_id])) $normalised_results[$current_order_id][$current_rate_id] = $default_result;
							if ($combined_format) {
								$normalised_results[$current_order_id][$current_rate_id] += $current_tax_amount;
							} else {
								$normalised_results[$current_order_id][$current_rate_id]['items_vat'] += $current_tax_amount;
							}
						}
						if (false != $current_shipping_tax_amount) {
							if (!isset($normalised_results[$current_order_id][$current_rate_id])) $normalised_results[$current_order_id][$current_rate_id] = $default_result;
							if ($combined_format) {
								$normalised_results[$current_order_id][$current_rate_id] += $current_shipping_tax_amount;
							} else {
								$normalised_results[$current_order_id][$current_rate_id]['shipping_vat'] += $current_shipping_tax_amount;
							}
						}
					}
				}

				// Reset other values for the new item
				$current_order_item_id = $order_item_id;
				$current_order_id = $order_id;
				$current_rate_id = false;
				$current_tax_amount = false;
				$current_shipping_tax_amount = false;

			}

			if ('rate_id' == $meta_key) {
				$current_rate_id = $meta_value;
			} elseif ('tax_amount' == $meta_key) {
				$current_tax_amount = $meta_value;
			} elseif ('shipping_tax_amount' == $meta_key) {
				$current_shipping_tax_amount = $meta_value;
			}

		}
		return $normalised_results;

	}

	/**
	 * @param String $start_date
	 * @param String $end_date
	 * @param Boolean $remove_non_eu_countries
	 * @param Boolean $print_as_csv
	 *
	 * @return Array
	 */
	public function get_report_results($start_date, $end_date, $remove_non_eu_countries = true, $print_as_csv = false) {
		global $wpdb;

		$compliance = WooCommerce_EU_VAT_Compliance();

		$default_rates_provider = $compliance->get_conversion_provider();

		// The thinking here is that even after the UK leaves the EU VAT area, it will still be desirable to include it in reports of past periods
		$reporting_countries = array_merge(
			$compliance->get_vat_region_countries('eu'),
			$compliance->get_vat_region_countries('uk')
		);

		$page = 0;
		// This used to be 1000; then up to Sep 2020, 7500. But we get a big speedup with a larger value. 20000 rows should be less than 2MB.
		$page_size = defined('WC_VAT_COMPLIANCE_REPORT_PAGE_SIZE') ? WC_VAT_COMPLIANCE_REPORT_PAGE_SIZE : 20000;
		$fetch_more = true;

		$normalised_results = array();

		$tax_based_on = get_option('woocommerce_tax_based_on');

		if ($print_as_csv) {
			$tax_based_on_extra = ", '_wcpdf_invoice_number', '_billing_country', '_shipping_country', '_customer_ip_address', '_payment_method_title'";
			$select_extra = ',orders.post_date';
		} else {
			$select_extra = '';
			if ('billing' == $tax_based_on) {
				$tax_based_on_extra = ", '_billing_country'";
			} elseif ('shipping' == $tax_based_on) {
				$tax_based_on_extra = ", '_shipping_country'";
			}
		}
		
		$sql_meta_fields_fetch_extra = $tax_based_on_extra.apply_filters('wc_eu_vat_compliance_report_meta_fields', '', $print_as_csv);

		while ($fetch_more) {
			$page_start = $page_size * $page;
			$results_this_time = 0;
			$sql = $this->get_report_sql($page_start, $page_size, $start_date, $end_date, $sql_meta_fields_fetch_extra, $select_extra);
			
			if (empty($sql)) break;

			$results = $wpdb->get_results($sql);
			$remove_order_id = false;

			if (empty($results)) {
				$fetch_more = false;
				continue;
			}

			$page++;
			foreach ($results as $res) {
				if (empty($res->ID)) continue;
				$order_id = $res->ID;
				$order_status = $res->order_status;
				$order_status = ('wc-' == substr($order_status, 0, 3)) ? substr($order_status, 3) : $order_status;
				if (empty($normalised_results[$order_status][$order_id])) {
					$normalised_results[$order_status][$order_id] = array('date_gmt' => $res->post_date_gmt);
					if ($print_as_csv) $normalised_results[$order_status][$order_id]['date'] = $res->post_date;
				}

				switch ($res->meta_key) {
					case 'vat_compliance_country_info':
						$cinfo = maybe_unserialize($res->meta_value);
						if ($print_as_csv) $normalised_results[$order_status][$order_id]['vat_compliance_country_info'] = $cinfo;
						$vat_country = empty($cinfo['taxable_address']) ? '??' : $cinfo['taxable_address'];
						if (!empty($vat_country[0])) {
							if ($remove_non_eu_countries && !in_array($vat_country[0], $reporting_countries)) {
								$remove_order_id = $order_id;
								unset($normalised_results[$order_status][$order_id]);
								continue(2);
							}
							$normalised_results[$order_status][$order_id]['taxable_country'] = $vat_country[0];
						}
						if (!empty($vat_country[1])) $normalised_results[$order_status][$order_id]['taxable_state'] = $vat_country[1];
					break;
					case 'vat_compliance_vat_paid':
						$vat_paid = maybe_unserialize($res->meta_value);
						if (is_array($vat_paid)) {
							// Trying to minimise memory usage for large shops
							unset($vat_paid['currency']);
// 								unset($vat_paid['items_total']);
// 								unset($vat_paid['items_total_base_currency']);
// 								unset($vat_paid['shipping_total']);
// 								unset($vat_paid['shipping_total_base_currency']);
						}
						$normalised_results[$order_status][$order_id]['vat_paid'] = $vat_paid;
					break;
					case '_billing_country':
					case '_shipping_country':
					case '_order_total':
					case '_order_total_base_currency':
					case '_order_currency':
					case '_payment_method_title':
						$normalised_results[$order_status][$order_id][$res->meta_key] = $res->meta_value;
					break;
					// If other plugins provide invoice numbers through other keys, we can use this to get them all into the right place in the end
					case '_wcpdf_invoice_number':
						$normalised_results[$order_status][$order_id]['invc_no'] = $res->meta_value;
					break;
					case 'Valid VAT Number':
						$normalised_results[$order_status][$order_id]['vatno_valid'] = $res->meta_value;
					break;
					case '_order_number_formatted':
						// This comes from WooCommerce Sequential Order Numbers Pro, and we prefer it
						$normalised_results[$order_status][$order_id]['order_number'] = $res->meta_value;
					case 'order_time_order_number':
						if (!isset($normalised_results[$order_status][$order_id]['order_number'])) $normalised_results[$order_status][$order_id]['order_number'] = $res->meta_value;
					break;
					case 'VAT Number':
						$normalised_results[$order_status][$order_id]['vatno'] = $res->meta_value;
					break;
					case 'VAT number validated':
						$normalised_results[$order_status][$order_id]['vatno_validated'] = $res->meta_value;
					break;
					case 'wceuvat_conversion_rates':
						$rates = maybe_unserialize($res->meta_value);
						$normalised_results[$order_status][$order_id]['conversion_rates'] = isset($rates['rates']) ? $rates['rates'] : array();
						$normalised_results[$order_status][$order_id]['conversion_provider'] = isset($rates['meta']['provider']) ? $rates['meta']['provider'] : $default_rates_provider;
					break;
					case '_customer_ip_address':
						if ($print_as_csv) $normalised_results[$order_status][$order_id][$res->meta_key] = $res->meta_value;
					break;
					default:
						// Allow inclusion of other data via filter
						if (false !== ($store_key = apply_filters('wc_eu_vat_compliance_get_report_results_store_key', false, $res))) {
							$normalised_results[$order_status][$order_id][$store_key] = $res->meta_value;
						}
					break;
					
				}

				if ($remove_order_id === $order_id) {
					unset($normalised_results[$order_status][$order_id]);
				}

			}

			// Parse results;
		}

		// Loop again, to make sure that we've got the VAT paid recorded.
		foreach ($normalised_results as $order_status => $orders) {
			foreach ($orders as $order_id => $res) {
				if (empty($res['taxable_country'])) {
					// Legacy orders
					switch ( $tax_based_on ) {
						case 'billing' :
						$res['taxable_country'] = isset($res['_billing_country']) ? $res['_billing_country'] : '';
						break;
						case 'shipping' :
						$res['taxable_country'] = isset($res['_shipping_country']) ? $res['_shipping_country'] : '';
						break;
						default:
						unset($normalised_results[$order_status][$order_id]);
						break;
					}
					if (!$print_as_csv) {
						unset($res['_billing_country']);
						unset($res['_shipping_country']);
					}
				}

				if (!isset($res['vat_paid'])) {
					// This is not good for performance. It was de-activated until version 1.14.22 (when a problem with metadata saving meant that there could be missing historic data that needed reconstructing).
					$vat_paid = WooCommerce_EU_VAT_Compliance()->get_vat_paid($order_id, true, true, false);
					$res['vat_paid'] = $vat_paid;
					$normalised_results[$order_status][$order_id]['vat_paid'] = $vat_paid;
				}

				// N.B. Use of empty() means that those with zero VAT are also excluded at this point
				if (empty($res['vat_paid'])) {
					unset($normalised_results[$order_status][$order_id]);
				} elseif (!isset($res['order_number'])) {
					// This will be database-intensive, the first time, if they had a lot of orders before this bit of meta began to be recorded at order time (plugin version 1.7.2)
					$order = wc_get_order($order_id);
					$order_number = $order->get_order_number();
					$normalised_results[$order_status][$order_id]['order_number'] = $order_number;
					$order->update_meta_data('order_time_order_number', $order_number);
				}
			}
		}

		/* Interesting keys:
			_order_currency
			_order_shipping_tax
			_order_shipping_tax_base_currency
			_order_tax
			_order_tax_base_currency
			_order_total
			_order_total_base_currency
			vat_compliance_country_info
			Valid VAT Number (true)
			VAT Number
			VAT number validated (true)
		*/

		return $normalised_results;

	}

	/**
	 * Populates $this::conversion_providers
	 */
	public function initialise_rate_providers() {
		$compliance =  WooCommerce_EU_VAT_Compliance();
		$providers = $compliance->get_rate_providers();
		$conversion_provider = $compliance->get_conversion_provider();

		if (!is_array($providers) || !isset($providers[$conversion_provider])) throw new Exception('Default conversion provider not found: '.$conversion_provider);

		$this->conversion_providers = $providers;
	}

	/**
	 * Get report results; this is the main entry point for (internally) fetching report data.
	 *
	 * @uses self::get_report_results()
	 *
	 * @param String $start_date		  - in format YYYY-MM-DD
	 * @param String $end_date			  - in format YYYY-MM-DD
	 * @param String $country_of_interest - either 'reporting' (to whom tax is payable, most useful for generating tax reports) or 'taxation' (the country from the customer's taxable address, useful for evaluating thresholds)
	 *
	 * @return Array - keyed by order status string then tabulation country (according to the parameter $country_of_interest) then reporting currency, then rate key, then item (e.g. 'vat', 'vat_shipping')
	 */
	public function get_tabulated_results($start_date, $end_date, $country_of_interest = 'reporting') {

		global $wpdb;

		$compliance = WooCommerce_EU_VAT_Compliance();
		
		$results = $this->get_report_results($start_date, $end_date);

		// Further processing. Need to do currency conversions and index the results by country
		$tabulated_results = array();

		$base_country = $compliance->wc->countries->get_base_country();
		$base_currency = get_option('woocommerce_currency');
		$base_currency_symbol = get_woocommerce_currency_symbol($base_currency);
		
		// The thinking here is that even after the UK leaves the EU VAT area, it will still be desirable to include it in reports of past periods
		$reporting_countries = array_merge(
			$compliance->get_vat_region_countries('eu'),
			$compliance->get_vat_region_countries('uk')
		);

		$this->initialise_rate_providers();

		$this->reporting_currencies = $compliance->get_vat_recording_currencies('reporting');
		if (empty($this->reporting_currencies)) $this->reporting_currencies = array($base_currency);
		
		$default_reporting_currency = $this->reporting_currency = $this->reporting_currencies[0];

		// We need to make sure that the outer foreach() loop does go round for each status, because otherwise refunds on orders made in different accounting periods may be missed
		// These have the wc- prefix.
		$all_possible_statuses = $compliance->order_status_to_text(true);
		foreach ($all_possible_statuses as $wc_status => $status_text) {
			$order_status = substr($wc_status, 3);
			if (!isset($results[$order_status])) $results[$order_status] = array();
		}

		// Refunds data is keyed by ID, and then by tax-rate. This isn't maximally efficient for the reports table, but since we are not expecting tens of thousands of refunds, this should have no significant performance or memory impact.
		// N.B. This gets refunds for orders of all statuses (which is easiest, because WooCommerce doesn't mark the refund post's status to folllow the parent post's status - instead, it marks all refunds as wc-completed)
		$refunds_data = $this->get_refund_report_results($start_date, $end_date, true);

		$order_ids_with_refunds = array_keys($refunds_data);
		$order_statuses = array();
		if (!empty($order_ids_with_refunds)) {
			// Process refunds to work out their parent order's order status
			$get_order_statuses_sql = "SELECT orders.ID as order_id, orders.post_status AS order_status FROM ".$wpdb->posts." AS orders WHERE orders.ID IN (".implode(',', $order_ids_with_refunds).")";
			$order_status_results = $wpdb->get_results($get_order_statuses_sql);
			if (is_array($order_status_results)) {
				foreach ($order_status_results as $r) {
					if (empty($r->order_id)) continue;
					$order_statuses[$r->order_id] = substr($r->order_status, 3);
				}
			}
		}
		// Then, we need to filter the refunds that are checked in the next loop, below
		
		foreach ($results as $order_status => $result_set) {

			// This returns an array of arrays; keys = order IDs; second key = tax rate IDs, values = total amount of orders taxed at these rates
			// N.B. The "total" column potentially has no meaning when totaling item totals, as a single item may have attracted multiple taxes (theoretically). Note also that the totals are *for orders with VAT*.
			$get_items_data = $this->get_items_data($start_date, $end_date, $order_status);

			// We need to make sure that refunds still get processed when they are from a different account period (i.e. when the order is not in the results set)
			foreach ($refunds_data as $order_id => $refunds_by_rate) {
				if (empty($result_set[$order_id])) {
					// Though this taxes the database more, it should be a very rare occurrence

					$refunded_order = wc_get_order($order_id);
					
					if (false == $refunded_order) {
						error_log("WC_EU_VAT_Compliance_Reports::get_main_chart(): get_order failed for order with refund, id=$order_id");
						continue;
					}

					$post_id = $refunded_order->get_id();
					
					$rates = $refunded_order->get_meta('wceuvat_conversion_rates', true);
					
					$cinfo = $refunded_order->get_meta('vat_compliance_country_info', true);
					$vat_compliance_vat_paid = $refunded_order->get_meta('vat_compliance_vat_paid', true);

					$by_rates = array();
					foreach ($refunds_by_rate as $tax_rate_id => $tax_refunded) {
						if (isset($vat_compliance_vat_paid['by_rates'][$tax_rate_id])) {
							$by_rates[$tax_rate_id] = array(
								'is_variable_eu_vat' => isset($vat_compliance_vat_paid['by_rates'][$tax_rate_id]) ? $vat_compliance_vat_paid['by_rates'][$tax_rate_id] : true,
								'items_total' => 0,
								'shipping_total' => 0,
								'rate' => $vat_compliance_vat_paid['by_rates'][$tax_rate_id]['rate'],
								'name' => $vat_compliance_vat_paid['by_rates'][$tax_rate_id]['name'],
							);
						}
					}

					$result_set[$order_id] = array(
						'vat_paid' => array(
							'total' => 0,
							'by_rates' => $by_rates
						),
						'_order_currency' => $refunded_order->get_currency()
					);

					$vat_country = empty($cinfo['taxable_address']) ? '??' : $cinfo['taxable_address'];
					if (!empty($vat_country[0])) {
						if (in_array($vat_country[0], $reporting_countries)) {
							$result_set[$order_id]['taxable_country'] = $vat_country[0];
						}
					}

					if (is_array($rates) && isset($rates['rates'])) $result_set[$order_id]['conversion_rates'] = $rates['rates'];

				}
			}
			
			foreach ($result_set as $order_id => $order_info) {

				// Don't test empty($order_info['vat_paid']['total']), as this can cause refunds to be not included
				if (!is_array($order_info) || empty($order_info['taxable_country']) || empty($order_info['vat_paid']) || !is_array($order_info['vat_paid']) || !isset($order_info['vat_paid']['total'])) continue;

				$order_currency = isset($order_info['_order_currency']) ? $order_info['_order_currency'] : $base_currency;
				// The country that the order is taxable for
				$taxable_country = $order_info['taxable_country'];

				$conversion_rates = isset($order_info['conversion_rates']) ? $order_info['conversion_rates'] : array();
				// Convert the 'vat_paid' array so that its values in the reporting currency, according to the conversion rates stored with the order

				$get_items_data_for_order = isset($get_items_data[$order_id]) ? $get_items_data[$order_id] : array();
				$refunds_data_for_order = (isset($refunds_data[$order_id]) && $order_statuses[$order_id] == $order_status) ? $refunds_data[$order_id] : array();

				$order_reporting_currency = $default_reporting_currency;
				if (!empty($order_info['conversion_rates'])) {
					$order_reporting_currencies = array_keys($order_info['conversion_rates']);
					$order_reporting_currency = $order_reporting_currencies[0];
				}
				
				$converted_order_data = $this->get_currency_converted_order_data($order_info, $order_currency, $conversion_rates, $get_items_data_for_order, $refunds_data_for_order, $order_reporting_currency);
				
				$order_info_converted = $converted_order_data['order_data'];
				$converted_items_data_for_order = $converted_order_data['items_data'];
				$converted_refunds_data_for_order = $converted_order_data['refunds_data'];

				$vat_paid = $order_info_converted['vat_paid'];

				$by_rate = array();
				if (isset($vat_paid['by_rates'])) {
					foreach ($vat_paid['by_rates'] as $tax_rate_id => $rate_info) {

						// The country where the tax is payable
						$tabulation_country = $taxable_country;
					
						$rate = sprintf('%0.2f', $rate_info['rate']);
						$rate_key = $rate;
						// !isset implies 'legacy - data produced before the plugin set this field: assume it is variable, because at that point the plugin did not officially support mixed shops with non-variable VAT'
						if (!isset($rate_info['is_variable_eu_vat']) || !empty($rate_info['is_variable_eu_vat'])) {
							// Variable VAT
							$rate_key = 'V-'.$rate_key;
						} elseif ('reporting' == $country_of_interest) {
							// Non-variable VAT: should be attribute to the base country, for reporting purposes, unless keying by taxation country was requested
							// We started to record the order-time base country from 1.14.25. If it's not there, we assume it is the current shop base country (changing will be rare).
							$tabulation_country = isset($vat_paid['base_country']) ? $vat_paid['base_country'] : $base_country;
						}
						
						$by_rate[$rate_key]['tabulation_country'] = $tabulation_country;

						$check_keys = array('vat', 'vat_shipping', 'sales', 'vat_refunded');
						if (!isset($by_rate[$rate_key])) $by_rate[$rate_key] = array();
						foreach ($check_keys as $check_key) {
							if (!isset($by_rate[$rate_key][$check_key])) $by_rate[$rate_key][$check_key] = 0;
						}
						
						if (isset($rate_info['items_total'])) $by_rate[$rate_key]['vat'] += $rate_info['items_total'];
						
						if (isset($rate_info['shipping_total'])) {
							$by_rate[$rate_key]['vat'] += $rate_info['shipping_total'];
							$by_rate[$rate_key]['vat_shipping'] += $rate_info['shipping_total'];
						}

						// Add sales from items totals
						if (isset($converted_items_data_for_order[$tax_rate_id])) {
							$by_rate[$rate_key]['sales'] += $converted_items_data_for_order[$tax_rate_id];
						}

						// Add refunds data
						// If no VAT was paid at this rate in the accounting period, then that means that the order itself can't have been in this accounting period - and so, the "missing order" detector above will add the necessary blank data. Thus, this code path will be active
						if (isset($converted_refunds_data_for_order[$tax_rate_id])) {
							$by_rate[$rate_key]['vat_refunded'] += $converted_refunds_data_for_order[$tax_rate_id];
						}
					}

				} else {
					// Legacy: no "by_rates" plugin versions also only allowed variable VAT
					$rate_key = 'V-'.__('Unknown', 'woocommerce-eu-vat-compliance');
					if (!isset($by_rate[$rate_key])) $by_rate[$rate_key] = array(
						'vat' => 0,
						'vat_shipping' => 0,
						'sales' => 0,
						'tabulation_country' => $taxable_country
					);
					
					$by_rate[$rate_key]['vat'] += $vat_paid['total'];
					$by_rate[$rate_key]['vat_shipping'] += $vat_paid['shipping_total'];

					foreach ($converted_items_data_for_order as $tax_rate_id => $sales_amount) {
						$by_rate[$rate_key]['sales'] += $sales_amount;
					}

					foreach ($converted_refunds_data_for_order as $tax_rate_id => $refund_amount) {
						$by_rate[$rate_key]['vat_refunded'] += $refund_amount;
					}
				}

				foreach ($by_rate as $rate_key => $rate_data) {
				
					$tabulation_country = $rate_data['tabulation_country'];
				
					// VAT (items)
					if (empty($tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat'])) $tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat'] = 0;
					$tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat'] += $rate_data['vat'];

					// VAT (shipping)
					if (empty($tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat_shipping'])) $tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat_shipping'] = 0;
					$tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat_shipping'] += $rate_data['vat_shipping'];
					
					// Items total, using the data got from the (current) order_itemmeta and order_items tables
					if (empty($tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['sales'])) $tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['sales'] = 0;
					if (isset($rate_data['sales'])) {
						$tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['sales'] += $rate_data['sales'];
					}
					
					// Refunds total, using the data got from the (current) order_itemmeta and order_items tables
					if (empty($tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat_refunded'])) $tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat_refunded'] = 0;
					if (isset($rate_data['vat_refunded'])) $tabulated_results[$order_status][$tabulation_country][$order_reporting_currency][$rate_key]['vat_refunded'] += $rate_data['vat_refunded'];
				}

			}
		}
		
		return $tabulated_results;
	}

	public function format_amount($amount) {
		return apply_filters('wc_eu_vat_compliance_reports_format_amount', sprintf("%0.".$this->format_num_decimals."f", $amount), $amount, $this->format_num_decimals);
	}

	public function get_converted_refunds_data($refunds_for_order, $order_currency, $conversion_rates, $reporting_currency = null) {

		if (!is_array($refunds_for_order)) return $refunds_for_order;

		$use_provider = '';
		$passed_reporting_currency = $reporting_currency;
		if (null == $reporting_currency) $reporting_currency = $this->reporting_currency;
		
		if (isset($conversion_rates[$reporting_currency])) {
			$use_rate = $conversion_rates[$reporting_currency];
			if (null !== $passed_reporting_currency && !empty($refunds_for_order['conversion_provider'])) $use_provider = $refunds_for_order['conversion_provider'];
		} elseif (isset($this->fallback_conversion_rates[$order_currency])) {
			$use_rate = $this->fallback_conversion_rates[$order_currency];
			$use_provider = $this->fallback_conversion_providers[$order_currency];
		} else {
			// Returns the conversion for 1 unit of the order currency.
			$conversion_provider_code = WooCommerce_EU_VAT_Compliance()->get_conversion_provider();
			$conversion_provider = $this->conversion_providers[$conversion_provider_code];
			$use_rate = $conversion_provider->convert($order_currency, $this->reporting_currency, 1);
			$use_provider = $conversion_provider_code;
			$this->fallback_conversion_rates[$order_currency] = $use_rate;
			$this->fallback_conversion_providers[$order_currency] = $conversion_provider_code;
		}

		foreach ($refunds_for_order as $tax_rate_id => $refunded_amount) {
			$refunds_for_order[$tax_rate_id] = $refunded_amount * $use_rate;
		}
		
		return $refunds_for_order;

	}

	// This takes one or two arrays of order data, and converts the amounts in them to the requested currency
	// public: used also in the CSV download
	public function get_currency_converted_order_data($raw, $order_currency, $conversion_rates, $get_items_data_for_order = array(), $refunds_data_for_order = array(), $reporting_currency = null) {

		$use_provider = '';
		$passed_reporting_currency = $reporting_currency;
		if (null == $reporting_currency) $reporting_currency = $this->reporting_currency;

		if (isset($conversion_rates[$reporting_currency])) {
			$use_rate = $conversion_rates[$reporting_currency];
			if (null !== $passed_reporting_currency && !empty($raw['conversion_provider'])) $use_provider = $raw['conversion_provider'];
		} elseif (isset($this->fallback_conversion_rates[$order_currency])) {
			$use_rate = $this->fallback_conversion_rates[$order_currency];
			$use_provider = $this->fallback_conversion_providers[$order_currency];
		} else {
			// Returns the conversion for 1 unit of the order currency.
			$conversion_provider_code = WooCommerce_EU_VAT_Compliance()->get_conversion_provider();
			$conversion_provider = $this->conversion_providers[$conversion_provider_code];
			$use_rate = $conversion_provider->convert($order_currency, $this->reporting_currency, 1);
			$use_provider = $conversion_provider_code;
			$this->fallback_conversion_rates[$order_currency] = $use_rate;
			$this->fallback_conversion_providers[$order_currency] = $conversion_provider_code;
		}
		
		$this->last_rate_used = $use_rate;

		if (isset($raw['_order_total'])) {
			$raw['_order_total'] = $raw['_order_total'] * $use_rate;
		}

		$convert_keys = array('items_total', 'shipping_total', 'total');
		foreach ($convert_keys as $key) {
			if (isset($raw['vat_paid'][$key])) {
				$raw['vat_paid'][$key] = $raw['vat_paid'][$key] * $use_rate;
			}
		}
		if (isset($raw['vat_paid']['by_rates'])) {
			foreach ($raw['vat_paid']['by_rates'] as $rate_id => $rate) {
				foreach ($convert_keys as $key) {
					if (isset($rate[$key])) {
						$raw['vat_paid']['by_rates'][$rate_id][$key] = $raw['vat_paid']['by_rates'][$rate_id][$key] * $use_rate;
					}
				}
			}
		}

		foreach ($get_items_data_for_order as $tax_rate_id => $amount) {
			$get_items_data_for_order[$tax_rate_id] = $amount * $use_rate;
		}

		foreach ($refunds_data_for_order as $tax_rate_id => $amount) {
			$refunds_data_for_order[$tax_rate_id] = $amount * $use_rate;
		}

		$raw['conversion_provider'] = $use_provider;
		
		return array(
			'order_data' => $raw,
			'items_data' => $get_items_data_for_order,
			'refunds_data' => $refunds_data_for_order
		);
	}

}
