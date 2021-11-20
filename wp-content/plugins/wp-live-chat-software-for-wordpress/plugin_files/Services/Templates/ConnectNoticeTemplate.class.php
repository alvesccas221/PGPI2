<?php
/**
 * Class ConnectNoticeTemplate
 *
 * @package LiveChat\Services\Templates
 */

namespace LiveChat\Services\Templates;

/**
 * Class ConnectNoticeTemplate
 */
class ConnectNoticeTemplate extends Template {
	/**
	 * Renders ConnectNotice in WP dashboard.
	 *
	 * @return string
	 */
	public function render() {
		$context                    = array();
		$context['lcNoticeLogoUrl'] = esc_html(
			sprintf(
				'%s/plugin_files/images/livechat-logo.svg',
				plugins_url( WPLC_PLUGIN_SLUG )
			)
		);
		$context['noticeHeader']    = esc_html__( 'Action required - connect LiveChat', 'wp-live-chat-software-for-wordpress' );
		$context['paragraph1']      = esc_html__( 'Please', 'wp-live-chat-software-for-wordpress' );
		$context['paragraph2']      = esc_html__( 'connect your LiveChat account', 'wp-live-chat-software-for-wordpress' );
		$context['paragraph3']      = esc_html__( 'to start chatting with your customers.', 'wp-live-chat-software-for-wordpress' );
		$context['button']          = esc_html__( 'Connect', 'wp-live-chat-software-for-wordpress' );

		return $this->template_parser->parse_template( 'connect_notice.html.twig', $context );
	}
}
