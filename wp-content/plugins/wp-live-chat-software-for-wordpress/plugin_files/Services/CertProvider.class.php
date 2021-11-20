<?php
/**
 * Class CertProvider
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use LiveChat\Exceptions\ApiClientException;
use LiveChat\Services\Options\PublicKey;

/**
 * Class CertProvider
 *
 * @package LiveChat\Services
 */
class CertProvider {

	/**
	 * Public RSA key
	 *
	 * @var string|null
	 */
	private $cert;

	/**
	 * Instance of PublicKey class
	 *
	 * @var PublicKey
	 */
	private $public_key;

	/**
	 * Instance of ApiClient class
	 *
	 * @var ApiClient
	 */
	private $api_client;

	/**
	 * CertProvider constructor.
	 *
	 * @param PublicKey   $public_key ApiClient instance.
	 * @param ApiClient   $api_client ApiClient instance.
	 * @param string|null $cert       JWT public key.
	 */
	public function __construct( $public_key, $api_client, $cert = null ) {
		$this->public_key = $public_key;
		$this->api_client = $api_client;
		$this->cert       = $cert;
	}

	/**
	 * Returns RSA public key
	 *
	 * @return string
	 * @throws ApiClientException Can be thrown from get_cert method.
	 */
	public function get_stored_cert() {
		if ( is_null( $this->cert ) ) {
			$cert = $this->public_key->get();
			if ( ! $cert ) {
				$cert = $this->api_client->get_cert();
				$this->public_key->set( $cert );
			}

			$this->cert = $cert;
		}

		return $this->cert;
	}

	/**
	 * Removes public RSA key from WP database
	 *
	 * @return bool
	 */
	public function remove_stored_cert() {
		return $this->public_key->remove();
	}

	/**
	 * Returns new instance of CertProvider
	 *
	 * @param string|null $cert RSA public key used to verify token.
	 *
	 * @return CertProvider
	 */
	public static function create( $cert = null ) {
		return new CertProvider(
			PublicKey::get_instance(),
			ApiClient::create(),
			$cert
		);
	}
}
