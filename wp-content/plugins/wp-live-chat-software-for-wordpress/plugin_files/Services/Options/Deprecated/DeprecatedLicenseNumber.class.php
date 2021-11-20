<?php
/**
 * Class DeprecatedLicenseNumber
 *
 * @package LiveChat\Services\Options\Deprecated
 */

namespace LiveChat\Services\Options\Deprecated;

/**
 * Class DeprecatedLicenseNumber
 *
 * @package LiveChat\Services\Options\Deprecated
 */
class DeprecatedLicenseNumber extends DeprecatedOption {
	/**
	 * DeprecatedLicenseNumber constructor.
	 */
	public function __construct() {
		parent::__construct( 'license_number', 'license' );
	}
}
