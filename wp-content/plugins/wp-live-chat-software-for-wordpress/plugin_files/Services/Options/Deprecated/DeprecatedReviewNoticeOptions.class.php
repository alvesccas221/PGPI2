<?php

namespace LiveChat\Services\Options\Deprecated;

use LiveChat\Services\Options\OptionsSet;

class DeprecatedReviewNoticeOptions extends OptionsSet {
	/**
	 * Instance of DeprecatedReviewNoticeDismissed.
	 *
	 * @var DeprecatedReviewNoticeDismissed
	 */
	public $dismissed;

	/**
	 * Instance of DeprecatedReviewNoticeTimestamp.
	 *
	 * @var DeprecatedReviewNoticeTimestamp
	 */
	public $timestamp;

	/**
	 * Instance of DeprecatedReviewNoticeOffset.
	 *
	 * @var DeprecatedReviewNoticeOffset
	 */
	public $offset;

	/**
	 * DeprecatedReviewNoticeOptions constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'dismissed' => DeprecatedReviewNoticeDismissed::get_instance(),
				'timestamp' => DeprecatedReviewNoticeTimestamp::get_instance(),
				'offset'    => DeprecatedReviewNoticeOffset::get_instance(),
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
