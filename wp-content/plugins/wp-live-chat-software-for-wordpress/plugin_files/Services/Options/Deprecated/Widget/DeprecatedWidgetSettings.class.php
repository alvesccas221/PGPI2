<?php
/**
 * Class DeprecatedWidgetSettings
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */

namespace LiveChat\Services\Options\Deprecated\Widget;

use LiveChat\Services\Options\OptionsSet;

/**
 * Class DeprecatedWidgetSettings
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */
class DeprecatedWidgetSettings extends OptionsSet {
	/**
	 * DeprecatedWidgetWordPressSettings instance.
	 *
	 * @var DeprecatedWidgetWordPressSettings
	 */
	protected $wp;
	/**
	 * DeprecatedWidgetWooCommerceSettings instance.
	 *
	 * @var DeprecatedWidgetWooCommerceSettings
	 */
	protected $woo;

	/**
	 * DeprecatedWidgetSettings constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'wp'  => DeprecatedWidgetWordPressSettings::get_instance(),
				'woo' => DeprecatedWidgetWooCommerceSettings::get_instance(),
			)
		);
	}

	/**
	 * Returns array of settings based on current platform.
	 *
	 * @return DeprecatedWidgetWooCommerceSettings|DeprecatedWidgetWordPressSettings
	 */
	private function option() {
		if ( livechat_is_woo() ) {
			return $this->woo;
		}

		return $this->wp;
	}

	/**
	 * Returns array of settings based on current platform.
	 *
	 * @return bool[]
	 */
	public function get() {
		return $this->option()->get();
	}

	/**
	 * Returns array of settings based on current platform.
	 *
	 * @return bool
	 */
	public function remove() {
		return $this->option()->remove();
	}
}
