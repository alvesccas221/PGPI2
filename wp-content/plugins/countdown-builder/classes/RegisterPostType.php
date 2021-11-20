<?php
namespace ycd;
use \YcdCountdownOptionsConfig;

class RegisterPostType {

	private $typeObj;
	private $type;
	private $id;

	public function __construct() {
		if (!AdminHelper::showMenuForCurrentUser()) {
			return false;
		}
		$this->init();
		
		return true;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return (int)$this->id;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function setTypeObj($typeObj) {
		$this->typeObj = $typeObj;
	}

	public function getTypeObj() {
		return $this->typeObj;
	}

	public function init() {

		if (!empty($_GET['post_type']) && $_GET['post_type'] == YCD_COUNTDOWN_POST_TYPE) {
			wp_deregister_script('autosave');
		}
		
		$postType = YCD_COUNTDOWN_POST_TYPE;
		add_filter('ycdPostTypeSupport', array($this, 'postTypeSupports'), 10, 1);
		$args = $this->getPostTypeArgs();

		register_post_type($postType, $args);

		if(@$_GET['post_type'] || get_post_type(@$_GET['post']) == YCD_COUNTDOWN_POST_TYPE) {
			$this->createCdObjFromCdType();
		}
		YcdCountdownOptionsConfig::optionsValues();
	}

	public function postTypeSupports($supports) {

		$id = $this->getId();
		$type = $this->getTypeName();
		$typePath = Countdown::getTypePathFormCountdownType($type);
		$className = Countdown::getClassNameCountdownType($type);

		if (!file_exists($typePath.$className.'.php')) {
			return $supports;
		}
		require_once($typePath.$className.'.php');
		$className = __NAMESPACE__.'\\'.$className;
		if (!class_exists($className)) {
			return $supports;
		}

		if (method_exists($className, 'getTypeSupports')) {
			$supports = $className::getTypeSupports();
		}

		return $supports;
	}

	private function createCdObjFromCdType() {
		$id = 0;

		if (!empty($_GET['post'])) {
			$id = (int)$_GET['post'];
		}

		$type = $this->getTypeName();
		$this->setType($type);
		$this->setId($id);

		$this->createCdObj();
	}

	public function createCdObj()
	{
		$id = $this->getId();
		$type = $this->getType();
		$typePath = Countdown::getTypePathFormCountdownType($type);
		$className = Countdown::getClassNameCountdownType($type);

		if (!file_exists($typePath.$className.'.php')) {
			wp_die(__($className.' class does not exist', YCD_TEXT_DOMAIN));
		}
		require_once($typePath.$className.'.php');
		$className = __NAMESPACE__.'\\'.$className;
		if (!class_exists($className)) {
			wp_die(__($className.' class does not exist', YCD_TEXT_DOMAIN));
		}
		$typeObj = new $className();
		$typeObj->setId($id);
		$typeObj->setType($type);
		$this->setTypeObj($typeObj);
	}

	private function getTypeName() {
		$type = 'circle';

		/*
		 * First, we try to find the countdown type with the post id then,
		 * if the post id doesn't exist, we try to find it with $_GET['ycd_type']
		 */
		if (!empty($_GET['post'])) {
			$id = (int)$_GET['post'];
			$cdOptionsData = Countdown::getPostSavedData($id);
			if (!empty($cdOptionsData['ycd-type'])) {
				$type = $cdOptionsData['ycd-type'];
			}
		}
		else if (!empty($_GET['ycd_type'])) {
			$type = $_GET['ycd_type'];
		}

		return $type;
	}

	public function getPostTypeArgs()
	{
		$labels = $this->getPostTypeLabels();

		$args = array(
			'labels'             => $labels,
			'description'        => __('Description.', 'your-plugin-textdomain'),
			//Exclude_from_search
			'public'             => true,
			'has_archive'        => true,
			//Where to show the post type in the admin menu
			'show_ui'            => true,
			'query_var'          => false,
			// post preview button
			'publicly_queryable' => false,
			'map_meta_cap'       => true,
			'capability_type'    => array('ycd_countdown', 'ycd_countdowns'),
			'menu_position'      => 10,
			'supports'           => apply_filters('ycdPostTypeSupport', array('title')),
			'menu_icon'          => 'dashicons-clock'
		);

		return $args;
	}

	public function getPostTypeLabels()
	{
		$labels = array(
			'name'               => _x(YCD_COUNTDOWN_MENU_TITLE, 'post type general name', YCD_TEXT_DOMAIN),
			'singular_name'      => _x(YCD_COUNTDOWN_MENU_TITLE, 'post type singular name', YCD_TEXT_DOMAIN),
			'menu_name'          => _x(YCD_COUNTDOWN_MENU_TITLE, 'admin menu', YCD_TEXT_DOMAIN),
			'name_admin_bar'     => _x('Countdown', 'add new on admin bar', YCD_TEXT_DOMAIN),
			'add_new'            => _x('Add New', 'Countdown', YCD_TEXT_DOMAIN),
			'add_new_item'       => __('Add New Countdown', YCD_TEXT_DOMAIN),
			'new_item'           => __('New Countdown', YCD_TEXT_DOMAIN),
			'edit_item'          => __('Edit Countdown', YCD_TEXT_DOMAIN),
			'view_item'          => __('View Countdown', YCD_TEXT_DOMAIN),
			'all_items'          => __('All '.YCD_COUNTDOWN_MENU_TITLE, YCD_TEXT_DOMAIN),
			'search_items'       => __('Search '.YCD_COUNTDOWN_MENU_TITLE, YCD_TEXT_DOMAIN),
			'parent_item_colon'  => __('Parent '.YCD_COUNTDOWN_MENU_TITLE.':', YCD_TEXT_DOMAIN),
			'not_found'          => __('No '.YCD_COUNTDOWN_MENU_TITLE.' found.', YCD_TEXT_DOMAIN),
			'not_found_in_trash' => __('No '.YCD_COUNTDOWN_MENU_TITLE.' found in Trash.', YCD_TEXT_DOMAIN)
		);

		return $labels;
	}

	public function addSubMenu() {
		$menuLabel = '';
		if (YCD_PKG_VERSION == YCD_FREE_VERSION) {
			$menuLabel = '<span style="color: red;"> '.__('Pro', YCD_TEXT_DOMAIN).'</span>';
		}
		add_submenu_page(
			'edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE,
			__('Countdown Types', YCD_TEXT_DOMAIN), // page title
			__('Countdown Types', YCD_TEXT_DOMAIN), // menu title
			'ycd_manage_options', 
			YCD_COUNTDOWN_POST_TYPE,
			array($this, 'countdownTypes')
		);
		add_submenu_page('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE, __('Newsletter', YCD_TEXT_DOMAIN), __('Newsletter', YCD_TEXT_DOMAIN).$menuLabel, 'ycd_manage_options', YCD_COUNTDOWN_NEWSLETTER, array($this, 'countdownNewsletter'));
		add_submenu_page('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE, __('Coming Soon', YCD_TEXT_DOMAIN), __('Coming Soon', YCD_TEXT_DOMAIN), 'ycd_manage_options', YCD_COUNTDOWN_COMING_SOON, array($this, 'comingSoon'));
		add_submenu_page('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE, __('Support', YCD_TEXT_DOMAIN), __('Support', YCD_TEXT_DOMAIN), 'ycd_manage_options', YCD_COUNTDOWN_SUPPORT, array($this, 'countdownSupport'));
		add_submenu_page('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE, __('Tutorials', YCD_TEXT_DOMAIN), __('Tutorials', YCD_TEXT_DOMAIN), 'ycd_manage_options', YCD_COUNTDOWN_TUTORIALS, array($this, 'countdownTutorials'));
		add_submenu_page('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE, __('More Ideas?', YCD_TEXT_DOMAIN), __('More Ideas?', YCD_TEXT_DOMAIN), 'ycd_manage_options', YCD_COUNTDOWN_IDEAS, array($this, 'countdownIdeas'));
		add_submenu_page('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE, __('Subscribers', YCD_TEXT_DOMAIN), __('Subscribers', YCD_TEXT_DOMAIN).$menuLabel, 'ycd_manage_options', YCD_COUNTDOWN_SUBSCRIBERS, array($this, 'countdownSubscribers'));
		add_submenu_page('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE, __('More Plugins', YCD_TEXT_DOMAIN), __('More Plugins', YCD_TEXT_DOMAIN), 'manage_options', YCD_COUNTDOWN_MORE_PLUGINS, array($this, 'morePlugins'));
		add_submenu_page('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE, __('Settings', YCD_TEXT_DOMAIN), __('Settings', YCD_TEXT_DOMAIN), 'manage_options', YCD_COUNTDOWN_SETTINGS, array($this, 'countdownSettings'));
	}

	public function countdownNewsletter() {
		if (YCD_PKG_VERSION == YCD_FREE_VERSION) {
			wp_redirect(YCD_COUNTDOWN_PRO_URL);
		}
		else {
			require_once YCD_VIEWS_PATH.'newsletter.php';
		}
	}
	
	public function comingSoon() {
		$comingSoonObj = new ComingSoon();
		$comingSoonObj->adminView();
	}
	
	public function countdownSupport() {
		require_once YCD_VIEWS_PATH.'support.php';
	}

	public function countdownIdeas() {

	}

	public function countdownTutorials() {
		require_once YCD_ADMIN_VIEWS_PATH.'tutorials.php';
	}

	public function morePlugins() {
		require_once YCD_VIEWS_PATH.'morePlugins.php';
	}

	public function countdownSubscribers() {
		require_once YCD_VIEWS_PATH.'subscribers.php';
	}

	public function countdownTypes() {
		require_once YCD_VIEWS_PATH.'types.php';
	}

	public function countdownSettings() {
		require_once YCD_VIEWS_PATH.'settings.php';
	}
}