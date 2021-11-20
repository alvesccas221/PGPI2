<?php
namespace ycd;
use \YcdCountdownConfig;
use \DateTime;

class Ajax {

	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action('wp_ajax_ycd-switch', array($this, 'switchCountdown'));
		add_action('wp_ajax_ycdSupport', array($this, 'ycdSupport'));

		// review panel
		add_action('wp_ajax_ycd_dont_show_review_notice', array($this, 'dontShowReview'));
		add_action('wp_ajax_ycd_change_review_show_period', array($this, 'changeReviewPeriod'));

		// conditions builder
		add_action('wp_ajax_ycd_select2_search_data', array($this, 'select2Ajax'));
		add_action('wp_ajax_ycd_edit_conditions_row', array($this, 'conditionsRow'));
		add_action('wp_ajax_ycd_add_conditions_row', array($this, 'conditionsRow'));

		add_action('wp_ajax_countdown-builder_storeSurveyResult', array($this, 'countdownBuilderStoreSurveyResult'));
	}

	public function countdownBuilderStoreSurveyResult() {
		check_ajax_referer('countdownBuilderAjaxNonce', 'token');
		$str = $_POST['savedData'];
		parse_str($str, $savedData);

		$headers  = 'MIME-Versions: 1.0'."\r\n";
		//$headers .= 'From: '.$sendFromEmail.''."\r\n";
		$headers .= 'Content-types: text/plain; charset=UTF-8'."\r\n";
		$message = '<b>Product</b>: Countdown builder<br>';
		$message .= '<b>Version</b>: '.YCD_VERSION_TEXT.'<br>';

		if (empty($savedData['countdown-builder_reason_key'])) {
			$message .= 'Skip <br>';
		}
		else {
			foreach ($savedData as $key => $value) {
				if (empty($value)) {
					continue;
				}
				$message .= '<b>'.$key.'</b>: '.$value.'<br>';
			}
		}

		$sendStatus = wp_mail('xavierveretu@gmail.com', 'Countdown builder Deactivate Survey', $message, $headers);
		echo 1;
		die;
	}

	public function changeReviewPeriod() {
		check_ajax_referer('ycdReviewNotice', 'ajaxNonce');
		$messageType = sanitize_text_field($_POST['messageType']);

		$timeDate = new DateTime('now');
		$timeDate->modify('+'.YCD_SHOW_REVIEW_PERIOD.' day');

		$timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));
		update_option('YcdShowNextTime', $timeNow);
		$usageDays = get_option('YcdUsageDays');
		$usageDays += YCD_SHOW_REVIEW_PERIOD;
		update_option('YcdUsageDays', $usageDays);

		echo YCD_AJAX_SUCCESS;
		wp_die();
	}

	public function dontShowReview() {
		check_ajax_referer('ycdReviewNotice', 'ajaxNonce');
		update_option('YcdDontShowReviewNotice', 1);

		echo YCD_AJAX_SUCCESS;
		wp_die();
	}

	public function ycdSupport() {
		check_ajax_referer('ycd_ajax_nonce', 'nonce');
		parse_str($_POST['formData'], $params);

		$headers	= 'MIME-Versions: 1.0'."\r\n";
		//$headers .= 'From: '.$sendFromEmail.''."\r\n";
		$headers .= 'Content-types: text/plain; charset=UTF-8'."\r\n";
		$message = '<b>Report type</b>: '.$params['report_type'].'<br>';
		$message .= '<b>Name</b>: '.$params['name'].'<br>';
		$message .= '<b>Email</b>: '.$params['email'].'<br>';
		$message .= '<b>Website</b>: '.$params['website'].'<br>';
		$message .= '<b>Message</b>: '.$params['ycd-message'].'<br>';
		$message .= '<b>version</b>: '.YcdCountdownConfig::getVersionString().'<br>';

		$sendStatus = wp_mail('adamskaat1@gmail.com', 'Web site support', $message, $headers);

		echo $sendStatus;
		die();
	}

	public function switchCountdown() {
		check_ajax_referer('ycd_ajax_nonce', 'nonce');
		$postId = (int)$_POST['id'];
		$checked = $_POST['checked'] == 'true' ? '' : true;
		update_post_meta($postId, 'ycd_enable', $checked);
		wp_die();
	}

	 public function select2Ajax() {
		check_ajax_referer('ycd_ajax_nonce', 'nonce_ajax');
		YcdCountdownConfig::displaySettings();
		$postTypeName = sanitize_text_field($_POST['postType']);
		$search = sanitize_text_field($_POST['searchTerm']);

		$args	 = array(
			's'			 => $search,
			'post__in'		=> ! empty( $_REQUEST['include'] ) ? array_map( 'intval', $_REQUEST['include'] ) : null,
			'page'		 => ! empty( $_REQUEST['page'] ) ? absint( $_REQUEST['page'] ) : null,
			'posts_per_page' => 100,
			'post_type'	 => $postTypeName
		);

		$searchResults = AdminHelper::getPostTypeData($args);

		if (empty($searchResults)) {
			$results['items'] = array();
		}

		/*Selected custom post type convert for select2 format*/
		foreach ($searchResults as $id => $name) {
			$results['items'][] = array(
				'id'	=> $id,
				'text' => $name
			);
		}

		echo json_encode($results);
		wp_die();
	 }

	 public function conditionsRow() {
		check_ajax_referer('ycd_ajax_nonce', 'nonce');
		YcdCountdownConfig::displaySettings();
		$selectedParams = sanitize_text_field($_POST['selectedParams']);
		$conditionId = (int)$_POST['conditionId'];
		$childClassName = $_POST['conditionsClassName'];
		$childClassName = __NAMESPACE__.'\\'.$childClassName;
		$obj = new $childClassName();

		echo $obj->renderConditionRowFromParam($selectedParams, $conditionId);
		wp_die();
	 }
}

new Ajax();