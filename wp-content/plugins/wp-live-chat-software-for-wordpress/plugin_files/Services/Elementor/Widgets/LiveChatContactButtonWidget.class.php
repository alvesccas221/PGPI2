<?php
/**
 * Class LiveChatContactButtonWidget
 *
 * @package Elementor
 */

namespace Elementor;

use LiveChat\Services\Templates\Widgets\ContactButtonWidgetTemplate;
use LiveChat\Services\Templates\Widgets\Previews\ContactButtonPreviewWidgetTemplate;

/**
 * Class LiveChatContactButtonWidget
 *
 * @package Elementor
 */
class LiveChatContactButtonWidget extends Widget_Base {
	/**
	 * Returns widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'livechat-contact-button';
	}

	/**
	 * Returns widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Contact Button', 'wp-live-chat-software-for-wordpress' );
	}

	/**
	 * Returns widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'lc lc-contact-button';
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
	 * Registers controls for 'Content' tab.
	 */
	private function register_content_tab_controls() {
		$this->start_controls_section(
			'contact_button_content_settings',
			array(
				'label' => __( 'Contact Button', 'wp-live-chat-software-for-wordpress' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'label',
			array(
				'label'   => __( 'Text', 'wp-live-chat-software-for-wordpress' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Contact us',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers 'Style' tab controls.
	 */
	private function register_style_tab_controls() {
		$this->start_controls_section(
			'contact_button_styles_settings',
			array(
				'label' => __( 'Contact Button', 'wp-live-chat-software-for-wordpress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'label'    => __( 'Typography', 'wp-live-chat-software-for-wordpress' ),
				'selector' => '{{WRAPPER}} .rWzRuLNl84i5nH_IVqYFH-lc-contact-button-container',
			)
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'label'    => __( 'Text Shadow', 'wp-live-chat-software-for-wordpress' ),
				'selector' => '{{WRAPPER}} .rWzRuLNl84i5nH_IVqYFH-lc-contact-button-container',
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'label'    => __( 'Box Shadow', 'wp-live-chat-software-for-wordpress' ),
				'selector' => '{{WRAPPER}} .rWzRuLNl84i5nH_IVqYFH-lc-contact-button-container',
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'border',
				'label'    => __( 'Border', 'wp-live-chat-software-for-wordpress' ),
				'selector' => '{{WRAPPER}} .rWzRuLNl84i5nH_IVqYFH-lc-contact-button-container',
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'label'    => __( 'Background', 'wp-live-chat-software-for-wordpress' ),
				'selector' => '{{WRAPPER}} .rWzRuLNl84i5nH_IVqYFH-lc-contact-button-container',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers controls for widget.
	 */
	protected function register_controls() {
		$this->register_content_tab_controls();
		$this->register_style_tab_controls();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$context = array(
			'label' => array_key_exists( 'label', $settings ) ? $settings['label'] : __( 'Contact us', 'wp-live-chat-software-for-wordpress' ),
		);

		ContactButtonWidgetTemplate::create( $context )->render();
	}

	/**
	 * Generates the live preview.
	 */
	public function content_template() {
		ContactButtonPreviewWidgetTemplate::create()->render();
	}

	/**
	 * Creates new instance of LiveChatContactButtonWidget.
	 *
	 * @return LiveChatContactButtonWidget
	 */
	public static function create() {
		return new static();
	}
}
