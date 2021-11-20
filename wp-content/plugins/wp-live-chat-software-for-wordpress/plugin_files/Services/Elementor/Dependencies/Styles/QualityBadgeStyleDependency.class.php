<?php
/**
 * QualityBadgeStyleDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Styles
 */

namespace LiveChat\Services\Elementor\Dependencies\Styles;

/**
 * QualityBadgeStyleDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Styles
 */
class QualityBadgeStyleDependency extends StyleDependency {
	/**
	 * Creates a new QualityBadgeStyleDependency instance.
	 *
	 * @param string|null $name             Name of the style file.
	 * @param string|null $style_file_path  Path to the styles file.
	 *
	 * @return static
	 */
	public static function create( $name = null, $style_file_path = null ) {
		return parent::create( 'quality-badge', 'css/livechat-quality-badge.css' );
	}
}
