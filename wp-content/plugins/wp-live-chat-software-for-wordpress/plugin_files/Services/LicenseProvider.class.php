<?php
/**
 * Class LicenseProvider
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use Exception;
use LiveChat\Services\Factories\ApiClientFactory;
use LiveChat\Services\Options\Deprecated\DeprecatedLicenseNumber;

/**
 * Class LicenseProvider
 *
 * @package LiveChat\Services
 */
class LicenseProvider {
	/**
	 * Instance of ApiClient.
	 *
	 * @var ApiClientFactory
	 */
	private $api_client_factory;

	/**
	 * Instance of DeprecatedLicenseNumber.
	 *
	 * @var DeprecatedLicenseNumber
	 */
	private $deprecated_license;

	/**
	 * LicenseProvider constructor.
	 *
	 * @param ApiClientFactory        $api_client_factory Instance of ApiClientFactory.
	 * @param DeprecatedLicenseNumber $deprecated_license Instance of DeprecatedLicenseNumber.
	 */
	public function __construct( $api_client_factory, $deprecated_license ) {
		$this->api_client_factory = $api_client_factory;
		$this->deprecated_license = $deprecated_license;
	}

	/**
	 * Returns true if option containing license number exists and is valid.
	 * Otherwise it returns false.
	 *
	 * @return bool
	 */
	public function has_deprecated_license_number() {
		$license_number = max( 0, $this->deprecated_license->get() );
		return $license_number > 0;
	}

	/**
	 * Returns deprecated license number stored in db by plugins in version <= 2.0.0.
	 *
	 * @return int|mixed
	 */
	private function get_deprecated_license_number() {
		if ( $this->has_deprecated_license_number() ) {
			return $this->deprecated_license->get();
		}
		return 0;
	}


	/**
	 * Returns license number.
	 *
	 * @return int
	 */
	public function get_license_number() {
		try {
			$response = $this->api_client_factory->create()->store_info();
			if ( ! isset( $response['store']['license'] ) ) {
				return $this->get_deprecated_license_number();
			}
			return $response['store']['license'];
		} catch ( Exception $ex ) {
			return $this->get_deprecated_license_number();
		}
	}

	/**
	 * Returns new instance of LicenseProvider.
	 *
	 * @return static
	 */
	public static function create() {
		return new static(
			ApiClientFactory::get_instance(),
			DeprecatedLicenseNumber::get_instance()
		);
	}
}
