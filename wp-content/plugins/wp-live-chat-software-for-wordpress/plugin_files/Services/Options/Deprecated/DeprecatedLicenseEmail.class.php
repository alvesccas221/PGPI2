<?php
/**
 * Class DeprecatedLicenseEmail
 *
 * @package LiveChat\Services\Options\Deprecated
 */

namespace LiveChat\Services\Options\Deprecated;

/**
 * Class DeprecatedLicenseEmail
 *
 * @package LiveChat\Services\Options\Deprecated
 */
class DeprecatedLicenseEmail extends DeprecatedOption {
	/**
	 * DeprecatedLicenseEmail constructor.
	 */
	public function __construct() {
		parent::__construct( 'email', 'licenseEmail' );
	}
}
