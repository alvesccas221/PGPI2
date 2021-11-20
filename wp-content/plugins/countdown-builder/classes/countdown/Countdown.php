<?php
namespace ycd;
use \YcdCountdownOptionsConfig;
use \DateTime;
use \DateTimeZone;

abstract class Countdown {

	private $id;
	private $type;
	private $title;
	private $savedData;
	private $sanitizedData;
	private $shortCodeArgs;
	private $shortCodeContent;
	private $isCountdown = true;
	
	public function __construct() {
		$savedData = CountdownModel::getDataById($this->getId());
		$this->setSavedData($savedData);
	}
	
	//expire seconds
	public $expireSeconds = 0;

	abstract protected function getViewContent();

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		$id = (int)$this->id;
		
		if (empty($id) && !empty($_GET['post'])) {
			$id = (int)$_GET['post'];
		}
		return $id;
	}
	
	public function setIsCountdown($isCountdown) {
		$this->isCountdown = $isCountdown;
	}

	public function getIsCountdown() {
		return (bool)$this->isCountdown;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}
	
	public function getTypeTitle() {
		$type = $this->getType();
		global $YCD_TYPES;
		$titles = $YCD_TYPES['titles'];
		
		$typeTitle = (isset($titles[$type])) ? $titles[$type] : __('Unknown Type', YCD_TEXT_DOMAIN);
		
		return $typeTitle;
	}

	public function allowToShowExpiration() {
		$status = true;
		$countdownDateType = $this->getOptionValue('ycd-countdown-date-type');

		if(!empty($countdownDateType) && $countdownDateType == 'duration') {
			return false;
		}

		return $status;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setShortCodeContent($shortCodeContent) {
		$this->shortCodeContent = $shortCodeContent;
	}

	public function getShortCodeContent() {
		return $this->shortCodeContent;
	}

	public function setShortCodeArgs($shortCodeArgs) {
		$this->shortCodeArgs = $shortCodeArgs;
	}

	public function getShortCodeArgs() {
		return $this->shortCodeArgs;
	}

	public function setSavedData($savedData) {
		$this->savedData = $savedData;
	}

	public function getSavedData() {
		return $this->savedData;
	}

	public function setExpireSeconds($expireSeconds) {
		$this->expireSeconds = $expireSeconds;
	}

	public function getExpireSeconds() {
		return $this->expireSeconds;
	}

	public function insertIntoSanitizedData($sanitizedData) {
		if (!empty($sanitizedData)) {
			$this->sanitizedData[$sanitizedData['name']] = $sanitizedData['value'];
		}
	}

	public function getSanitizedData() {
		return $this->sanitizedData;
	}
	
	public function setSanitizedData($sanitizedData) {
		$this->sanitizedData = $sanitizedData;
	}
	
	public function getMetaBoxes()
	{
		$metaboxes = $this->defaultMainMetaboxes();
		
		return apply_filters('ycdGeneralMetaboxes', $metaboxes);
	}
	
	public function includeGeneralScripts() {
		$isAdmin = is_admin();
		ScriptsIncluder::registerScript('YcdGeneral.js', array('dirUrl' => YCD_COUNTDOWN_JS_URL));
		ScriptsIncluder::localizeScript('YcdGeneral.js', 'YCD_GENERAL_ARGS', array('YCD_COUNTDOWN_RESET_COOKIE_NAME' => YCD_COUNTDOWN_RESET_COOKIE_NAME, 'isAdmin' => $isAdmin));
		ScriptsIncluder::enqueueScript('YcdGeneral.js');
		ScriptsIncluder::registerScript('moment.js', array('dirUrl' => YCD_COUNTDOWN_JS_URL));
		ScriptsIncluder::enqueueScript('moment.js');
	}

	public static function create($data = array()) {
		$obj = new static();
		$id = $data['ycd-post-id'];
		$obj->setId($id);

		// set up apply filter
		YcdCountdownOptionsConfig::optionsValues();
		foreach ($data as $name => $value) {
			$defaultData = $obj->getDefaultDataByName($name);
			if (empty($defaultData['type'])) {
				$defaultData['type'] = 'string';
			}
			$obj->saveConditionSettings($data);
			$sanitizedValue = $obj->sanitizeValueByType($value, $defaultData['type']);
			$obj->insertIntoSanitizedData(array('name' => $name,'value' => $sanitizedValue));
		}

		$result = $obj->save();
	}

	private function saveConditionSettings($data) {
		if(empty($data['ycd-display-settings'])) {
			return '';
		}

		$postId = $this->getId();
		$settings = $data['ycd-display-settings'];

		$obj = new DisplayConditionBuilder();
		$obj->setSavedData($settings);
		$settings = $obj->filterForSave();

		update_post_meta($postId, 'ycd-display-settings', $settings);
	}
	
	private function filterSavedData($options) {
		if (!empty($options['ycd-countdown-date-type']) && $options['ycd-countdown-date-type'] == 'duration') {
			if (!empty($options['ycd-countdown-save-duration'])) {
				
				$days = $options['ycd-countdown-duration-days'];
				$hours = (int)$options['ycd-countdown-duration-hours'];
				$minutes = (int)$options['ycd-countdown-duration-minutes'];
				$secondsSaved = (int)$options['ycd-countdown-duration-seconds'];
				
				$seconds = $days*86400 + $hours*60*60 + $minutes*60 + $secondsSaved;
				
				$options['ycd-countdown-duration-saved-str-time'] = strtotime('+'.$seconds.' seconds');
			}
		}
		
		return $options;
	}

	public function save() {
		$options = $this->getSanitizedData();
		$options = $this->filterSavedData($options);
		$postId = $this->getId();

		update_post_meta($postId, 'ycd_options', $options);
	}

	public function sanitizeValueByType($value, $type) {
		switch ($type) {
			case 'string':
			case 'number':
				$sanitizedValue = sanitize_text_field($value);
				break;
			case 'html':
				$sanitizedValue = $value;
				break;
			case 'array':
				$sanitizedValue = $this->recursiveSanitizeTextField($value);
				break;
			case 'email':
				$sanitizedValue = sanitize_email($value);
				break;
			case "checkbox":
				$sanitizedValue = sanitize_text_field($value);
				break;
			default:
				$sanitizedValue = sanitize_text_field($value);
				break;
		}

		return $sanitizedValue;
	}

	public function recursiveSanitizeTextField($array) {
		if (!is_array($array)) {
			return $array;
		}

		foreach ($array as $key => &$value) {
			if (is_array($value)) {
				$value = $this->recursiveSanitizeTextField($value);
			}
			else {
				/*get simple field type and do sensitization*/
				$defaultData = $this->getDefaultDataByName($key);
				if (empty($defaultData['type'])) {
					$defaultData['type'] = 'string';
				}
				$value = $this->sanitizeValueByType($value, $defaultData['type']);
			}
		}

		return $array;
	}

	public function getDefaultDataByName($optionName) {
		global $YCD_OPTIONS;

		if(empty($YCD_OPTIONS)) {
			return array();
		}
		foreach ($YCD_OPTIONS as $option) {
			if ($option['name'] == $optionName) {
				return $option;
			}
		}

		return array();
	}

	public function getDefaultValue($optionName) {

		if (empty($optionName)) {
			return '';
		}

		$defaultData = $this->getDefaultDataByName($optionName);

		if (empty($defaultData['defaultValue'])) {
			return '';
		}

		return $defaultData['defaultValue'];
	}

	public function isAllowOption($optionName) {
		if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
			return true;
		}
		$defaultData = $this->getDefaultDataByName($optionName);

		if(empty($defaultData['available'])) {
			return true;
		}

		return YCD_PKG_VERSION >= $defaultData['available'];
	}

	public static function parseCountdownDataFromData($data) {
		$cdData = array();

		if (empty($data)) {
			return $cdData;
		}

		foreach ($data as $key => $value) {
			if (strpos($key, 'ycd') === 0) {
				$cdData[$key] = $value;
			}
		}

		return $cdData;
	}

	public static function getClassNameCountdownType($type) {
		$typeName = ucfirst(strtolower($type));
		$className = $typeName.'Countdown';

		return $className;
	}

	public static function getTypePathFormCountdownType($type) {
		global $YCD_TYPES;
		$typePath = '';

		if (!empty($YCD_TYPES['typePath'][$type])) {
			$typePath = $YCD_TYPES['typePath'][$type];
		}

		return $typePath;
	}

	/**
	 * Get option value from name
	 * @since 1.0.0
	 *
	 * @param string $optionName
	 * @param bool $forceDefaultValue
	 * @return string
	 */
	public function getOptionValue($optionName, $forceDefaultValue = false) {
	
		return $this->getOptionValueFromSavedData($optionName, $forceDefaultValue);
	}

	public function getOptionValueFromSavedData($optionName, $forceDefaultValue = false) {
		
		$defaultData = $this->getDefaultDataByName($optionName);
		$savedData = $this->getSavedData();

		$optionValue = null;

		if (empty($defaultData['type'])) {
			$defaultData['type'] = 'string';
		}

		if (!empty($savedData)) { //edit mode
			if (isset($savedData[$optionName])) { //option exists in the database
				$optionValue = $savedData[$optionName];
			}
			/* if it's a checkbox, it may not exist in the db
			 * if we don't care about it's existence, return empty string
			 * otherwise, go for it's default value
			 */
			else if ($defaultData['type'] == 'checkbox' && !$forceDefaultValue) {
				$optionValue = '';
			}
		}

		if (($optionValue === null && !empty($defaultData['defaultValue'])) || ($defaultData['type'] == 'number' && !isset($optionValue))) {
			$optionValue = $defaultData['defaultValue'];
		}

		if ($defaultData['type'] == 'checkbox') {
			$optionValue = $this->boolToChecked($optionValue);
		}

		if(isset($defaultData['ver']) && $defaultData['ver'] > YCD_PKG_VERSION) {
			if (empty($defaultData['allow'])) {
				return $defaultData['defaultValue'];
			}
			else if (!in_array($optionValue, $defaultData['allow'])) {
				return $defaultData['defaultValue'];
			}
		}

		return $optionValue;
	}

	public static function getPostSavedData($postId) {
		$savedData = get_post_meta($postId, 'ycd_options');

		if (empty($savedData)) {
			return $savedData;
		}
		$savedData = $savedData[0];
		$displaySettings = self::getDisplaySettings($postId);
		if(!empty($displaySettings)) {
			$savedData['ycd-display-settings'] = $displaySettings;
		}

		return $savedData;
	}

	public static function getDisplaySettings($postId) {
		$savedData = get_post_meta($postId, 'ycd-display-settings', true);

		return $savedData;
	}

	/**
	 * Returns separate countdown types Free or Pro
	 *
	 * @since 1.0.0
	 *
	 * @return array $countdownType
	 */
	public static function getCountdownTypes()
	{
		global $YCD_TYPES;
		$countdownTypesObj = array();
		$countdownTypes = $YCD_TYPES['typeName'];
		$groups = $YCD_TYPES['typeGroupName'];

		foreach($countdownTypes as $type => $level) {
			if(empty($level)) {
				$level = YCD_FREE_VERSION;
			}
			
			$isAvailable = false;
			$typeObj = new CountdownType();
			
			if ($level == 'comingSoon') {
				$level = YCD_EXTENSION_VERSION;
				$typeObj->setIsComingSoon(1);
			}
			
			$typeObj->setName($type);
			$typeObj->setAccessLevel($level);

			if (!empty($groups[$type])) {
				$typeObj->setGroup($groups[$type]);
			}

			if(YCD_PKG_VERSION >= $level) {
				$isAvailable = true;
			}
			$isAvailable = apply_filters('ycd'.$type.'ExtensionAvailable', $isAvailable);
			$typeObj->setAvailable($isAvailable);
			$countdownTypesObj[] = $typeObj;
		}

		return $countdownTypesObj;
	}

	public static function find($id) {
		$options = CountdownModel::getDataById($id);

		if(empty($options)) {
			return false;
		}
		$type = $options['ycd-type'];

		$typePath = self::getTypePathFormCountdownType($type);
		$className = self::getClassNameCountdownType($type);

		if (!file_exists($typePath.$className.'.php')) {
			return false;
		}

		require_once($typePath.$className.'.php');
		$className = __NAMESPACE__.'\\'.$className;
		$postTitle = get_the_title($id);

		$typeObj = new $className();
		$typeObj->setId($id);
		$typeObj->setType($type);
		$typeObj->setTitle($postTitle);
		$typeObj->setSavedData($options);

		return $typeObj;
	}
	
	public function defaultMainMetaboxes() {
		$metaboxes = array();
	
		$metaboxes['advancedOptions'] = array('title' => 'Advanced Options', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['generalOptions'] = array('title' => 'General Options', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['subscription'] = array('title' => 'Subscription Section', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['afterCountdownExpire'] = array('title' => 'After Expire', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['countdownButton'] = array('title' => 'Countdown Button Extension', 'position' => 'normal', 'prioritet' => 'high', 'defaultActionView' => array($this, 'countdownButton'));

		return $metaboxes;
	}
	
	public function mainOptions() {
		$proLabel = '';
		
		if (YCD_PKG_VERSION == YCD_FREE_VERSION) {
			$proLabel = '<span class="ycd-pro-span"><b>'.__('pro', YCD_TEXT_DOMAIN).'</b></span>';
		}
		$metaboxes = $this->getMetaBoxes();
		$typeMetaboxObj = $this;
		foreach ($metaboxes as $key => $metabox) {
			$defaultActionView = array($this, $key);
			if (!empty($metabox['defaultActionView'])) {
				$defaultActionView = $metabox['defaultActionView'];
			}
			add_meta_box($key, __($metabox['title'], YCD_TEXT_DOMAIN), $defaultActionView, YCD_COUNTDOWN_POST_TYPE, $metabox['position'], $metabox['prioritet'], array('typeObj' => $this));
		}
	}

	public function countdownButton() {
		$typeObj = $this;
		require_once YCD_VIEWS_PATH.'countdownButton.php';
	}

	public function afterCountdownExpire() {
		require_once YCD_VIEWS_PATH.'afterExpire.php';
	}
	
	public function advancedOptions() {
		require_once YCD_VIEWS_PATH.'advancedOptions.php';
	}

	public function generalOptions() {
		require_once YCD_VIEWS_PATH.'generalOptions.php';
	}

	public function subscription() {
		require_once YCD_VIEWS_PATH.'subscriptionSection.php';
	}

	public function ycdMetaboxProgress() {
		require_once YCD_VIEWS_PATH.'progressBar.php';
	}

	public static function isActivePost($postId) {
		$enabled = !get_post_meta($postId, 'ycd_enable', true);
		$postStatus = get_post_status($postId);

		return ($enabled && $postStatus == 'publish');
	}

	public function boolToChecked($var) {
		return ($var ? 'checked' : '');
	}

	public static function getCountdownsObj($agrs = array()) {
		$postStatus = array('publish');
		$countdowns = array();

		if (!empty($agrs['postStatus'])) {
			$postStatus = $agrs['postStatus'];
		}

		$posts = get_posts(array(
			'post_type' => YCD_COUNTDOWN_POST_TYPE,
			'post_status' => $postStatus,
			'numberposts' => -1
			// 'order'	=> 'ASC'
		));

		if(empty($posts)) {
			return $countdowns;
		}

		foreach ($posts as $post) {
			$countdownObj = self::find($post->ID);

			if(empty($countdownObj)) {
				continue;
			}
			$countdowns[] = $countdownObj;
		}

		return $countdowns;
	}

	public static function shapeIdTitleData($contdowns = false) {

		if (empty($contdowns)) {
			$contdowns = self::getCountdownsObj();
		}
		$idTitle = array();

		if(empty($contdowns)) {
			return $idTitle;
		}

		foreach ($contdowns as $countdown) {
			$title = $countdown->getTitle();
			$id = $countdown->getId();
			$isActive = Countdown::isActivePost($id);

			if(!$isActive) {
				continue;
			}
			if(empty($title)) {
				$title = __('(no title)', YCD_TEXT_DOMAIN);
			}

			$idTitle[$id] = $title .' - '. $countdown->getTypeTitle();
		}

		return $idTitle;
	}
	
	public function getDataAllOptions() {
		$options = array();
		
		$options['ycd-countdown-expire-behavior'] = $this->getOptionValue('ycd-countdown-expire-behavior');
		$options['ycd-expire-text'] = $this->getOptionValue('ycd-expire-text');
		$options['ycd-expire-url'] = $this->getOptionValue('ycd-expire-url');
		$options['ycd-countdown-end-sound'] = $this->getOptionValue('ycd-countdown-end-sound');
		$options['ycd-countdown-end-sound-url'] = $this->getOptionValue('ycd-countdown-end-sound-url');
		
		return apply_filters('ycdGeneralDataAllOptions', $options, $this);
	}

	public function renderSubscriptionForm() {
		if (!$this->getOptionValue('ycd-enable-subscribe-form')) {
			return '';
		}
		$args = array(
			'width' => $this->getOptionValue('ycd-subscribe-width')	,
			'aboveText' => $this->getOptionValue('ycd-form-above-text'),
			'inputText' => $this->getOptionValue('ycd-form-input-text'),
			'submitText' => $this->getOptionValue('ycd-form-submit-text'),
			'submitButtonColor' => $this->getOptionValue('ycd-form-submit-color'),
			'successMessage' => $this->getOptionValue('ycd-subscribe-success-message'),
			'emailMessage' => $this->getOptionValue('ycd-subscribe-error-message'),
			'id' => $this->getId()
		);

		$subscription = new Subscription();
		$subscription->setOptions($args);

		return $subscription->render();
	}

	public function renderProgressBar() {
		if(!$this->getOptionValue('ycd-countdown-enable-progress')) {
			return '';
		}
		$allSecondsArgs = array(
			'dateType' => $this->getOptionValue('ycd-countdown-date-type'),
			'timePicker' => $this->getOptionValue('ycd-date-time-picker'),
			'timeZone' => $this->getOptionValue('ycd-circle-time-zone'),
			'durationHours' => (int)$this->getOptionValue('ycd-countdown-duration-hours'),
			'minutes' => (int)$this->getOptionValue('ycd-countdown-duration-minutes'),
			'secondsSaved' => (int)$this->getOptionValue('ycd-countdown-duration-seconds')
		);
		$currentSeconds = $this->gettProgressAllSeconds();
		$allSeconds =  $this->getProgressCurrentSeconds();

		$args = array(
			'id' => $this->getId(),
			'allSeconds' => $allSeconds,
			'currentSeconds' => $currentSeconds,
			'width' => $this->getOptionValue('ycd-progress-width'),
			'height' => $this->getOptionValue('ycd-progress-height'),
			'type' => $this->getOptionValue('ycd-countdown-date-type'),
			'mainColor' => $this->getOptionValue('ycd-progress-main-color'),
			'progressColor' => $this->getOptionValue('ycd-progress-color'),
			'textColor' => $this->getOptionValue('ycd-progress-text-color')
		);
	
		return Countdown::renderProgress($args);
	}

	public static function renderProgress($args = array()) {
		$progressBar = new ProgressBar();
		$progressBar->setOptions($args);

		return $progressBar;
	}

	private function gettProgressAllSeconds($args = array()) {
		$seconds = 0;
		$filteredObj = $this;
		$countdownType = $this->getType();
		$dateType = $this->getOptionValue('ycd-countdown-date-type');
		$timePicker = $this->getOptionValue('ycd-date-time-picker');
		$timeZone = $this->getOptionValue('ycd-circle-time-zone');
		$durationHours = (int)$this->getOptionValue('ycd-countdown-duration-hours');
		$minutes = (int)$this->getOptionValue('ycd-countdown-duration-minutes');
		$secondsSaved = (int)$this->getOptionValue('ycd-countdown-duration-seconds');

		$dateType = $dateType;

		if($dateType == 'dueDate') {
			$dueDate = $timePicker;
			$timezone = $timeZone;
			$dueDate .= ':00';
			$timeDate = new DateTime('now', new DateTimeZone($timezone));
			$timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));
			$seconds = strtotime($dueDate)-$timeNow;
		}
		else if($dateType == 'schedule') {
			$filteredObj = apply_filters('ycdScheduleExpireSecond', $this);
			$seconds = $this->getExpireSeconds();
		}
		else {
			$hours = $durationHours;
			$minutes = $minutes;
			$secondsSaved = $secondsSaved;

			$seconds = $hours*60*60 + $minutes*60 + $secondsSaved;
		}

		if($countdownType == 'timer') {
			$hours = $this->getOptionValue('ycd-timer-hours');
			$minutes = $this->getOptionValue('ycd-timer-minutes');
			$secondsSaved = $this->getOptionValue('ycd-timer-seconds');

			$seconds = $hours*60*60 + $minutes*60 + $secondsSaved;
		}
		
		return $seconds;
	}

	private function getProgressCurrentSeconds() {
		$seconds = 0;
		$countdownType = $this->getType();
		$filteredObj = $this;
		$dateType = $this->getOptionValue('ycd-countdown-date-type');
		$startDate = $this->getOptionValue('ycd-date-progress-start-date');
		$timePicker = $this->getOptionValue('ycd-date-time-picker');
		$timezone = $this->getOptionValue('ycd-circle-time-zone');
		$durationHours = (int)$this->getOptionValue('ycd-countdown-duration-hours');
		$minutes = (int)$this->getOptionValue('ycd-countdown-duration-minutes');
		$secondsSaved = (int)$this->getOptionValue('ycd-countdown-duration-seconds');

		$dateType = $dateType;

		if($dateType == 'dueDate') {
			$dueDate = $startDate;
			$endDate = $timePicker;
			$timezone = $timezone;
			$dueDate .= ':00';
			$timeDate = new DateTime('now', new DateTimeZone($timezone));
			$timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));
			$seconds = strtotime($endDate)-strtotime($dueDate);
		}
		else if($dateType == 'schedule') {
			 $filteredObj = apply_filters('ycdScheduleAllSeconds', $this);
			 $seconds = $this->getExpireSeconds();
		}
		else {
			$hours = $durationHours;
			$minutes = $minutes;
			$secondsSaved = $secondsSaved;

			$seconds = $hours*60*60 + $minutes*60 + $secondsSaved;
		}

		if($countdownType == 'timer') {
			$days = $this->getOptionValue('ycd-countdown-duration-days');
			$hours = $this->getOptionValue('ycd-timer-hours');
			$minutes = $this->getOptionValue('ycd-timer-minutes');
			$secondsSaved = $this->getOptionValue('ycd-timer-seconds');

			$seconds = $days*86400 + $hours*60*60 + $minutes*60 + $secondsSaved;
		}

		return $seconds;
	}
	
	/**
	 * Changing default options form changing options by name
	 *
	 * @since 1.0.0
	 *
	 * @param array $defaultOptions
	 * @param array $changingOptions
	 *
	 * @return array $defaultOptions
	 */
	public function changeDefaultOptionsByNames($defaultOptions, $changingOptions)
	{
		if (empty($defaultOptions) || empty($changingOptions)) {
			return $defaultOptions;
		}
		$changingOptionsNames = array_keys($changingOptions);
		
		foreach ($defaultOptions as $key => $defaultOption) {
			$defaultOptionName = $defaultOption['name'];
			if (in_array($defaultOptionName, $changingOptionsNames)) {
				$defaultOptions[$key] = $changingOptions[$defaultOptionName];
			}
		}
		
		return $defaultOptions;
	}

	public function getCurrentTypeFromOptions() {
		$type = $this->getOptionValue('ycd-type');
		if(!empty($_GET['ycd_type'])) {
			$type = $_GET['ycd_type'];
		}

		return $type;
	}
	
	public function isExpired() {
		$obj = $this->getCircleSeconds();
		$seconds = $obj->expireSeconds;
	
		return ($seconds <= 0);
	}

	public function getExpireDate() {
		$dateType = $this->getOptionValue('ycd-countdown-date-type');

		$timezone = $this->getOptionValue('ycd-circle-time-zone');
		$current = new DateTime('now');
		if ($timezone) {
			$current = new DateTime('now', new \DateTimeZone($timezone));
		}
		$currentDate = $current->format('Y-m-d H:i:s');
		
		$obj = $this->getCircleSeconds();
		$seconds = $obj->expireSeconds;
		$date = strtotime("+$seconds seconds", strtotime($currentDate));
		
		$dateString = human_time_diff($date, strtotime($currentDate));

		return $dateString;
	}
	
	public static function allowToLoad($contdownPost, $countdownObj) {
		$isAllow = Checker::isAllow($contdownPost, $countdownObj);

		return $isAllow;
	}
	
	public function getSecondsFromObj() {
		$secondsObj = $this->getCircleSeconds();
		$seconds = $secondsObj->expireSeconds;
	
		return $seconds;
	}

	public function getCircleSeconds() {
		$seconds = 0;
		$filteredObj = $this;
		$dateType = $this->getOptionValue('ycd-countdown-date-type');

		if($dateType == 'dueDate') {
			$dueDate = $this->getOptionValue('ycd-date-time-picker');
			$timezone = $this->getOptionValue('ycd-circle-time-zone');
			$dueDate .= ':00';
			$timeDate = new DateTime('now');
			if ($timezone) {
				$timeDate = new DateTime('now', new DateTimeZone($timezone));
			}
			$timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));
			$seconds = strtotime($dueDate)-$timeNow;
		}
		else if($dateType == 'schedule') {
			$filteredObj = apply_filters('ycdScheduleExpireSecond', $this);
			$seconds = $this->getExpireSeconds();
		}
		else if($dateType == 'schedule2') {
			$filteredObj = apply_filters('ycdSchedule2ExpireSecond', $this);
			$seconds = $this->getExpireSeconds();
		}
		else {
			$days = $this->getOptionValue('ycd-countdown-duration-days');
			$hours = (int)$this->getOptionValue('ycd-countdown-duration-hours');
			$minutes = (int)$this->getOptionValue('ycd-countdown-duration-minutes');
			$secondsSaved = (int)$this->getOptionValue('ycd-countdown-duration-seconds');

			$seconds = $days*86400 + $hours*60*60 + $minutes*60 + $secondsSaved;
		}
		$filteredObj->expireSeconds = $seconds;

		return $filteredObj;
	}

	public function allowOpen() {
		$id = $this->getId();
		$status = true;

		if(!empty($_COOKIE['YcdDontShow'.$id]) && $this->getOptionValue('ycd-countdown-showing-limitation')) {
			$status = false;
		}

		return $status;
	}

	protected function scheduleOptions(&$options) {
		$modifiedObj = $this->getCircleSeconds();
		$modifiedSavedData = $modifiedObj->datesNumber;
		
		$options['startDay'] = $this->getOptionValue('ycd-schedule-start-day');
		$options['startDayNumber'] = $modifiedSavedData['startDayNumber'];
		$options['endDay'] = $this->getOptionValue('ycd-schedule-end-day');
		$options['endDayNumber'] = $modifiedSavedData['endDayNumber'];
		$options['currentDayNumber'] = $modifiedSavedData['currentDayNumber'];
		$options['ycd-schedule-end-to'] = $this->getOptionValue('ycd-schedule-end-to');
		$options['ycd-schedule-start-from'] = $this->getOptionValue('ycd-schedule-start-from');
		$options['ycd-schedule-time-zone'] = $this->getOptionValue('ycd-schedule-time-zone');
	}

	public function renderView() {
		$id = $this->getId();

		$content = '<div class="ycd-all-content-wrapper ycd-countdown-content-wrapper-'.$id.'">';
		$content .= apply_filters('ycdCountdownBeforeContent', '', $this);
		$content .= $this->getViewContent();
	  
		do_action('ycdGeneralScripts');
		$content .= apply_filters('ycdCountdownAfterContent', '', $this);
		$content .= '</div>';
		return $content;
	}

	public function addToContent() {

	}
	
	public function getTheContentFilter($content) {
		$id = $this->getId();
		$position = $this->getOptionValue('ycd-position-countdown');
		$explodedData = explode( '_', $position);
		$vertical = $explodedData[0];
		$horizontal = $explodedData[1];

		$countdownContent = apply_filters('ycdCountdownBeforeContent', '', $this);
		$countdownContent .= $this->getViewContent();
		$allContent = $content.$countdownContent;
		if ($vertical == 'top') {
			$allContent = $countdownContent.$content;
		}
		$allContent .= apply_filters('ycdCountdownAfterContent', '', $this);
		$allContent .= '<style>.ycd-circle-'.$id.'-wrapper {text-align: '.$horizontal.' !important;}</style>';
		return $allContent;
	}
	
	public function chanegSavedDataFromArgs() {
		$args = $this->getShortCodeArgs();
		$savedData = $this->getSavedData();
		if (!empty($args['date'])) {
			$savedData['ycd-date-time-picker'] = $args['date'];
		}
		$this->setSavedData($savedData);
	}
	
	public static function getCountdownsIdAndTitle($args) {
		
		$allCountdowns = self::getCountdownsObj();
		$allowedTypes = (!empty($args['allowTypes'])) ? $args['allowTypes'] : array();
		$exceptTypes = (!empty($args['except'])) ? $args['except'] : array();
		$idTitles = array('' => 'Select Countdown');
		
		foreach ($allCountdowns as $countdown) {
			$type = $countdown->getType();
			if (is_array($allowedTypes) && !empty($allowedTypes) && !in_array($type, $allowedTypes)) {
				continue;
			}
			if (is_array($exceptTypes) && !empty($exceptTypes) && in_array($type, $exceptTypes)) {
				continue;
			}
			$id = $countdown->getId();
			$title = $countdown->getTitle();
			
			if (empty($title)) {
				$title = '(no title)';
			}
			$idTitles[$id] = $title;
		}
		
		return $idTitles;
	}
	
	protected function getCountdownTimerAttrSeconds() {
		$seconds = 0;
		$countdownDateType = $this->getOptionValue('ycd-countdown-date-type');
		
		if($this->getOptionValue('ycd-countdown-save-duration') && $countdownDateType == 'duration') {
			$seconds = $this->getOptionValue('ycd-countdown-duration-saved-str-time') - strtotime('now');
		}
		
		return $seconds;
	}
	
	public function generalOptionsData() {
		$options = array();
		$isExpired = $this->isExpired();
		
		$options['ycd-countdown-date-type'] = $this->getOptionValue('ycd-countdown-date-type');
		$options['ycd-countdown-duration-days'] = $this->getOptionValue('ycd-countdown-duration-days');
		$options['ycd-countdown-duration-hours'] = $this->getOptionValue('ycd-countdown-duration-hours');
		$options['ycd-countdown-duration-minutes'] = $this->getOptionValue('ycd-countdown-duration-minutes');
		$options['ycd-countdown-duration-seconds'] = $this->getOptionValue('ycd-countdown-duration-seconds');
		$options['ycd-countdown-save-duration'] = $this->getOptionValue('ycd-countdown-save-duration');
		$options['ycd-countdown-save-duration-each-user'] = $this->getOptionValue('ycd-countdown-save-duration-each-user');
		$options['ycd-date-time-picker'] = $this->getOptionValue('ycd-date-time-picker');
		$options['ycd-time-zone'] = $this->getOptionValue('ycd-circle-time-zone');
		$options['ycd-countdown-restart'] = $this->getOptionValue('ycd-countdown-restart');
		$options['ycd-countdown-restart-hour'] = $this->getOptionValue('ycd-countdown-restart-hour');
		$options['isExpired'] = $isExpired;
		
		do_action('ycdIncludeGeneralOptions', $this);
		
		return apply_filters('ycdGeneralIncludingOptions', $options, $this);
	}
	
	public function getFlipClockOptionsData() {
		$options = array();
		
		
		$options['id'] = $this->getId();
		$modifiedObj = $this->getCircleSeconds();
		$modifiedSavedData = $modifiedObj->datesNumber;
		$options['ycd-seconds'] = $modifiedObj->expireSeconds;
		$options['ycd-countdown-date-type'] = $this->getOptionValue('ycd-countdown-date-type');
		
		$options += $this->generalOptionsData();
		
		$options['output-format'] = $this->getOutputFormats();
		$options['ycd-flip-countdown-year-text'] = $this->getOptionValue('ycd-flip-countdown-year-text');
		$options['ycd-flip-countdown-week-text'] = $this->getOptionValue('ycd-flip-countdown-week-text');
		$options['ycd-flip-countdown-days-text'] = $this->getOptionValue('ycd-flip-countdown-days-text');
		$options['ycd-flip-countdown-hours-text'] = $this->getOptionValue('ycd-flip-countdown-hours-text');
		$options['ycd-flip-countdown-minutes-text'] = $this->getOptionValue('ycd-flip-countdown-minutes-text');
		$options['ycd-flip-countdown-seconds-text'] = $this->getOptionValue('ycd-flip-countdown-seconds-text');
		$options['ycd-countdown-expire-behavior'] = $this->getOptionValue('ycd-countdown-expire-behavior');
		$options['count_past_zero'] = false;
		if($this->getOptionValue('ycd-countdown-expire-behavior') == 'countToUp') {
			$options['count_past_zero'] = true;
		}
		if (!empty($this->getOptionValue('ycd-count-up-from-end-date'))) {
			$options['countUp'] = true;
		}
		$options['ycd-expire-text'] = $this->getOptionValue('ycd-expire-text');
		$options['ycd-expire-url'] = $this->getOptionValue('ycd-expire-url');
		$options['ycd-countdown-end-sound'] = $this->getOptionValue('ycd-countdown-end-sound');
		$options['ycd-countdown-end-sound-url'] = $this->getOptionValue('ycd-countdown-end-sound-url');
		$options['ycd-countdown-end-sound'] = $this->getOptionValue('ycd-countdown-end-sound');
		$options['ycd-countdown-end-sound-url'] = $this->getOptionValue('ycd-countdown-end-sound-url');
		$options['ycd-schedule-time-zone'] = $this->getOptionValue('ycd-schedule-time-zone');
		// Day numbers
		
		$options['startDay'] = $this->getOptionValue('ycd-schedule-start-day');
		$options['startDayNumber'] = $modifiedSavedData['startDayNumber'];
		$options['endDay'] = $this->getOptionValue('ycd-schedule-end-day');
		$options['endDayNumber'] = $modifiedSavedData['endDayNumber'];
		$options['currentDayNumber'] = $modifiedSavedData['currentDayNumber'];
		$options['ycd-schedule-end-to'] = $this->getOptionValue('ycd-schedule-end-to');
		$options['ycd-schedule-start-from'] = $this->getOptionValue('ycd-schedule-start-from');
		
		return $options;
	}
	
	public function getCircleOptionsData() {
		$options = array();
		
		$modifiedObj = $this->getCircleSeconds();
		$modifiedSavedData = $modifiedObj->datesNumber;
		$options['id'] = $this->getId();
		$options['ycd-seconds'] = $modifiedObj->expireSeconds;
		$options['ycd-countdown-date-type'] = $this->getOptionValue('ycd-countdown-date-type');
		$options += $this->generalOptionsData();
		
		$options['animation'] = $this->getOptionValue('ycd-circle-animation');
		$options['direction'] = $this->getOptionValue('ycd-countdown-direction');
		$options['fg_width'] = $this->getOptionValue('ycd-circle-width');
		$options['bg_width'] = $this->getOptionValue('ycd-circle-bg-width');
		$options['start_angle'] = $this->getOptionValue('ycd-circle-start-angle');
		$options['count_past_zero'] = false;
		if($this->getOptionValue('ycd-countdown-expire-behavior') == 'countToUp') {
			$options['count_past_zero'] = true;
		}
		$options['circle_bg_color'] = $this->getOptionValue('ycd-countdown-bg-circle-color');
		$options['use_background'] = $this->getOptionValue('ycd-countdown-background-circle');
		$options['ycd-count-up-from-end-date'] = $this->getOptionValue('ycd-count-up-from-end-date');
		$options['ycd-schedule-time-zone'] = $this->getOptionValue('ycd-schedule-time-zone');
		// Day numbers

		$options['startDay'] = $this->getOptionValue('ycd-schedule-start-day');
		$options['startDayNumber'] = @$modifiedSavedData['startDayNumber'];
		$options['endDay'] = $this->getOptionValue('ycd-schedule-end-day');
		$options['endDayNumber'] = @$modifiedSavedData['endDayNumber'];
		$options['currentDayNumber'] = @$modifiedSavedData['currentDayNumber'];
		$options['ycd-schedule-end-to'] = $this->getOptionValue('ycd-schedule-end-to');
		$options['ycd-schedule-start-from'] = $this->getOptionValue('ycd-schedule-start-from');
		$options['ycd-countdown-showing-limitation'] = $this->getOptionValue('ycd-countdown-showing-limitation');
		$options['ycd-countdown-expiration-time'] = $this->getOptionValue('ycd-countdown-expiration-time');
		$options['ycd-countdown-switch-number'] = $this->getOptionValue('ycd-countdown-switch-number');

		$options['time'] = array(
			'Years' => array(
				'text' =>  $this->getOptionValue('ycd-countdown-years-text'),
				'color' =>  $this->getOptionValue('ycd-countdown-years-color'),
				'show' => $this->getOptionValue('ycd-countdown-years')
			),
			'Months' => array(
				'text' => $this->getOptionValue('ycd-countdown-months-text'),
				'color' => $this->getOptionValue('ycd-countdown-months-color'),
				'show' => $this->getOptionValue('ycd-countdown-months')
			),
			'Days' => array(
				'text' =>  $this->getOptionValue('ycd-countdown-days-text'),
				'color' =>  $this->getOptionValue('ycd-countdown-days-color'),
				'show' => $this->getOptionValue('ycd-countdown-days')
			),
			'Hours' => array(
				'text' => $this->getOptionValue('ycd-countdown-hours-text'),
				'color' =>  $this->getOptionValue('ycd-countdown-hours-color'),
				'show' => $this->getOptionValue('ycd-countdown-hours')
			),
			'Minutes' => array(
				'text' => $this->getOptionValue('ycd-countdown-minutes-text'),
				'color' => $this->getOptionValue('ycd-countdown-minutes-color'),
				'show' => $this->getOptionValue('ycd-countdown-minutes')
			),
			'Seconds' => array(
				'text' => $this->getOptionValue('ycd-countdown-seconds-text'),
				'color' => $this->getOptionValue('ycd-countdown-seconds-color'),
				'show' => $this->getOptionValue('ycd-countdown-seconds')
			),
		);
		
		return $options;
	}

    public function getFontFamilyByName($name) {
        $fontFamily = $this->getOptionValue($name);
        if ($fontFamily == 'customFont') {
            $fontFamily = $this->getOptionValue($name.'-custom');
        }

        return $fontFamily;
    }
	
	public function additionalFunctionality() {
		$content = $this->renderProgressBar();
		$content .= $this->renderSubscriptionForm();
		
		return $content;
	}
}