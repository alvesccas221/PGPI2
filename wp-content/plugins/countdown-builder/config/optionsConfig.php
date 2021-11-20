<?php

class YcdCountdownOptionsConfig
{
	public static function init()
	{
		global $YCD_TYPES;

		$YCD_TYPES['typeName'] = apply_filters('ycdTypes', array(
			'circle' => YCD_FREE_VERSION,
			'sticky' => YCD_FREE_VERSION,
			'simple' => YCD_FREE_VERSION,
			'timer' => YCD_FREE_VERSION,
			'clock1' => YCD_FREE_VERSION,
			'clock2' => YCD_FREE_VERSION,
			'clock3' => YCD_FREE_VERSION,
			'clock4' => YCD_SILVER_VERSION,
			'clock5' => YCD_SILVER_VERSION,
			'clock6' => YCD_SILVER_VERSION,
			'clock7' => YCD_SILVER_VERSION,
			'woo' => YCD_GOLD_VERSION,
			'circlePopup' => YCD_GOLD_VERSION,
			'flipClock' => YCD_SILVER_VERSION,
			'flipClockPopup' => YCD_GOLD_VERSION
		));

		$YCD_TYPES['typeGroupName'] = apply_filters('ycdTypeGroupName', array(
			'circle' => array('countdown'),
			'sticky' => array('countdown', 'other'),
			'simple' => array('countdown'),
			'timer' => array('timer'),
			'clock1' => array('clock'),
			'clock2' => array('clock'),
			'clock3' => array('clock'),
			'clock4' => array('clock'),
			'clock5' => array('clock'),
			'clock6' => array('clock'),
			'clock7' => array('clock'),
			'woo' => array('countdown', 'other'),
			'circlePopup' => array('countdown', 'popup'),
			'flipClock' => array('countdown'),
			'flipClockPopup' => array('countdown', 'popup')
		));

		$YCD_TYPES['typePath'] = apply_filters('ycdTypePaths', array(
			'circle' => YCD_COUNTDOWNS_PATH,
			'sticky' => YCD_COUNTDOWNS_PATH,
			'simple' => YCD_COUNTDOWNS_PATH,
			'timer' => YCD_COUNTDOWNS_PATH,
			'clock1' => YCD_COUNTDOWNS_PATH,
			'clock2' => YCD_COUNTDOWNS_PATH,
			'clock3' => YCD_COUNTDOWNS_PATH,
			'clock4' => YCD_COUNTDOWNS_PATH,
			'clock5' => YCD_COUNTDOWNS_PATH,
			'clock6' => YCD_COUNTDOWNS_PATH,
			'clock7' => YCD_COUNTDOWNS_PATH,
			'woo' => YCD_COUNTDOWNS_PATH,
			'circlePopup' => YCD_COUNTDOWNS_PATH,
			'flipClock' => YCD_COUNTDOWNS_PATH,
			'flipClockPopup' => YCD_COUNTDOWNS_PATH
		));
		
		$YCD_TYPES['titles'] = apply_filters('ycdTitles', array(
			'circle' => __('Circle', YCD_TEXT_DOMAIN),
			'sticky' => __('Sticky Countdown', YCD_TEXT_DOMAIN),
			'simple' => __('Simple Countdown', YCD_TEXT_DOMAIN),
			'timer' => __('Timer', YCD_TEXT_DOMAIN),
			'clock1' => __('Clock 1', YCD_TEXT_DOMAIN),
			'clock2' => __('Clock 2', YCD_TEXT_DOMAIN),
			'clock3' => __('Clock 3', YCD_TEXT_DOMAIN),
			'clock4' => __('Clock 4', YCD_TEXT_DOMAIN),
			'clock5' => __('Clock 5', YCD_TEXT_DOMAIN),
			'clock6' => __('Clock 6', YCD_TEXT_DOMAIN),
			'clock7' => __('Clock 7', YCD_TEXT_DOMAIN),
			'woo' => __('WooCommerce Countdown', YCD_TEXT_DOMAIN),
			'circlePopup' => __('Circle Popup', YCD_TEXT_DOMAIN),
			'flipClock' => __('Flip Clock', YCD_TEXT_DOMAIN),
			'flipClockPopup' => __('Flip Clock Popup', YCD_TEXT_DOMAIN),
			'circleTimer' => __('Circle Timer', YCD_TEXT_DOMAIN)
		));

		$YCD_TYPES['youtubeUrls'] = apply_filters('ycdYoutubeUrls', array(
			'countdownCreate' => 'https://www.youtube.com/watch?v=efqVcdKF620',
			'clock5' => 'https://www.youtube.com/watch?v=NbP4aKPrWfM&',
			'clock6' => 'https://www.youtube.com/watch?v=rsWijVfKQzk',
			'clock7' => 'https://www.youtube.com/watch?v=WqsbNipqyCM',
			'sticky' => 'https://www.youtube.com/watch?v=sK9A-ADoy8Y',
			'woo' => 'https://www.youtube.com/watch?v=ObLMBFp69ro',
			'circlePopup' => 'https://www.youtube.com/watch?v=KUEvK0FuErw',
			'flipClock' => 'https://www.youtube.com/watch?v=Zb7fIkEBcio',
			'flipClockPopup' => 'https://www.youtube.com/watch?v=i46qN2sFwZc',
			'countdownButton' => 'https://www.youtube.com/watch?v=WwBuEGIy8po',
			'analytics' => 'https://www.youtube.com/watch?v=58asfPjhMS8',
			'circleTimer' => 'https://www.youtube.com/watch?v=DZHUxHlSdcU&feature=youtu.be'
		));

		$YCD_TYPES['tutorialsTitles'] = apply_filters('ycdYoutubeUrlsTitles', array(
			'countdownCreate' => __('How to create Countdown', YCD_TEXT_DOMAIN),
			'clock5' => __('How to create Clock 5', YCD_TEXT_DOMAIN),
			'clock6' => __('How to create Clock 6', YCD_TEXT_DOMAIN),
			'clock7' => __('How to create Clock 7', YCD_TEXT_DOMAIN),
			'sticky' => __('How to create Sticky Countdown', YCD_TEXT_DOMAIN),
			'woo' => __('How to create WooCommerce Countdown', YCD_TEXT_DOMAIN),
			'circlePopup' => __('How to create Circle Countdown Popup', YCD_TEXT_DOMAIN),
			'flipClock' => __('How to create FlipClock Countdown', YCD_TEXT_DOMAIN),
			'flipClockPopup' => __('How to create FlipClock Popup Countdown', YCD_TEXT_DOMAIN),
			'countdownButton' => __('Countdown Button Extension', YCD_TEXT_DOMAIN),
			'analytics' => __('Countdown Analytic Extension', YCD_TEXT_DOMAIN),
			'circleTimer' => __('Circle Timer Extension', YCD_TEXT_DOMAIN)
		));

		$YCD_TYPES['typesGroupList'] = apply_filters('ycdGroupsLost', array(
			'all' => __('All Types', YCD_TEXT_DOMAIN),
			'countdown' => __('Countdown', YCD_TEXT_DOMAIN),
			'clock' => __('Clock', YCD_TEXT_DOMAIN),
			'other' => __('Other', YCD_TEXT_DOMAIN),
			'timer' => __('Timer', YCD_TEXT_DOMAIN),
			'popup' => __('Popup', YCD_TEXT_DOMAIN)
		));
	}

