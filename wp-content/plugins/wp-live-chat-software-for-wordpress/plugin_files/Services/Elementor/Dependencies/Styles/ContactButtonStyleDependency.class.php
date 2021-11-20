<?php
/**
 * ContactButtonStyleDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Styles
 */

namespace LiveChat\Services\Elementor\Dependencies\Styles;

/**
 * ContactButtonStyleDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Styles
 */
class ContactButtonStyleDependency extends StyleDependency {
	/**
	 * Creates a new ContactButtonStyleDependency instance.
	 *
	 * @param string|null $name             Name of the style file.
	 * @param string|null $style_file_path  Path to the styles file.
	 *
	 * @return static
	 */
	public static function create( $name = null, $style_file_path = null ) {
		return parent::create( 'contact-button', 'css/livechat-contact-button.css' );
	}
}
