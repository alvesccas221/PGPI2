<?php
/**
 * Class DeprecatedWidgetWordPressDisableMobileOption
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */

namespace LiveChat\Services\Options\Deprecated\Widget;

use LiveChat\Services\Options\Deprecated\DeprecatedOption;

/**
 * Class DeprecatedWidgetWordPressDisableMobileOption
 *
 * @package LiveChat\Services\Options\Deprecated\Widget
 */
class DeprecatedWidgetWordPressDisableMobileOption extends DeprecatedOption {
	/**
	 * DeprecatedWidgetWordPressDisableMobileOption constructor.
	 */
	public function __construct() {
		parent::__construct( 'disable_mobile' );
	}
}
