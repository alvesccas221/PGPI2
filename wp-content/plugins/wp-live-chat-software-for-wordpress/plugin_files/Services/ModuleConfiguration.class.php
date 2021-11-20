<?php
/**
 * Class ModuleConfiguration
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

/**
 * Class ModuleConfiguration
 *
 * @package LiveChat\Services
 */
class ModuleConfiguration {
	/**
	 * Instance of ModuleConfiguration (singleton pattern)
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * WordPress site's url
	 *
	 * @var string
	 */
	private $site_url;

	/**
	 * Plugin's url
	 *
	 * @var string
	 */
	private $plugin_url;

	/**
	 * WordPress version
	 *
	 * @var string
	 */
	private $wp_version;

	/**
	 * Plugins version
	 *
	 * @var string
	 */
	private $plugin_version;

	/**
	 * ModuleConfiguration constructor.
	 */
	public function __construct() {
		global $wp_version;

		$this->wp_version = $wp_version;
	}

	/**
	 * Returns WordPress version
	 *
	 * @return string
	 */
	public function get_wp_version() {
		return $this->wp_version;
	}

	/**
	 * Returns WooCommerce version
	 *
	 * @return string
	 */
	public function get_extension_version() {
		if ( livechat_is_woo() ) {
			return defined( 'WOOCOMMERCE_VERSION' ) ? WOOCOMMERCE_VERSION : 'unknown';
		}

		if ( livechat_is_elementor() ) {
			return defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : 'unknown';
		}

		return '';
	}

	/**
	 * Returns plugin files absolute path
	 *
	 * @return string
	 */
	public function get_plugin_url() {
		if ( is_null( $this->plugin_url ) ) {
			$this->plugin_url = plugin_dir_url( __DIR__ . '..' );
		}

		return $this->plugin_url;
	}

	/**
	 * Returns site's url
	 *
	 * @return string
	 */
	public function get_site_url() {
		if ( is_null( $this->site_url ) ) {
			$this->site_url = get_site_url();
		}

		return $this->site_url;
	}

	/**
	 * Returns this plugin's version
	 *
	 * @return string
	 */
	public function get_plugin_version() {
		if ( is_null( $this->plugin_version ) ) {
			list(, $file)         = explode( '/', WPLC_PLUGIN_MAIN_FILE );
			$this->plugin_version = get_file_data( __DIR__ . '/../../' . $file, array( 'Version' ) )[0];
		}

		return $this->plugin_version;
	}

	/**
	 * Returns new instance of ModuleConfiguration class
	 *
	 * @return ModuleConfiguration
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
}
