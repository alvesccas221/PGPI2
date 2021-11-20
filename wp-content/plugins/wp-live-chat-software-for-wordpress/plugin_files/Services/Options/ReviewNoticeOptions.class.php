<?php
/**
 * Class ReviewNoticeOptions
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class ReviewNoticeOptions
 *
 * @package LiveChat\Services\Options
 */
class ReviewNoticeOptions extends OptionsSet {
	/**
	 * ReviewNoticeDismissed instance.
	 *
	 * @var ReviewNoticeDismissed
	 */
	public $dismissed;

	/**
	 * ReviewNoticeTimestamp instance.
	 *
	 * @var ReviewNoticeTimestamp
	 */
	public $timestamp;

	/**
	 * ReviewNoticeOffset instance.
	 *
	 * @var ReviewNoticeOffset
	 */
	public $offset;

	/**
	 * ReviewNoticeOptions constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'dismissed' => ReviewNoticeDismissed::get_instance(),
				'timestamp' => ReviewNoticeTimestamp::get_instance(),
				'offset'    => ReviewNoticeOffset::get_instance(),
			)
		);
	}

	/**
	 * Returns an array with all options
	 */
	public function get() {
		return array_filter(
			array(
				'reviewNoticeDismissed' => $this->dismissed->get(),
				'reviewNoticeTimestamp' => $this->timestamp->get(),
				'reviewNoticeOffset'    => $this->offset->get(),
			),
			function ( $val ) {
				return ! is_null( $val ); }
		);
	}
}
