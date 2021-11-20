<?php
/**
 * Class NotificationsRenderer
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use LiveChat\Services\Notifications\ConfirmIdentityNotice;
use LiveChat\Services\Notifications\ConnectNotice;
use LiveChat\Services\Notifications\DeactivationModal;
use LiveChat\Services\Notifications\Notice;
use LiveChat\Services\Notifications\Notification;

/**
 * Class NotificationsRenderer
 *
 * @package LiveChat\Services
 */
class NotificationsRenderer {
	/**
	 * Array of Notifications.
	 *
	 * @var Notification[]
	 */
	private $notifications;

	/**
	 * NotificationsRenderer constructor.
	 *
	 * @param Notification[] $notifications Array of Notifications.
	 */
	public function __construct( $notifications ) {
		$this->notifications = $notifications;
	}

	/**
	 * Initializes modals and notices.
	 */
	public function init() {
		foreach ( $this->notifications as $notification ) {
			add_action( $notification->get_register_hook(), array( $notification, 'register' ) );
			add_action( $notification->get_render_hook(), array( $notification, 'render' ) );
		}
	}

	/**
	 * Returns instance of NotificationsRenderer (singleton pattern).
	 *
	 * @return NotificationsRenderer
	 */
	public static function get_instance() {
		return new static(
			array(
				ConnectNotice::get_instance(),
				ConfirmIdentityNotice::get_instance(),
				DeactivationModal::get_instance(),
				Notice::get_instance(),
			)
		);
	}
}