	public static function optionsValues()
	{
		global $YCD_OPTIONS;
		$options = array();
		$options[] = array('name' => 'ycd-type', 'type' => 'text', 'defaultValue' => 'circle');
		$options[] = array('name' => 'ycd-countdown-date-type', 'type' => 'text', 'defaultValue' => 'dueDate');
		$options[] = array('name' => 'ycd-date-time-picker', 'type' => 'text', 'defaultValue' => date('Y-m-d H:i', strtotime(' +1 day')));
		$options[] = array('name' => 'ycd-date-progress-start-date', 'type' => 'text', 'defaultValue' => date('Y-m-d H:i'));
		$options[] = array('name' => 'ycd-circle-time-zone', 'type' => 'text', 'defaultValue' => self::getDefaultTimezone());
		$options[] = array('name' => 'ycd-circle-animation', 'type' => 'text', 'defaultValue' => 'smooth');
		$options[] = array('name' => 'ycd-circle-alignment', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-countdown-width', 'type' => 'text', 'defaultValue' => '500');
		$options[] = array('name' => 'ycd-dimension-measure', 'type' => 'text', 'defaultValue' => 'px');
		$options[] = array('name' => 'ycd-countdown-background-circle', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-countdown-months', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-months-text', 'type' => 'text', 'defaultValue' => __('Months', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-countdown-years', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-years-text', 'type' => 'text', 'defaultValue' => __('Years', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-countdown-days', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-countdown-days-text', 'type' => 'text', 'defaultValue' => __('DAYS', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-countdown-hours', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-countdown-hours-text', 'type' => 'text', 'defaultValue' => __('HOURS', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-countdown-minutes', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-countdown-minutes-text', 'type' => 'text', 'defaultValue' => __('MINUTES', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-countdown-seconds', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-countdown-seconds-text', 'type' => 'text', 'defaultValue' => __('SECONDS', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-countdown-direction', 'type' => 'text', 'defaultValue' => __('Clockwise', YCD_TEXT_DOMAIN));
		$options[] = array(
			'name' => 'ycd-countdown-expire-behavior',
			'type' => 'text',
			'defaultValue' => __('hideCountdown', YCD_TEXT_DOMAIN),
			'ver' => YCD_SILVER_VERSION,
			'allow' => array('hideCountdown', 'default', 'countToUp')
		);
		$options[] = array('name' => 'ycd-expire-text', 'type' => 'html', 'defaultValue' => __('', YCD_TEXT_DOMAIN), 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-expire-url', 'type' => 'text', 'defaultValue' => __('', YCD_TEXT_DOMAIN), 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-months-color', 'type' => 'text', 'defaultValue' => '#8A2BE2', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-months-text-color', 'type' => 'text', 'defaultValue' => '#000000', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-years-color', 'type' => 'text', 'defaultValue' => '#A52A2A', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-years-text-color', 'type' => 'text', 'defaultValue' => '#000000', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-days-color', 'type' => 'text', 'defaultValue' => '#FFCC66', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-days-text-color', 'type' => 'text', 'defaultValue' => '#000000', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-hours-color', 'type' => 'text', 'defaultValue' => '#99CCFF', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-hours-text-color', 'type' => 'text', 'defaultValue' => '#000000', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-minutes-color', 'type' => 'text', 'defaultValue' => '#BBFFBB', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-minutes-text-color', 'type' => 'text', 'defaultValue' => '#000000', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-seconds-color', 'type' => 'text', 'defaultValue' => '#FF9999', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-seconds-text-color', 'type' => 'text', 'defaultValue' => '#000000', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-circle-width', 'type' => 'text', 'defaultValue' => '0.1');
		$options[] = array('name' => 'ycd-circle-bg-width', 'type' => 'text', 'defaultValue' => '1.2');
		$options[] = array('name' => 'ycd-circle-start-angle', 'type' => 'text', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-countdown-bg-image', 'type' => 'checkbox', 'defaultValue' => 0, 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-bg-image-size', 'type' => 'text', 'defaultValue' => 'cover', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-bg-image-repeat', 'type' => 'text', 'defaultValue' => 'no-repeat', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-bg-image-url', 'type' => 'text', 'defaultValue' => '', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-bg-circle-color', 'type' => 'text', 'defaultValue' => '#60686F', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-text-font-size', 'type' => 'text', 'defaultValue' => '9');
		$options[] = array('name' => 'ycd-countdown-number-size', 'type' => 'text', 'defaultValue' => '35');
		$options[] = array('name' => 'ycd-countdown-number-font-weight', 'type' => 'text', 'defaultValue' => 'bold');
		$options[] = array('name' => 'ycd-countdown-font-weight', 'type' => 'text', 'defaultValue' => 'normal');
		$options[] = array('name' => 'ycd-countdown-font-style', 'type' => 'text', 'defaultValue' => 'initial');
		$options[] = array('name' => 'ycd-text-font-family', 'type' => 'text', 'defaultValue' => 'Century Gothic', 'ver' => YCD_SILVER_VERSION);
		$options[] = array('name' => 'ycd-countdown-padding', 'type' => 'text', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-flip-time-zone', 'type' => 'text', 'defaultValue' => self::getDefaultTimezone());
		$options[] = array('name' => 'ycd-flip-date-time-picker', 'type' => 'text', 'defaultValue' => date('Y-m-d H:i', strtotime(' +1 day')));
		$options[] = array('name' => 'ycd-countdown-duration-days', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-countdown-duration-hours', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-countdown-duration-minutes', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-countdown-duration-seconds', 'type' => 'number', 'defaultValue' => 30);

		$options[] = array('name' => 'ycd-clock-timer-hours', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-clock-timer-minutes', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-clock-timer-seconds', 'type' => 'number', 'defaultValue' => 30);
		$options[] = array('name' => 'ycd-circle-countdown-before-countdown', 'type' => 'html', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-circle-countdown-after-countdown', 'type' => 'html', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-circle-countdown-expiration-before-countdown', 'type' => 'html', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-circle-countdown-expiration-after-countdown', 'type' => 'html', 'defaultValue' => '');

		// timer clock
		$options[] = array('name' => 'ycd-countdown-save-duration', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-save-duration-each-user', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-restart', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-restart-hour', 'type' => 'text', 'defaultValue' => '1');
		$options[] = array('name' => 'ycd-timer-days', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-timer-hours', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-timer-minutes', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-timer-seconds', 'type' => 'number', 'defaultValue' => 30);
		$options[] = array('name' => 'ycd-timer-font-size', 'type' => 'number', 'defaultValue' => 6);
		$options[] = array('name' => 'ycd-timer-content-padding', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-timer-bg-image', 'type' => 'checkbox', 'defaultValue' => 0);
		$options[] = array('name' => 'ycd-timer-content-alignment', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-countdown-timer-labels', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-timer-label-days', 'type' => 'text', 'defaultValue' => 'Days');
		$options[] = array('name' => 'ycd-timer-label-hours', 'type' => 'text', 'defaultValue' => 'Hrs');
		$options[] = array('name' => 'ycd-timer-label-minutes', 'type' => 'text', 'defaultValue' => 'Mins');
		$options[] = array('name' => 'ycd-timer-label-seconds', 'type' => 'text', 'defaultValue' => 'Secs');
		$options[] = array('name' => 'ycd-timer-font-size-label', 'type' => 'text', 'defaultValue' => '20');
		$options[] = array('name' => 'ycd-before-timer-html', 'type' => 'html', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-after-timer-html', 'type' => 'html', 'defaultValue' => '');

		// clock
		$options[] = array('name' => 'ycd-clock-mode', 'type' => 'html', 'defaultValue' => '24');
		$options[] = array('name' => 'ycd-clock1-time-zone', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-clock1-width', 'type' => 'text', 'defaultValue' => 200);
		$options[] = array('name' => 'ycd-clock1-alignment', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-clock2-width', 'type' => 'text', 'defaultValue' => 200);
		$options[] = array('name' => 'ycd-clock2-alignment', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-clock3-width', 'type' => 'text', 'defaultValue' => 200);
		$options[] = array('name' => 'ycd-clock3-alignment', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-clock4-width', 'type' => 'text', 'defaultValue' => 200);
		$options[] = array('name' => 'ycd-clock4-alignment', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-clock5-width', 'type' => 'text', 'defaultValue' => 200);
		$options[] = array('name' => 'ycd-clock5-alignment', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-clock6-width', 'type' => 'text', 'defaultValue' => 200);
		$options[] = array('name' => 'ycd-clock6-alignment', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-clock7-width', 'type' => 'text', 'defaultValue' => 200);
		$options[] = array('name' => 'ycd-clock7-alignment', 'type' => 'text', 'defaultValue' => 'center');
		
		if(YCD_PKG_VERSION > YCD_FREE_VERSION) {
			require_once dirname(__FILE__) . '/proOptionsConfig.php';
		}

		$options[] = array('name' => 'ycd-countdown-hide-mobile', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-show-mobile', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-selected-countries', 'type' => 'checkbox', 'defaultValue' => '', 'available' => YCD_PLATINUM_VERSION);
		$options[] = array('name' => 'ycd-counties-names', 'type' => 'array', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-end-sound', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-end-sound-url', 'type' => 'text', 'defaultValue' => YCD_COUNTDOWN_LIB_URL.'alarm.mp3');
		$options[] = array('name' => 'ycd-enable-subscribe-form', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-subscribe-width', 'type' => 'text', 'defaultValue' => '100%');
		$options[] = array('name' => 'ycd-form-above-text', 'type' => 'text', 'defaultValue' => __('Join Our Newsletter', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-form-input-text', 'type' => 'text', 'defaultValue' => __('Enter your email here', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-form-submit-text', 'type' => 'text', 'defaultValue' => __('Subscribe', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-subscribe-success-message', 'type' => 'text', 'defaultValue' => __('Thanks for subscribing.', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-subscribe-error-message', 'type' => 'text', 'defaultValue' => __('Invalid email address.', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-form-submit-color', 'type' => 'text', 'defaultValue' => __('#3274d1', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-stick-countdown-font-size', 'type' => 'text', 'defaultValue' => __('25', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-countdown-content-click', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-switch-number', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-showing-limitation', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-expiration-time', 'type' => 'text', 'defaultValue' => '1');
		$options[] = array('name' => 'ycd-countdown-showing-animation', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-circle-showing-animation-speed', 'type' => 'text', 'defaultValue' => '1');
		$options[] = array('name' => 'ycd-circle-box-shadow', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-circle-box-shadow-horizontal-length', 'type' => 'text', 'defaultValue' => '10');
		$options[] = array('name' => 'ycd-circle-box-shadow-vertical-length', 'type' => 'text', 'defaultValue' => '10');
		$options[] = array('name' => 'ycd-circle-box-blur-radius', 'type' => 'text', 'defaultValue' => '5');
		$options[] = array('name' => 'ycd-circle-box-spread-radius', 'type' => 'text', 'defaultValue' => 1);
		$options[] = array('name' => 'ycd-circle-box-shadow-color', 'type' => 'text', 'defaultValue' => '#ffffff');
		$options[] = array('name' => 'ycd-display-settings', 'type' => 'ycd', 'defaultValue' => array(array('key1' => 'select_settings')));
		$options[] = array('name' => 'ycd-countdown-display-on', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-position-countdown', 'type' => 'text', 'defaultValue' => 'top_center');
		$options[] = array('name' => 'ycd-countdown-clock-mode', 'type' => 'text', 'defaultValue' => 'clock');
		$options[] = array('name' => 'ycd-countdown-timer-button', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-timer-milliseconds', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-timer-days', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-timer-auto-counting', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-timer-button-start-title', 'type' => 'text', 'defaultValue' => __('Start', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-timer-button-stop-title', 'type' => 'text', 'defaultValue' => __('Stop', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-timer-reset-button', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-timer-reset-button-label', 'type' => 'text', 'defaultValue' => __('Reset', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-count-up-from-end-date', 'type' => 'checkbox', 'defaultValue' => '');

		$options[] = array('name' => 'ycd-button-name', 'type' => 'text', 'defaultValue' => 'Buy Now');
		$options[] = array('name' => 'ycd-button-action-url', 'type' => 'text', 'defaultValue' => get_site_url());
		$options[] = array('name' => 'ycd-button-action-url-tab', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-enable-button', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-button-width', 'type' => 'text', 'defaultValue' => '200px');
		$options[] = array('name' => 'ycd-button-height', 'type' => 'text', 'defaultValue' => '50px');
		$options[] = array('name' => 'ycd-button-border-width', 'type' => 'text', 'defaultValue' => '0px');
		$options[] = array('name' => 'ycd-button-border-radius', 'type' => 'text', 'defaultValue' => '5');
		$options[] = array('name' => 'ycd-button-bg-color', 'type' => 'text', 'defaultValue' => '#4dba7a');
		$options[] = array('name' => 'ycd-button-color', 'type' => 'text', 'defaultValue' => '#ffffff');
		$options[] = array('name' => 'ycd-button-after-countdown', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-button-horizontal', 'type' => 'text', 'defaultValue' => 'center');
		$options[] = array('name' => 'ycd-button-font-size', 'type' => 'text', 'defaultValue' => '14px');
		$options[] = array('name' => 'ycd-button-margin-top', 'type' => 'text', 'defaultValue' => '0px');
		$options[] = array('name' => 'ycd-button-margin-right', 'type' => 'text', 'defaultValue' => '0px');
		$options[] = array('name' => 'ycd-button-margin-bottom', 'type' => 'text', 'defaultValue' => '0px');
		$options[] = array('name' => 'ycd-button-margin-left', 'type' => 'text', 'defaultValue' => '0px');
		$options[] = array('name' => 'ycd-button-opacity', 'type' => 'text', 'defaultValue' => '1');
		$options[] = array('name' => 'ycd-button-hover-colors', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-button-hover-bg-color', 'type' => 'text', 'defaultValue' => '#4dba7a');
		$options[] = array('name' => 'ycd-button-hover-color', 'type' => 'text', 'defaultValue' => '#ffffff');
		$options[] = array('name' => 'ycd-countdown-content-click-url-tab', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-countdown-button-behavior', 'type' => 'text', 'defaultValue' => 'redirect');
		$options[] = array('name' => 'ycd-countdown-expiration-text-change', 'type' => 'checkbox', 'defaultValue' => '');

		$options[] = array('name' => 'ycd-sticky-button-text', 'type' => 'text', 'defaultValue' => __('Checkout', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-sticky-bg-color', 'type' => 'text', 'defaultValue' => '#000000');
		$options[] = array('name' => 'ycd-sticky-button-color', 'type' => 'text', 'defaultValue' => '#fff');
		$options[] = array('name' => 'ycd-sticky-text-color', 'type' => 'text', 'defaultValue' => '#fff');
		$options[] = array('name' => 'ycd-sticky-text-background-color', 'type' => 'text', 'defaultValue' => '#555');
		$options[] = array('name' => 'ycd-sticky-countdown-text-color', 'type' => 'text', 'defaultValue' => '#fff');
		$options[] = array('name' => 'ycd-sticky-all-pages', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-sticky-countdown-days', 'type' => 'text', 'defaultValue' => 'd');
		$options[] = array('name' => 'ycd-sticky-countdown-hours', 'type' => 'text', 'defaultValue' => 'h');
		$options[] = array('name' => 'ycd-sticky-countdown-minutes', 'type' => 'text', 'defaultValue' => 'm');
		$options[] = array('name' => 'ycd-sticky-countdown-seconds', 'type' => 'text', 'defaultValue' => 's');
		$options[] = array('name' => 'ycd-sticky-button-padding-enable', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-sticky-button-padding', 'type' => 'text', 'defaultValue' => '0px');
		$options[] = array('name' => 'ycd-sticky-button-border-enable', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-sticky-button-border-width', 'type' => 'text', 'defaultValue' => '0px');
		$options[] = array('name' => 'ycd-sticky-button-border-radius', 'type' => 'text', 'defaultValue' => '0px');
		$options[] = array('name' => 'ycd-stick-countdown-font-weight', 'type' => 'text', 'defaultValue' => 'inherit');
		$options[] = array('name' => 'ycd-sticky-button-redirect-new-tab', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-sticky-countdown-mode', 'type' => 'text', 'defaultValue' => 'stickyCountdownDefault');
		$options[] = array('name' => 'ycd-sticky-countdown-sections', 'type' => 'text', 'defaultValue' => 'Text-Countdown-Button');
		$options[] = array('name' => 'ycd-sticky-enable-close', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-sticky-close-text', 'type' => 'text', 'defaultValue' =>  __('Close', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-sticky-expire-behavior', 'type' => 'text', 'defaultValue' =>  'redirectToURL');
		$options[] = array('name' => 'ycd-sticky-button-copy', 'type' => 'text', 'defaultValue' =>  '');
		$options[] = array('name' => 'ycd-sticky-copy-alert', 'type' => 'checkbox', 'defaultValue' =>  '');

		// Simple countdown
		$options[] = array('name' => 'ycd-simple-enable-months', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'ycd-simple-months-text', 'type' => 'text', 'defaultValue' => __('Months', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-simple-enable-days', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-simple-days-text', 'type' => 'text', 'defaultValue' => __('Days', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-simple-enable-hours', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-simple-hours-text', 'type' => 'text', 'defaultValue' => __('Hrs', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-simple-enable-minutes', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-simple-minutes-text', 'type' => 'text', 'defaultValue' => __('Mins', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-simple-enable-seconds', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'ycd-simple-seconds-text', 'type' => 'text', 'defaultValue' => __('Secs', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-enable-simple-double-digits', 'type' => 'checkbox', 'defaultValue' => '');

		$options[] = array('name' => 'ycd-simple-numbers-font-size', 'type' => 'text', 'defaultValue' => __('35px', YCD_TEXT_DOMAIN));
		$options[] = array('name' => 'ycd-simple-text-font-size', 'type' => 'text', 'defaultValue' => __('12px', YCD_TEXT_DOMAIN));

		$YCD_OPTIONS = apply_filters('ycdCountdownDefaultOptions', $options);
	}

	public static function getDefaultValuesData()
	{
		self::optionsValues();
		global $YCD_OPTIONS;
		$currentKeyVal = array();
		foreach ($YCD_OPTIONS as $option) {
			$currentKeyVal[$option['name']] = $option['defaultValue'];
		}

		return $currentKeyVal;
	}

	public static function getDefaultTimezone()
	{
		$timezone = get_option('timezone_string');
		if (!$timezone) {
			$timezone = 'America/New_York';
		}

		return $timezone;
	}
}

YcdCountdownOptionsConfig::init();