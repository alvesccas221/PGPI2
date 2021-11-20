<?php
/**
 * Class ConfirmIdentityNotice
 *
 * @package LiveChat\Services\Notifications
 */

namespace LiveChat\Services\Notifications;

use LiveChat\Services\Templates\ConfirmIdentityNoticeTemplate;

/**
 * Class ConfirmIdentityNotice
 *
 * @package LiveChat\Services\Notifications
 */
class ConfirmIdentityNotice extends Notification {
	/**
	 * ConnectNotice constructor.
	 *
	 * @inheritDoc
	 */
	public function __construct( $store, $options, $menu_slug ) {
		parent::__construct( $store, $options, $menu_slug, ConfirmIdentityNoticeTemplate::create() );
	}
	/**
	 * Returns true when plugin is not connected,
	 * user is not on plugin's settings page,
	 * and plugin was migrated.
	 *
	 * @inheritDoc
	 */
	public function should_render() {
		return ! $this->store->is_connected() &&
				parent::should_render() &&
				$this->was_migrated();
	}
}
