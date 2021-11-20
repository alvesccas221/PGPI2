<?php
/**
 * Class ContactButtonWidgetTemplate
 *
 * @package LiveChat\Services\Templates\Widgets
 */

namespace LiveChat\Services\Templates\Widgets;

use LiveChat\Services\Templates\Template;
use LiveChat\Services\TemplateParser;

/**
 * Class ContactButtonWidgetTemplate
 *
 * @package LiveChat\Services\Templates\Widgets
 */
class ContactButtonWidgetTemplate extends Template {
	/**
	 * Renders contact button widget for Elementor plugin.
	 *
	 * @return string
	 */
	public function render() {
		return $this->template_parser->parse_template( 'contact_button_widget.html.twig', $this->context );
	}

	/**
	 * Returns instance of ContactButtonWidgetTemplate class.
	 *
	 * @param string $context
	 * @return ContactButtonWidgetTemplate|static
	 */
	public static function create( $context = array() ) {
		return new static( TemplateParser::create( '../templates/widgets' ), $context );
	}
}
