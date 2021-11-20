<?php
use ycd\AdminHelper;

class YcdCountdownConfig
{
	public static function addDefine($name, $value)
	{
		if(!defined($name)) {
			define($name, $value);
		}
	}

	public static function init()
	{
		self::addDefine('YCD_PREFIX', YCD_FILE_NAME);
		self::addDefine('YCD_ADMIN_URL', admin_url());
		self::addDefine('YCD_COUNTDOWN_BUILDER_URL', plugins_url().'/'.YCD_FOLDER_NAME.'/');
		self::addDefine('YCD_COUNTDOWN_ADMIN_URL', admin_url());
		self::addDefine('YCD_COUNTDOWN_URL', plugins_url().'/'.YCD_FOLDER_NAME.'/');
		self::addDefine('YCD_COUNTDOWN_ASSETS_URL', YCD_COUNTDOWN_URL.'assets/');
		self::addDefine('YCD_COUNTDOWN_CSS_URL', YCD_COUNTDOWN_ASSETS_URL.'css/');
		self::addDefine('YCD_COUNTDOWN_ADMIN_CSS_URL', YCD_COUNTDOWN_CSS_URL.'admin/');
		self::addDefine('YCD_COUNTDOWN_JS_URL', YCD_COUNTDOWN_ASSETS_URL.'js/');
		self::addDefine('YCD_COUNTDOWN_ADMIN_JS_URL', YCD_COUNTDOWN_JS_URL.'admin/');
		self::addDefine('YCD_COUNTDOWN_IMG_URL', YCD_COUNTDOWN_ASSETS_URL.'img/');
		self::addDefine('YCD_COUNTDOWN_LIB_URL', YCD_COUNTDOWN_URL.'lib/');
		self::addDefine('YCD_COUNTDOWN_PATH', WP_PLUGIN_DIR.'/'.YCD_FOLDER_NAME.'/');
		self::addDefine('YCD_CLASSES_PATH', YCD_COUNTDOWN_PATH.'classes/');
		self::addDefine('YCD_BLOCKS_PATH', YCD_CLASSES_PATH.'blocks/');
		self::addDefine('YCD_DATA_TABLE_PATH', YCD_CLASSES_PATH.'dataTable/');
		self::addDefine('YCD_LIB_PATH', YCD_COUNTDOWN_PATH.'lib/');
		self::addDefine('YCD_HELPERS_PATH', YCD_COUNTDOWN_PATH.'helpers/');
		self::addDefine('YCD_CONFIG_PATH', YCD_COUNTDOWN_PATH.'config/');
		self::addDefine('YCD_ASSETS_PATH', YCD_COUNTDOWN_PATH.'/assets/');
		self::addDefine('YCD_VIEWS_PATH', YCD_ASSETS_PATH.'views/');
		self::addDefine('YCD_VIEWS_MAIN_PATH', YCD_VIEWS_PATH.'main/');
		self::addDefine('YCD_ADMIN_VIEWS_PATH', YCD_VIEWS_PATH.'admin/');
		self::addDefine('YCD_ADMIN_COMING_VIEWS_PATH', YCD_ADMIN_VIEWS_PATH.'comingSoon/');
		self::addDefine('YCD_FRONT_VIEWS_PATH', YCD_VIEWS_PATH.'front/');
		self::addDefine('YCD_PREVIEW_VIEWS_PATH', YCD_VIEWS_PATH.'preview/');
		self::addDefine('YCD_CSS_PATH', YCD_ASSETS_PATH.'css/');
		self::addDefine('YCD_JS_PATH', YCD_ASSETS_PATH.'js/');
		self::addDefine('YCD_COUNTDOWNS_PATH', YCD_CLASSES_PATH.'countdown/');
		self::addDefine('YCD_COMING_SOON_PATH', YCD_CLASSES_PATH.'commingSoon/');
		self::addDefine('YCD_HELPERS_PATH', YCD_COUNTDOWN_PATH.'helpers/');
		self::addDefine('YCD_COUNTDOWN_POST_TYPE', 'ycdcountdown');
		self::addDefine('YCD_COUNTDOWN_SETTINGS', 'ycdSettings');
		self::addDefine('YCD_COUNTDOWN_MORE_PLUGINS', 'ycdPlugins');
		self::addDefine('YCD_COUNTDOWN_COMING_SOON', 'ycdComingSoon');
		self::addDefine('YCD_COUNTDOWN_SUPPORT', 'supports');
		self::addDefine('YCD_COUNTDOWN_IDEAS', 'ycdIdeas');
		self::addDefine('YCD_COUNTDOWN_TUTORIALS', 'ycdTutorials');
		self::addDefine('YCD_COUNTDOWN_NEWSLETTER', 'ycdNewsletter');
		self::addDefine('YCD_COUNTDOWN_SUBSCRIBERS', 'ycdSubscribers');
		self::addDefine('YCD_COUNTDOWN_LICENSE', 'ycdLicense');
		self::addDefine('YCD_POSTS_TABLE_NAME', 'posts');
		self::addDefine('YCD_COUNTDOWN_SUBSCRIBERS_TABLE', 'ycd_subscribers');
		self::addDefine('YCD_COUNTDOWN_WIDGET', 'ycd_countdown_widget');
		self::addDefine('YCD_COUNTDOWN_RESET_COOKIE_NAME', 'ycd-reset-duration-');
		self::addDefine('YCD_TEXT_DOMAIN', 'ycdCountdown');
		self::addDefine('YCD_STORE_URL', 'https://edmonsoft.com/countdown/');
		self::addDefine('YCD_PRO_KEY', 'ycdProVersion');
		self::addDefine('YCD_ADMIN_POST_NONCE', 'YCD_ADMIN_POST_NONCE');
		self::addDefine('YCD_COUNTDOWN_PRO_URL', 'https://edmonsoft.com/countdown');
		self::addDefine('YCD_COUNTDOWN_BUTTON_URL', 'https://edmonsoft.com/countdown/#yrm-analytics');
		self::addDefine('YCD_COUNTDOWN_REVIEW_URL', 'https://wordpress.org/support/plugin/countdown-builder/reviews/?filter=5');
		self::addDefine('YCD_PROGRESS_METABOX_KEY', 'ycdMetaboxProgress');
		self::addDefine('YCD_PROGRESS_METABOX_TITLE', __('Progress Bar', YCD_TEXT_DOMAIN));
		self::addDefine('YCD_COUNTDOWN_MENU_TITLE', 'Countdown & Clock');
		self::addDefine('YCD_COUNTDOWN_SUPPORT_URL', 'https://wordpress.org/support/plugin/countdown-builder/');
		self::addDefine('YCD_DEMO_URL', 'https://edmonsoft.com/demo/wp-admin/edit.php?post_type=ycdcountdown');
		self::addDefine('YCD_FILTER_REPEAT_INTERVAL', 50);
		self::addDefine('YCD_SHOW_REVIEW_PERIOD', 30);
		self::addDefine('YCD_PRODUCTS_LIMIT', 1000);
		self::addDefine('YCD_CRON_REPEAT_INTERVAL', 1);
		self::addDefine('YCD_AJAX_SUCCESS', 1);
		self::addDefine('YCD_TABLE_LIMIT', 15);
		self::addDefine('YCD_VERSION_PRO', 2.08);
		self::addDefine('YCD_VERSION', 2.22);
		self::addDefine('YCD_FREE_VERSION', 1);
		self::addDefine('YCD_SILVER_VERSION', 2);
		self::addDefine('YCD_GOLD_VERSION', 3);
		self::addDefine('YCD_PLATINUM_VERSION', 4);
		self::addDefine('YCD_EXTENSION_VERSION', 99);
		require_once(dirname(__FILE__).'/config-pkg.php');
		
		$versionText = '2.2.2';
		if (YCD_PKG_VERSION != YCD_FREE_VERSION) {
			$versionText = '2.0.8';
        }
		self::addDefine('YCD_VERSION_TEXT', $versionText);
		self::addDefine('YCD_LAST_UPDATE', 'Nov 14');
		self::addDefine('YCD_NEXT_UPDATE', 'Nov 25');
	}

