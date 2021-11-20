<?php
/**
 * ContactButtonWidgetDependencies class.
 *
 * @package LiveChat\Services\Elementor\Dependencies
 */

namespace LiveChat\Services\Elementor\Dependencies;

use Elementor\LiveChatContactButtonWidget;
use Elementor\Plugin;
use Exception;
use LiveChat\Services\Elementor\Dependencies\Scripts\ContactButtonScriptDependency;
use LiveChat\Services\Elementor\Dependencies\Styles\ContactButtonStyleDependency;

/**
 * ContactButtonWidgetDependencies class.
 *
 * @package LiveChat\Services\Elementor\Dependencies
 */
class ContactButtonWidgetDependencies extends WidgetDependencies {
	/**
	 * Creates new instance of ContactButtonWidgetDependencies.
	 *
	 * @return ContactButtonWidgetDependencies
	 * @throws Exception Can be thrown by parent class create method.
	 */
	public static function create() {
		return new static(
			LiveChatContactButtonWidget::create(),
			array( ContactButtonScriptDependency::create() ),
			array( ContactButtonStyleDependency::create() ),
			Plugin::instance()->widgets_manager
		);
	}
}
