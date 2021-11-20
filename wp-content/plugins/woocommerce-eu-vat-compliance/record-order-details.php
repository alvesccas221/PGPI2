<?php

if (!defined('WC_VAT_COMPLIANCE_DIR')) die('No direct access');

/**
 * Function: record various bits of meta-data about the order (e.g. the GeoIP information for the order), at order time. For GeoIP, module uses either the CloudFlare header (if available - https://support.cloudflare.com/hc/en-us/articles/200168236-What-does-CloudFlare-IP-Geolocation-do-), or the geo-location class built-in to WC (2.3+), or requires http://wordpress.org/plugins/geoip-detect/. Or, you can hook into it and use something else. It will always record something, even if the something is the information that nothing could be worked out.
 *
 */

if (class_exists('WC_EU_VAT_Compliance_Record_Order_Details')) return;
class WC_EU_VAT_Compliance_Record_Order_Details {

	private $wc;
	
	private $compliance;

	/**
	 * Class constructor
	 */
	public function __construct() {
	
		add_action('woocommerce_checkout_create_order', array($this, 'woocommerce_checkout_create_order'));

		add_action('woocommerce_checkout_order_processed', array($this, 'woocommerce_checkout_order_processed'), 10, 3);

		add_action('add_meta_boxes_shop_order', array($this, 'add_meta_boxes_shop_order'));

		$this->compliance = WooCommerce_EU_VAT_Compliance();

	}

	/**
	 * Called by the WP action add_meta_boxes_shop_order
	 */
	public function add_meta_boxes_shop_order() {
	
		$current_screen = get_current_screen();
		
		// Don't show the meta-box on the "New order" screen
		if ('shop_order' == $current_screen->id && 'add' == $current_screen->action) return;
	
		add_meta_box('wc_eu_vat_vat_meta',
			__('VAT compliance information', 'woocommerce-eu-vat-compliance'),
			array($this, 'meta_box_shop_order'),
			'shop_order',
			'side',
			'default'
		);
	}

	/**
	 * Registered meta box print-out function
	 */
	public function meta_box_shop_order() {
	
		$current_screen = get_current_screen();
		
		if ('shop_order' == $current_screen->id && 'add' == $current_screen->action) {
			echo '<em>'.__('There is no compliance information to show, as this order has not yet been created.', 'woocommerce-eu-vat-compliance').'</em>';
		} else {
			global $post;
			$this->print_order_vat_info($post->ID);
		}
	}

	/**
	 * Called upon the WC action woocommerce_checkout_create_order
	 *
	 * @param WC_Order $order
	 */
	public function woocommerce_checkout_create_order($order) {

		// Record the information about the customer's location in the order meta
		$compliance = WooCommerce_EU_VAT_Compliance();

		// Note: whilst this records the country via GeoIP resolution, that does not indicate which tax WooCommerce applies - that will be determined by the user's WooCommerce settings. The GeoIP data is recorded for compliance purposes.

		$country_info = $compliance->get_visitor_country_info();
		$country_info['taxable_address'] = $this->compliance->get_taxable_address();

		$country_info = apply_filters('wc_eu_vat_compliance_meta_country_info', $country_info);
		
		$order->update_meta_data('vat_compliance_country_info', $country_info);

	}

