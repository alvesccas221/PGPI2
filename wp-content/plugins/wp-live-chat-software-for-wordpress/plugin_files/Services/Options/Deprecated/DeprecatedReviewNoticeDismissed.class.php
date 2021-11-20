<?php
/**
 * Class DeprecatedReviewNoticeDismissed
 *
 * @package LiveChat\Services\Options\Deprecated
 */

namespace LiveChat\Services\Options\Deprecated;

/**
 * Class DeprecatedReviewNoticeDismissed
 *
 * @package LiveChat\Services\Options\Deprecated
 */
class DeprecatedReviewNoticeDismissed extends DeprecatedOption {
	/**
	 * DeprecatedReviewNoticeDismissed constructor.
	 */
	public function __construct() {
		parent::__construct( 'review_notice_dismissed', false );
	}
}
