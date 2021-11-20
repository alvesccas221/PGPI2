<?php
/**
 * ElementorWidgetsFactory class.
 *
 * @package LiveChat\Services\Elementor\Factories
 */

namespace LiveChat\Services\Elementor\Factories;

use Exception;
use LiveChat\Services\Elementor\Dependencies\ContactButtonWidgetDependencies;
use LiveChat\Services\Elementor\Dependencies\QualityBadgeWidgetDependencies;
use LiveChat\Services\Elementor\Dependencies\WidgetDependencies;

/**
 * ElementorWidgetsFactory class.
 *
 * @package LiveChat\Services\Elementor\Factories
 */
class ElementorWidgetsFactory {
	/**
	 * Returns array of Elementor widgets instances.
	 *
	 * @return WidgetDependencies[]
	 * @throws Exception Can be thrown by widget create method.
	 */
	public function create() {
		return array(
			ContactButtonWidgetDependencies::create(),
			QualityBadgeWidgetDependencies::create(),
		);
	}

	/**
	 * Returns new instance of ElementorWidgetsFactory.
	 *
	 * @return ElementorWidgetsFactory
	 */
	public static function get_instance() {
		return new static();
	}
}
