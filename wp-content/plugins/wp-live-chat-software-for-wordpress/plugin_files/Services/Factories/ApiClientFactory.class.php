<?php


namespace LiveChat\Services\Factories;

use LiveChat\Exceptions\ApiClientException;
use LiveChat\Exceptions\InvalidTokenException;
use LiveChat\Services\ApiClient;
use LiveChat\Services\ConnectToken;
use LiveChat\Services\Store;

class ApiClientFactory {
	/**
	 * Instance of ConnectTokenProviderFactory
	 *
	 * @var ConnectTokenProviderFactory
	 */
	private $connect_token_provider_factory;

	/**
	 * ApiClientFactory constructor.
	 *
	 * @param ConnectTokenProviderFactory $connect_token_provider_factory Instance of ConnectTokenProviderFactory.
	 */
	public function __construct( $connect_token_provider_factory ) {
		$this->connect_token_provider_factory = $connect_token_provider_factory;
	}

	/**
	 * Creates and returns ApiClient instance.
	 *
	 * @param ConnectToken|null $connect_token ConnectToken instance.
	 *
	 * @return ApiClient
	 * @throws ApiClientException Could be thrown by ConnectTokenProvider.
	 * @throws InvalidTokenException Could be thrown by ConnectTokenProvider.
	 */
	public function create( $connect_token = null ) {
		if ( ! $connect_token ) {
			$connect_token = $this->connect_token_provider_factory->create()->get(
				Store::get_instance()->get_store_token(),
				'store'
			);
		}
		return ApiClient::create( $connect_token );
	}

	/**
	 * Returns instance of ApiClientFactory (singleton pattern).
	 *
	 * @return static
	 */
	public static function get_instance() {
		return new static( ConnectTokenProviderFactory::get_instance() );
	}
}
