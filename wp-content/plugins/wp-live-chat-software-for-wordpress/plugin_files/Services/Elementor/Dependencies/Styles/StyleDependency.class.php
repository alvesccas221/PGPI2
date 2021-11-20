<?php
/**
 * StyleDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Scripts
 */

namespace LiveChat\Services\Elementor\Dependencies\Styles;

use LiveChat\Services\ModuleConfiguration;

/**
 * StyleDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Scripts
 */
class StyleDependency {
	/**
	 * Name of the style file.
	 *
	 * @var string $name
	 */
	private $name;

	/**
	 * ModuleConfiguration instance.
	 *
	 * @var ModuleConfiguration $module_configuration
	 */
	private $module_configuration;

	/**
	 * Path to the styles file.
	 *
	 * @var string $style_file_path
	 */
	private $style_file_path;

	/**
	 * StyleDependency constructor.
	 *
	 * @param string               $name                    Name of the style file.
	 * @param ModuleConfiguration  $module_configuration    ModuleConfiguration instance.
	 * @param string               $style_file_path         Path to the styles file.
	 */
	public function __construct( $name, $module_configuration, $style_file_path ) {
		$this->name                 = $name;
		$this->module_configuration = $module_configuration;
		$this->style_file_path      = $style_file_path;
	}

	/**
	 * Returns handle name for dependency.
	 *
	 * @return string
	 */
	private function get_handle_name() {
		return sprintf(
			'livechat-%s-style',
			$this->name
		);
	}

	/**
	 * Returns file URL based on plugin URL and local path to file.
	 *
	 * @param string $style_file_path Path to the styles file.
	 *
	 * @return string
	 */
	private function get_file_url( $style_file_path ) {
		return sprintf(
			'%s%s',
			$this->module_configuration->get_plugin_url(),
			$style_file_path
		);
	}

	/**
	 * Registers widget styles sheets.
	 *
	 * @return bool
	 */
	public function register() {
		$handle_name = $this->get_handle_name();

		$was_registered = wp_register_style(
			$handle_name,
			$this->get_file_url( $this->style_file_path ),
			array(),
			$this->module_configuration->get_plugin_version()
		);

		if ( $was_registered ) {
			wp_enqueue_style( $handle_name );
		}

		return $was_registered;
	}

	/**
	 * Creates a new StyleDependency instance.
	 *
	 * @param string  $name             Name of the style file.
	 * @param string  $style_file_path  Path to the styles file.
	 *
	 * @return static
	 */
	public static function create( $name, $style_file_path ) {
		return new static(
			$name,
			ModuleConfiguration::get_instance(),
			$style_file_path
		);
	}
}
