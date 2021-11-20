<?php
/**
 * Class ConnectToken
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use Exception;
use Firebase\JWT\JWT;

/**
 * Class ConnectToken
 *
 * @package LiveChat\Services
 */
class ConnectToken {
	/**
	 * JWT token string
	 *
	 * @var string|null $token
	 */
	private $token = null;

	/**
	 * JWT data object
	 *
	 * @var object|null $decoded_token
	 */
	private $decoded_token = null;

	/**
	 * Decodes and sets JWT
	 *
	 * @param string $token JWT token string.
	 * @param string $cert  JWT public key.
	 *
	 * @throws Exception Any exception that could be thrown from JWT::decode.
	 */
	private function set_token( $token, $cert ) {
		$this->token         = $token;
		$this->decoded_token = JWT::decode( $token, $cert, array( 'RS256' ) );
	}

	/**
	 * Checks if JWT token is set
	 *
	 * @return bool
	 */
	public function has_token() {
		return (bool) $this->token;
	}

	/**
	 * Returns JWT token string
	 *
	 * @return string
	 */
	public function get_token() {
		return $this->has_token() ? $this->token : null;
	}

	/**
	 * Gets a property from JWT data object
	 *
	 * @param string $key JWT data object property key name.
	 *
	 * @return mixed
	 */
	private function get_from_token( $key ) {
		return $this->decoded_token && property_exists( $this->decoded_token, $key )
			? $this->decoded_token->{$key}
			: null;
	}

	/**
	 * Gets API region from JWT data object
	 *
	 * @return string|null
	 */
	public function get_api_region() {
		return $this->get_from_token( 'apiRegion' );
	}

	/**
	 * Gets API version from JWT data object
	 *
	 * @return string|null
	 */
	public function get_api_version() {
		return $this->get_from_token( 'apiVersion' );
	}

	/**
	 * Gets store UUID from JWT data object
	 *
	 * @return string|null
	 */
	public function get_store_uuid() {
		return $this->get_from_token( 'storeUUID' );
	}

	/**
	 * Gets user UUID from JWT data object
	 *
	 * @return string|null
	 */
	public function get_user_uuid() {
		return $this->get_from_token( 'userUUID' );
	}

	/**
	 * Decodes payload of token without validation.
	 *
	 * @param string $token JWT to decode.
	 */
	private function set_token_without_validation( $token ) {
		$this->token = $token;

		list(, $payload)     = explode( '.', $token );
		$this->decoded_token = JWT::jsonDecode( JWT::urlsafeB64Decode( $payload ) );
	}

	/**
	 * Creates ConnectToken instance
	 *
	 * @param string $token JWT token string.
	 * @param string $cert  Public key for given JWT token.
	 *
	 * @return ConnectToken
	 * @throws Exception Any exception that could be thrown from JWT::decode.
	 */
	public function load( $token, $cert ) {
		$this->set_token( $token, $cert );

		return $this;
	}

	/**
	 * Only decodes token without validating it.
	 *
	 * @param string $token JWT to decode.
	 *
	 * @return ConnectToken
	 */
	public function decode( $token ) {
		$this->set_token_without_validation( $token );

		return $this;
	}

	/**
	 * Returns new instance of ConnectToken.
	 *
	 * @return static
	 */
	public static function create() {
		return new static();
	}
}
