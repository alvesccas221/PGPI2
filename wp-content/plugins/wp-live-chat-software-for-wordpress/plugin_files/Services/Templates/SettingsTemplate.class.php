<?php
/**
 * Class ConnectServiceTemplate
 *
 * @package LiveChat\Services\Templates
 */

namespace LiveChat\Services\Templates;

use LiveChat\Services\LicenseProvider;
use LiveChat\Services\ModuleConfiguration;
use LiveChat\Services\Options\Deprecated\DeprecatedReviewNoticeOptions;
use LiveChat\Services\Options\Deprecated\Widget\DeprecatedWidgetSettings;
use LiveChat\Services\Options\ReviewNoticeOptions;
use LiveChat\Services\Store;
use LiveChat\Services\TemplateParser;
use LiveChat\Services\UrlProvider;
use LiveChat\Services\User;

/**
 * Class ConnectServiceTemplate
 */
class SettingsTemplate extends Template {
	/**
	 * ModuleConfiguration instance
	 *
	 * @var ModuleConfiguration|null
	 */
	private $module = null;

	/**
	 * Current user instance
	 *
	 * @var User|null
	 */
	private $user = null;

	/**
	 * Current store instance.
	 *
	 * @var Store|null
	 */
	private $store = null;

	/**
	 * Instance of LicenseProvider.
	 *
	 * @var LicenseProvider
	 */
	private $license_provider;

	/**
	 * Instance of DeprecatedWidgetSettings.
	 *
	 * @var DeprecatedWidgetSettings
	 */
	private $deprecated_widget_settings;

	/**
	 * Instance of DeprecatedReviewNoticeOptions.
	 *
	 * @var DeprecatedReviewNoticeOptions
	 */
	private $deprecated_review_notice;

	/**
	 * Instance of ReviewNoticeOptions.
	 *
	 * @var ReviewNoticeOptions
	 */
	private $review_notice;

	/**
	 * UrlProvider instance.
	 *
	 * @var UrlProvider
	 */
	private $url_provider;

	/**
	 * ConnectServiceTemplate constructor.
	 *
	 * @param ModuleConfiguration           $module                     ModuleConfiguration class instance.
	 * @param User                          $user                       User class instance.
	 * @param Store                         $store                      Store class instance.
	 * @param LicenseProvider               $license_provider           Instance of LicenseProvider.
	 * @param DeprecatedWidgetSettings      $deprecated_widget_settings Instance of DeprecatedWidgetSettings.
	 * @param DeprecatedReviewNoticeOptions $deprecated_review_notice   Instance of DeprecatedReviewNoticeOptions.
	 * @param ReviewNoticeOptions           $review_notice              Instance of ReviewNoticeOptions.
	 * @param UrlProvider                   $url_provider               Instance of UrlProvider.
	 * @param TemplateParser                $template_parser            Instance of TemplateParser.
	 * @param array                         $context                    Template context.
	 */
	public function __construct(
		$module,
		$user,
		$store,
		$license_provider,
		$deprecated_widget_settings,
		$deprecated_review_notice,
		$review_notice,
		$url_provider,
		$template_parser,
		$context
	) {
		parent::__construct( $template_parser, $context );
		$this->module                     = $module;
		$this->user                       = $user;
		$this->store                      = $store;
		$this->license_provider           = $license_provider;
		$this->deprecated_widget_settings = $deprecated_widget_settings;
		$this->deprecated_review_notice   = $deprecated_review_notice;
		$this->review_notice              = $review_notice;
		$this->url_provider               = $url_provider;
	}

	/**
	 * Returns legacy options array.
	 *
	 * @returns array
	 */
	private function get_legacy_options() {
		return array_merge(
			$this->deprecated_review_notice->get(),
			$this->review_notice->get(),
			$this->deprecated_widget_settings->get()
		);
	}

	/**
	 * Renders iframe with Connect service.
	 */
	public function render() {
		$context                        = array();
		$context['appUrl']              = esc_html( $this->url_provider->get_app_url() );
		$context['siteUrl']             = esc_html( $this->module->get_site_url() );
		$context['userEmail']           = esc_html( $this->user->get_user_data()['email'] );
		$context['userName']            = esc_html( $this->user->get_user_data()['name'] );
		$context['wpVer']               = esc_html( $this->module->get_wp_version() );
		$context['extensionVer']        = esc_html( $this->module->get_extension_version() );
		$context['moduleVer']           = esc_html( $this->module->get_plugin_version() );
		$context['lcToken']             = esc_html( $this->user->get_current_user_token() );
		$context['storeToken']          = esc_html( $this->store->get_store_token() );
		$context['partnerId']           = esc_html( WPLC_PARTNER_ID );
		$context['utmCampaign']         = esc_html( WPLC_UTM_CAMPAIGN );
		$context['license']             = esc_html( $this->license_provider->get_license_number() );
		$context['legacyOptions']       = wp_json_encode( $this->get_legacy_options() );
		$context['platform']            = esc_js( livechat_get_platform() );
		$context['platformLanguageVer'] = esc_html( phpversion() );

		$this->template_parser->parse_template( 'connect.html.twig', $context );
	}

	/**
	 * Returns new instance of ConnectServiceTemplate.
	 *
	 * @param array $context
	 * @return static
	 */
	public static function create( $context = array() ) {
		return new static(
			ModuleConfiguration::get_instance(),
			User::get_instance(),
			Store::get_instance(),
			LicenseProvider::create(),
			DeprecatedWidgetSettings::get_instance(),
			DeprecatedReviewNoticeOptions::get_instance(),
			ReviewNoticeOptions::get_instance(),
			UrlProvider::create_from_token(),
			TemplateParser::create( '../templates' ),
			$context
		);
	}
}
