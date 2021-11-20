<?php
/**
 * Class LiveChatAdmin
 *
 * @package LiveChat
 */

namespace LiveChat;

use Exception;
use LiveChat\Services\ApiClient;
use LiveChat\Services\CertProvider;
use LiveChat\Services\ConnectTokenProvider;
use LiveChat\Services\MenuProvider;
use LiveChat\Services\NotificationsRenderer;
use LiveChat\Services\Options\SettingsOptions;
use LiveChat\Services\SettingsProvider;
use LiveChat\Services\SetupProvider;
use LiveChat\Services\Store;
use LiveChat\Services\User;

/**
 * Class LiveChatAdmin
 *
 * @package LiveChat
 */
final class LiveChatAdmin extends LiveChat {
	/**
	 * Starts the plugin
	 */
	public function __construct() {
		parent::__construct();

		add_action(
			'activated_plugin',
			array(
				$this,
				'plugin_activated_action_handler',
			)
		);

		add_filter( 'auto_update_plugin', array( $this, 'auto_update' ), 10, 2 );
	}

	/**
	 * Enables auto-update for LC plugin.
	 *
	 * @param bool   $update Default WP API response.
	 * @param object $item Plugin's slug.
	 * @return bool
	 */
	public function auto_update( $update, $item ) {
		return WPLC_PLUGIN_SLUG === $item->slug ? true : $update;
	}

	/**
	 * Returns instance of LiveChat class (singleton pattern).
	 *
	 * @return LiveChat
	 * @throws Exception Can be thrown by constructor.
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Inits basic services.
	 */
	public function init_services() {
		if ( ! is_super_admin() ) {
			return;
		}

		SetupProvider::get_instance()->init();
		MenuProvider::get_instance()->init();
		SettingsProvider::get_instance()->init();
		NotificationsRenderer::get_instance()->init();
	}

	/**
	 * Handles plugin activated action - redirects to plugin setting page.
	 *
	 * @param string $plugin Plugin slug.
	 */
	public function plugin_activated_action_handler( $plugin ) {
		if ( WPLC_PLUGIN_MAIN_FILE !== $plugin ) {
			return;
		}

		wp_safe_redirect( admin_url( 'admin.php?page=' . WPLC_MENU_SLUG . '_settings' ) );
		exit;
	}

	/**
	 * Removes all LiveChat data stored in WP database.
	 * It's called as uninstall hook.
	 */
	public static function uninstall_hook_handler() {
		$store = Store::get_instance();

		if ( ! empty( $store->get_store_token() ) ) {
			try {
				$connect_token = ConnectTokenProvider::create( CertProvider::create() )->get( $store->get_store_token(), 'store' );
				ApiClient::create( $connect_token )->uninstall();
				// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
			} catch ( Exception $exception ) {
				// Exception during uninstall request is ignored to not break process of plugin uninstallation.
			}

			$store->remove_store_data();
		}

		User::get_instance()->remove_authorized_users();
		CertProvider::create()->remove_stored_cert();
		SettingsOptions::get_instance()->remove();
	}
}
