<?php
/**
 * Class WooCommerceOption
 *
 * @package LiveChat\Services\Options\WooCommerce
 */

namespace LiveChat\Services\Options\WooCommerce;

use LiveChat\Services\Options\ReadableOption;

/**
 * Class WooCommerceOption
 *
 * @package LiveChat\Services\Options\WooCommerce
 */
class WooCommerceOption extends ReadableOption {
	/**
	 * WooCommerceOption constructor.
	 *
	 * @param string $key WooCommerce deprecated option key.
	 * @param mixed  $fallback Fallback value.
	 */
	public function __construct( $key, $fallback = null ) {
		parent::__construct(
			$key,
			$fallback,
			WPLC_DEPRECATED_OPTION_PREFIXES['woo-2.x']
		);
	}
}
