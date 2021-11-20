<?php
/**
 * Class Store
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use LiveChat\Services\Options\StoreToken;

/**
 * Class Store
 *
 * @package LiveChat\Services
 */
class Store {
	/**
	 * Instance of Store class (singleton pattern)
	 *
	 * @var Store
	 */
	private static $instance = null;

	/**
	 * Instance of StoreToken.
	 *
	 * @var StoreToken
	 */
	private $store_token;

	/**
	 * Store constructor.
	 *
	 * @param StoreToken $store_token StoreToken instance.
	 */
	public function __construct( $store_token ) {
		$this->store_token = $store_token;
	}

	/**
	 * Saves store token in WP database
	 *
	 * @param string $token JWT store token.
	 *
	 * @return bool
	 */
	public function authorize_store( $token ) {
		return $this->store_token->set( $token );
	}

	/**
	 * Removes store token from WP database
	 *
	 * @return bool
	 */
	public function remove_store_data() {
		return $this->store_token->remove();
	}

	/**
	 * Returns store token if is saved in WP database
	 *
	 * @return string
	 */
	public function get_store_token() {
		$store_token = $this->store_token->get();
		if ( ! $store_token ) {
			return '';
		}

		return $store_token;
	}

	/**
	 * Checks if plugin is connected with LiveChat account.
	 *
	 * @return bool
	 */
	public function is_connected() {
		return ! empty( $this->get_store_token() );
	}

	/**
	 * Returns new instance of User class
	 *
	 * @return Store
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static( StoreToken::get_instance() );
		}

		return static::$instance;
	}
}
