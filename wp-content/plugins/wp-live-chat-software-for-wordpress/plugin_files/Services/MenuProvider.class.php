<?php
/**
 * Class MenuProvider
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use LiveChat\Services\Templates\ResourcesTabTemplate;

/**
 * Class MenuProvider
 *
 * @package LiveChat\Services
 */
class MenuProvider {
	/**
	 * Instance of MenuProvider.
	 *
	 * @var MenuProvider|null
	 */
	private static $instance = null;

	/**
	 * Instance of User.
	 *
	 * @var User|null
	 */
	private $user;

	/**
	 * Instance of Store.
	 *
	 * @var Store|null
	 */
	private $store;

	/**
	 * Instance of SettingsProvider.
	 *
	 * @var SettingsProvider|null
	 */
	private $settings;

	/**
	 * Instance of ResourcesTabTemplate.
	 *
	 * @var ResourcesTabTemplate|null
	 */
	private $resources_tab;

	/**
	 * Plugin URL.
	 *
	 * @var string
	 */
	private $plugin_url;

	/**
	 * Menu slug.
	 *
	 * @var string
	 */
	private $menu_slug;

	/**
	 * Plugin main file.
	 *
	 * @var string
	 */
	private $plugin_main_file;

	/**
	 * LiveChat Agent App URL.
	 *
	 * @var string
	 */
	private $lc_aa_url;

	/**
	 * MenuProvider constructor.
	 *
	 * @param User                 $user             Instance of User.
	 * @param Store                $store            Instance of Store.
	 * @param SettingsProvider     $settings         Instance of SettingsProvider.
	 * @param ResourcesTabTemplate $resources_tab    Instance of ResourcesTabTemplate.
	 * @param string               $plugin_url       Plugin URL.
	 * @param string               $menu_slug        Menu slug.
	 * @param string               $plugin_main_file Plugin main file.
	 * @param string               $lc_aa_url        LiveChat Agent App URL.
	 */
	public function __construct(
		$user,
		$store,
		$settings,
		$resources_tab,
		$plugin_url,
		$menu_slug,
		$plugin_main_file,
		$lc_aa_url
	) {
		$this->user             = $user;
		$this->store            = $store;
		$this->settings         = $settings;
		$this->resources_tab    = $resources_tab;
		$this->plugin_url       = $plugin_url;
		$this->menu_slug        = $menu_slug;
		$this->plugin_main_file = $plugin_main_file;
		$this->lc_aa_url        = $lc_aa_url;
	}

	/**
	 * Returns string with menu slug for given suffix.
	 *
	 * @param string $suffix Resource name.
	 * @return string
	 */
	private function slugged( $suffix ) {
		return "{$this->menu_slug}_$suffix";
	}

	/**
	 * Returns string with menu slug for given suffix.
	 *
	 * @param string $suffix Resource name.
	 * @return string
	 */
	private function get_admin_script( $suffix ) {
		return 'admin.php?page=' . $this->slugged( $suffix );
	}

	/**
	 * Registers admin menu.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
	}

	/**
	 * Registers plugin menu in WP menu bar.
	 */
	public function register_admin_menu() {
		add_menu_page(
			'LiveChat',
			$this->is_installed() ? 'LiveChat' : 'LiveChat <span class="awaiting-mod">!</span>',
			'administrator',
			$this->menu_slug,
			array( $this, 'livechat_settings_page' ),
			$this->plugin_url . 'images/livechat-icon.svg'
		);

		add_submenu_page(
			$this->menu_slug,
			__( 'Settings', 'wp-live-chat-software-for-wordpress' ),
			__( 'Settings', 'wp-live-chat-software-for-wordpress' ),
			'administrator',
			$this->slugged( 'settings' ),
			array( $this, 'livechat_settings_page' )
		);

		add_submenu_page(
			$this->menu_slug,
			__( 'Resources', 'wp-live-chat-software-for-wordpress' ),
			__( 'Resources', 'wp-live-chat-software-for-wordpress' ),
			'administrator',
			$this->slugged( 'resources' ),
			array( $this, 'livechat_resources_page' )
		);

		// Remove the submenu that is automatically added.
		if ( function_exists( 'remove_submenu_page' ) ) {
			remove_submenu_page( $this->menu_slug, $this->menu_slug );
		}

		// Settings link.
		add_filter( 'plugin_action_links', array( $this, 'livechat_settings_link' ), 10, 2 );

		if ( $this->has_user_token() ) {
			add_submenu_page(
				'livechat',
				__( 'Go to LiveChat', 'wp-live-chat-software-for-wordpress' ),
				__( 'Go to LiveChat', 'wp-live-chat-software-for-wordpress' ),
				'administrator',
				$this->slugged( 'link' ),
				'__return_false'
			);

			add_filter( 'clean_url', array( $this, 'go_to_livechat_link' ), 10, 2 );
		}
	}

	/**
	 * Renders settings page.
	 */
	public function livechat_settings_page() {
		$this->settings->render();
	}

	/**
	 * Renders resources page.
	 */
	public function livechat_resources_page() {
		$this->resources_tab->render();
	}

	/**
	 * Returns link to LiveChat setting page.
	 *
	 * @param array  $links Array with links.
	 * @param string $file File name.
	 *
	 * @return mixed
	 */
	public function livechat_settings_link( $links, $file ) {
		if ( $this->plugin_main_file !== $file ) {
			return $links;
		}

		$settings_link = sprintf(
			'<a href="' . $this->get_admin_script( 'settings' ) . '">%s</a>',
			__( 'Settings' )
		);
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Opens Agent App in new tab
	 *
	 * @param string $current_url URL of current menu page.
	 *
	 * @return string
	 */
	public function go_to_livechat_link( $current_url ) {
		if ( $this->get_admin_script( 'link' ) === $current_url ) {
			$current_url = $this->lc_aa_url;
		}

		return $current_url;
	}

	/**
	 * Returns true if LiveChat store token is set (not empty string),
	 * false otherwise.
	 *
	 * @return bool
	 */
	private function is_installed() {
		return ! empty( $this->store->get_store_token() );
	}

	/**
	 * Checks if current WP user has LC account.
	 *
	 * @return bool
	 */
	private function has_user_token() {
		return ! empty( $this->user->get_current_user_token() );
	}

	/**
	 * Returns instance of MenuProvider (singleton pattern).
	 *
	 * @return MenuProvider|null
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static(
				User::get_instance(),
				Store::get_instance(),
				SettingsProvider::get_instance(),
				ResourcesTabTemplate::create(),
				ModuleConfiguration::get_instance()->get_plugin_url(),
				WPLC_MENU_SLUG,
				WPLC_PLUGIN_MAIN_FILE,
				WPLC_AA_URL
			);
		}

		return static::$instance;
	}
}
