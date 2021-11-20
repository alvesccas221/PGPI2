<?php
/**
 * Class DeprecatedWidgetWordPressDisableGuestsOption
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */

namespace LiveChat\Services\Options\Deprecated\Widget;

use LiveChat\Services\Options\Deprecated\DeprecatedOption;

/**
 * Class DeprecatedWidgetWordPressDisableGuestsOption
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */
class DeprecatedWidgetWordPressDisableGuestsOption extends DeprecatedOption {
	/**
	 * DeprecatedWidgetWordPressDisableGuestsOption constructor.
	 */
	public function __construct() {
		parent::__construct( 'disable_guests' );
	}
}
