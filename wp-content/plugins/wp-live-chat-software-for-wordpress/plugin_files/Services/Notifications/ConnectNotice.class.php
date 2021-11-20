<?php
/**
 * Class ConnectNotice
 *
 * @package LiveChat\Services\Notifications
 */

namespace LiveChat\Services\Notifications;

use LiveChat\Services\Templates\ConnectNoticeTemplate;

/**
 * Class ConnectNotice
 *
 * @package LiveChat\Services\Notifications
 */
class ConnectNotice extends Notification {
	/**
	 * ConnectNotice constructor.
	 *
	 * @inheritDoc
	 */
	public function __construct( $store, $options, $menu_slug ) {
		parent::__construct( $store, $options, $menu_slug, ConnectNoticeTemplate::create() );
	}

	/**
	 * Returns true when plugin is not installed,
	 * user is not on plugin's settings page,
	 * and plugin wasn't migrated.
	 *
	 * @inheritDoc
	 */
	public function should_render() {
		return ! $this->store->is_connected() &&
				parent::should_render() &&
				! $this->was_migrated();
	}
}
