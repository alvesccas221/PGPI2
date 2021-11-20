<?php
/**
 * Class DeprecatedWidgetWooCommerceSettings
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */

namespace LiveChat\Services\Options\Deprecated\Widget;

use LiveChat\Services\Options\Deprecated\DeprecatedOption;

/**
 * Class DeprecatedWidgetWooCommerceSettings
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */
class DeprecatedWidgetWooCommerceSettings extends DeprecatedOption {
	/**
	 * DeprecatedWidgetWooCommerceSettings constructor.
	 */
	public function __construct() {
		parent::__construct( 'customDataSettings' );
	}

	/**
	 * Returns array of WooCommerce widget options.
	 *
	 * @return bool[]
	 */
	public function get() {
		$settings = parent::get();

		if ( ! is_array( $settings ) ) {
			return array();
		}

		return $this->extract_widget_options( $settings );
	}

	/**
	 * Returns mapped deprecated widget options from plugin settings.
	 *
	 * @param array $settings Array with legacy settings.
	 *
	 * @return bool[]
	 */
	public function extract_widget_options( $settings ) {
		$options            = array();
		$disable_guest_key  = $this->prefix . 'disableGuest';
		$disable_mobile_key = $this->prefix . 'disableMobile';

		if ( array_key_exists( $disable_guest_key, $settings ) ) {
			$options['hideForGuests'] = $settings[ $disable_guest_key ];
		}

		if ( array_key_exists( $disable_mobile_key, $settings ) ) {
			$options['hideOnMobile'] = $settings[ $disable_mobile_key ];
		}

		return $options;
	}
}
