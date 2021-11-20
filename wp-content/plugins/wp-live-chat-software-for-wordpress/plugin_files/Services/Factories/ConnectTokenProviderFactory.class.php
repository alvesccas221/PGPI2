<?php
/**
 * Class ConnectTokenProviderFactory
 *
 * @package LiveChat\Services\Factories
 */

namespace LiveChat\Services\Factories;

use LiveChat\Services\CertProvider;
use LiveChat\Services\ConnectTokenProvider;

/**
 * Class ConnectTokenProviderFactory
 *
 * @package LiveChat\Services\Factories
 */
class ConnectTokenProviderFactory {
	/**
	 * Returns new instance of ConnectTokenProvider.
	 *
	 * @param CertProvider|null $cert_provider Instance of CertProvider.
	 *
	 * @return ConnectTokenProvider
	 */
	public function create( $cert_provider = null ) {
		if ( ! $cert_provider ) {
			$cert_provider = CertProvider::create();
		}

		return ConnectTokenProvider::create( $cert_provider );
	}

	/**
	 * Returns new instance of ConnectTokenProviderFactory.
	 *
	 * @return static
	 */
	public static function get_instance() {
		return new static();
	}
}
