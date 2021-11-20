<?php
/**
 * Class NoticeTemplate
 *
 * @package LiveChat\Services\Templates
 */

namespace LiveChat\Services\Templates;

use LiveChat\Services\ModuleConfiguration;
use LiveChat\Services\Options\ReviewNoticeOptions;
use LiveChat\Services\Store;
use LiveChat\Services\TemplateParser;
use LiveChat\Services\UrlProvider;
use LiveChat\Services\User;

/**
 * Class NoticeTemplate
 */
class NoticeTemplate extends Template {
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
	 * UrlProvider instance.
	 *
	 * @var UrlProvider
	 */
	private $url_provider;

	/**
	 * Current platform name.
	 *
	 * @var string
	 */
	private $platform;

	/**
	 * ReviewNoticeOptions instance.
	 *
	 * @var ReviewNoticeOptions
	 */
	private $review_notice;

	/**
	 * NoticeTemplate constructor.
	 *
	 * @param ModuleConfiguration $module              ModuleConfiguration class instance.
	 * @param User                $user                User class instance.
	 * @param Store               $store               Store class instance.
	 * @param UrlProvider         $url_provider        Instance of UrlProvider.
	 * @param ReviewNoticeOptions $review_notice       ReviewNoticeOptions instance.
	 * @param string              $platform            Current platform name.
	 * @param TemplateParser      $template_parser     Instance of TemplateParser.
	 * @param array               $context             Template context.
	 */
	public function __construct(
		$module,
		$user,
		$store,
		$url_provider,
		$review_notice,
		$platform,
		$template_parser,
		$context
	) {
		parent::__construct( $template_parser, $context );
		$this->module        = $module;
		$this->user          = $user;
		$this->store         = $store;
		$this->url_provider  = $url_provider;
		$this->review_notice = $review_notice;
		$this->platform      = $platform;
	}

	/**
	 * Renders notice iframe with Connect service.
	 */
	public function render() {
		$context               = array();
		$context['noticeUrl']  = esc_html( $this->url_provider->get_app_url( '/notice' ) );
		$context['wpVer']      = esc_html( $this->module->get_wp_version() );
		$context['moduleVer']  = esc_html( $this->module->get_plugin_version() );
		$context['lcToken']    = esc_html( $this->user->get_current_user_token() );
		$context['storeToken'] = esc_html( $this->store->get_store_token() );
		$context['options']    = wp_json_encode( $this->review_notice->get() );
		$context['platform']   = esc_js( $this->platform );

		$this->template_parser->parse_template( 'notice.html.twig', $context );
	}

	/**
	 * Returns new instance of NoticeTemplate.
	 *
	 * @param array $context
	 * @return static
	 */
	public static function create( $context = array() ) {
		return new static(
			ModuleConfiguration::get_instance(),
			User::get_instance(),
			Store::get_instance(),
			UrlProvider::create_from_token(),
			ReviewNoticeOptions::get_instance(),
			WPLC_PLATFORM,
			TemplateParser::create( '../templates' ),
			$context
		);
	}
}
