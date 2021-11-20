<?php
/**
 * Class DeactivationModal
 *
 * @package LiveChat\Services\Notifications
 */

namespace LiveChat\Services\Notifications;

use LiveChat\Services\Templates\DeactivationModalTemplate;

/**
 * Class DeactivationModal
 *
 * @package LiveChat\Services\Notifications
 */
class DeactivationModal extends Notification {
	/**
	 * DeactivationModal constructor.
	 *
	 * {@inheritDoc}
	 */
	public function __construct( $store, $options, $menu_slug ) {
		parent::__construct(
			$store,
			$options,
			$menu_slug,
			DeactivationModalTemplate::create(),
			'current_screen',
			'admin_footer'
		);
	}

	/**
	 * Returns true when plugin is connected.
	 *
	 * @inheritDoc
	 */
	public function should_render() {
		return $this->is_user_on_page( 'plugins' );
	}
}
