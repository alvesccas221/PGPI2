<?php
/**
 * Class ConnectTokenProvider
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use LiveChat\Exceptions\ApiClientException;
use LiveChat\Exceptions\InvalidTokenException;
use LiveChat\Services\Factories\ConnectTokenFactory;

/**
 * Class ConnectTokenProvider
 *
 * @package LiveChat\Services
 */
class ConnectTokenProvider {
	/**
	 * Instance of CertProvider
	 *
	 * @var CertProvider
	 */
	private $cert_provider;

	/**
	 * Instance of TokenValidator
	 *
	 * @var TokenValidator
	 */
	private $token_validator;

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
	 * @param TokenValidator      $token_validator        Instance of TokenValidator.
	 * @param ConnectTokenFactory $connect_token_factory  Instance of ConnectTokenFactory.
	 */
	public function __construct( $cert_provider, $token_validator, $connect_token_factory ) {
		$this->cert_provider         = $cert_provider;
		$this->token_validator       = $token_validator;
		$this->connect_token_factory = $connect_token_factory;
	}

	/**
	 * Returns ConnectToken if user token is valid
	 *
	 * @param string $token         JWT token.
	 * @param string $token_type    Type of JWT token (could be store or user).
	 * @param bool   $allow_expired True if should allow expired tokens.
	 *
	 * @return ConnectToken
	 * @throws ApiClientException Can be thrown by get_stored_cert method.
	 * @throws InvalidTokenException Can be thrown by get_stored_cert method.
	 */
	public function get( $token, $token_type = 'user', $allow_expired = false ) {
		if ( 'store' === $token_type ) {
			$this->token_validator->validate_store_token( $token, $allow_expired );
		} else {
			$this->token_validator->validate_user_token( $token );
		}

		$connect_token = $this->connect_token_factory->create();

		if ( $allow_expired ) {
			return $connect_token->decode( $token );
		} else {
			return $connect_token->load(
				$token,
				$this->cert_provider->get_stored_cert()
			);
		}
	}

	/**
	 * Returns new instance of ConnectTokenProvider
	 *
	 * @param CertProvider $cert_provider Instance of CertProvider.
	 *
	 * @return static
	 */
	public static function create( $cert_provider ) {
		return new static(
			$cert_provider,
			TokenValidator::create( $cert_provider ),
			ConnectTokenFactory::get_instance()
		);
	}
}
