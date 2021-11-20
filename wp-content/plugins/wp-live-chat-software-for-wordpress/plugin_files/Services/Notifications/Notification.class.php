<?php
/**
 * Class Notification
 *
 * @package LiveChat\Services\Notifications
 */

namespace LiveChat\Services\Notifications;

use LiveChat\Services\Options\Deprecated\DeprecatedOptions;
use LiveChat\Services\Store;
use LiveChat\Services\Templates\Template;

/**
 * Class Notification
 *
 * @package LiveChat\Services\Notifications
 */
class Notification {
	/**
	 * WP Hook on which a Notification should be registered.
	 *
	 * @var string
	 */
	private $register_hook;

	/**
	 * WP Hook on which a Notification should be rendered.
	 *
	 * @var string
	 */
	private $render_hook;

	/**
	 * Instance of Store.
	 *
	 * @var Store
	 */
	protected $store;

	/**
	 * Instance of DeprecatedOptions.
	 *
	 * @var DeprecatedOptions|null
	 */
	protected $options;

	/**
	 * Menu slug.
	 *
	 * @var string
	 */
	protected $menu_slug;

	/**
	 * Instance of template that should be rendered.
	 *
	 * @var Template|null
	 */
	private $template;

	/**
	 * Notification constructor.
	 *
	 * @param Store                  $store         Store instance.
	 * @param DeprecatedOptions|null $options       DeprecatedOptions instance.
	 * @param string                 $menu_slug     Menu slug.
	 * @param Template|null          $template      Template instance.
	 * @param string                 $register_hook WP hook used for register.
	 * @param string                 $render_hook   WP hook used for render.
	 */
	public function __construct(
		$store,
		$options,
		$menu_slug,
		$template = null,
		$register_hook = 'current_screen',
		$render_hook = 'admin_notices'
	) {
		$this->store         = $store;
		$this->options       = $options;
		$this->menu_slug     = $menu_slug;
		$this->template      = $template;
		$this->register_hook = $register_hook;
		$this->render_hook   = $render_hook;
	}

	/**
	 * Returns render hook.
	 *
	 * @return string
	 */
	public function get_render_hook() {
		return $this->render_hook;
	}

	/**
	 * Returns register hook.
	 *
	 * @return string
	 */
	public function get_register_hook() {
		return $this->register_hook;
	}

	/**
	 * Allows to perform actions before rendering.
	 */
	public function register() {}

	/**
	 * @param string $suffix Menu page suffix.
	 *
	 * @return string
	 */
	protected function slugged_menu_page( $suffix ) {
		return sprintf( '%s_page_%s_%s', $this->menu_slug, $this->menu_slug, $suffix );
	}

	/**
	 * Returns true if user is on given page.
	 *
	 * @param string $page_id ID of desired page.
	 *
	 * @return bool
	 */
	protected function is_user_on_page( $page_id ) {
		$screen = get_current_screen();
		return ! is_null( $screen ) ? $page_id === $screen->id : false;
	}

	/**
	 * Returns true if plugin was migrated from 3.X version.
	 *
	 * @return bool
	 */
	protected function was_migrated() {
		return max( 0, $this->options->license->get() ) > 0;
	}

	/**
	 * Returns true if a notification should be rendered.
	 *
	 * @return bool
	 */
	public function should_render() {
		return ! $this->is_user_on_page( $this->slugged_menu_page( 'settings' ) ) &&
				! $this->is_user_on_page( $this->slugged_menu_page( 'resources' ) );
	}

	/**
	 * Registers a notification.
	 */
	public function render() {
		if ( $this->should_render() ) {
			$this->template->render();
		}
	}

	/**
	 * Returns instance of Notification (singleton pattern).
	 *
	 * @return static
	 */
	public static function get_instance() {
		return new static( Store::get_instance(), DeprecatedOptions::get_instance(), WPLC_MENU_SLUG );
	}
}
