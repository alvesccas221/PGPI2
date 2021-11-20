<?php
/**
 * Class ContactButtonPreviewWidgetTemplate
 *
 * @package LiveChat\Services\Templates\Widgets\Previews
 */

namespace LiveChat\Services\Templates\Widgets\Previews;

use LiveChat\Services\Templates\Template;
use LiveChat\Services\TemplateParser;

/**
 * Class ContactButtonPreviewWidgetTemplate
 *
 * @package LiveChat\Services\Templates\Widgets\Previews
 */
class ContactButtonPreviewWidgetTemplate extends Template {
	/**
	 * Renders contact button widget for Elementor live preview mode.
	 *
	 * @return string
	 */
	public function render() {
		// Escaping output is skipped because Elementor requires string with valid HTML tags and handles its validation.
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $this->template_parser->get_template_file_contents( 'contact_button_preview_widget.html' );
	}

	/**
	 * Returns instance of ContactButtonPreviewWidgetTemplate class.
	 *
	 * @param string $context
	 * @return ContactButtonPreviewWidgetTemplate|static
	 */
	public static function create( $context = array() ) {
		return new static( TemplateParser::create( '../templates/widgets/previews' ), $context );
	}
}
