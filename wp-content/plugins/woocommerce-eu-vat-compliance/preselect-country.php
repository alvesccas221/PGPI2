<?php

if (!defined('WC_VAT_COMPLIANCE_DIR')) die('No direct access');

/*

Function: pre-select the taxable country in the WooCommerce session, based on GeoIP lookup (or equivalent).
Also handles re-setting the taxable country via self-certification.

Also, provide a widget and shortcode to allow this to be over-ridden by the user (since GeoIP is not infallible)

[euvat_country_selector include_notaxes="true|false"]

*/

if (defined('WC_EU_VAT_NOCOUNTRYPRESELECT') && is_admin()) {
	error_log("The constant WC_EU_VAT_NOCOUNTRYPRESELECT is deprecated and will be removed in a later version; please switch to using WC_VAT_NO_COUNTRY_PRESELECT");
}

if (!class_exists('WC_EU_VAT_Compliance_Preselect_Country') && (!defined('WC_EU_VAT_NOCOUNTRYPRESELECT') || !WC_EU_VAT_NOCOUNTRYPRESELECT) && (!defined('WC_VAT_NO_COUNTRY_PRESELECT') || !WC_VAT_NO_COUNTRY_PRESELECT)):

class WC_EU_VAT_Compliance_Preselect_Country {

	private $preselect_route = null;

	/**
	 * Class constructor
	 */
	public function __construct() {
		$this->compliance = WooCommerce_EU_VAT_Compliance();

		add_shortcode('euvat_country_selector', array($this, 'shortcode_vat_country_selector'));
		add_action('widgets_init', array($this, 'widgets_init'));

		// This filter shows prices on the shop front-end
		add_filter('woocommerce_get_tax_location', array($this, 'woocommerce_customer_taxable_address'), 11);

		// This filter is used to set their taxable address when they check-out
		add_filter('woocommerce_customer_taxable_address', array($this, 'woocommerce_customer_taxable_address'), 11);

		add_filter('woocommerce_get_price_suffix', array($this, 'woocommerce_get_price_suffix'), 10, 2);

		// This is hacky. To get the "taxes estimated for (country)" message on the cart page to work, we use these two actions to hook and then unhook a filter.
		add_action('woocommerce_cart_totals_after_order_total', array($this, 'woocommerce_cart_totals_after_order_total'));
		add_action('woocommerce_after_cart_totals', array($this, 'woocommerce_after_cart_totals'));
		
		if ((defined('WC_EU_VAT_DEBUG') && WC_EU_VAT_DEBUG) || (defined('WC_VAT_DEBUG') && WC_VAT_DEBUG)) {
			add_action('wp_footer', array($this, 'wp_debug_footer'), 999999);
		}

	}
	
	/**
	 * Runs upon the action wp_footer; used to add debugging information
	 */
	public function wp_debug_footer() {
		if (null !== $this->preselect_route) {
			$country = $this->preselect_result;
			$method = "Prior lookup during page load";
		} else {
			$country = $this->get_preselect_country();
			$method = "Explicit lookup (all methods allowed)";
		}
		if (!is_string($country)) $country = "no_result";
		echo "<!-- WC VAT Compliance debugging: country=$country; route=".$this->preselect_route.", method: $method -->\n";
	}

	/**
	 * Runs upon the WP action woocommerce_cart_totals_after_order_total
	 */
	public function woocommerce_cart_totals_after_order_total() {
		add_filter('woocommerce_countries_base_country', array($this, 'woocommerce_countries_base_country'));
	}

	/**
	 * Runs upon the WP action woocommerce_after_cart_totals
	 */
	public function woocommerce_after_cart_totals() {
		remove_filter('woocommerce_countries_base_country', array($this, 'woocommerce_countries_base_country'));
	}

	public function woocommerce_countries_base_country($country) {
		if (!defined('WOOCOMMERCE_CART') || !WOOCOMMERCE_CART) return $country;

		$vat_country = $this->get_preselect_country(false, true);

		return (empty($vat_country) || 'none' === $country) ? $country : $vat_country;
	}

	/**
	 * Runs upon the WP action widgets_init
	 */
	public function widgets_init() {
		register_widget('WC_EU_VAT_Country_PreSelect_Widget');
	}

	public function price_display_replace_callback($matches) {

		if (empty($this->all_countries)) $this->all_countries = $this->compliance->wc->countries->countries;

		$country = $this->get_preselect_country(true);

		$country_name = isset($this->all_countries[$country]) ? $this->all_countries[$country] : '';

		if (!empty($this->suffixing_product) && is_a($this->suffixing_product, 'WC_Product')) {
			if (!$this->compliance->product_taxable_class_indicates_buyer_country_variable_vat($this->suffixing_product)) {
				$country_name = '';
			}
		}

		$search = array(
			'{country}',
			'{country_with_brackets}',
		);
		$replace = array(
			$country_name,
			$country_name ? '('.$country_name.')' : '',
		);

		return str_replace($search, $replace, $matches[1]);
	}

