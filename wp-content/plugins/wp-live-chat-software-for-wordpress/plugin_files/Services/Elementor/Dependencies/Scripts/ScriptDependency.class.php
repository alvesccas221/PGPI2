<?php
/**
 * ScriptDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Scripts
 */

namespace LiveChat\Services\Elementor\Dependencies\Scripts;

use Exception;
use LiveChat\Exceptions\ApiClientException;
use LiveChat\Exceptions\InvalidTokenException;
use LiveChat\Services\CertProvider;
use LiveChat\Services\ConnectTokenProvider;
use LiveChat\Services\Factories\UrlProviderFactory;
use LiveChat\Services\ModuleConfiguration;
use LiveChat\Services\Options\WritableOption;
use LiveChat\Services\Store;

/**
 * ScriptDependency class.
 *
 * @package LiveChat\Services\Elementor\Dependencies\Scripts
 */
class ScriptDependency {
	/**
	 * Name of the script file.
	 *
	 * @var string $name
	 */
	private $name;

	/**
	 * Scripts file URL.
	 *
	 * @var WritableOption $widget_url_option
	 */
	private $widget_url_option;

	/**
	 * ModuleConfiguration instance.
	 *
	 * @var ModuleConfiguration $module_configuration
	 */
	private $module_configuration;

	/**
	 * ConnectTokenProvider instance.
	 *
	 * @var ConnectTokenProvider $module_configuration
	 */
	private $connect_token_provider;

	/**
	 * Store instance.
	 *
	 * @var Store $module_configuration
	 */
	private $store;

	/**
	 * UrlProviderFactory instance.
	 *
	 * @var UrlProviderFactory $module_configuration
	 */
	private $url_provider_factory;

	/**
	 * ScriptDependency constructor.
	 *
	 * @param string               $name                    Name of the script file.
	 * @param WritableOption       $widget_url_option       Widget URL WritableOption instance.
	 * @param ModuleConfiguration  $module_configuration    ModuleConfiguration instance.
	 * @param ConnectTokenProvider $connect_token_provider  ConnectTokenProvider instance.
	 * @param Store                $store                   Store instance.
	 * @param UrlProviderFactory   $url_provider_factory    UrlProviderFactory instance.
	 */
	public function __construct(
		$name,
		$widget_url_option,
		$module_configuration,
		$connect_token_provider,
		$store,
		$url_provider_factory
	) {
		$this->name                   = $name;
		$this->widget_url_option      = $widget_url_option;
		$this->module_configuration   = $module_configuration;
		$this->connect_token_provider = $connect_token_provider;
		$this->store                  = $store;
		$this->url_provider_factory   = $url_provider_factory;
	}

	/**
	 * Checks if widget URL matches RegEx. Returns true if URL is valid,
	 * otherwise returns false.
	 *
	 * @param string $widget_url Widget URL to check.
	 *
	 * @return false|int
	 */
	private function is_widget_url_valid( $widget_url ) {
		$pattern = sprintf(
			WPLC_ELEMENTOR_WIDGET_URL_REGEX,
			$this->name
		);

		return preg_match( $pattern, $widget_url );
	}

	/**
	 * Returns widget URL build from token data.
	 *
	 * @throws ApiClientException Can be thrown by ConnectTokenProvider method.
	 * @throws InvalidTokenException Can be thrown by ConnectTokenProvider method.
	 */
	private function get_widget_url_from_token() {
		$connect_token = $this->connect_token_provider->get(
			$this->store->get_store_token(),
			'store',
			true
		);

		$api_url = $this->url_provider_factory->create( $connect_token )->get_api_url();

		return sprintf(
			'%s/api/v1/script/%s/%s.js',
			$api_url,
			$connect_token->get_store_uuid(),
			$this->name
		);
	}

	/**
	 * Returns handle name for dependency.
	 *
	 * @return string
	 */
	private function get_handle_name() {
		return sprintf(
			'livechat-%s-script',
			$this->name
		);
	}

	/**
	 * Registers widget scripts sheets.
	 *
	 * @return bool
	 */
	public function register() {
		try {
			$widget_url = $this->widget_url_option->get();

			if ( ! $widget_url || ! $this->is_widget_url_valid( $widget_url ) ) {
				$widget_url = $this->get_widget_url_from_token();
				$this->widget_url_option->set( $widget_url );
			}
		} catch ( Exception $ex ) {
			return false;
		}

		$handle_name    = $this->get_handle_name();
		$was_registered = wp_register_script(
			$handle_name,
			$widget_url,
			array(),
			$this->module_configuration->get_plugin_version(),
			false
		);

		if ( $was_registered ) {
			wp_enqueue_script( $handle_name );
		}

		return $was_registered;
	}

	/**
	 * Creates a new ScriptDependency instance.
	 *
	 * @param string          $name               Name of the script file.
	 * @param WritableOption  $widget_url_option  Widget URL WritableOption instance.
	 *
	 * @return static
	 */
	public static function create( $name, $widget_url_option ) {
		return new static(
			$name,
			$widget_url_option,
			ModuleConfiguration::get_instance(),
			ConnectTokenProvider::create( CertProvider::create() ),
			Store::get_instance(),
			UrlProviderFactory::get_instance()
		);
	}
}
