<?php
/**
 * Class ChatWidgetScriptTemplate
 *
 * @package LiveChat\Services\Templates
 */

namespace LiveChat\Services\Templates;

use Exception;
use LiveChat\Exceptions\ApiClientException;
use LiveChat\Exceptions\InvalidTokenException;
use LiveChat\Services\CertProvider;
use LiveChat\Services\ConnectTokenProvider;
use LiveChat\Services\Factories\UrlProviderFactory;
use LiveChat\Services\Options\WidgetURL;
use LiveChat\Services\Store;
use LiveChat\Services\TemplateParser;

/**
 * Class ChatWidgetScriptTemplate
 *
 * @package LiveChat\Services\Templates
 */
class ChatWidgetScriptTemplate extends Template {
	/**
	 * Instance of Store.
	 *
	 * @var Store
	 */
	private $store;

	/**
	 * Instance of WidgetURL.
	 *
	 * @var WidgetURL
	 */
	private $widget_url;

	/**
	 * Instance of ConnectTokenProvider.
	 *
	 * @var ConnectTokenProvider
	 */
	private $connect_token_provider;

	/**
	 * Instance of UrlProviderFactory.
	 *
	 * @var UrlProviderFactory
	 */
	private $url_provider_factory;

	/**
	 * Instance of CustomerTrackingTemplate.
	 *
	 * @var CustomerTrackingTemplate
	 */
	private $customer_tracking_template;

	/**
	 * WidgetProvider constructor.
	 *
	 * @param Store                    $store                          Instance of Store.
	 * @param WidgetURL                $widget_url                     Instance of WidgetURL.
	 * @param ConnectTokenProvider     $connect_token_provider         Instance of ConnectTokenProvider.
	 * @param UrlProviderFactory       $url_provider_factory           Instance of UrlProviderFactory.
	 * @param CustomerTrackingTemplate $customer_tracking_template     Instance of CustomerTrackingTemplate.
	 * @param TemplateParser           $template_parser                Instance of TemplateParser.
	 * @param array                    $context                        Template context.
	 */
	public function __construct(
		$store,
		$widget_url,
		$connect_token_provider,
		$url_provider_factory,
		$customer_tracking_template,
		$template_parser,
		$context
	) {
		parent::__construct( $template_parser, $context );
		$this->store                      = $store;
		$this->widget_url                 = $widget_url;
		$this->connect_token_provider     = $connect_token_provider;
		$this->customer_tracking_template = $customer_tracking_template;
		$this->url_provider_factory       = $url_provider_factory;
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
		return preg_match( WPLC_WIDGET_URL_REGEX, $widget_url );
	}

	/**
	 * Gets URL from token
	 *
	 * @return string
	 * @throws ApiClientException Can be thrown from ConnectTokenProvider and UrlProvider.
	 * @throws InvalidTokenException Can be thrown from ConnectTokenProvider and UrlProvider.
	 */
	private function get_url_from_token() {
		$connect_token = $this->connect_token_provider->get(
			$this->store->get_store_token(),
			'store',
			true
		);

		$api_url = $this->url_provider_factory->create( $connect_token )->get_api_url();

		return sprintf(
			'%s/api/v1/script/%s/widget.js',
			$api_url,
			$connect_token->get_store_uuid()
		);
	}

	/**
	 * Injects chat widget script.
	 *
	 * @return string
	 * @throws ApiClientException Can be thrown from ConnectTokenProvider and UrlProvider.
	 * @throws InvalidTokenException Can be thrown from ConnectTokenProvider and UrlProvider.
	 */
	public function render() {
		$widget_url = $this->widget_url->get();

		if ( ! $widget_url || ! $this->is_widget_url_valid( $widget_url ) ) {
			$widget_url = $this->get_url_from_token();
			$this->widget_url->set( $widget_url );
		}

		$context = array(
			'customerTrackingScript' => livechat_is_woo() ? $this->customer_tracking_template->render() : '',
			'widgetUrl'              => $widget_url,
		);

		return $this->template_parser->parse_template( 'chat_widget_script.html.twig', $context );
	}

	/**
	 * Returns instance of ChatWidgetScriptTemplate.
	 *
	 * @param array $context
	 * @return ChatWidgetScriptTemplate|static
	 * @throws Exception
	 */
	public static function create( $context = array() ) {
		return new static(
			Store::get_instance(),
			WidgetURL::get_instance(),
			ConnectTokenProvider::create( CertProvider::create() ),
			UrlProviderFactory::get_instance(),
			CustomerTrackingTemplate::create(),
			TemplateParser::create( '../templates' ),
			$context
		);
	}
}
