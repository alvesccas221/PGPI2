<?php
/**
 * Class DeprecatedReviewNoticeTimestamp
 *
 * @package LiveChatServicesOptionsDeprecated
 */

namespace LiveChat\Services\Options\Deprecated;

/**
 * Class DeprecatedReviewNoticeTimestamp
 *
 * @package LiveChat\Services\Options\Deprecated
 */
class DeprecatedReviewNoticeTimestamp extends DeprecatedOption {
	/**
	 * DeprecatedReviewNoticeTimestamp constructor.
	 */
	public function __construct() {
		parent::__construct( 'review_notice_start_timestamp', 0 );
	}
}
