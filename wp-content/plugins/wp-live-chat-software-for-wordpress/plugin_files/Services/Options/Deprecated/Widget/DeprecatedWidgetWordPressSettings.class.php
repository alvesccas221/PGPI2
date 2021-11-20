<?php
/**
 * Class DeprecatedWidgetWordPressSettings
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */

namespace LiveChat\Services\Options\Deprecated\Widget;

use LiveChat\Services\Options\OptionsSet;

/**
 * Class DeprecatedWidgetWordPressSettings
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */
class DeprecatedWidgetWordPressSettings extends OptionsSet {
	/**
	 * DeprecatedWidgetWordPressDisableMobileOption instance.
	 *
	 * @var DeprecatedWidgetWordPressDisableMobileOption
	 */
	protected $disable_mobile;
	/**
	 * DeprecatedWidgetWordPressDisableMobileOption instance.
	 *
	 * @var DeprecatedWidgetWordPressDisableGuestsOption
	 */
	protected $disable_guests;

	/**
	 * DeprecatedWidgetWordPressSettings constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'disable_mobile' => DeprecatedWidgetWordPressDisableMobileOption::get_instance(),
				'disable_guests' => DeprecatedWidgetWordPressDisableGuestsOption::get_instance(),
			)
		);
	}

	/**
	 * Returns array of WordPress widget options.
	 *
	 * @return bool[]
	 */
	public function get() {
		return array_map(
			function ( $val ) {
				return (bool) $val;
			},
			array_filter(
				array(
					'hideForGuests' => $this->disable_guests->get(),
					'hideOnMobile'  => $this->disable_mobile->get(),
				),
				function ( $val ) {
					return ! is_null( $val );
				}
			)
		);
	}

	/**
	 * Removes deprecated WordPress widget options.
	 *
	 * @return bool
	 */
	public function remove() {
		return $this->disable_guests->remove() && $this->disable_mobile->remove();
	}
}