	/**
	 * Add meta information to an order; specifically, wceuvat_conversion_rates and order_time_order_number
	 *
	 * @param WC_Order|WC_Order_Refund $order
	 * @param Boolean				   $add_order_number - whether to add the order number or not
	 * @param Array|Boolean			   $country_info - optional country info to use (but only 'optional' if you don't mind not using any country-specific over-ride rules for exchange rate lookups, for example). Currently only the 0th key is used, to indicate the taxation country.
	 *
	 * @return Array|Boolean - possibly, conversion rates
	 */
	public function record_conversion_rates_and_other_meta($order, $add_order_number = true, $country_info = null) {

		$compliance = WooCommerce_EU_VAT_Compliance();

		// Record order number; see: http://docs.woothemes.com/document/sequential-order-numbers/
		if ($add_order_number && is_a($order, 'WC_Order')) $order->update_meta_data('order_time_order_number', $order->get_order_number());

		$country_code = (null === $country_info) ? null : $country_info[0];
		
		$conversion_provider = $compliance->get_conversion_provider($country_code);
		
		$providers = $compliance->get_rate_providers();
		
		if (!is_array($providers) || !isset($providers[$conversion_provider])) return false;

		$provider = $providers[$conversion_provider];

		$record_currencies = $compliance->get_vat_recording_currencies('recording', $country_code);

		$order_currency = $order->get_currency();
		
		$conversion_rates = array(
			'meta' => array('order_currency' => $order_currency),
			'rates' => array()
		);

		// The method exists if it's a WC_Order but not for a WC_Order_Refund
		$order_date = is_callable(array($order, 'get_date_completed')) ? $order->get_date_completed() : null;
		if (!$order_date) $order_date = $order->get_date_created();
		$order_epoch_time = is_callable(array($order_date, 'getTimestamp')) ? $order_date->getTimestamp() : time();
		
		foreach ($record_currencies as $vat_currency) {
			if (!is_string($vat_currency) || $order_currency == $vat_currency) continue;
			// Returns the conversion for 1 unit of the order currency.
			$result = $provider->convert($order_currency, $vat_currency, 1, $order_epoch_time);
			if ($result) {
				$conversion_rates['rates'][$vat_currency] = $result;
			}
			$conversion_rates['meta']['provider'] = $conversion_provider;
		}

		$order->update_meta_data('wceuvat_conversion_rates', $conversion_rates);
		
		$order->save();
		
		return $conversion_rates;
	}


	/**
	 * Called upon the WP action woocommerce_checkout_order_processed
	 *
	 * @param Integer  $order_id
	 * @param Array	   $posted_data
	 * @param WC_Order $order
	 */
	public function woocommerce_checkout_order_processed($order_id, $posted_data, $order) {
	
		// N.B. A falsey first parameter was seen in HS#19665; we used to check that, but now check the object
		if (!is_a($order, 'WC_Order')) {
			error_log("WC_EU_VAT_Compliance_Record_Order_Details::woocommerce_checkout_order_processed() : unexpected event: null order passed (".gettype($order).", ".serialize($order_id).")");
			return;
		}
		
		$vat_paid = $this->record_meta_vat_paid($order);
		
		$has_variable_vat = !empty($vat_paid['total']);
		if (!$has_variable_vat && !empty($vat_paid['by_rates'])) {
			foreach ($vat_paid['by_rates'] as $vat_info) {
				if (!empty($vat_info['is_variable_eu_vat'])) $has_variable_vat = true;
			}
		}
		
		// We used to do the next call in woocommerce_checkout_create_order, but when per-country exchange rate recording was introduced, we needed the info on taxes from record_meta_vat_paid() to be able to get the country right
		$country_info = $order->get_meta('vat_compliance_country_info', true);
		
		// What about if there is no VAT at all? That doesn't seem to be covered here.
		if ($has_variable_vat) {
			$taxable_address = $country_info['taxable_address'];
		} else {
			$base_countries = array_values($this->compliance->get_base_countries());
			$taxable_address = array($base_countries[0]);
		}
		
		// Record the current conversion rates in the order meta
		$this->record_conversion_rates_and_other_meta($order, true, $taxable_address);
	}

	/**
	 * Records details about taxes paid, as order meta-data
	 *
	 * @param WC_Order $order
	 *
	 * @return Array
	 */
	public function record_meta_vat_paid($order) {

		$vat_paid = WooCommerce_EU_VAT_Compliance()->get_vat_paid($order);

		$order->update_meta_data('vat_compliance_vat_paid', $vat_paid);

		$order->save();
		
		return $vat_paid;
		
	}

