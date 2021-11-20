<?php
/**
 * QualityBadgeScriptDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Scripts
 */

namespace LiveChat\Services\Elementor\Dependencies\Scripts;

use Exception;
use LiveChat\Services\Options\Elementor\QualityBadgeWidgetURL;
use LiveChat\Services\Options\WritableOption;

/**
 * QualityBadgeScriptDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Scripts
 */
class QualityBadgeScriptDependency extends ScriptDependency {
	/**
	 * Creates a new QualityBadgeScriptDependency instance.
	 *
	 * @param string|null         $name Name of the script file.
	 * @param WritableOption|null $widget_url_option Widget URL WritableOption instance.
	 *
	 * @return static
	 * @throws Exception Can be thrown by parent create method.
	 */
	public static function create( $name = null, $widget_url_option = null ) {
		return parent::create( 'quality-badge', QualityBadgeWidgetURL::get_instance() );
	}
}
