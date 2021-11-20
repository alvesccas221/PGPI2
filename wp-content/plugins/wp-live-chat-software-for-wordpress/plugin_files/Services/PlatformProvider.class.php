<?php
/**
 * Class PlatformProvider
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use Exception;
use LiveChat\Services\Factories\ApiClientFactory;
use LiveChat\Services\Factories\ConnectTokenProviderFactory;
use LiveChat\Services\Options\Platform;
use LiveChat\Services\Options\StoreToken;

/**
 * Class PlatformProvider
 *
 * @package LiveChat\Services
 */
class PlatformProvider {
	/**
	 * String of WordPress platform.
	 *
	 * @var string
	 */
	// phpcs:ignore WordPress.WP.CapitalPDangit.Misspelled
	public static $wordpress_platform = 'wordpress';

	/**
	 * String of WooCommerce platform.
	 *
	 * @var string
	 */
	public static $woocommerce_platform = 'woocommerce';

	/**
	 * String of Elementor platform.
	 *
	 * @var string
	 */
	public static $elementor_platform = 'elementor';

	/**
	 * Instance of ApiClientFactory.
	 *
	 * @var ApiClientFactory
	 */
	private $api_client_factory;

	/**
	 * Instance of ConnectTokenProviderFactory.
	 *
	 * @var ConnectTokenProviderFactory
	 */
	private $connect_token_provider_factory;

	/**
	 * Instance of Store.
	 *
	 * @var StoreToken
	 */
	private $store_token;

	/**
	 * Instance of Platform.
	 *
	 * @var Platform
	 */
	private $platform;

	/**
	 * PlatformProvider constructor.
	 *
	 * @param ApiClientFactory            $api_client_factory                 Instance of ApiClientFactory.
	 * @param ConnectTokenProviderFactory $connect_token_provider_factory     Instance of ConnectTokenProviderFactory.
	 * @param StoreToken                  $store_token                        Instance of StoreToken.
	 * @param Platform                    $platform                           Instance of Platform.
	 */
	public function __construct(
		$api_client_factory,
		$connect_token_provider_factory,
		$store_token,
		$platform
	) {
		$this->api_client_factory             = $api_client_factory;
		$this->connect_token_provider_factory = $connect_token_provider_factory;
		$this->store_token                    = $store_token;
		$this->platform                       = $platform;
	}

	/**
	 * Returns default platform obtained by checking activation state of WooCommerce plugin.
	 *
	 * @return string
	 */
	private function get_default_platform() {
		// phpcs:ignore WordPress.WP.CapitalPDangit.Misspelled
		if ( livechat_is_woo_plugin_active() ) {
			return self::$woocommerce_platform;
		} elseif ( livechat_is_elementor_plugin_active() ) {
			return self::$elementor_platform;
		} else {
			return self::$wordpress_platform;
		}
	}

	/**
	 * Returns platform based on plugin slug.
	 *
	 * @return string
	 */
	private function get_platform_from_slug() {
		switch ( WPLC_PLUGIN_SLUG ) {
			case 'livechat-woocommerce':
				return self::$woocommerce_platform;
			case 'livechat-elementor':
				return self::$elementor_platform;
			case 'wp-live-chat-software-for-wordpress':
			default:
				return self::$wordpress_platform;
		}
	}

	/**
	 * Checks platform assigned to store on Connect backend.
	 *
	 * @return string
	 */
	private function get_backend_platform() {
		try {
			$api_client = $this->api_client_factory->create();
			$platforms  = array( self::$wordpress_platform, self::$woocommerce_platform, self::$elementor_platform );

			foreach ( $platforms as $platform ) {
				$response = $api_client->store_info( $platform );

				if (
					array_key_exists( 'statusCode', $response ) &&
					401 === $response['statusCode']
				) {
					continue;
				}

				return $response['store']['platform'];
			}
			// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
		} catch ( Exception $exception ) {
			// Exception is ignored and detected platform is returned.
		}

		return $this->get_platform_from_slug();
	}

	/**
	 * @param string $token Store token string.
	 *
	 * @return bool
	 */
	private function is_token_valid( $token ) {
		try {
			$this->connect_token_provider_factory
				->create()
				->get( $token, 'store' );
			return true;
		} catch ( Exception $exception ) {
			return false;
		}
	}

	/**
	 * Detects platform based on store token.
	 *
	 * @return string
	 */
	private function detect_platform() {
		$token = $this->store_token->get();

		if ( ! $token ) {
			return $this->get_default_platform();
		}

		if ( ! $this->is_token_valid( $token ) ) {
			return $this->get_platform_from_slug();
		}

		return $this->get_backend_platform();
	}

	/**
	 * Returns platform name.
	 *
	 * @return string
	 */
	public function get() {
		$platform = $this->platform->get();

		if ( $platform ) {
			return $platform;
		}

		$platform = $this->detect_platform();

		$this->platform->set( $platform );
		return $platform;
	}

	/**
	 * Returns instance of PlatformProvider.
	 *
	 * @return static
	 * @throws Exception
	 */
	public static function create() {
		return new static(
			ApiClientFactory::get_instance(),
			ConnectTokenProviderFactory::get_instance(),
			StoreToken::get_instance(),
			Platform::get_instance()
		);
	}
}
