<?php
namespace ycd;

class Css {

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
    
    public function getComingSoonMenuPage() {
    	return 'toplevel_page_'.YCD_COUNTDOWN_COMING_SOON;
    }

    public function getSupportPageKey() {
    	return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_SUPPORT;
    }

    public function getSubscribersPageKey() {
    	return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_SUBSCRIBERS;
    }

    public function getMorePluginsPage() {
    	return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_MORE_PLUGINS;
    }
    
    public function getNewsletterPageKey() {
    	return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_NEWSLETTER;
    }
    
    public function getLicensePageKey() {
    	return YCD_COUNTDOWN_POST_TYPE.'_page_'.YCD_COUNTDOWN_LICENSE;
    }

    public function enqueueStyles($hook) {

        ScriptsIncluder::registerStyle('admin.css');
        ScriptsIncluder::registerStyle('bootstrap.css');
        ScriptsIncluder::registerStyle('colorpicker.css');
        ScriptsIncluder::registerStyle('ion.rangeSlider.css');
        ScriptsIncluder::registerStyle('ion.rangeSlider.skinFlat.css');
	    ScriptsIncluder::registerStyle('select2.css');
	    ScriptsIncluder::registerStyle('jquery.dateTimePicker.min.css');
		$settingsKey = $this->getSettingsPageKey();
		$supportKey = $this->getSupportPageKey();
		$subscriberKey = $this->getSubscribersPageKey();
		$newsletterKey = $this->getNewsletterPageKey();
		$morePlugins = $this->getMorePluginsPage();
		$comingSoonPage = $this->getComingSoonPage();
		$comingSoonMenuPage = $this->getComingSoonMenuPage();
		$licensePageKey = $this->getLicensePageKey();
	    $allowedPages = array(
		    $settingsKey,
		    $supportKey,
		    $subscriberKey,
		    $newsletterKey,
            $morePlugins,
		    $comingSoonPage,
		    $comingSoonMenuPage,
		    $licensePageKey,
		    'ycdcountdown_page_ycdcountdown',
	    );
        if(in_array($hook, $allowedPages) || get_post_type(@$_GET['post']) == YCD_COUNTDOWN_POST_TYPE) {
            ScriptsIncluder::enqueueStyle('bootstrap.css');
            ScriptsIncluder::enqueueStyle('admin.css');
            ScriptsIncluder::enqueueStyle('colorpicker.css');
            ScriptsIncluder::enqueueStyle('ion.rangeSlider.css');
            ScriptsIncluder::enqueueStyle('ion.rangeSlider.skinFlat.css');
	        ScriptsIncluder::enqueueStyle('select2.css');
	        ScriptsIncluder::enqueueStyle('jquery.dateTimePicker.min.css');
			
	        if (YCD_PKG_VERSION > YCD_FREE_VERSION) {
		        Subscription::renderStyles();
	        }
        }
    }
}

new Css();