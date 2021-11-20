<?php
namespace ycd;

class Js {

	public function __construct() {
		$this->init();
	}

	public function init() {

		add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
	}

	public function getSettingsPageKey() {
		return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_SETTINGS;
	}
	
	public function getComingSoonPage() {
		return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_COMING_SOON;
	}

	public function getSupportPageKey() {
		return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_SUPPORT;
	}

	public function getSubscribersPageKey() {
		return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_SUBSCRIBERS;
	}
	
	public function getComingSoonMenuPage() {
		return 'toplevel_page_'.YCD_COUNTDOWN_COMING_SOON;
	}
	
	public function getNewsletterPageKey() {
		return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_NEWSLETTER;
	}

	private function gutenbergParams() {
		$settings = array(
				'allCountdowns' => Countdown::shapeIdTitleData(),
				'title'   => __('Countdowns', YCD_TEXT_DOMAIN),
				'description'   => __('This block will help you to add countdown’s shortcode inside the page content', YCD_TEXT_DOMAIN),
				'logo_classname' => 'ycd-gutenberg-logo',
				'coountdown_select' => __('Select countdown', YCD_TEXT_DOMAIN)
			);

		return $settings;
	}

	public function enqueueStyles($hook) {
		$blockSettings = $this->gutenbergParams();
		ScriptsIncluder::registerScript('WpCountdownBlockMin.js', array('dirUrl' => YCD_COUNTDOWN_ADMIN_JS_URL));
		ScriptsIncluder::localizeScript('WpCountdownBlockMin.js', 'YCD_GUTENBERG_PARAMS', $blockSettings);
		ScriptsIncluder::enqueueScript('WpCountdownBlockMin.js');

		ScriptsIncluder::registerScript('Admin.js');
		ScriptsIncluder::localizeScript('Admin.js', 'ycd_admin_localized', array(
			'nonce' => wp_create_nonce('ycd_ajax_nonce'),
			'changeSound' => __('Change the sound', YCD_TEXT_DOMAIN),
			'adminUrl' => admin_url(),
			'pkgVersion' => YCD_PKG_VERSION,
			'supportURL' => YCD_COUNTDOWN_SUPPORT_URL,
            'copied' => __('Copied', YCD_TEXT_DOMAIN),
            'copyToClipboard' => __('Copy to clipboard', YCD_TEXT_DOMAIN),
			'proUrl' => YCD_COUNTDOWN_PRO_URL
		));
		ScriptsIncluder::registerScript('select2.js');
		ScriptsIncluder::registerScript('minicolors.js');
		ScriptsIncluder::registerScript('ionRangeSlider.js');
		ScriptsIncluder::registerScript('jquery.datetimepicker.full.min.js');
		$settingsKey = $this->getSettingsPageKey();
		$supportKey = $this->getSupportPageKey();
		$subscriberKey = $this->getSubscribersPageKey();
		$newsletterKey = $this->getNewsletterPageKey();
		$comingSoonPage = $this->getComingSoonPage();
		$comingSoonMenuPage = $this->getComingSoonMenuPage();
		
		$allowedPages = array(
			$settingsKey,
			$supportKey,
			$subscriberKey,
			$newsletterKey,
			$comingSoonPage,
			$comingSoonMenuPage,
			'ycdcountdown_page_ycdcountdown'
		);

		if(in_array($hook, $allowedPages) || get_post_type(@$_GET['post']) == YCD_COUNTDOWN_POST_TYPE || @$_GET['post_type'] == YCD_COUNTDOWN_POST_TYPE) {
			
			wp_enqueue_script('jquery-ui-core');
            if(function_exists('wp_enqueue_code_editor')) {
                wp_enqueue_code_editor(array( 'type' => 'text/html'));
            }
			ScriptsIncluder::enqueueScript('Admin.js');
			if(YCD_PKG_VERSION != YCD_FREE_VERSION) {
				ScriptsIncluder::registerScript('AdminPro.js');
				ScriptsIncluder::enqueueScript('AdminPro.js');
				ScriptsIncluder::registerScript('Subscribers.js');
				ScriptsIncluder::enqueueScript('Subscribers.js');
			}
			ScriptsIncluder::enqueueScript('select2.js');
			ScriptsIncluder::enqueueScript('minicolors.js');
			ScriptsIncluder::enqueueScript('ionRangeSlider.js');
			ScriptsIncluder::enqueueScript('jquery.datetimepicker.full.min.js');
			
			if (YCD_PKG_VERSION > YCD_FREE_VERSION) {
				Subscription::renderScripts();
			}
		}
	}
}

new Js();