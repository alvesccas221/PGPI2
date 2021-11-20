<?php
/**
 * Class ContactButtonWidgetURL
 *
 * @package LiveChat\Services\Options\Elementor
 */

namespace LiveChat\Services\Options\Elementor;

use Exception;
use LiveChat\Services\Options\WritableOption;

/**
 * Class ContactButtonWidgetURL
 *
 * @package LiveChat\Services\Options\Elementor
 */
class ContactButtonWidgetURL extends WritableOption {
	/**
	 * ContactButtonWidgetURL constructor.
	 *
	 * @throws Exception Can be thrown by parent constructor.
	 */
	public function __construct() {
		parent::__construct( 'contact_button_widget_url' );
	}
}
