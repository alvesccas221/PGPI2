<?php
/**
 * Class LiveChat
 *
 * @package LiveChat
 */

namespace LiveChat;

use LiveChat\Services\LicenseProvider;
use LiveChat\Services\ModuleConfiguration;
use LiveChat\Services\Templates\TrackingCodeTemplate;
use LiveChat\Services\WidgetProvider;
use LiveChat\Services\WooCommerce\CustomerTrackingProvider;
use LiveChat\Services\Elementor\ElementorWidgetsProvider;

/**
 * Class LiveChat
 */
class LiveChat {
	/**
	 * Singleton pattern
	 *
	 * @var LiveChat $instance
	 */
	protected static $instance;

	/**
	 * Instance of ModuleConfiguration class
	 *
	 * @var ModuleConfiguration|null
	 */
	protected $module = null;

	/**
	 * LiveChat account login
	 *
	 * @var string|null $login
	 */
	protected $login = null;

	/**
	 * Starts the plugin
	 */
	public function __construct() {
		add_action(
			'plugins_loaded',
			function () {
				if ( livechat_is_woo() ) {
					$customer_tracking = CustomerTrackingProvider::create();
					add_action( 'wp_ajax_lc-refresh-cart', array( $customer_tracking, 'ajax_get_customer_tracking' ) );
					add_action( 'wp_ajax_nopriv_lc-refresh-cart', array( $customer_tracking, 'ajax_get_customer_tracking' ) );
				}

				if ( livechat_is_elementor_plugin_active() ) {
					ElementorWidgetsProvider::get_instance()->init();
				}

				$this->init_services();
			}
		);
	}

	/**
	 * Inits basic services.
	 */
	public function init_services() {
		if ( LicenseProvider::create()->has_deprecated_license_number() ) {
			add_action( 'wp_head', array( TrackingCodeTemplate::create(), 'render' ) );
			return;
		}

		add_action( 'wp_footer', array( WidgetProvider::get_instance(), 'set_widget' ) );
	}

	/**
	 * Singleton pattern
	 *
	 * @return LiveChat
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
}
