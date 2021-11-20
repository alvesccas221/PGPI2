<?php
/**
 * Class ReviewNoticeTimestamp
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class ReviewNoticeTimestamp
 *
 * @package LiveChat\Services\Options
 */
class ReviewNoticeTimestamp extends ReadableOption {
	/**
	 * ReviewNoticeTimestamp constructor.
	 */
	public function __construct() {
		parent::__construct( 'review_notice_start_timestamp' );
	}
}
