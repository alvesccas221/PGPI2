<?php
/**
 * Class UrlProvider
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use Exception;

/**
 * Class UrlProvider
 */
class UrlProvider {
	/**
	 * Instance of ConnectTokenProvider.
	 *
	 * @var ConnectToken|null
	 */
	private $connect_token = null;

	/**
	 * Format for API url.
	 *
	 * @var string
	 */
	private $api_url_format;

	/**
	 * Format for frontend url.
	 *
	 * @var string
	 */
	private $app_url_format;

	/**
	 * UrlProvider constructor.
	 *
	 * @param ConnectToken|null $connect_token      Instance of ConnectTokenProvider.
	 * @param string            $api_url_format     Format for API url.
	 * @param string            $app_url_format     Format for frontend url.
	 */
	public function __construct(
		$connect_token,
		$api_url_format,
		$app_url_format
	) {
		$this->connect_token  = $connect_token;
		$this->api_url_format = $api_url_format;
		$this->app_url_format = $app_url_format;
	}

	/**
	 * Returns frontend url based on ConnectToken (if exists) or returns default url.
	 *
	 * @param string $path Frontend url optional path.
	 * @return string
	 */
	public function get_app_url( $path = '' ) {
		return sprintf(
			$this->app_url_format,
			is_null( $this->connect_token ) ? 'us' : $this->connect_token->get_api_region(),
			livechat_get_platform(),
			$path
		);
	}

	/**
	 * Returns api url based on ConnectToken (if exists) or returns default url.
	 *
	 * @return string
	 */
	public function get_api_url() {
		if ( is_null( $this->connect_token ) ) {
			return sprintf( $this->api_url_format, 'connect' );
		}

		return sprintf(
			$this->api_url_format,
			$this->connect_token->get_api_region() === 'us' ? 'connect' : 'connect-eu'
		);
	}

	/**
	 * Returns UrlProvider instance based on token.
	 *
	 * @return UrlProvider
	 */
	public static function create_from_token() {
		try {
			$store_token   = Store::get_instance()->get_store_token();
			$decoded_token = ConnectTokenProvider::create( CertProvider::create() )->get( $store_token, 'store' );
			return self::create( $decoded_token );
		} catch ( Exception $exception ) {
			return self::create();
		}
	}

	/**
	 * Returns new instance of UrlProvider class.
	 *
	 * @param ConnectToken|null $connect_token      Instance of ConnectTokenProvider.
	 * @param string            $api_url_format     Format for API url.
	 * @param string            $app_url_format     Format for frontend url.
	 *
	 * @return $this
	 */
	public static function create(
		$connect_token = null,
		$api_url_format = WPLC_API_URL_PATTERN,
		$app_url_format = WPLC_APP_URL_PATTERN
	) {
		return new static(
			$connect_token,
			$api_url_format,
			$app_url_format
		);
	}
}
