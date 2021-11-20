<?php
/**
 * Class DeactivationModalTemplate
 *
 * @package LiveChat\Services\Templates
 */

namespace LiveChat\Services\Templates;

use LiveChat\Services\LicenseProvider;
use LiveChat\Services\User;

/**
 * Class DeactivationModalTemplate
 */
class DeactivationModalTemplate extends Template {
	/**
	 * Renders modal with deactivation feedback form.
	 */
	public function render() {
		$user           = User::get_instance()->get_user_data();
		$license_number = LicenseProvider::create()->get_license_number();

		$context                                = array();
		$context['cancelButton']                = esc_html__( 'Cancel', 'wp-live-chat-software-for-wordpress' );
		$context['lcNoticeLogo']                = esc_html(
			sprintf(
				'%s/plugin_files/images/livechat-icon.svg',
				plugins_url( WPLC_PLUGIN_SLUG )
			)
		);
		$context['header']                      = esc_html__( 'Quick Feedback', 'wp-live-chat-software-for-wordpress' );
		$context['description']                 = esc_html__( 'If you have a moment, please let us know why you are deactivating LiveChat:', 'wp-live-chat-software-for-wordpress' );
		$context['reasonNoLongerNeed']          = esc_html__( 'I no longer need the plugin.', 'wp-live-chat-software-for-wordpress' );
		$context['reasonDoesNotWork']           = esc_html__( "I couldn't get the plugin to work.", 'wp-live-chat-software-for-wordpress' );
		$context['reasonBetterPlugin']          = esc_html__( 'I found a better plugin.', 'wp-live-chat-software-for-wordpress' );
		$context['reasonTemporaryDeactivation'] = esc_html__( "It's a temporary deactivation.", 'wp-live-chat-software-for-wordpress' );
		$context['reasonOther']                 = esc_html__( 'Other', 'wp-live-chat-software-for-wordpress' );
		$context['textPlaceholder']             = esc_html__( 'Tell us more...', 'wp-live-chat-software-for-wordpress' );
		$context['options']                     = esc_html__( 'Please choose one of available options.', 'wp-live-chat-software-for-wordpress' );
		$context['feedback']                    = esc_html__( 'Please provide additional feedback.', 'wp-live-chat-software-for-wordpress' );
		$context['licenseNumber']               = $license_number;
		$context['name']                        = $user['name'];
		$context['email']                       = $user['email'];
		$context['skipButton']                  = esc_html__( 'Skip & continue', 'wp-live-chat-software-for-wordpress' );
		$context['sendButton']                  = esc_html__( 'Send feedback', 'wp-live-chat-software-for-wordpress' );

		$this->template_parser->parse_template( 'deactivation_modal.html.twig', $context );
	}
}
