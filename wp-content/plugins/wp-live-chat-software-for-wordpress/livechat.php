<?php
/**
 * Plugin Name: LiveChat
 * Plugin URI: https://www.livechat.com/marketplace/apps/wordpress/
 * Description: Live chat software for live help, online sales and customer support. This plugin allows to quickly install LiveChat on any WordPress website.
 * Version: 4.5.2
 * Author: LiveChat
 * Author URI: https://www.livechat.com
 * Text Domain: wp-live-chat-software-for-wordpress
 * Domain Path: /languages
 *
 * Copyright: © 2021 LiveChat.
 * License: GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( class_exists( 'LiveChat\LiveChat' ) ) {
	return;
}

require_once dirname( __FILE__ ) . '/vendor/autoload.php';
require_once dirname( __FILE__ ) . '/config.php';


if ( ! function_exists( 'livechat_is_woo_plugin_active' ) ) {
	/**
	 * Checks if WooCommerce plugin is active.
	 *
	 * @return bool
	 */
	function livechat_is_woo_plugin_active() {
		return in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins', array() ), true );
	}
}

if ( ! function_exists( 'livechat_is_elementor_plugin_active' ) ) {
	/**
	 * Checks if Elementor plugin is active.
	 *
	 * @return bool
	 */
	function livechat_is_elementor_plugin_active() {
		return (
			in_array(
				'elementor/elementor.php',
				get_option( 'active_plugins', array() ),
				true
			) &&
			class_exists( '\Elementor\Plugin' )
		);
	}
}


if ( ! function_exists( 'livechat_get_detected_platform' ) ) {
	/**
	 * Detects platform based on active plugins.
	 *
	 * @return string
	 * @throws Exception
	 */
	function livechat_get_detected_platform() {
		require_once dirname( __FILE__ ) . '/plugin_files/Services/PlatformProvider.class.php';
		return \LiveChat\Services\PlatformProvider::create()->get();
	}
}

define( 'WPLC_PLATFORM', livechat_get_detected_platform() );

if ( ! function_exists( 'livechat_get_platform' ) ) {
	/**
	 * Returns current platform.
	 *
	 * @return bool
	 */
	function livechat_get_platform() {
		// phpcs:ignore WordPress.WP.CapitalPDangit.Misspelled
		return defined( 'WPLC_PLATFORM' ) ? WPLC_PLATFORM : 'wordpress';
	}
}

if ( ! function_exists( 'livechat_is_woo' ) ) {
	/**
	 * Checks if WooCommerce is current platform.
	 *
	 * @return bool
	 */
	function livechat_is_woo() {
		return 'woocommerce' === livechat_get_platform();
	}
}

if ( ! function_exists( 'livechat_is_elementor' ) ) {
	/**
	 * Checks if Elementor is current platform.
	 *
	 * @return bool
	 */
	function livechat_is_elementor() {
		return 'elementor' === livechat_get_platform();
	}
}

if ( ! function_exists( 'livechat_is_elementor_preview_mode' ) ) {
	/**
	 * Checks if website is in Elementor preview mode.
	 *
	 * @return bool
	 */
	function livechat_is_elementor_preview_mode() {
		return livechat_is_elementor_plugin_active() && \Elementor\Plugin::$instance->preview->is_preview_mode();
	}
}

if ( is_admin() ) {
	require_once dirname( __FILE__ ) . '/plugin_files/LiveChatAdmin.class.php';
	\LiveChat\LiveChatAdmin::get_instance();

	register_uninstall_hook( __FILE__, 'LiveChat\LiveChatAdmin::uninstall_hook_handler' );
} else {
	require_once dirname( __FILE__ ) . '/plugin_files/LiveChat.class.php';
	\LiveChat\LiveChat::get_instance();
}
