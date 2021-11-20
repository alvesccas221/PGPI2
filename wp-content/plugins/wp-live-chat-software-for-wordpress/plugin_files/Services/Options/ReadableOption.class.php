<?php
/**
 * Class ReadableOption
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

use LiveChat\Services\Options\WooCommerce\WooCommerceOption;

/**
 * Class ReadableOption
 *
 * @package LiveChat\Services\Options
 */
class ReadableOption extends Option {
	/**
	 * Fallbacks default value to legacy WooCommerceOption value.
	 *
	 * @param mixed $id User ID.
	 * @return mixed
	 */
	public function get_option_fallback( $id = null ) {
		// To prevent fallbacks for WooCommerceOption instances.
		if ( WPLC_OPTION_PREFIX !== $this->prefix ) {
			return $this->fallback;
		}

		$woo_option       = new WooCommerceOption( $this->name, null );
		$woo_option_value = $woo_option->get();

		if ( is_null( $woo_option_value ) ) {
			return $this->fallback;
		}

		update_option( $this->key, $woo_option_value );
		$woo_option->remove();

		return $woo_option_value;
	}

	/**
	 * Returns option value.
	 *
	 * @return mixed
	 */
	public function get() {
		$option = get_option( $this->key, null );

		if ( is_null( $option ) ) {
			return $this->get_option_fallback();
		}

		return $option;
	}

	/**
	 * Removes an option.
	 *
	 * @return bool
	 */
	public function remove() {
		return delete_option( $this->key );
	}
}
