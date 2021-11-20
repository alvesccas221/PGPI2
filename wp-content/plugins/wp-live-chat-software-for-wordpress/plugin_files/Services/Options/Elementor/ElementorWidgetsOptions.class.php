<?php
/**
 * Class ElementorWidgetsOptions
 *
 * @package LiveChat\Services\Options\Elementor
 */

namespace LiveChat\Services\Options\Elementor;

use Exception;
use LiveChat\Services\Options\OptionsSet;

/**
 * Class ElementorWidgetsOptions
 *
 * @package LiveChat\Services\Options\Elementor
 */
class ElementorWidgetsOptions extends OptionsSet {
	/**
	 * Instance of ContactButtonWidgetURL class.
	 *
	 * @var ContactButtonWidgetURL
	 */
	public $contact_button_widget_url;

	/**
	 * ElementorWidgetsOptions constructor.
	 *
	 * @throws Exception Can be thrown by OptionsSet constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'contact_button_widget_url' => ContactButtonWidgetURL::get_instance(),
				'quality_badge_widget_url'  => QualityBadgeWidgetURL::get_instance(),
			)
		);
	}
}