	/**
	 * Runs upon the WP filter woocommerce_get_price_suffix
	 *
	 * @param String $price_display_suffix
	 * @param Object $product
	 *
	 * @return String
	 */
	public function woocommerce_get_price_suffix($price_display_suffix, $product) {

		if (('' !== $price_display_suffix || (is_a($product, 'WC_Product_Variable') && defined('WOOCOMMERCE_VAT_PARSE_SUFFIXES_ALSO_WHEN_VARIABLE') && WOOCOMMERCE_VAT_PARSE_SUFFIXES_ALSO_WHEN_VARIABLE && '' != ($price_display_suffix = get_option('woocommerce_price_display_suffix')))) && preg_match('#\{iftax\}(.*)\{\/iftax\}#', $price_display_suffix, $matches)) {

			// Rounding is needed, otherwise you get an imprecise float (e.g. one can be d:14.199999999999999289457264239899814128875732421875, whilst the other is d:14.2017000000000006565414878423325717449188232421875)

			$decimals = absint(get_option('woocommerce_price_num_decimals'));
			$including_tax = round(wc_get_price_including_tax($product), $decimals);
			$excluding_tax = round(wc_get_price_excluding_tax($product), $decimals);

			if ($including_tax != $excluding_tax) {
				$this->suffixing_product = $product;
				$price_display_suffix = preg_replace_callback( '#\{iftax\}(.*)\{\/iftax\}#', array($this, 'price_display_replace_callback'), $price_display_suffix );
			} else {
				$price_display_suffix = preg_replace( '#\{iftax\}(.*)\{\/iftax\}#', '', $price_display_suffix );
			}

		}

		return $price_display_suffix;

	}

	// In WC 2.2.9, there is a filter woocommerce_get_tax_location which may a better one to use, depending on the purpose (needs verifying)
	public function woocommerce_customer_taxable_address($address) {

		// This is caught (on PHP 7.0+), because wc_get_chosen_shipping_method_ids calls WC()->session->get() without checking if WC()->session is an object.
		try {
			// wc_get_chosen_shipping_method_ids() is available, since it is used in the WC method calling this filter
			if (function_exists('wc_get_chosen_shipping_method_ids') && true === apply_filters('woocommerce_apply_base_tax_for_local_pickup', true) && count(array_intersect(wc_get_chosen_shipping_method_ids(), apply_filters('woocommerce_local_pickup_methods', array('legacy_local_pickup', 'local_pickup')))) > 0) {
				return $address;
			}
		} catch (Error $e) {
			error_log('Caught: '.$e->getMessage().' at '.$e->getFile().' line '.$e->getLine());
		}
	
		$country = isset($address[0]) ? $address[0] : '';
 		// $state = $address[1];
 		// $postcode = $address[2];
 		// $city = $address[3];

		if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) return $address;

		if (isset($this->compliance->wc->session) && is_object($this->compliance->wc->session)) {
			# Value set by check-out logic
			$vat_state = $this->compliance->wc->session->get('eu_vat_state_checkout');
		} else {
			$vat_state = '';
		}

		// Checkout or cart?
		if ((function_exists('is_checkout') && is_checkout()) || (function_exists('is_cart') && is_cart()) || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART') ) {

			// Processing of checkout form activity - get from session only

			$allow_from_widget = (!defined('WOOCOMMERCE_CHECKOUT') || !WOOCOMMERCE_CHECKOUT) ? true : false;

			$vat_country = $this->get_preselect_country(false, $allow_from_widget);
			if (!empty($vat_country) && $country != $vat_country) {
				return array($vat_country, $vat_state, '', '');
			}
			return $address;
		}

		$vat_country = $this->get_preselect_country(true);
		if (!empty($vat_country) && $country != $vat_country) {
			return array($vat_country, $vat_state, '', '');
		}

