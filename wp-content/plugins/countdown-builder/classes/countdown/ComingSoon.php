<?php
namespace ycd;

Class ComingSoon {
	
	public function __construct()
	{
		add_filter('YcdComingSoonPageHeader', array(&$this,'comingSoonPageHeader'), 1, 1);
		add_filter('YcdComingSoonPageMessage', array(&$this,'comingSoonPageMessage'), 1, 1);
		add_filter('YcdComingSoonPageTitle', array(&$this,'YcdComingSoonPageTitle'), 1, 1);
		add_filter('YcdComingSoonPageHeaderContent', array(&$this,'YcdComingSoonPageHeaderContent'), 1, 1);
	}
	
	public function YcdComingSoonPageHeaderContent($content)
	{
		$description = $this->getOptionValue('ycd-coming-soon-seo-description');
		$favicon = $this->getOptionValue('ycd-coming-soon-favicon');
		$customJs = $this->getOptionValue('ycd-coming-soon-countdown-custom-js');
		$customCSS = $this->getOptionValue('ycd-coming-soon-countdown-custom-css');
		
		$content .= '<meta name="description" content="'.esc_attr($description).'">';
		$content .= '<link href="'.esc_attr($favicon).'" rel="shortcut icon" type="image/x-icon" >';
		if (!empty($customJs)) {
			$content .= "<script>$customJs</script>";
		}
		if (!empty($customCSS)) {
			$content .= "<style>$customCSS</style>";
		}

		return $content;
	}
	
	public function YcdComingSoonPageTitle($content)
	{
		$title = $this->getOptionValue('ycd-coming-soon-title');

		return $title;
	}
	
	public function comingSoonPageHeader($content)
	{
		$header = $this->getOptionValue('ycd-coming-soon-headline');
		return '<h1>'.$header.'</h1>';
	}
	
	public function comingSoonPageMessage($content)
	{
		$message = $this->getOptionValue('ycd-coming-soon-message');
		return  '<div>'.do_shortcode($message).'</div>';
	}
	
	public function allowComingSoon()
	{
		$renderStatus = true;
		$isAllow = $this->getOptionValue('ycd-enable-coming-soon');
		$status = empty($isAllow);

		if (YCD_PKG_VERSION == YCD_FREE_VERSION) {
			$status = $status || is_user_logged_in();
		}

		if ($status) {
			return false;
		}
		$renderStatus = apply_filters('ycdComingSoonIsEnable', $renderStatus, $this);
		return $renderStatus;
	}
	
	public function render()
	{
		$comingSoonThis = $this;
		$this->changeHeaderStatus();
		require_once YCD_FRONT_VIEWS_PATH.'comingSoonTempleate.php';
		exit();
	}
	
	private function changeHeaderStatus()
	{
		$mode = $this->getOptionValue('ycd-coming-soon-mode');
		if ($mode == 'maintenanceMode') {
			status_header(503);
		}
	}
	
	public static function defaults()
	{
		$defaults = array();
		
		$defaults['ycd-coming-soon-headline'] = 'Get Ready... Something Really Cool Is Coming Soon';
		$defaults['ycd-coming-soon-message'] = '';
		$defaults['ycd-enable-coming-soon'] = 'on';
		$defaults['ycd-coming-soon-title'] = '';
		$defaults['ycd-coming-soon-seo-description'] = '';
		$defaults['ycd-coming-soon-favicon'] = '';
		$defaults['ycd-coming-soon-bg-image'] = '';
		$defaults['ycd-coming-soon-image-size'] = '';
		$defaults['ycd-coming-soon-bg-image-repeat'] = '';
		$defaults['ycd-coming-soon-bg-image-url'] = '';
		$defaults['ycd-coming-soon-background-color'] = '';
		$defaults['ycd-coming-soon-add-countdown'] = '';
		$defaults['ycd-coming-soon-countdown'] = '';
		$defaults['ycd-coming-soon-countdown-position'] = '';
		$defaults['ycd-coming-headline-color'] = '#000000';
		$defaults['ycd-coming-message-color'] = '#000000';
		$defaults['ycd-coming-soon-page-font-family'] = '';
		$defaults['ycd-coming-soon-bg-video'] = '';
		$defaults['ycd-coming-soon-bg-video-url'] = '';
		$defaults['ycd-coming-soon-mode'] = 'comingSoonMode';
		$defaults['ycd-coming-soon-countdown-custom-css'] = '';
		$defaults['ycd-coming-soon-countdown-custom-js'] = '';
		$defaults['ycd-coming-soon-whitelist-ip'] = '';
		$defaults['ycd-coming-soon-for-loggdin'] = '';
		$defaults['ycd-coming-soon-automat-enable'] = '';
		$defaults['ycd-coming-soon-automat-expiration'] = '';
		$defaults['ycd-coming-soon-ip-address'] = '';
		$defaults['ycd-coming-soon-user-roles'] = '';
		$defaults['ycd-coming-soon-start'] = '';
		$defaults['ycd-coming-soon-start-timezone'] = '';
		$defaults['ycd-coming-soon-expiration'] = '';
		$defaults['ycd-coming-soon-expiration-timezone'] = '';
		$defaults['checkboxes'] = array(
			'ycd-enable-coming-soon',
			'ycd-coming-soon-bg-image',
			'ycd-coming-soon-add-countdown',
			'ycd-coming-soon-bg-video',
			'ycd-coming-soon-whitelist-ip',
			'ycd-coming-soon-for-loggdin',
			'ycd-coming-soon-automat-enable',
			'ycd-coming-soon-automat-expiration',
		);
		
		return apply_filters('ycdComingSoonDefaults', $defaults);
	}
	
	public function getSavedData()
	{
		$settings = array();
		$savedSettingsStr = get_option('ycdComingSoonSettings');
		
		if (empty($savedSettingsStr)) {
			return $settings;
		}
		
		$savedSettings = json_decode($savedSettingsStr, true);
		
		if (empty($savedSettings)) {
			return $settings;
		}
		$settings = $savedSettings;
		
		return $settings;
	}
	
	public function getOptionValue($optionName)
	{
		$defaults = ComingSoon::defaults();
		$savedData = $this->getSavedData();
		$checkboxes = $defaults['checkboxes'];
		
		$optionValue = '';
		
		if (isset($savedData[$optionName])) {
			$optionValue = $savedData[$optionName];
		}
		else if (!in_array($optionName, $checkboxes) && isset($defaults[$optionName])) {
			$optionValue = $defaults[$optionName];
		}
		
		if (in_array($optionName, $checkboxes) && !empty($optionValue)) {
			$optionValue = 'checked';
		}
		
		return $optionValue;
	}
	
	public function adminView()
	{
		require_once YCD_ADMIN_COMING_VIEWS_PATH.'comingSoon.php';
	}
	
	public static function saveComingSoonSettings($postData)
	{
		$postData = stripslashes_deep($postData);
		$defaults = self::defaults();
		$optionsNames = array_keys($defaults);
		$savedData = array();
		
		foreach ($optionsNames as $name) {
			if (isset($postData[$name])) {
				$savedData[$name] = $postData[$name];
			}
		}
		do_action('ycdComingSoonSave', $savedData);
		$savedDataString = json_encode($savedData);
		update_option('ycdComingSoonSettings', $savedDataString);
	}
}