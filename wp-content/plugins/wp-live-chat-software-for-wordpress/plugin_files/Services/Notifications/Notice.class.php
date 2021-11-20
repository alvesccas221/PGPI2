<?php
/**
 * Class Notice
 *
 * @package LiveChat\Services\Notifications
 */

namespace LiveChat\Services\Notifications;

use LiveChat\Services\Templates\NoticeTemplate;

/**
 * Class Notice
 *
 * @package LiveChat\Services\Notifications
 */
class Notice extends Notification {
	/**
	 * Notice constructor.
	 *
	 * @inheritDoc
	 */
	public function __construct( $store, $options, $menu_slug ) {
		parent::__construct( $store, $options, $menu_slug, NoticeTemplate::create() );
	}
}
