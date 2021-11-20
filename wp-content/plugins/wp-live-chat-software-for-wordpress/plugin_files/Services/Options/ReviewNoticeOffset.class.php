<?php
/**
 * Class ReviewNoticeOffset
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class ReviewNoticeOffset
 *
 * @package LiveChat\Services\Options
 */
class ReviewNoticeOffset extends ReadableOption {
	/**
	 * ReviewNoticeOffset constructor.
	 */
	public function __construct() {
		parent::__construct( 'review_notice_start_timestamp_offset' );
	}
}
