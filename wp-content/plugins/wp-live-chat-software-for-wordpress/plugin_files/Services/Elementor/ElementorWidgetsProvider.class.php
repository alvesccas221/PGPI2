<?php
/**
 * Class ElementorWidgetsProvider
 *
 * @package LiveChat\Services\Elementor
 */

namespace LiveChat\Services\Elementor;

use Elementor\Plugin;
use Exception;
use LiveChat\Services\Elementor\Factories\ElementorWidgetsFactory;
use LiveChat\Services\ModuleConfiguration;

/**
 * Class ElementorWidgetsProvider
 *
 * @package LiveChat\Services\Elementor
 */
class ElementorWidgetsProvider {
	/**
	 * Instance of self (singleton pattern)
	 *
	 * @var ElementorWidgetsProvider|null $instance
	 */
	private static $instance = null;

	/**
	 * Plugin instance
	 *
	 * @var \Elementor\Plugin $plugin
	 */
	public $plugin;

	/**
	 * ElementorWidgetsFactory instance.
	 *
	 * @var ElementorWidgetsFactory
	 */
	private $elementor_widgets_factory;

	/**
	 * ModuleConfiguration instance.
	 *
	 * @var ModuleConfiguration
	 */
	private $module_configuration;

	/**
	 * ElementorWidgetsProvider constructor.
	 *
	 * @param \Elementor\Plugin       $plugin                         Plugin instance.
	 * @param ElementorWidgetsFactory $elementor_widgets_factory      ElementorWidgetsFactory instance.
	 * @param ModuleConfiguration     $module_configuration             ModuleConfiguration instance.
	 */
	public function __construct(
		$plugin,
		$elementor_widgets_factory,
		$module_configuration
	) {
		$this->plugin                    = $plugin;
		$this->elementor_widgets_factory = $elementor_widgets_factory;
		$this->module_configuration      = $module_configuration;
	}

	/**
	 * Initiates hooks.
	 */
	public function init() {
		add_action( 'elementor/init', array( $this, 'register_categories' ) );
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'register_common_icons' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}

	/**
	 * Registers widgets.
	 *
	 * @throws Exception Can be thrown by create method.
	 */
	public function register_widgets() {
		$widgets = $this->elementor_widgets_factory->create();
		foreach ( $widgets as $widget ) {
			$widget->register();
		}
	}

	/**
	 * Registers categories.
	 */
	public function register_categories() {
		$this->plugin->elements_manager->add_category(
			'livechat',
			array(
				'title' => __( 'LiveChat', 'wp-live-chat-software-for-wordpress' ),
				'icon'  => 'lc lc-livechat',
			)
		);
	}

	/**
	 * Returns custom LiveChat icons.
	 *
	 * @return array
	 */
	public function register_common_icons() {
		$icons_url      = $this->module_configuration->get_plugin_url() . 'css/livechat-icons.css';
		$plugin_version = $this->module_configuration->get_plugin_version();

		wp_register_style(
			'livechat-icons-style',
			$icons_url,
			array(),
			$plugin_version
		);
		wp_enqueue_style( 'livechat-icons-style' );

		return array(
			'livechat-icons' => array(
				'name'          => 'livechat-icons',
				'label'         => __( 'LiveChat Icons', 'wp-live-chat-software-for-wordpress' ),
				'labelIcon'     => 'lc lc-livechat',
				'prefix'        => 'lc-',
				'displayPrefix' => 'lc',
				'url'           => $icons_url,
				'icons'         => array(
					'livechat',
					'contact-button',
					'quality-badge',
				),
				'ver'           => $plugin_version,
				'native'        => true,
			),
		);
	}

	/**
	 * Returns instance of ElementorWidgetsProvider (singleton pattern).
	 *
	 * @return ElementorWidgetsProvider
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new static(
				Plugin::instance(),
				ElementorWidgetsFactory::get_instance(),
				ModuleConfiguration::get_instance()
			);
		}
		return self::$instance;
	}
}
