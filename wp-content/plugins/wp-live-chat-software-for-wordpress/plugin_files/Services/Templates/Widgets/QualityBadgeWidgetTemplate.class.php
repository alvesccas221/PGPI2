<?php
/**
 * Class QualityBadgeWidgetTemplate
 *
 * @package LiveChat\Services\Templates
 */

namespace LiveChat\Services\Templates\Widgets;

use LiveChat\Services\Templates\Template;
use LiveChat\Services\TemplateParser;

/**
 * Class QualityBadgeWidgetTemplate
 *
 * @package LiveChat\Services\Templates
 */
class QualityBadgeWidgetTemplate extends Template {
	/**
	 * Renders quality badge widget for Elementor plugin.
	 *
	 * @return string
	 */
	public function render() {
		return $this->template_parser->parse_template( 'quality_badge_widget.html.twig', $this->context );
	}

	/**
	 * Returns instance of QualityBadgeWidgetTemplate class.
	 *
	 * @param array $context
	 * @return QualityBadgeWidgetTemplate|static
	 */
	public static function create( $context = array() ) {
		return new static( TemplateParser::create( '../templates/widgets' ), $context );
	}
}
