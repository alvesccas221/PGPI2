<?php
/**
 * Class LiveChatQualityBadgeWidget
 *
 * @package Elementor
 */

namespace Elementor;

use LiveChat\Services\Templates\Widgets\QualityBadgeWidgetTemplate;

/**
 * Class LiveChatQualityBadgeWidget
 *
 * @package Elementor
 */
class LiveChatQualityBadgeWidget extends Widget_Base {
	/**
	 * Returns widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'livechat-quality-badge';
	}

	/**
	 * Returns widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Quality Badge', 'wp-live-chat-software-for-wordpress' );
	}

	/**
	 * Returns widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'lc lc-quality-badge';
	}

	/**
	 * Returns widget categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'livechat' );
	}

	/**
	 * Registers widget controls.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'badge_settings',
			array(
				'label' => __( 'Badge Settings', 'wp-live-chat-software-for-wordpress' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'theme',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Theme', 'wp-live-chat-software-for-wordpress' ),
				'default' => 'light',
				'options' => array(
					'light' => __( 'Light', 'wp-live-chat-software-for-wordpress' ),
					'dark'  => __( 'Dark', 'wp-live-chat-software-for-wordpress' ),
				),
			)
		);

		$this->add_control(
			'size',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Size', 'wp-live-chat-software-for-wordpress' ),
				'default' => 200,
				'options' => array(
					160 => __( 'Small (160x96)', 'wp-live-chat-software-for-wordpress' ),
					200 => __( 'Medium (200x120)', 'wp-live-chat-software-for-wordpress' ),
					240 => __( 'Large (240x144)', 'wp-live-chat-software-for-wordpress' ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$context = array(
			'theme' => array_key_exists( 'theme', $settings ) ? $settings['theme'] : 'light',
			'size'  => array_key_exists( 'size', $settings ) ? $settings['size'] : 200,
		);

		QualityBadgeWidgetTemplate::create( $context )->render();
	}

	/**
	 * Creates new instance of LiveChatContactButtonWidget.
	 *
	 * @return LiveChatQualityBadgeWidget
	 */
	public static function create() {
		return new static();
	}
}
