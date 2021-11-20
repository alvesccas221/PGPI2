<?php
/**
 * QualityBadgeWidgetDependencies class.
 *
 * @package LiveChat\Services\Elementor\Dependencies
 */

namespace LiveChat\Services\Elementor\Dependencies;

use Elementor\LiveChatQualityBadgeWidget;
use Elementor\Plugin;
use Exception;
use LiveChat\Services\Elementor\Dependencies\Scripts\QualityBadgeScriptDependency;
use LiveChat\Services\Elementor\Dependencies\Styles\QualityBadgeStyleDependency;

/**
 * QualityBadgeWidgetDependencies class.
 *
 * @package LiveChat\Services\Elementor\Dependencies
 */
class QualityBadgeWidgetDependencies extends WidgetDependencies {
	/**
	 * Creates new instance of QualityBadgeWidgetDependencies.
	 *
	 * @return QualityBadgeWidgetDependencies
	 * @throws Exception Can be thrown by parent class create method.
	 */
	public static function create() {
		return new static(
			LiveChatQualityBadgeWidget::create(),
			array( QualityBadgeScriptDependency::create() ),
			array( QualityBadgeStyleDependency::create() ),
			Plugin::instance()->widgets_manager
		);
	}
}