	public static function displaySettings()
	{
		global $YCD_DISPLAY_SETTINGS_CONFIG;
		$keys = array(
			'select_settings' => 'Select settings',
			'everywhere' => 'Everywhere',
			'selected_post' => 'Select posts',
			'all_post' => 'All posts',
			'selected_page' => 'Select pages',
			'all_page' => 'All pages',
		);

		$keys = apply_filters('ycdConditionsDisplayKeys', $keys);
		
		$values = array(
			'key1' => $keys,
			'key2' => array('is' => 'Is', 'isnot' => 'Is not'),
			'selected_post' => array(),
			'all_post' => array(),
			'selected_page' => array(),
			'all_page' => array(),
			'everywhere' => array()
		);

		$attributes = array(
			'key1' => array(
				'label' => __('Select Conditions'),
				'fieldType' => 'select',
				'fieldAttributes' => array(
					'class' => 'ycd-condition-select js-ycd-select js-conditions-param',
					'value' => ''
				)
			),
			'key2' => array(
				'label' => __('Select Conditions'),
				'fieldType' => 'select',
				'fieldAttributes' => array(
					'class' => 'ycd-condition-select js-ycd-select',
					'value' => ''
				)
			),
			'selected_post' => array(
				'label' => __('Select Post(s)'),
				'fieldType' => 'select',
				'fieldAttributes' => array(
					'data-post-type' => 'post',
					'data-select-type' => 'ajax',
					'multiple' => 'multiple',
					'class' => 'ycd-condition-select js-ycd-select',
					'value' => ''
				)
			),
			'selected_page' => array(
				'label' => __('Select Page(s)'),
				'fieldType' => 'select',
				'fieldAttributes' => array(
					'data-post-type' => 'page',
					'data-select-type' => 'ajax',
					'multiple' => 'multiple',
					'class' => 'ycd-condition-select js-ycd-select',
					'value' => ''
				)
			),
		);

		$values = apply_filters('ycdConditionsDisplayValues', $values);
		$attributes = apply_filters('ycdConditionsDisplayAttributes', $attributes);

		$YCD_DISPLAY_SETTINGS_CONFIG = array(
			'keys' => $keys,
			'values' => $values,
			'attributes' => $attributes
		);
	}

