<?php
namespace ycd;

class CountdownInit {

	private static $instance = null;
	private $actions;
	private $filters;

	private function __construct() {
		$this->init();
	}

	private function __clone() {
	}

	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function init() {
		register_activation_hook(YCD_PREFIX, array($this, 'activate'));
		register_deactivation_hook(YCD_PREFIX, array($this, 'deactivate'));
		$this->includeData();
		$this->actions();
		$this->filters();
		add_action('admin_init', array($this, 'pluginRedirect'));
	}

	private function includeData() {
		if(YCD_PKG_VERSION > YCD_FREE_VERSION) {
			require_once YCD_HELPERS_PATH.'AdminHelperPro.php';
			require_once YCD_HELPERS_PATH.'CheckerPro.php';
			require_once YCD_BLOCKS_PATH.'ProgressBar.php';
			require_once(YCD_HELPERS_PATH.'ExtensionRegister.php');
		}
		require_once(YCD_HELPERS_PATH.'ShowReviewNotice.php');
		require_once YCD_HELPERS_PATH.'HelperFunctions.php';
		require_once YCD_HELPERS_PATH.'ScriptsIncluder.php';
		require_once YCD_HELPERS_PATH.'MultipleChoiceButton.php';
		require_once YCD_HELPERS_PATH.'TypesNavBar.php';
		require_once YCD_HELPERS_PATH.'AdminHelper.php';
		require_once YCD_CLASSES_PATH.'DisplayRuleChecker.php';
		require_once YCD_CLASSES_PATH.'ConditionBuilder.php';
		require_once YCD_CLASSES_PATH.'DisplayConditionBuilder.php';
		require_once YCD_CLASSES_PATH.'Tickbox.php';
		require_once YCD_CLASSES_PATH.'YcdWidget.php';
		require_once YCD_CLASSES_PATH.'CountdownType.php';
		require_once YCD_COUNTDOWNS_PATH.'CountdownModel.php';
        require_once YCD_CLASSES_PATH.'Checker.php';
		require_once YCD_COUNTDOWNS_PATH.'Countdown.php';
		require_once YCD_CSS_PATH.'Css.php';
		require_once YCD_JS_PATH.'Js.php';
		require_once YCD_CLASSES_PATH.'RegisterPostType.php';
        require_once YCD_CLASSES_PATH.'IncludeManager.php';
		require_once YCD_CLASSES_PATH.'Actions.php';
		require_once YCD_CLASSES_PATH.'Ajax.php';
		require_once YCD_CLASSES_PATH.'Filters.php';
		require_once YCD_CLASSES_PATH.'Installer.php';
		require_once YCD_COUNTDOWNS_PATH.'ComingSoon.php';
		if (YCD_PKG_VERSION > YCD_FREE_VERSION) {
			require_once YCD_CLASSES_PATH.'Updates.php';
			require_once YCD_CLASSES_PATH.'Subscription.php';
			require_once YCD_CLASSES_PATH.'AjaxPro.php';
			require_once YCD_CLASSES_PATH.'ActionsPro.php';
			require_once YCD_COMING_SOON_PATH.'CommingSoonProFilters.php';
			require_once YCD_CLASSES_PATH.'FiltersPro.php';
			require_once(YCD_HELPERS_PATH.'ExtensionRegister.php');
		}
	}

	public function actions() {
		$this->actions = new Actions();
	}

	public function filters() {
		$this->filters = new Filters();
	}

	public function activate() {
		
		if (YCD_PKG_VERSION > YCD_FREE_VERSION) {
			$pluginName = YCD_FILE_NAME;
			
			$options = array(
				'licence' => array(
					'key' => YCD_PRO_KEY,
					'storeURL' => YCD_STORE_URL,
					'file' => YCD_FILE_NAME,
					'itemId' => YCD_VERSION_ITEM_ID,
					'itemName' => __(YCD_COUNTDOWN_ITEM_LABEL, YCD_TEXT_DOMAIN),
					'author' => 'Adam',
					'boxLabel' => __('Countdown pro version license', YCD_TEXT_DOMAIN)
				)
			);
			ExtensionRegister::register($pluginName, $options);
		}
		Installer::install();
	}
	
	public function deactivate() {
		if (YCD_PKG_VERSION > YCD_FREE_VERSION) {
			$pluginName = YCD_FILE_NAME;
			ExtensionRegister::remove($pluginName);
		}
		
		delete_option('ycd_redirect');
	}
	
	public function pluginRedirect() {
		if (!get_option('ycd_redirect') && post_type_exists(YCD_COUNTDOWN_POST_TYPE)) {
			update_option('ycd_redirect', 1);
			exit(wp_redirect(admin_url('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE)));
		}
	}
}

CountdownInit::getInstance();