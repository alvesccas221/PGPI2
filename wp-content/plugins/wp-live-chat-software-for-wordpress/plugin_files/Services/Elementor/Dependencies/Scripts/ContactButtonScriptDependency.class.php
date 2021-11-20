<?php
/**
 * ContactButtonScriptDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Scripts
 */

namespace LiveChat\Services\Elementor\Dependencies\Scripts;

use Exception;
use LiveChat\Services\Options\Elementor\ContactButtonWidgetURL;
use LiveChat\Services\Options\WritableOption;

/**
 * ContactButtonScriptDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Scripts
 */
class ContactButtonScriptDependency extends ScriptDependency {
	/**
	 * Creates a new ContactButtonScriptDependency instance.
	 *
	 * @param string|null         $name Name of the script file.
	 * @param WritableOption|null $widget_url_option Widget URL WritableOption instance.
	 *
	 * @return static
	 * @throws Exception Can be thrown by parent create method.
	 */
	public static function create( $name = null, $widget_url_option = null ) {
		return parent::create( 'contact-button', ContactButtonWidgetURL::get_instance() );
	}
}
