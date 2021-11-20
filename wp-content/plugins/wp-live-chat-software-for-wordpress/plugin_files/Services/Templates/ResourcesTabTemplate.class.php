<?php
/**
 * Class ResourcesTabTemplate
 *
 * @package LiveChat\Services\Templates
 */

namespace LiveChat\Services\Templates;

/**
 * Class ResourcesTabTemplate
 */
class ResourcesTabTemplate extends Template {
	/**
	 * Renders iframe with Resources page.
	 */
	public function render() {
		$context                 = array();
		$context['resourcesUrl'] = esc_html( WPLC_RESOURCES_URL );
		$this->template_parser->parse_template( 'resources.html.twig', $context );
	}
}
