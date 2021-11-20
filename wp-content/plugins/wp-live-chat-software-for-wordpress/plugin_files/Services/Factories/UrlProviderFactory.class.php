<?php
/**
 * Class UrlProviderFactory
 *
 * @package LiveChat\Services\Factories
 */

namespace LiveChat\Services\Factories;

use LiveChat\Exceptions\ApiClientException;
use LiveChat\Exceptions\InvalidTokenException;
use LiveChat\Services\Store;
use LiveChat\Services\UrlProvider;

/**
 * Class UrlProviderFactory
 *
 * @package LiveChat\Services\Factories
 */
class UrlProviderFactory {
	/**
	 * Instance of ConnectTokenProviderFactory.
	 *
	 * @var ConnectTokenProviderFactory
	 */
	private $connect_token_provider_factory;

	/**
	 * UrlProviderFactory constructor.
	 *
	 * @param ConnectTokenProviderFactory $connect_token_provider_factory Instance of ConnectTokenProviderFactory.
	 */
	public function __construct( $connect_token_provider_factory ) {
		$this->connect_token_provider_factory = $connect_token_provider_factory;
	}

	/**
	 * Creates and returns UrlProvider instance.
	 *
	 * @param ConnectToken|null $connect_token Instance of ConnectToken.
	 *
	 * @return UrlProvider
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

		return UrlProvider::create( $connect_token );
	}

	/**
	 * Returns new instance of UrlProviderFactory.
	 *
	 * @return static
	 */
	public static function get_instance() {
		return new static( ConnectTokenProviderFactory::get_instance() );
	}
}