	/**
	 * Print out VAT info
	 *
	 * @param Integer $order_id
	 */
	private function print_order_vat_info($order_id) {

		$compliance = WooCommerce_EU_VAT_Compliance();
		
		$order = wc_get_order($order_id);
		
		$country_info = $order->get_meta('vat_compliance_country_info', true);

		echo '<p id="wc_eu_vat_compliance_countryinfo">';

		if (empty($country_info) || !is_array($country_info)) {
			echo '<em>'.__('No further information recorded (the WooCommerce VAT Compliance plugin was not active when this order was made).', 'woocommerce-eu-vat-compliance').'</em>';
			if (function_exists('geoip_detect_get_info_from_ip') && $ip = $order->get_meta('_customer_ip_address', true)) {
				$country_info = $compliance->construct_country_info($ip);
				if (!empty($country_info) && is_array($country_info)) {
					echo ' '.__("The following information is based upon looking up the customer's IP address now.", 'woocommerce-eu-vat-compliance');
				}
			}
			echo '<br>';
		}

		// Relevant function: get_woocommerce_currency_symbol($currency = '')
		$vat_paid = $compliance->get_vat_paid($order, true, true);
	
		if (is_array($vat_paid)) {

			$order_currency = isset($vat_paid['currency']) ? $vat_paid['currency'] : $order->get_currency();

			// This should not be possible - but, it is best to err on the side of caution
			if (!isset($vat_paid['by_rates'])) $vat_paid['by_rates'] = array(array('items_total' => $vat_paid['items_total'], 'is_variable_eu_vat' => 1, 'shipping_total' => $vat_paid['shipping_total'], 'rate' => '??', 'name' => __('VAT', 'woocommerce-eu-vat-compliance')));

			// What currencies is VAT meant to be reported in?
			$conversion_rates =  $order->get_meta('wceuvat_conversion_rates', true);

			if (is_array($conversion_rates) && isset($conversion_rates['rates'])) {
				$conversion_currencies = array_keys($conversion_rates['rates']);
				if (count($conversion_rates['rates']) > 0) $conversion_provider_key = isset($conversion_rates['meta']['provider']) ? $conversion_rates['meta']['provider'] : '??';
			} else {
				$conversion_currencies = array();
				# Convert from legacy format - only existed for 2 days from 24-Dec-2014; can be removed later.
				
				$record_currencies = $compliance->get_vat_recording_currencies();
				
				if (1 == count($record_currencies)) {
					$try_currency = array_shift($record_currencies);
					$conversion_rate = $order->get_meta('wceuvat_conversion_rate_'.$order_currency.'_'.$try_currency, true);
					if (!empty($conversion_rate)) {
						$conversion_provider_key = '??';
						$conversion_rates = array('order_currency' => $order_currency, 'rates' => array($try_currency => $conversion_rate));
						$conversion_currencies = array($try_currency);
						$order->update_meta_data('wceuvat_conversion_rates', $conversion_rates);
					}
				}
			}

			// A default - redundant
 			// if (empty($conversion_currencies)) $conversion_currencies = array($order_currency);

			if (!in_array($order_currency, $conversion_currencies)) $conversion_currencies[] = $order_currency;

			# Show the recorded currency conversion rate(s)
			$currency_title = '';
			if (isset($conversion_rates['rates']) && is_array($conversion_rates['rates'])) {
				foreach ($conversion_rates['rates'] as $cur => $rate) {
					$currency_title .= sprintf("1 unit %s = %s units %s\n", $order_currency, $rate, $cur);
				}
			}

			$items_total = false;
			$shipping_total = false;
			$total_total = false;

			$refunded_items_total = false;
			$refunded_shipping_total = false;
			$refunded_shipping_tax_total = false;
			$refunded_total_total = false;

			// Any tax refunds?
			$total_tax_refunded = $order->get_total_tax_refunded();
			if ($total_tax_refunded > 0) $any_tax_refunds_exist = true;
			
			foreach ($vat_paid['by_rates'] as $rate_id => $vat) {

				$refunded_item_amount = 0;
				$refunded_shipping_amount = 0;
				$refunded_tax_amount = 0;
				$refunded_shipping_tax_amount = 0;

				if (!empty($any_tax_refunds_exist)) {
					// This loop is adapted from WC_Order::get_total_tax_refunded_by_rate_id() (WC 2.3+)
					foreach ($order->get_refunds() as $refund) {
						foreach ($refund->get_items('tax') as $refunded_item) {
							if (isset( $refunded_item['rate_id']) && $refunded_item['rate_id'] == $rate_id) {
								$refunded_tax_amount += abs( $refunded_item['tax_amount'] );
								$refunded_shipping_tax_amount += abs($refunded_item['shipping_tax_amount']);
							}
						}
						foreach ($refund->get_items('shipping') as $refunded_item) {
							if (!isset($refunded_item['taxes'])) continue;
							$tax_data = maybe_unserialize($refunded_item['taxes']);
							// Was the current tax rate ID used on this item?
							if ( !empty( $tax_data[$rate_id] )) {
								// Minus, because we want to end up with a positive amount, so that all the $refunded_ variables are consistent.
								$refunded_shipping_amount -= $refunded_item['cost'];
								// Don't add it again here - it's already added above
 								// $refunded_shipping_tax_amount -= $tax_data[$rate_id];
							}
						}
						foreach ($refund->get_items() as $refunded_item) {
							if (!isset($refunded_item['line_tax_data'])) continue;
							$tax_data = maybe_unserialize($refunded_item['line_tax_data']);
							// Was the current tax rate ID used on this item?
							if ( !empty( $tax_data['total'][$rate_id] )) {
								// Minus, because we want to end up with a positive amount, so that all the $refunded_ variables are consistent.
								$refunded_item_amount -= $refunded_item['line_total'];
							}
						}
					}
				}

				$items_total += $vat['items_total'];
				$shipping_total += $vat['shipping_total'];
				$total_total += $vat['items_total'] + $vat['shipping_total'];

				$refunded_items_total += $refunded_item_amount;
				$refunded_shipping_total += $refunded_shipping_amount;
				$refunded_shipping_tax_total += $refunded_shipping_tax_amount;
				$refunded_total_total += $refunded_tax_amount + $refunded_shipping_tax_amount;

				$items = $compliance->get_amount_in_conversion_currencies($vat['items_total'], $conversion_currencies, $conversion_rates, $order_currency);

				$shipping = $compliance->get_amount_in_conversion_currencies($vat['shipping_total'], $conversion_currencies, $conversion_rates, $order_currency);
				$total = $compliance->get_amount_in_conversion_currencies($vat['items_total']+$vat['shipping_total'], $conversion_currencies, $conversion_rates, $order_currency);

				// When it is not set, we have legacy data format (pre 1.7.0), where all VAT-able items were assumed to have the customer's location as the place of supply
				if (isset($vat['is_variable_eu_vat']) && !$vat['is_variable_eu_vat']) {
					$extra_title = '<em>'._x("(Seller's place-of-supply VAT)", 'Traditional VAT = VAT where the place of supply is the seller (not customer) location', 'woocommerce-eu-vat-compliance').'</em><br>';
				} else {
					$extra_title = '';
				}

				echo '<p><strong>'.$vat['name'].' ('.sprintf('%0.2f', $vat['rate']).' %)</strong><br>'.$extra_title;

				echo __('Items', 'woocommerce-eu-vat-compliance').': '.$items.'<br>';
				if ($refunded_tax_amount) {
					$refunded_taxes = $compliance->get_amount_in_conversion_currencies($refunded_tax_amount*-1, $conversion_currencies, $conversion_rates, $order_currency);
					echo __('Items refunded', 'woocommerce-eu-vat-compliance').': '.$refunded_taxes;
					echo '<br>';
				}

				echo __('Shipping', 'woocommerce-eu-vat-compliance').': '.$shipping."<br>\n";
				if ($refunded_shipping_tax_amount) {
					echo __('Shipping refunded', 'woocommerce-eu-vat-compliance').': '.$compliance->get_amount_in_conversion_currencies($refunded_shipping_tax_amount*-1, $conversion_currencies, $conversion_rates, $order_currency);
					echo "<br>\n";
				}

				if ($refunded_tax_amount || $refunded_shipping_tax_amount) {
					$total_after_refunds = $vat['items_total']+$vat['shipping_total'] - ($refunded_tax_amount + $refunded_shipping_tax_amount);
					$total_after_refunds_converted = $compliance->get_amount_in_conversion_currencies($total_after_refunds, $conversion_currencies, $conversion_rates, $order_currency);
					echo __('Total (after refunds)', 'woocommerce-eu-vat-compliance').': '.$total_after_refunds_converted;
					echo "<br>\n";
				} else {
					echo __('Total', 'woocommerce-eu-vat-compliance').': '.$total."<br>\n";
				}
				
				echo '</p>';
			}

			if (count($vat_paid['by_rates']) > 1) {

				$items = $compliance->get_amount_in_conversion_currencies(($items_total === false) ? $vat_paid['items_total'] : $items_total, $conversion_currencies, $conversion_rates, $order_currency);

				$shipping = $compliance->get_amount_in_conversion_currencies(($shipping_total === false) ? $vat_paid['shipping_total'] : $shipping_total, $conversion_currencies, $conversion_rates, $order_currency);

				$total = $compliance->get_amount_in_conversion_currencies(($total_total === false) ? $vat_paid['total'] : $total_total, $conversion_currencies, $conversion_rates, $order_currency);

				echo '<strong>'.__('All VAT charges', 'woocommerce-eu-vat-compliance').'</strong><br>';
				echo __('Items', 'woocommerce-eu-vat-compliance').': '.$items.'<br>';
				echo __('Shipping', 'woocommerce-eu-vat-compliance').': '.$shipping."<br>\n";
				if ($refunded_total_total) {
					echo __('Net total', 'woocommerce-eu-vat-compliance').': '.$total.'<br>';
					echo __('Refund total', 'woocommerce-eu-vat-compliance').': '.$compliance->get_amount_in_conversion_currencies($refunded_total_total*-1, $conversion_currencies, $conversion_rates, $order_currency).'<br>';
					$grand_total = $total_total - $refunded_total_total;
					echo __('Grand total', 'woocommerce-eu-vat-compliance').': '.$compliance->get_amount_in_conversion_currencies($grand_total, $conversion_currencies, $conversion_rates, $order_currency).'<br>'."\n";
				} else {
					echo __('Total', 'woocommerce-eu-vat-compliance').': '.$total.'<br>';
				}
			}

 			// if (!in_array($order_currency, $conversion_currencies)) $paid_in_order_currency = get_woocommerce_currency_symbol($vat_paid['currency']).' '.sprintf('%.02f', $vat_paid['total']);

			// Allow filtering - since for some shops using a multi-currency plugin, the VAT currency is neither the base nor necessarily the purchase currency.
 			// echo apply_filters('wc_eu_vat_compliance_show_vat_paid', $paid, $vat_paid);

			$valid_vat_number = $order->get_meta('Valid VAT Number', true);
			$vat_number_validated = $order->get_meta('VAT number validated', true);
			$vat_number = $order->get_meta('VAT Number', true);

			if (!empty($vat_paid['value_based_exemption']) && is_array($vat_paid['value_based_exemption'])) {
				$value = isset($vat_paid['value_based_exemption']['pre_conversion_value']) ? $vat_paid['value_based_exemption']['pre_conversion_value'] : $vat_paid['value_based_exemption']['value'];
				// N.B. By default get_woocommerce_currency_symbol() returns HTML entities; but the Aelia currency switcher does not (unless someone entered entities in their settings). So we have to be able to handle both.
				$symbol = get_woocommerce_currency_symbol($vat_paid['value_based_exemption']['currency']);
				echo '<p>';
				if (!empty($vat_paid['value_based_exemption']['based_upon']) && 'any_item_above' == $vat_paid['value_based_exemption']['based_upon']) {
					printf(__("Order was tax-exempt due to a destination value-based exemption rule; at least one item's value exceeded %s.", 'woocommerce-eu-vat-compliance'), htmlentities($symbol.' '.$value, ENT_COMPAT, null, false));	
				} else {
					printf(__('Order was tax-exempt due to a destination value-based exemption rule; its value exceeded %s.', 'woocommerce-eu-vat-compliance'), htmlentities($symbol.' '.$value, ENT_COMPAT, null, false));
				}
				echo '</p>';
			}

			$woocommerce_recorded_vat_exempt_value = $order->get_meta('is_vat_exempt', true);
			// Sep 2020: it records it as (string)"yes" or (string)"no". Note that if we get something other than (string)"no" then we won't print out that WooCommerce did not register as exempt (we don't want to do that if no value was stored).
			if ('yes' == $woocommerce_recorded_vat_exempt_value || true === $woocommerce_recorded_vat_exempt_value) {
				echo __('WooCommerce registered the customer as being tax-exempt.', 'woocommerce-eu-vat-compliance')."<br>\n";
			} elseif ('no' == $woocommerce_recorded_vat_exempt_value) {
				echo __('WooCommerce registered the customer as not being tax-exempt.', 'woocommerce-eu-vat-compliance')."<br>\n";
			}

			$partial_vat_exemption = empty($vat_paid['partial_vat_exemption']) ? 'no' : $vat_paid['partial_vat_exemption'];
			
			if ('yes' === $partial_vat_exemption) {
				echo __('The plugin registered the customer as being tax-exempt on configured tax classes only.', 'woocommerce-eu-vat-compliance')."<br>\n";
			}
			
			if ($valid_vat_number && $vat_number_validated && 0 == $vat_paid['total']) {
				echo sprintf(__('Validated VAT number: %s', 'woocommerce-eu-vat-compliance'), $vat_number)."\n";
			}

			$vies_full_result = $order->get_meta('VIES Response', true);

			if (!empty($vies_full_result)) {
				echo '<p><strong title="'.esc_attr($currency_title).'">'.__('VIES extended information:', 'woocommerce-eu-vat-compliance')."</strong><br>\n";
				if (!empty($vies_full_result['requestDate'])) echo __('Validated at:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($vies_full_result['requestDate']).'<br>';
				if (!empty($vies_full_result['requestIdentifier'])) echo __('Request ID:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($vies_full_result['requestIdentifier']).'<br>';
				if (!empty($vies_full_result['traderName'])) {
					echo __('Trader name:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($vies_full_result['traderName']).'<br>';
				}
				// 21-Jul-2018 : Corner-case: If the lookup for your own VAT number was cached, you get 'name'/'address' instead of 'traderName', 'traderAddress'
				if (!empty($vies_full_result['name'])) {
					echo __('Trader name:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($vies_full_result['name']).'<br>';
				}
				if (!empty($vies_full_result['traderCompanyType'])) {
					echo __('Trader company type:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($vies_full_result['traderCompanyType']).'<br>';
				}
				if (!empty($vies_full_result['traderAddress'])) {
					echo __('Trader address:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($vies_full_result['traderAddress']).'<br>';
				}
				// 21-Jul-2018 : similarly with address/traderAddress
				if (!empty($vies_full_result['address'])) {
					echo __('Trader address:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($vies_full_result['address']).'<br>';
				}

				echo '</p>';
			} else {
			
				$vat_lookup_response = $order->get_meta('vat_lookup_response', true);
				
				if (is_array($vat_lookup_response) && isset($vat_lookup_response['response']) && is_array($vat_lookup_response['response'])) {
				
					$resp = $vat_lookup_response['response'];
					
					$region = $vat_lookup_response['region_used'];
					
					$region_object = $compliance->get_vat_region_object($region, false);
					
					$lookup_service = is_object($region_object) ? $region_object->get_service_name() : $region;
					
					echo '<p><strong title="'.esc_attr($currency_title).'">'.sprintf(__('Lookup extended information (%s):', 'woocommerce-eu-vat-compliance'), $lookup_service)."</strong><br>\n";
					
					if (!empty($resp['processingDate'])) echo __('Validated at:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($resp['processingDate']).'<br>';
					
					if (!empty($resp['consultationNumber'])) echo __('Request ID:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($resp['consultationNumber']).'<br>';
					
					if (!empty($resp['target']['name'])) {
						echo __('Trader name:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars($resp['target']['name']).'<br>';
					}
					
					if (!empty($resp['target']['address'])) {
						echo __('Trader address:', 'woocommerce-eu-vat-compliance').' '.htmlspecialchars(implode(', ', $resp['target']['address'])).'<br>';
					}
				
					echo '</p>';
				}
				
			
			}

			if (!empty($conversion_provider_key)) {
				$conversion_provider = $compliance->get_rate_providers($conversion_provider_key);
				if (!empty($conversion_provider)) {
					$provider_info = $conversion_provider->info();
					$provider_title = isset($provider_info['title']) ? $provider_info['title'] : $conversion_provider_key;
					echo '<p><strong title="'.esc_attr($currency_title).'">'.__('Currency conversion source:', 'woocommerce-eu-vat-compliance').'</strong><br>';
					if (!empty($provider_info['url'])) echo '<a href="'.esc_attr($provider_info['url']).'">';
					echo htmlspecialchars($provider_title);
					if (!empty($provider_info['url'])) echo '</a>';
					echo '</p>';
				} else {
					echo '<br>';
				}
			} else {
				echo '<br>';
			}
		} else {
			echo __("VAT paid:", 'woocommerce-eu-vat-compliance').' '.__('Unknown', 'woocommerce-eu-vat-compliance')."<br>";
		}

/*
	array (size=9)
	'items_total' => float 3.134
	'shipping_total' => float 4.39
	'total' => float 7.524
	'currency' => string 'USD' (length=3)
	'base_currency' => string 'GBP' (length=3)
	'items_total_base_currency' => int 2
	'shipping_total_base_currency' => float 2.8
	'total_base_currency' => float 4.8
*/
		if (!empty($country_info) && is_array($country_info)) {

			$country_code = !empty($country_info['data']) ? $country_info['data'] : __('Unknown', 'woocommerce-eu-vat-compliance');

			$source = !empty($country_info['source']) ? $country_info['source'] :  __('Unknown', 'woocommerce-eu-vat-compliance');

			$source_description = (isset($compliance->data_sources[$source])) ? $compliance->data_sources[$source] : __('Unknown', 'woocommerce-eu-vat-compliance');

			echo '<span title="'.esc_attr(__('Raw information:', 'woocommerce-eu-vat-compliance').': '.print_r($country_info, true)).'">';

			$countries = $compliance->wc->countries->countries;

			$country_name = isset($countries[$country_code]) ? $countries[$country_code] : '??';

			$taxable_address = empty($country_info['taxable_address']) ?  __('Unknown', 'woocommerce-eu-vat-compliance') : $country_info['taxable_address'];

			echo '<span title="'.esc_attr(print_r($taxable_address, true)).'">'.__("Customer's taxable address:", 'woocommerce-eu-vat-compliance').' ';

			$calculated_country_code = empty($taxable_address[0]) ? __('Unknown', 'woocommerce-eu-vat-compliance') : $taxable_address[0];

			$calculated_country_name = isset($countries[$calculated_country_code]) ? $countries[$calculated_country_code] : '??';

			echo "$calculated_country_name ($calculated_country_code)";

			echo "</span><br>";

			echo __('IP Country:', 'woocommerce-eu-vat-compliance')." $country_name ($country_code)";
			echo ' - <span title="'.esc_attr($source).'">'.__('source:', 'woocommerce-eu-vat-compliance')." ".htmlspecialchars($source_description)."</span><br>";

			echo '</span>';

		}

		// $time
		echo "</p>";

	}

}
