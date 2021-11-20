<?php
/**
 * Class TokenValidator
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use Exception;
use LiveChat\Exceptions\ApiClientException;
use LiveChat\Exceptions\InvalidTokenException;
use LiveChat\Services\Factories\ConnectTokenFactory;

/**
 * Class TokenValidator
 *
 * @package LiveChat\Services
 */
class TokenValidator {

	/**
	 * Public key
	 *
	 * @var string|null
	 */
	private $cert_provider;

	/**
	 * Instance of ConnectTokenFactory.
	 *
	 * @var ConnectTokenFactory
	 */
	private $connect_token_factory;

	/**
	 * ConnectTokenProvider constructor.
	 *
	 * @param CertProvider        $cert_provider          Instance of CertProvider.
	 * @param ConnectTokenFactory $connect_token_factory  Instance of ConnectTokenFactory.
	 */
	public function __construct( $cert_provider, $connect_token_factory ) {
		$this->cert_provider         = $cert_provider;
		$this->connect_token_factory = $connect_token_factory;
	}

	/**
	 * Checks if given token is valid JWT token.
	 *
	 * @param string $token JWT token to validate.
	 * @param bool   $allow_expired True if should allow expired tokens.
	 *
	 * @return ConnectToken|null
	 */
	private function validate_jwt_token( $token, $allow_expired = false ) {
		$connect_token = $this->connect_token_factory->create();

		try {
			return $connect_token->load(
				$token,
				$this->cert_provider->get_stored_cert()
			);
		} catch ( Exception $exception ) {
			if ( $allow_expired && 'Expired token' === $exception->getMessage() ) {
				return $connect_token->decode(
					$token
				);
			}

			return null;
		}
	}

	/**
	 * Validates signed store token
	 *
	 * @param string $store_token JWT store token.
	 * @param bool   $allow_expired True if should allow expired tokens.
	 *
	 * @throws InvalidTokenException Can be thrown if store_token is incorrect.
	 */
	public function validate_store_token( $store_token, $allow_expired = false ) {
		$decoded_store_token = $this->validate_jwt_token( $store_token, $allow_expired );

		if ( is_null( $decoded_store_token ) || ! $decoded_store_token->get_store_uuid() ) {
			throw InvalidTokenException::store();
		}
	}

	/**
	 * Verifies signed user token.
	 *
	 * @param string $user_token JWT user token.
	 *
	 * @throws InvalidTokenException Can be thrown if user_token is incorrect.
	 */
	public function validate_user_token( $user_token ) {
		$decoded_user_token = $this->validate_jwt_token( $user_token );

		if ( is_null( $decoded_user_token ) || ! $decoded_user_token->get_user_uuid() ) {
			throw InvalidTokenException::user();
		}
	}

	/**
	 * Validates user and store tokens
	 *
	 * @param string $user_token User JWT token.
	 * @param string $store_token Store JWT token.
	 *
	 * @return bool
	 * @throws InvalidTokenException|ApiClientException Can be thrown by validation methods.
	 */
	public function validate_tokens( $user_token, $store_token ) {
		$this->validate_user_token( $user_token );
		$this->validate_store_token( $store_token );

		return true;
	}

	/**
	 * Returns new instance of TokenValidator
	 *
	 * @param CertProvider|null $cert_provider CertProvider instance.
	 *
	 * @return TokenValidator
	 */
	public static function create( $cert_provider = null ) {
		return new static(
			$cert_provider ? $cert_provider : CertProvider::create(),
			ConnectTokenFactory::get_instance()
		);
	}
}
