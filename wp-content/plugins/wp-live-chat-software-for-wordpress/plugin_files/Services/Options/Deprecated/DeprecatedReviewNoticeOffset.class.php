<?php
/**
 * Class DeprecatedReviewNoticeOffset
 *
 * @package LiveChat\Services\Options\Deprecated
 */

namespace LiveChat\Services\Options\Deprecated;

/**
 * Class DeprecatedReviewNoticeOffset
 *
 * @package LiveChat\Services\Options\Deprecated
 */
class DeprecatedReviewNoticeOffset extends DeprecatedOption {
	/**
	 * DeprecatedReviewNoticeOffset constructor.
	 */
	public function __construct() {
		parent::__construct( 'review_notice_start_timestamp_offset', 0 );
	}
}
