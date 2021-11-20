<?php
/**
 * Class UserOption
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

use LiveChat\Services\Options\WooCommerce\WooCommerceUserOption;

/**
 * Class UserOption
 *
 * @package LiveChat\Services\Options
 */
class UserOption extends Option {
	/**
	 * Fallbacks default value to legacy WooCommerceOption value.
	 *
	 * @param mixed $id User ID.
	 * @return mixed
	 */
	public function get_option_fallback( $id ) {
		// To prevent fallbacks for WooCommerceUserOption instances.
		if ( WPLC_OPTION_PREFIX !== $this->prefix ) {
			return $this->fallback;
		}

		$woo_option       = new WooCommerceUserOption( $this->name, null );
		$woo_option_value = $woo_option->get( $id );

		if ( is_null( $woo_option_value ) ) {
			return $this->fallback;
		}

		$this->set( $id, $woo_option_value );
		$woo_option->remove( $id );

		return $woo_option_value;
	}

	/**
	 * Returns JWt for given user.
	 *
	 * @param mixed $id User ID.
	 * @return string
	 */
	public function get( $id ) {
		$option = get_option( sprintf( $this->key, $id ), null );

		if ( is_null( $option ) ) {
			return $this->get_option_fallback( $id );
		}

		return $option;
	}

	/**
	 * Removes JWt for given user.
	 *
	 * @param mixed $id User ID.
	 * @return string
	 */
	public function remove( $id ) {
		return delete_option( sprintf( $this->key, $id ) );
	}

	/**
	 * Returns JWt for given user.
	 *
	 * @param mixed  $id    User ID.
	 * @param string $value JWT.
	 * @return string
	 */
	public function set( $id, $value ) {
		return update_option( sprintf( $this->key, $id ), $value );
	}
}