		return $address;

	}

	/**
	 * Shortcode function for creating the country selector drop-down
	 *
	 * @param Array $atts - shortcode attributes
	 *
	 * @return String - the resulting output
	 */
	public function shortcode_vat_country_selector($atts) {
		$atts = shortcode_atts(array(
			'include_notaxes' => 1,
			'classes' => '',
			'include_which_countries' => 'all'
		), $atts, 'euvat_country_selector');

		ob_start();
		$this->render_dropdown($atts['include_notaxes'], $atts['classes'], $atts['include_which_countries']);
		return ob_get_clean();
	}

	/**
	 * Render the country selection dropdown (output HTML)
	 *
	 * @param Integer $include_taxes - whether to include the 'Show prices without VAT' option
	 * @param String $classes - CSS classes to add to the form
	 * @param String $which_countries - either 'all', 'selling' or 'shipping'
	 */
	public function render_dropdown($include_notaxes = 1, $classes = '', $which_countries = 'all') {

		static $index_count = 0;
		$index_count++;

		$wc_countries = $this->compliance->wc->countries;
		
		$entry_countries = $wc_countries->countries;
		
		if ('shipping' == $which_countries) {
			$filter_list = array_keys($wc_countries->get_allowed_countries());
		} elseif ('selling' == $which_countries) {
			$filter_list = array_keys($wc_countries->get_shipping_countries());
		} else {
			$filter_list = array_keys($entry_countries);
		}

		$url = remove_query_arg('wc_country_preselect');

		echo '<form class="countrypreselect_chosencountry_form" action="'.esc_attr($url).'"><select name="wc_country_preselect" class="countrypreselect_chosencountry '.esc_attr($classes).'">';

		$selected_country = $this->get_preselect_country();

		if ($include_notaxes) {
			$selected = ('none' == $selected_country) ? ' selected="selected"' : '';
			$label = apply_filters('wc_country_preselect_notaxes_label', __('Show prices without VAT', 'woocommerce-eu-vat-compliance'));
			echo '<option value="none"'.$selected.'>'.htmlspecialchars($label).'</option>';
		}

		foreach ($entry_countries as $code => $label) {
			if (!in_array($code, $filter_list)) continue;
			$selected = ($code == $selected_country) ? ' selected="selected"' : '';
			echo '<option value="'.$code.'"'.$selected.'>'.$label.'</option>';
		}

		echo '</select>';

		if (2 == $include_notaxes) {
			$id = 'wc_country_preselect_withoutvat_checkbox_'.$index_count;
			echo '<div class="wc_country_preselect_withoutvat"><input id="'.$id.'" type="checkbox" class="wc_country_preselect_withoutvat_checkbox" '.(('none' == $selected_country) ? 'checked="checked"' : '').'> <label for="'.$id.'">'.apply_filters('wceuvat_showpriceswithoutvat_msg', __('Show prices without VAT', 'woocommerce-eu-vat-compliance')).'</label></div>';
		}

		echo '<noscript><input type="submit" value="'.__('Change', 'woocommerce-eu-vat-compliance').'"></noscript>';

		echo '</form>';

		add_action('wp_footer', array($this, 'wp_footer'));

	}

	/**
	 * Runs upon the WP action wp_footer if a drop-down is being shown
	 */
	public function wp_footer() {

		// Ensure we print once per page only
		static $already_printed;
		if (!empty($already_printed)) return;
		$already_printed = true;

		wp_enqueue_script('jquery');
		
		echo <<<ENDHERE
		<script>
			jQuery(function($) {

				// https://stackoverflow.com/questions/1634748/how-can-i-delete-a-query-string-parameter-in-javascript
				function removeURLParameter(url, parameter) {
					//prefer to use l.search if you have a location/link object
					var urlparts= url.split('?');   
					if (urlparts.length>=2) {

						var prefix= encodeURIComponent(parameter)+'=';
						var pars= urlparts[1].split(/[&;]/g);

						//reverse iteration as may be destructive
						for (var i= pars.length; i-- > 0;) {    
							//idiom for string.startsWith
							if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
								pars.splice(i, 1);
							}
						}

						url= urlparts[0]+'?'+pars.join('&');
						return url;
					} else {
						return url;
					}
				}

				var previously_chosen = '';

				$('.wc_country_preselect_withoutvat_checkbox').on('click', function() {
					var chosen = $(this).is(':checked');
					var selector = $(this).parents('form').find('select.countrypreselect_chosencountry');
					var none_exists_on_menu = $(selector).find('option[value="none"]').length;
					if (chosen) {
						if (none_exists_on_menu) {
// 							$(selector).val('none');
						}
						reload_page_with_country('none');
					} else {
						if (none_exists_on_menu) { $(selector).val('none'); }
						country = $(selector).val();
						if ('none' != country) { reload_page_with_country(country); }
					}
				});

				function reload_page_with_country(chosen) {
					var url = removeURLParameter(document.location.href.match(/(^[^#]*)/)[0], 'wc_country_preselect');
					if (url.indexOf('?') > -1){
						url += '&wc_country_preselect='+chosen;
					} else {
						url += '?&wc_country_preselect='+chosen;
					}
					window.location.href = url;
				}

				$('select.countrypreselect_chosencountry').on('change', function() {
					var chosen = $(this).val();
					reload_page_with_country(chosen);
				});
			});
		</script>
ENDHERE;
	}

	/**
	 * Will also set the class variable $preselect_route - useful for debugging
	 *
	 * @param Boolean $allow_via_geoip
	 * @param Boolean $allow_from_widget
	 * @param Boolean $allow_from_request
	 * @param Boolean $allow_from_session
	 *
	 * @return String|Boolean - if no result could be obtained, then will return false. A string could be a valid country, or 'none'.
	 */
	public function get_preselect_country($allow_via_geoip = true, $allow_from_widget = true, $allow_from_request = true, $allow_from_session = true) {

		$this->preselect_route = 'none';
		$this->preselect_result = false;
	
		// Priority: 1) Something set via _REQUEST 2) Something already set in the session 3) GeoIP country

		$countries = $this->compliance->wc->countries->countries;

 		// if (defined('DOING_AJAX') && DOING_AJAX && isset($_POST['action']) && 'woocommerce_update_order_review' == $_POST['action']) $allow_via_session = false;

		// Something set via _REQUEST? or _POST from shipping page calculator?
		if ($allow_from_request && (!empty($_REQUEST['wc_country_preselect']) || !empty($_POST['calc_shipping_country']))) {
			$req_country = (!empty($_POST['calc_shipping_country'])) ? $_POST['calc_shipping_country'] : $_REQUEST['wc_country_preselect'];

			if ('none' == $req_country || isset($countries[$req_country])) {

				if (isset($this->compliance->wc->customer)) {
					$customer = $this->compliance->wc->customer;
					// Set shipping/billing countries, so that the choice persists until the checkout
					if (is_a($customer, 'WC_Customer')) {
						$customer->set_billing_country($req_country);
						$customer->set_shipping_country($req_country);
					}
				}

				if (isset($this->compliance->wc->session)) {
					if (!$this->compliance->wc->session->has_session()) $this->compliance->wc->session->set_customer_session_cookie(true);
					if ('none' == $req_country) {
						$this->compliance->wc->session->set('vat_country_widget_choice', 'none');
					} else {
						$this->compliance->wc->session->set('vat_country_widget_choice', $req_country);
					}
				}

				$this->preselect_route = 'request_variable';
				$this->preselect_result = $req_country;
				
				return $req_country;
			}
		}

		// Something set in the session (via the widget)?
		if ($allow_from_widget) {
			$session_widget_country = isset($this->compliance->wc->session) ? $this->compliance->wc->session->get('vat_country_widget_choice') : '';
			if ('none' == $session_widget_country || ($session_widget_country && isset($countries[$session_widget_country]))) {
				$this->preselect_route = 'widget';
				$this->preselect_result = $session_widget_country;
				return $session_widget_country;
			}
		}

		if ($allow_from_session) {
			// Something already set in the session (via the checkout)?
			$session_country = isset($this->compliance->wc->session) ? $this->compliance->wc->session->get('vat_country_checkout') : '';
			// $vat_state = $this->compliance->wc->session->get('eu_vat_state_checkout');

			if ('none' == $session_country || ($session_country && isset($countries[$session_country]))) {
				$this->preselect_route = 'session';
				$this->preselect_result = $session_country;
				return $session_country;
			}
		}

		// GeoIP country?
		if ($allow_via_geoip) {
			$country_info = $this->compliance->get_visitor_country_info();
			$geoip_country = empty($country_info['data']) ? '' : $country_info['data'];
			if (isset($countries[$geoip_country])) {
				if (isset($this->compliance->wc->session)) {
					// Put in session, so that it will be retained on cart/checkout pages; but allow store-owners to prevent a new session being started if not desired
					if (!$this->compliance->wc->session->has_session() && apply_filters('wc_vat_start_session_for_geoip', true)) $this->compliance->wc->session->set_customer_session_cookie(true);
					if ($this->compliance->wc->session->has_session()) {
						$this->compliance->wc->session->set('vat_country_widget_choice', $geoip_country);
					}
				}
				$this->preselect_route = 'geoip_lookup';
				$this->preselect_result = $geoip_country;
				return $geoip_country;
			}
		}

		$woo_country = isset($this->compliance->wc->customer) ? (is_callable(array($this->compliance->wc->customer, 'get_billing_country')) ? $this->compliance->wc->customer->get_billing_country() : $this->compliance->wc->customer->get_country()) : $this->compliance->wc->countries->get_base_country();

		if ($woo_country) {
			$this->preselect_route = isset($this->compliance->wc->customer) ? 'woocommerce_customer_object' : 'woocommerce_base_country';
			$this->preselect_result = $woo_country;
			return $woo_country;
		}

		// No default
		return false;

	}

}
endif;