	public static function getVersionString() {
		$version = 'YCD_VERSION='.YCD_VERSION;
		if(YCD_PKG_VERSION > YCD_FREE_VERSION) {
			$version = 'YCD_VERSION_PRO=' . YCD_VERSION_PRO.";";
		}

		return $version;
	}

	public static function headerScript() {
		$version = self::getVersionString();

		ob_start();
		?>
			<script type="text/javascript">
				<?= $version; ?>
			</script>
		<?php
		$content = ob_get_contents();
		ob_get_clean();

		return $content;
	}

    public static function extensions() {

        $extensions['analytics'] = array(
            'pluginKey' => 'countdown-builder-analytics/countdown-builder-analytics.php',
            'isType' => false,
            'shortKey' => 'analytics',
            'videoURL' => 'https://www.youtube.com/watch?v=58asfPjhMS8',
            'boxTitle' => __('Analytics')
        );

        $extensions['countdownButton'] = array(
            'pluginKey' => 'countdown-builder-call-to-action/countdownBuilderButton.php',
            'isType' => false,
            'shortKey' => 'countdownButton',
            'videoURL' => 'https://www.youtube.com/watch?v=WwBuEGIy8po',
            'boxTitle' => __('Countdown Button')
        );
        
        $extensions['circleTimer'] = array(
            'pluginKey' => 'countdown-builder-circle-timer/countdown-bilder-circle-timer.php',
            'isType' => true,
            'shortKey' => 'circleTimer',
            'videoURL' => 'https://www.youtube.com/watch?v=DZHUxHlSdcU&feature=youtu.be',
            'boxTitle' => __('Circle Timer')
        );

        return apply_filters('ycdExtensionsInfo', $extensions);
    }
}

YcdCountdownConfig::init();
