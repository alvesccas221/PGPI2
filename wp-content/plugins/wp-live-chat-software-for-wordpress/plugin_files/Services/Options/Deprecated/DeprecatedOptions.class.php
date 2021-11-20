<?php
/**
 * Class DeprecatedOptions
 *
 * @package LiveChat\Services\Options\Deprecated
 */

namespace LiveChat\Services\Options\Deprecated;

use LiveChat\Services\Options\Deprecated\Widget\DeprecatedWidgetSettings;
use LiveChat\Services\Options\OptionsSet;

/**
 * Class DeprecatedOptions
 *
 * @package LiveChat\Services\Options\Deprecated
 */
class DeprecatedOptions extends OptionsSet {
	/**
	 * Instance of DeprecatedLicenseNumber.
	 *
	 * @var DeprecatedLicenseNumber
	 */
	public $license;

	/**
	 * Instance of DeprecatedLicenseEmail.
	 *
	 * @var DeprecatedLicenseEmail
	 */
	public $license_email;

	/**
	 * Instance of DeprecatedReviewNoticeOptions.
	 *
	 * @var DeprecatedReviewNoticeOptions
	 */
	public $review_notice;

	/**
	 * Instance of DeprecatedWidgetSettings.
	 *
	 * @var DeprecatedWidgetSettings
	 */
	public $widget_settings;

	/**
	 * DeprecatedOptions constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'license'         => DeprecatedLicenseNumber::get_instance(),
				'license_email'   => DeprecatedLicenseEmail::get_instance(),
				'review_notice'   => DeprecatedReviewNoticeOptions::get_instance(),
				'widget_settings' => DeprecatedWidgetSettings::get_instance(),
			)
		);
	}
}
