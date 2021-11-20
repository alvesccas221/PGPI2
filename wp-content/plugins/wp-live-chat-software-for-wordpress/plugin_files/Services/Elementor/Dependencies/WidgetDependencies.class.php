<?php
/**
 * WidgetDependencies class.
 *
 * @package LiveChat\Services\Elementor\Scripts
 */

namespace LiveChat\Services\Elementor\Dependencies;

use Elementor\Widget_Base;
use Elementor\Widgets_Manager;
use LiveChat\Services\Elementor\Dependencies\Scripts\ScriptDependency;
use LiveChat\Services\Elementor\Dependencies\Styles\StyleDependency;

/**
 * WidgetDependencies class.
 *
 * @package LiveChat\Services\Elementor\Scripts
 */
class WidgetDependencies {
	/**
	 * Instance of Widget_Base.
	 *
	 * @var Widget_Base $widget
	 */
	private $widget;

	/**
	 * Instance of Widgets_Manager.
	 *
	 * @var Widgets_Manager $widgets_manager
	 */
	private $widgets_manager;

	/**
	 * Array of ScriptDependency instances.
	 *
	 * @var ScriptDependency[] $script_dependencies
	 */
	private $script_dependencies;

	/**
	 * Array of StyleDependency instances.
	 *
	 * @var StyleDependency[] $style_dependencies
	 */
	private $style_dependencies;

	/**
	 * ElementorWidgetsProvider constructor.
	 *
	 * @param Widget_Base         $widget               Instance of Widget_Base.
	 * @param ScriptDependency[]  $script_dependencies  Array of ScriptDependency instances.
	 * @param StyleDependency[]   $style_dependencies   Array of StyleDependency instances.
	 * @param Widgets_Manager     $widgets_manager      Instance of Widgets_Manager.
	 */
	public function __construct( $widget, $script_dependencies, $style_dependencies, $widgets_manager ) {
		$this->widget              = $widget;
		$this->script_dependencies = $script_dependencies;
		$this->style_dependencies  = $style_dependencies;
		$this->widgets_manager     = $widgets_manager;
	}

	/**
	 * Registers all widget required dependencies.
	 */
	public function register() {
		$scripts_registered = array_reduce(
			$this->script_dependencies,
			function ( $acc, $dependency ) {
				return $acc && $dependency->register();
			},
			true
		);
		$styles_registered  = array_reduce(
			$this->style_dependencies,
			function ( $acc, $dependency ) {
				return $acc && $dependency->register();
			},
			true
		);

		if ( ! $scripts_registered || ! $styles_registered ) {
			return;
		}

		$this->widgets_manager->register_widget_type( $this->widget );
	}
}
