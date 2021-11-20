<?php
/**
 * Class WidgetProvider
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use Exception;
use LiveChat\Services\Templates\ChatWidgetScriptTemplate;
use LiveChat\Services\Templates\TrackingCodeTemplate;

/**
 * Class WidgetProvider
 *
 * @package LiveChat\Services
 */
class WidgetProvider {
	/**
	 * Instance of WidgetProvider.
	 *
	 * @var WidgetProvider|null
	 */
	private static $instance = null;

	/**
	 * Instance of ChatWidgetScriptTemplate.
	 *
	 * @var ChatWidgetScriptTemplate
	 */
	private $chat_widget_script_template;

	/**
	 * Instance of TrackingCodeTemplate.
	 *
	 * @var TrackingCodeTemplate
	 */
	private $tracking_code_template;

	/**
	 * WidgetProvider constructor.
	 *
	 * @param ChatWidgetScriptTemplate $chat_widget_script_template Instance of ChatWidgetScriptTemplate.
	 * @param TrackingCodeTemplate     $tracking_code_template      Instance of TrackingCodeTemplate.
	 */
	public function __construct( $chat_widget_script_template, $tracking_code_template ) {
		$this->chat_widget_script_template = $chat_widget_script_template;
		$this->tracking_code_template      = $tracking_code_template;
	}

	/**
	 * Sets widget script.
	 */
	public function set_widget() {
		if ( livechat_is_elementor_preview_mode() ) {
			return;
		}

		try {
			$this->chat_widget_script_template->render();
		} catch ( Exception $ex ) {
			$this->tracking_code_template->render();
		}
	}

	/**
	 * Returns instance of WidgetProvider (singleton pattern).
	 *
	 * @return WidgetProvider|null
	 * @throws Exception
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static(
				ChatWidgetScriptTemplate::create(),
				TrackingCodeTemplate::create()
			);
		}

		return static::$instance;
	}
}
