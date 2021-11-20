<?php
/**
 * Class CustomerTrackingProvider
 *
 * @package LiveChat\Services\WooCommerce
 */

namespace LiveChat\Services\WooCommerce;

use LiveChat\Services\User;
use WC_Cart;
use WC_Customer;

/**
 * Class CustomerTrackingProvider
 *
 * @package LiveChat\Services\WooCommerce
 */
class CustomerTrackingProvider {
	/**
	 * Instance of User.
	 *
	 * @var User
	 */
	private $user;

	/**
	 * CustomerTrackingProvider constructor.
	 *
	 * @param User $user   Instance of User.
	 */
	public function __construct( $user ) {
		$this->user = $user;
	}

	/**
	 * Returns shipping address string for given customer.
	 *
	 * @param WC_Customer $customer  Woo customer.
	 * @param array       $countries WooCommerce countries.
	 *
	 * @return string
	 */
	private function get_shipping_address( $customer, $countries ) {
		return implode(
			', ',
			array_filter(
				array(
					$customer->get_shipping_address_1(),
					$customer->get_shipping_address_2(),
					implode(
						' ',
						array_filter(
							array(
								$customer->get_shipping_city(),
								$customer->get_shipping_state(),
								$customer->get_shipping_postcode(),
							)
						)
					),
					$countries[ $customer->get_shipping_country() ],
				)
			)
		);
	}

	/**
	 * Returns cart contents.
	 *
	 * @param WC_Cart $woo_cart Woo cart.
	 *
	 * @return array
	 */
	private function get_cart_content( $woo_cart ) {
		$count = $woo_cart->get_cart_contents_count();
		$cart  = array();

		if ( $count > 0 ) {
			$cart['Total count'] = $count;
			$total               = $woo_cart->get_cart_contents_total();
			$currency            = get_woocommerce_currency();
			$cart['Total value'] = "$total $currency";

			$items = $woo_cart->get_cart_contents();
			foreach ( $items as $item ) {
				$product = wc_get_product( $item['data'] );
				$url     = $product->get_permalink();
				$qty     = $item['quantity'];
				$name    = $product->get_name();

				$cart[ "{$qty}x $name" ] = $url;
			}
		}

		return $cart;
	}

	/**
	 * Returns cart and customer tracking data for AJAX action.
	 */
	public function ajax_get_customer_tracking() {
		$woocommerce = WC();

		if ( ! $woocommerce ) {
			return null;
		}

		$woo_customer = $woocommerce->customer;

		if ( ! $woo_customer ) {
			return null;
		}

		$customer_details = array();

		if ( $this->user->check_logged() ) {
			$order                          = wc_get_customer_last_order( $woo_customer->get_id() );
			$order_url                      = $order ? $order->get_edit_order_url() : null;
			$customer_details['Last order'] = $order_url ? $order_url : '---';

			$customer_details['Shipping address'] = $this->get_shipping_address( $woo_customer, $woocommerce->countries->get_countries() );
		}

		$cart_contents = $this->get_cart_content( $woocommerce->cart );
		wp_send_json(
			array(
				'cart'     => array_merge(
					$customer_details,
					$cart_contents
				),
				'customer' => $this->user->get_user_data(),
			)
		);
	}

	/**
	 * Returns new instance of CustomerTrackingProvider class.
	 *
	 * @return CustomerTrackingProvider
	 */
	public static function create() {
		return new static(
			User::get_instance()
		);
	}
}
