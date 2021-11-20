<?php
namespace ycd;
use \WP_Query;

class AdminHelper {

	public static function buildCreateCountdownUrl($type) {
		$isAvailable = $type->isAvailable();
		$name = $type->getName();

		$url = YCD_COUNTDOWN_ADMIN_URL.'post-new.php?post_type='.YCD_COUNTDOWN_POST_TYPE.'&ycd_type='.$name;

		if (!$isAvailable) {
			$url = YCD_COUNTDOWN_PRO_URL;
		}

		return $url;
	}

	public static function buildCreateCountdownAttrs($type) {
		$attrStr = '';
		$isAvailable = $type->isAvailable();

		if (!$isAvailable) {
			$args = array(
				'target' => '_blank'
			);
			$attrStr = self::createAttrs($args);
		}

		return $attrStr;
	}

	public static function getCountdownThumbClass($type) {
		$isAvailable = $type->isAvailable();
		$name = $type->getName();

		$typeClassName = $name.'-countdown';

		if (!$isAvailable) {
			$typeClassName .= '-pro ycd-pro-version';
		}

		return $typeClassName;
	}

	public static function getCountdownDisplayName($type) {
		global $YCD_TYPES;
		$titles = $YCD_TYPES['titles'];
		$name = $type->getName();
		
		return @$titles[$name];
	}

	public static function getCountdownYoutubeUrl($type) {
		global $YCD_TYPES;
		$titles = $YCD_TYPES['youtubeUrls'];
		$name = $type->getName();
		
		if (empty($titles[$name])) {
			return '';
		}
		
		return $titles[$name];
	}

	public static function getCountdownThumbText($type) {
		$isAvailable = $type->isAvailable();
		$name = $type->getName();

		$content = '';

		if (!$isAvailable) {
			if ($type->getIsComingSoon()) {
				$content = '<p class="ycd-type-title-pro ycd-coming-soon-type">'.__('Coming Soon', YCD_TEXT_DOMAIN).'</p>';
				return $content;
			}
			$content = '<p class="ycd-type-title-pro">'.__('PRO Features', YCD_TEXT_DOMAIN).'</p>';
		}

		return $content;
	}

	private static function getAllProducts() {
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => YCD_PRODUCTS_LIMIT
		);
		$products = array();

    	$productsObj = get_posts($args);

    	if (empty($productsObj)) {
    		return $products;
    	}

    	foreach($productsObj as $product) {
    		$products[$product->ID] = $product->post_title;
    	}
    	
    	return $products;
	}

	public static function defaultData() {

		$data = array();

		$data['ycd-circle-animation'] = array(
			'smooth' => __('Smooth', YCD_TEXT_DOMAIN),
			'ticks' => __('Ticks', YCD_TEXT_DOMAIN)
		);

		$data['ycd-dimension-measure'] = array(
		  'px' => __('Px', YCD_TEXT_DOMAIN),
		  '%' => __('%', YCD_TEXT_DOMAIN)
		);

		$data['ycd-countdown-direction'] = array(
		  'Clockwise' => __('Clockwise', YCD_TEXT_DOMAIN),
		  'Counter-clockwise' => __('Counter clockwise', YCD_TEXT_DOMAIN),
		  'Both' => __('Both', YCD_TEXT_DOMAIN)
		);

		$data['bg-image-size'] = array(
			'auto' => __('Auto', YCD_TEXT_DOMAIN),
			'cover' => __('Cover', YCD_TEXT_DOMAIN),
			'contain' => __('Contain', YCD_TEXT_DOMAIN)
		);

		$data['bg-image-repeat'] = array(
			'repeat' => __('Repeat', YCD_TEXT_DOMAIN),
			'repeat-x' => __('Repeat x', YCD_TEXT_DOMAIN),
			'repeat-y' => __('Repeat y', YCD_TEXT_DOMAIN),
			'no-repeat' => __('Not Repeat', YCD_TEXT_DOMAIN)
		);
	
		for($i = 7; $i <= 15; $i++) {
			$data['font-size'][$i] = __($i.'px', YCD_TEXT_DOMAIN);
		}
		
		for($i = 0; $i <= 22; $i++) {
			$data['circleTextMarginTop'][$i] = __($i.'px', YCD_TEXT_DOMAIN);
		}
		
		for($i = 0; $i <= 22; $i++) {
			$data['circleNumberMarginTop'][$i] = __($i.'px', YCD_TEXT_DOMAIN);
		}
	
		for($i = 7; $i <= 100; $i++) {
			$data['font-size-number'][$i] = __($i.'px', YCD_TEXT_DOMAIN);
		}

		$data['font-weight'] = array(
			'normal' => __('Normal', YCD_TEXT_DOMAIN),
			'bold' => __('Bold', YCD_TEXT_DOMAIN),
			'bolder' => __('Bolder', YCD_TEXT_DOMAIN),
			'lighter' => __('Lighter', YCD_TEXT_DOMAIN),
			'100' => __('100', YCD_TEXT_DOMAIN),
			'200' => __('200', YCD_TEXT_DOMAIN),
			'300' => __('300', YCD_TEXT_DOMAIN),
			'400' => __('400', YCD_TEXT_DOMAIN),
			'500' => __('500', YCD_TEXT_DOMAIN),
			'600' => __('600', YCD_TEXT_DOMAIN),
			'700' => __('700', YCD_TEXT_DOMAIN),
			'800' => __('800', YCD_TEXT_DOMAIN),
			'900' => __('900', YCD_TEXT_DOMAIN),
			'initial' => __('Initial', YCD_TEXT_DOMAIN),
			'inherit' => __('Inherit', YCD_TEXT_DOMAIN)
		);
		
		$data['font-style'] = array(
			'normal' => __('Normal', YCD_TEXT_DOMAIN),
			'italic' => __('Italic', YCD_TEXT_DOMAIN),
			'initial' => __('Initial', YCD_TEXT_DOMAIN)
		);

		$data['woo-countdown-positions'] = array(
			1 => __('Above the Title', YCD_TEXT_DOMAIN),
			5 => __('Below the Title', YCD_TEXT_DOMAIN),
			10 => __('Below the Price', YCD_TEXT_DOMAIN),
			20 => __('Below Short Description', YCD_TEXT_DOMAIN),
			30 => __('Below Add to Cart Button', YCD_TEXT_DOMAIN),
		);

        $data['showing-animation'] = array(
            'No effect' => __('None', YCD_TEXT_DOMAIN),
            'ycd-flip' => __('Flip', YCD_TEXT_DOMAIN),
            'ycd-shake' => __('Shake', YCD_TEXT_DOMAIN),
            'ycd-wobble' => __('Wobble', YCD_TEXT_DOMAIN),
            'ycd-swing' => __('Swing', YCD_TEXT_DOMAIN),
            'ycd-flash' => __('Flash', YCD_TEXT_DOMAIN),
            'ycd-bounce' => __('Bounce', YCD_TEXT_DOMAIN),
            'ycd-bounceInRight' => __('BounceInRight', YCD_TEXT_DOMAIN),
            'ycd-bounceIn' => __('BounceIn', YCD_TEXT_DOMAIN),
            'ycd-pulse' => __('Pulse', YCD_TEXT_DOMAIN),
            'ycd-rubberBand' => __('RubberBand', YCD_TEXT_DOMAIN),
            'ycd-tada' => __('Tada', YCD_TEXT_DOMAIN),
            'ycd-slideInUp' => __('SlideInUp', YCD_TEXT_DOMAIN),
            'ycd-jello' => __('Jello', YCD_TEXT_DOMAIN),
            'ycd-rotateIn' => __('RotateIn', YCD_TEXT_DOMAIN),
            'ycd-fadeIn' => __('FadeIn', YCD_TEXT_DOMAIN)
        );
		
		$data['font-family'] = array(
			'inherit' => 'Inherit',
			'Century Gothic' => 'Century Gothic',
			'Diplomata SC' => 'Diplomata SC',
			'flavors' => 'Flavors',
			'Open Sans' => 'Open Sans',
			'Droid Sans' =>'Droid Sans',
			'Droid Serif' => 'Droid Serif',
			'chewy' => 'Chewy',
			'oswald' => 'Oswald',
			'Dancing Script' => 'Dancing Script',
			'Merriweather' => 'Merriweather',
			'Roboto Condensed' => 'Roboto Condensed',
			'Oswald' => 'Oswald',
			'PT Sans' => 'PT Sans',
			'Montserrat' => 'Montserrat',
            'customFont' => 'Custom font'
		);

		$data['woo-products'] = self::getAllProducts();
		
		$data['countdown-behavior'] =array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-button-behavior',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-button-redirect',
						'value' => 'redirect'
					),
					'label' => array(
						'name' => __('Redirect', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-button-behavior',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-button-scroll',
						'value' => 'scroll'
					),
					'label' => array(
						'name' => __('Scroll', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-button-behavior',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-button-download',
						'value' => 'download'
					),
					'label' => array(
						'name' => __('Download File', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-button-behavior',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-button-copy',
						'value' => 'copy'
					),
					'label' => array(
						'name' => __('Copy to clipboard', YCD_TEXT_DOMAIN)
					)
				),
			)
		);
		
		$data['comingSoonModes'] =array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-coming-soon-mode',
						'class' => 'ycd-coming-soon-maintenance ycd-form-radio',
						'data-attr-href' => 'ycd-coming-soon-redirect',
						'value' => 'comingSoonMode'
					),
					'label' => array(
						'name' => __('Coming soon', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-coming-soon-mode',
						'class' => 'ycd-coming-soon-maintenance ycd-form-radio',
						'data-attr-href' => 'ycd-coming-soon-maintenance',
						'value' => 'maintenanceMode'
					),
					'label' => array(
						'name' => __('Maintenance', YCD_TEXT_DOMAIN)
					)
				)
			)
		);

		$data['stickyCountdownMode'] =array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-sticky-countdown-mode',
						'class' => ' ycd-form-radio',
						'data-attr-href' => 'ycd-sticky-countdown-default',
						'value' => 'stickyCountdownDefault'
					),
					'label' => array(
						'name' => __('Default', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-sticky-countdown-mode',
						'class' => 'ycd-form-radio',
						'data-attr-href' => 'ycd-sticky-countdown-custom',
						'value' => 'stickyCountdownCustom'
					),
					'label' => array(
						'name' => __('Custom', YCD_TEXT_DOMAIN)
					)
				)
			)
		);

		$data['woo-show-products'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-woo-show-products',
						'class' => 'ycd-woo-show-products',
						'value' => 'showOnAll'
					),
					'label' => array(
						'name' => __('Show on all products', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-woo-show-products',
						'class' => 'ycd-woo-show-products',
						'data-attr-href' => 'ycd-woo-selected-products',
						'value' => 'selectedProducts'
					),
					'label' => array(
						'name' => __('Show on all selected products', YCD_TEXT_DOMAIN)
					)
				)
			)
		);
		$countdownDateTypeFields = array(
			array(
				'attr' => array(
					'type' => 'radio',
					'name' => 'ycd-countdown-date-type',
					'class' => 'ycd-date-type ycd-form-radio',
					'data-attr-href' => 'ycd-countdown-due-date',
					'value' => 'dueDate'
				),
				'label' => array(
					'name' => __('Due Date', YCD_TEXT_DOMAIN)
				)
			),
			array(
				'attr' => array(
					'type' => 'radio',
					'name' => 'ycd-countdown-date-type',
					'class' => 'ycd-date-type ycd-form-radio',
					'data-attr-href' => 'ycd-date-duration',
					'value' => 'duration'
				),
				'label' => array(
					'name' => __('Duration', YCD_TEXT_DOMAIN)
				)
			)
		);
		

		if(YCD_PKG_VERSION != YCD_SILVER_VERSION) {
			$countdownDateTypeFields[] = array(
				'attr' => array(
					'type' => 'radio',
					'name' => 'ycd-countdown-date-type',
					'class' => 'ycd-date-type',
					'data-attr-href' => 'ycd-date-schedule',
					'value' => 'schedule'
				),
				'label' => array(
					'name' => __('Schedule 1', YCD_TEXT_DOMAIN)
				)
			);
			
			$countdownDateTypeFields[] = array(
				'attr' => array(
					'type' => 'radio',
					'name' => 'ycd-countdown-date-type',
					'class' => 'ycd-date-type',
					'data-attr-href' => 'ycd-date-schedule2',
					'value' => 'schedule2'
				),
				'label' => array(
					'name' => __('Schedule 2', YCD_TEXT_DOMAIN)
				)
			);

			$countdownDateTypeFields[] = array(
				'attr' => array(
					'type' => 'radio',
					'name' => 'ycd-countdown-date-type',
					'class' => 'ycd-date-type',
					'data-attr-href' => 'ycd-date-schedule3',
					'value' => 'schedule3'
				),
				'label' => array(
					'name' => __('Upcoming Day Of Week (Recurring)', YCD_TEXT_DOMAIN)
				)
			);
			$countdownDateTypeFields[] = array(
				'attr' => array(
					'type' => 'radio',
					'name' => 'ycd-countdown-date-type',
					'class' => 'ycd-date-type',
					'data-attr-href' => 'ycd-date-wooCoupon',
					'value' => 'wooCoupon'
				),
				'label' => array(
					'name' => __('WooCommerce Coupon', YCD_TEXT_DOMAIN)
				)
			);
		}

		$data['countdown-date-type'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => $countdownDateTypeFields
		);

		$data['clockMode'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-clock-mode',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio ycd-timer-mode',
						'data-attr-href' => 'ycd-countdown-clock-mode-clock',
						'value' => 'clock'
					),
					'label' => array(
						'name' => __('Clock', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-clock-mode',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio ycd-timer-mode',
						'data-attr-href' => 'ycd-countdown-clock-mode-countdown',
						'value' => 'timer'
					),
					'label' => array(
						'name' => __('Timer', YCD_TEXT_DOMAIN)
					)
				)
			)
		);

		$data['countdownExpireTime'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-expire-behavior',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-default-behavior',
						'value' => 'default'
					),
					'label' => array(
						'name' => __('Default', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-expire-behavior',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-hide-behavior',
						'value' => 'hideCountdown'
					),
					'label' => array(
						'name' => __('Hide Countdown', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-expire-behavior',
						'class' => 'ycd-countdown-hide-behavior ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-countUp-behavior',
						'value' => 'countToUp'
					),
					'label' => array(
						'name' => __('Count Up', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-expire-behavior',
						'class' => 'ycd-countdown-show-text ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-show-text',
						'value' => 'showText'
					),
					'label' => array(
						'name' => __('Show Text', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-countdown-expire-behavior',
						'class' => 'ycd-countdown-redirect-url ycd-form-radio',
						'data-attr-href' => 'ycd-countdown-redirect-url',
						'value' => 'redirectToURL'
					),
					'label' => array(
						'name' => __('Redirect To URL', YCD_TEXT_DOMAIN)
					)
				)
			)
		);

		$data['stickyButtonExpiration'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-sticky-expire-behavior',
						'class' => 'ycd-sticky-expire-redirect-url ycd-form-radio',
						'data-attr-href' => 'ycd-sticky-expire-redirect-url',
						'value' => 'redirectToURL'
					),
					'label' => array(
						'name' => __('Redirect To URL', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-sticky-expire-behavior',
						'class' => 'ycd-sticky-expire-copy ycd-form-radio',
						'data-attr-href' => 'ycd-sticky-expire-copy',
						'value' => 'copy'
					),
					'label' => array(
						'name' => __('Copy to clipboard', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-sticky-expire-behavior',
						'class' => 'ycd-sticky-expire-copy ycd-form-radio',
						'data-attr-href' => '',
						'value' => 'closeBanner'
					),
					'label' => array(
						'name' => __('Close', YCD_TEXT_DOMAIN)
					)
				)
			)
		);

		$data['countdownFlipExpireTime'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-7 ycd-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-5 ycd-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group ycd-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-flip-countdown-expire-behavior',
						'class' => 'ycd-flip-countdown-hide-behavior',
						'data-attr-href' => 'ycd-flip-countdown-default-behavior',
						'value' => 'default'
					),
					'label' => array(
						'name' => __('Default', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-flip-countdown-expire-behavior',
						'class' => 'ycd-flip-countdown-hide-behavior',
						'data-attr-href' => 'ycd-flip-countdown-hide-behavior',
						'value' => 'hideCountdown'
					),
					'label' => array(
						'name' => __('Hide Countdown', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-flip-countdown-expire-behavior',
						'class' => 'ycd-flip-countdown-show-text',
						'data-attr-href' => 'ycd-flip-countdown-show-text',
						'value' => 'showText'
					),
					'label' => array(
						'name' => __('Show Text', YCD_TEXT_DOMAIN)
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'ycd-flip-countdown-expire-behavior',
						'class' => 'ycd-flip-countdown-redirect-url',
						'data-attr-href' => 'ycd-flip-countdown-redirect-url',
						'value' => 'redirectToURL'
					),
					'label' => array(
						'name' => __('Redirect To URL', YCD_TEXT_DOMAIN)
					)
				)
			)
		);

		$data['time-zone'] = self::getTimeZones();

        $data['clock-mode'] = array(
            '24' => '24h',
            '12' => '12h'
        );

		$timeZone = array('' => __('Current time zone', YCD_TEXT_DOMAIN))+self::getTimeZones();
		$data['clock-time-zone'] = $timeZone;

		$data['horizontal-alignment'] = array(
			'left' => __('Left', YCD_TEXT_DOMAIN),
			'center' => __('Center', YCD_TEXT_DOMAIN),
			'right' => __('Right', YCD_TEXT_DOMAIN)
		);

		$data['position-countdown'] = array(
			'top_left' => __('Top Left', YCD_TEXT_DOMAIN),
			'top_center' => __('Top Center', YCD_TEXT_DOMAIN),
			'top_right' => __('Top Right', YCD_TEXT_DOMAIN),
			'bottom_left' => __('Bottom Left', YCD_TEXT_DOMAIN),
			'bottom_center' => __('Bottom Center', YCD_TEXT_DOMAIN),
			'bottom_right' => __('Bottom Right', YCD_TEXT_DOMAIN),
		);

		$data['userRoles'] = self::getAllUserRoles();
		$data['countries-names'] = apply_filters('ycdCountries', array());
		$data['countries-is'] = array(
			'is' => __('Is', YCD_TEXT_DOMAIN),
			'isNot' => __('Is not', YCD_TEXT_DOMAIN),
		);
		$data['stickySectionsOrder'] = array(
			'Text-Countdown-Button' => __('Text Countdown Button', YCD_TEXT_DOMAIN),
			'Text-Button-Countdown' => __('Text Button Countdown', YCD_TEXT_DOMAIN),
			'Countdown-Text-Button' => __('Countdown Text Button', YCD_TEXT_DOMAIN),
			'Countdown-Button-Text' => __('Countdown Button Text', YCD_TEXT_DOMAIN),
			'Button-Text-Countdown' => __('Button Text Countdown', YCD_TEXT_DOMAIN),
			'Button-Countdown-Text' => __('Button Countdown Text', YCD_TEXT_DOMAIN),
			'Text-Countdown' => __('Text Countdown', YCD_TEXT_DOMAIN),
			'Countdown-Text' => __('Countdown Text', YCD_TEXT_DOMAIN),
			'Button-Countdown' => __('Button Countdown', YCD_TEXT_DOMAIN),
			'Countdown-Button' => __('Countdown Button', YCD_TEXT_DOMAIN)
		);
		
		$data['coming-soon-countdown-position'] = array(
			'YcdComingSoonPageBeforeHeader' => 'Before Header',
			'YcdComingSoonPageHeader' => 'Header',
			'YcdComingSoonPageAfterHeader' => 'After Header',
			'YcdComingSoonPageBeforeMessage' => 'Before Message',
			'YcdComingSoonPageMessage' => 'Message',
			'YcdComingSoonPageAfterMessage' => 'After Message',
		);

		return apply_filters('ycdDefaults', $data);
	}

	public static function getAllUserRoles() {
		$rulesArray = array();
		if(!function_exists('get_editable_roles')){
			return $rulesArray;
		}

		$roles = get_editable_roles();
		foreach($roles as $roleName => $roleInfo) {

			if($roleName == 'administrator') {
				continue;
			}
			$rulesArray[$roleName] = $roleName;
		}

		return $rulesArray;
	}

	public static function selectBox($data = array(), $selectedValue = array(), $attrs = array()) {

		$attrString = '';
		$selected = '';

		if(!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		$selectBox = '<select '.$attrString.'>';

		foreach ($data as $value => $label) {

			/*When is multiselect*/
			if(is_array($selectedValue)) {
				$isSelected = in_array($value, $selectedValue);
				if($isSelected) {
					$selected = 'selected';
				}
			}
			else if($selectedValue == $value) {
				$selected = 'selected';
			}
			else if(is_array($value) && in_array($selectedValue, $value)) {
				$selected = 'selected';
			}

			$selectBox .= '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
			$selected = '';
		}

		$selectBox .= '</select>';

		return $selectBox;
	}

	/**
	 * ToDo add description for this function
	 * @param $date
	 * @return string
	 */
	public static function getFormattedDate($date) {
		$date = strtotime($date);
		$month = date('F', $date);
		$year = date('Y', $date);

		return $month.' '.$year;
	}

	/**
	 * Create html attrs
	 *
	 * @since 1.0.9
	 *
	 * @param array $attrs
	 *
	 * @return string $attrStr
	 */
	public static function createAttrs($attrs)
	{
		$attrStr = '';

		if (empty($attrs)) {
			return $attrStr;
		}

		foreach ($attrs as $attrKey => $attrValue) {
			$attrStr .= $attrKey.'="'.$attrValue.'" ';
		}

		return $attrStr;
	}

	/**
	 * Create Radio buttons
	 *
	 * @since 1.0.9
	 *
	 * @param array $data
	 * @param string $savedValue
	 * @param array $attrs
	 *
	 * @return string
	 */
	public static function createRadioButtons($data, $savedValue, $attrs = array()) {

		$attrString = '';
		$selected = '';

		if(!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		$radioButtons = '';

		foreach($data as $value) {

			$checked = '';
			if($value == $savedValue) {
				$checked = 'checked';
			}

			$radioButtons .= "<input type=\"radio\" value=\"$value\" $attrString  $checked>";
		}

		return $radioButtons;
	}

	public static function getCurrentUserRole()
	{
		$role = 'administrator';

		if (is_multisite()) {

			$getUsersObj = get_users(
				array(
					'blog_id' => get_current_blog_id()
				)
			);
			if (is_array($getUsersObj)) {
				foreach ($getUsersObj as $key => $userData) {
					if ($userData->ID == get_current_user_id()) {
						$roles = $userData->roles;
						if (is_array($roles) && !empty($roles)) {
							$role = $roles[0];
						}
					}
				}
			}

			return $role;
		}

		global $current_user, $wpdb;
		$userRoleKey = $wpdb->prefix . 'capabilities';
		if(!empty($current_user->$userRoleKey)) {
			$usersRoles = array_keys(@$current_user->$userRoleKey);
		}

		if (!empty($usersRoles) && is_array($usersRoles)) {
			$role = $usersRoles[0];
		}

		return $role;
	}

	public static function getCountdownPostAllowedUserRoles() {
		$userSavedRoles = get_option('ycd-user-roles');

		if (!$userSavedRoles) {
			$userSavedRoles = array('administrator');
		}
		else {
				array_push($userSavedRoles, 'administrator');
			}

		return $userSavedRoles;
	}

	public static function showMenuForCurrentUser() {
		$savedUserRoles = self::getCountdownPostAllowedUserRoles();
		$currentUserRole = AdminHelper::getCurrentUserRole();

		return in_array($currentUserRole, $savedUserRoles);
 	}

	public static function subscribersRelatedQuery($query = '')
	{
		global $wpdb;
		$subscribersTablename = $wpdb->prefix.YCD_COUNTDOWN_SUBSCRIBERS_TABLE;
		$postsTablename = $wpdb->prefix.YCD_POSTS_TABLE_NAME;

		if ($query == '') {
			$query = 'SELECT email, cDate, '.$postsTablename.'.post_title AS type FROM '.$subscribersTablename.' ';
		}
		$searchQuery = '';
		$filterCriteria = '';

		$query .= ' LEFT JOIN '.$postsTablename.' ON '.$postsTablename.'.ID='.$subscribersTablename.'.type';

		if (isset($_GET['ycd-subscription-id']) && !empty($_GET['ycd-subscription-id'])) {
			$filterCriteria = esc_sql($_GET['ycd-subscription-id']);
			if ($filterCriteria != 'all') {
				$searchQuery .= $subscribersTablename.".type = $filterCriteria";
			}
		}
		if ($filterCriteria != '' && $filterCriteria != 'all' && isset($_GET['s']) && !empty($_GET['s'])) {
			$searchQuery .= ' LIKE ';
		}
		if (isset($_GET['s']) && !empty($_GET['s'])) {
			$searchCriteria = esc_sql($_GET['s']);
			$searchQuery .= " email LIKE '%$searchCriteria%' or $postsTablename.post_title LIKE '%$searchCriteria%'";
		}
		if (isset($_GET['ycd-subscribers-dates']) && !empty($_GET['ycd-subscribers-dates'])) {
			$filterCriteria = esc_sql($_GET['ycd-subscribers-dates']);
			if ($filterCriteria != 'all') {
				if ($searchQuery != '') {
					$searchQuery .= ' AND ';
				}
				$searchQuery .= " cDate LIKE '$filterCriteria%'";
			}
		}
		if ($searchQuery != '') {
			$query .= " WHERE ($searchQuery)";
		}

		return $query;
	}

	public static function getTimeZones() {

		return array(
			"" => "Per User",
			"Pacific/Midway"=>"(GMT-11:00) Midway",
			"Pacific/Niue"=>"(GMT-11:00) Niue",
			"Pacific/Pago_Pago"=>"(GMT-11:00) Pago Pago",
			"Pacific/Honolulu"=>"(GMT-10:00) Hawaii Time",
			"Pacific/Rarotonga"=>"(GMT-10:00) Rarotonga",
			"Pacific/Tahiti"=>"(GMT-10:00) Tahiti",
			"Pacific/Marquesas"=>"(GMT-09:30) Marquesas",
			"America/Anchorage"=>"(GMT-09:00) Alaska Time",
			"Pacific/Gambier"=>"(GMT-09:00) Gambier",
			"America/Los_Angeles"=>"(GMT-08:00) Pacific Time",
			"America/Tijuana"=>"(GMT-08:00) Pacific Time - Tijuana",
			"America/Vancouver"=>"(GMT-08:00) Pacific Time - Vancouver",
			"America/Whitehorse"=>"(GMT-08:00) Pacific Time - Whitehorse",
			"Pacific/Pitcairn"=>"(GMT-08:00) Pitcairn",
			"America/Dawson_Creek"=>"(GMT-07:00) Mountain Time - Dawson Creek",
			"America/Denver"=>"(GMT-07:00) Mountain Time",
			"America/Edmonton"=>"(GMT-07:00) Mountain Time - Edmonton",
			"America/Hermosillo"=>"(GMT-07:00) Mountain Time - Hermosillo",
			"America/Mazatlan"=>"(GMT-07:00) Mountain Time - Chihuahua, Mazatlan",
			"America/Phoenix"=>"(GMT-07:00) Mountain Time - Arizona",
			"America/Yellowknife"=>"(GMT-07:00) Mountain Time - Yellowknife",
			"America/Belize"=>"(GMT-06:00) Belize",
			"America/Chicago"=>"(GMT-06:00) Central Time",
			"America/Costa_Rica"=>"(GMT-06:00) Costa Rica",
			"America/El_Salvador"=>"(GMT-06:00) El Salvador",
			"America/Guatemala"=>"(GMT-06:00) Guatemala",
			"America/Managua"=>"(GMT-06:00) Managua",
			"America/Mexico_City"=>"(GMT-06:00) Central Time - Mexico City",
			"America/Regina"=>"(GMT-06:00) Central Time - Regina",
			"America/Tegucigalpa"=>"(GMT-06:00) Central Time - Tegucigalpa",
			"America/Winnipeg"=>"(GMT-06:00) Central Time - Winnipeg",
			"Pacific/Easter"=>"(GMT-06:00) Easter Island",
			"Pacific/Galapagos"=>"(GMT-06:00) Galapagos",
			"America/Bogota"=>"(GMT-05:00) Bogota",
			"America/Cayman"=>"(GMT-05:00) Cayman",
			"America/Guayaquil"=>"(GMT-05:00) Guayaquil",
			"America/Havana"=>"(GMT-05:00) Havana",
			"America/Iqaluit"=>"(GMT-05:00) Eastern Time - Iqaluit",
			"America/Jamaica"=>"(GMT-05:00) Jamaica",
			"America/Lima"=>"(GMT-05:00) Lima",
			"America/Montreal"=>"(GMT-05:00) Eastern Time - Montreal",
			"America/Nassau"=>"(GMT-05:00) Nassau",
			"America/New_York"=>"(GMT-05:00) Eastern Time",
			"America/Panama"=>"(GMT-05:00) Panama",
			"America/Port-au-Prince"=>"(GMT-05:00) Port-au-Prince",
			"America/Rio_Branco"=>"(GMT-05:00) Rio Branco",
			"America/Toronto"=>"(GMT-05:00) Eastern Time - Toronto",
			"America/Caracas"=>"(GMT-04:30) Caracas",
			"America/Antigua"=>"(GMT-04:00) Antigua",
			"America/Asuncion"=>"(GMT-04:00) Asuncion",
			"America/Barbados"=>"(GMT-04:00) Barbados",
			"America/Boa_Vista"=>"(GMT-04:00) Boa Vista",
			"America/Campo_Grande"=>"(GMT-04:00) Campo Grande",
			"America/Cuiaba"=>"(GMT-04:00) Cuiaba",
			"America/Curacao"=>"(GMT-04:00) Curacao",
			"America/Grand_Turk"=>"(GMT-04:00) Grand Turk",
			"America/Guyana"=>"(GMT-04:00) Guyana",
			"America/Halifax"=>"(GMT-04:00) Atlantic Time - Halifax",
			"America/La_Paz"=>"(GMT-04:00) La Paz",
			"America/Manaus"=>"(GMT-04:00) Manaus",
			"America/Martinique"=>"(GMT-04:00) Martinique",
			"America/Port_of_Spain"=>"(GMT-04:00) Port of Spain",
			"America/Porto_Velho"=>"(GMT-04:00) Porto Velho",
			"America/Puerto_Rico"=>"(GMT-04:00) Puerto Rico",
			"America/Santiago"=>"(GMT-04:00) Santiago",
			"America/Santo_Domingo"=>"(GMT-04:00) Santo Domingo",
			"America/Thule"=>"(GMT-04:00) Thule",
			"Antarctica/Palmer"=>"(GMT-04:00) Palmer",
			"Atlantic/Bermuda"=>"(GMT-04:00) Bermuda",
			"America/St_Johns"=>"(GMT-03:30) Newfoundland Time - St. Johns",
			"America/Araguaina"=>"(GMT-03:00) Araguaina",
			"America/Argentina/Buenos_Aires"=>"(GMT-03:00) Buenos Aires",
			"America/Bahia"=>"(GMT-03:00) Salvador",
			"America/Belem"=>"(GMT-03:00) Belem",
			"America/Cayenne"=>"(GMT-03:00) Cayenne",
			"America/Fortaleza"=>"(GMT-03:00) Fortaleza",
			"America/Godthab"=>"(GMT-03:00) Godthab",
			"America/Maceio"=>"(GMT-03:00) Maceio",
			"America/Miquelon"=>"(GMT-03:00) Miquelon",
			"America/Montevideo"=>"(GMT-03:00) Montevideo",
			"America/Paramaribo"=>"(GMT-03:00) Paramaribo",
			"America/Recife"=>"(GMT-03:00) Recife",
			"America/Sao_Paulo"=>"(GMT-03:00) Sao Paulo",
			"Antarctica/Rothera"=>"(GMT-03:00) Rothera",
			"Atlantic/Stanley"=>"(GMT-03:00) Stanley",
			"America/Noronha"=>"(GMT-02:00) Noronha",
			"Atlantic/South_Georgia"=>"(GMT-02:00) South Georgia",
			"America/Scoresbysund"=>"(GMT-01:00) Scoresbysund",
			"Atlantic/Azores"=>"(GMT-01:00) Azores",
			"Atlantic/Cape_Verde"=>"(GMT-01:00) Cape Verde",
			"Africa/Abidjan"=>"(GMT+00:00) Abidjan",
			"Africa/Accra"=>"(GMT+00:00) Accra",
			"Africa/Bissau"=>"(GMT+00:00) Bissau",
			"Africa/Casablanca"=>"(GMT+00:00) Casablanca",
			"Africa/El_Aaiun"=>"(GMT+00:00) El Aaiun",
			"Africa/Monrovia"=>"(GMT+00:00) Monrovia",
			"America/Danmarkshavn"=>"(GMT+00:00) Danmarkshavn",
			"Atlantic/Canary"=>"(GMT+00:00) Canary Islands",
			"Atlantic/Faroe"=>"(GMT+00:00) Faeroe",
			"Atlantic/Reykjavik"=>"(GMT+00:00) Reykjavik",
			"Etc/GMT"=>"(GMT+00:00) GMT (no daylight saving)",
			"Europe/Dublin"=>"(GMT+00:00) Dublin",
			"Europe/Lisbon"=>"(GMT+00:00) Lisbon",
			"Europe/London"=>"(GMT+00:00) London",
			"Africa/Algiers"=>"(GMT+01:00) Algiers",
			"Africa/Ceuta"=>"(GMT+01:00) Ceuta",
			"Africa/Lagos"=>"(GMT+01:00) Lagos",
			"Africa/Ndjamena"=>"(GMT+01:00) Ndjamena",
			"Africa/Tunis"=>"(GMT+01:00) Tunis",
			"Africa/Windhoek"=>"(GMT+01:00) Windhoek",
			"Europe/Amsterdam"=>"(GMT+01:00) Amsterdam",
			"Europe/Andorra"=>"(GMT+01:00) Andorra",
			"Europe/Belgrade"=>"(GMT+01:00) Central European Time - Belgrade",
			"Europe/Berlin"=>"(GMT+01:00) Berlin",
			"Europe/Brussels"=>"(GMT+01:00) Brussels",
			"Europe/Budapest"=>"(GMT+01:00) Budapest",
			"Europe/Copenhagen"=>"(GMT+01:00) Copenhagen",
			"Europe/Gibraltar"=>"(GMT+01:00) Gibraltar",
			"Europe/Luxembourg"=>"(GMT+01:00) Luxembourg",
			"Europe/Madrid"=>"(GMT+01:00) Madrid",
			"Europe/Malta"=>"(GMT+01:00) Malta",
			"Europe/Monaco"=>"(GMT+01:00) Monaco",
			"Europe/Oslo"=>"(GMT+01:00) Oslo",
			"Europe/Paris"=>"(GMT+01:00) Paris",
			"Europe/Prague"=>"(GMT+01:00) Central European Time - Prague",
			"Europe/Rome"=>"(GMT+01:00) Rome",
			"Europe/Stockholm"=>"(GMT+01:00) Stockholm",
			"Europe/Tirane"=>"(GMT+01:00) Tirane",
			"Europe/Vienna"=>"(GMT+01:00) Vienna",
			"Europe/Warsaw"=>"(GMT+01:00) Warsaw",
			"Europe/Zurich"=>"(GMT+01:00) Zurich",
			"Africa/Cairo"=>"(GMT+02:00) Cairo",
			"Africa/Johannesburg"=>"(GMT+02:00) Johannesburg",
			"Africa/Maputo"=>"(GMT+02:00) Maputo",
			"Africa/Tripoli"=>"(GMT+02:00) Tripoli",
			"Asia/Amman"=>"(GMT+02:00) Amman",
			"Asia/Beirut"=>"(GMT+02:00) Beirut",
			"Asia/Damascus"=>"(GMT+02:00) Damascus",
			"Asia/Gaza"=>"(GMT+02:00) Gaza",
			"Asia/Jerusalem"=>"(GMT+02:00) Jerusalem",
			"Asia/Nicosia"=>"(GMT+02:00) Nicosia",
			"Europe/Athens"=>"(GMT+02:00) Athens",
			"Europe/Bucharest"=>"(GMT+02:00) Bucharest",
			"Europe/Chisinau"=>"(GMT+02:00) Chisinau",
			"Europe/Helsinki"=>"(GMT+02:00) Helsinki",
			"Europe/Istanbul"=>"(GMT+02:00) Istanbul",
			"Europe/Kaliningrad"=>"(GMT+02:00) Moscow-01 - Kaliningrad",
			"Europe/Kiev"=>"(GMT+02:00) Kiev",
			"Europe/Riga"=>"(GMT+02:00) Riga",
			"Europe/Sofia"=>"(GMT+02:00) Sofia",
			"Europe/Tallinn"=>"(GMT+02:00) Tallinn",
			"Europe/Vilnius"=>"(GMT+02:00) Vilnius",
			"Africa/Addis_Ababa"=>"(GMT+03:00) Addis Ababa",
			"Africa/Asmara"=>"(GMT+03:00) Asmera",
			"Africa/Dar_es_Salaam"=>"(GMT+03:00) Dar es Salaam",
			"Africa/Djibouti"=>"(GMT+03:00) Djibouti",
			"Africa/Kampala"=>"(GMT+03:00) Kampala",
			"Africa/Khartoum"=>"(GMT+03:00) Khartoum",
			"Africa/Mogadishu"=>"(GMT+03:00) Mogadishu",
			"Africa/Nairobi"=>"(GMT+03:00) Nairobi",
			"Antarctica/Syowa"=>"(GMT+03:00) Syowa",
			"Asia/Aden"=>"(GMT+03:00) Aden",
			"Asia/Baghdad"=>"(GMT+03:00) Baghdad",
			"Asia/Bahrain"=>"(GMT+03:00) Bahrain",
			"Asia/Kuwait"=>"(GMT+03:00) Kuwait",
			"Asia/Qatar"=>"(GMT+03:00) Qatar",
			"Asia/Riyadh"=>"(GMT+03:00) Riyadh",
			"Europe/Minsk"=>"(GMT+03:00) Minsk",
			"Europe/Moscow"=>"(GMT+03:00) Moscow+00",
			"Indian/Antananarivo"=>"(GMT+03:00) Antananarivo",
			"Indian/Comoro"=>"(GMT+03:00) Comoro",
			"Indian/Mayotte"=>"(GMT+03:00) Mayotte",
			"Asia/Tehran"=>"(GMT+03:30) Tehran",
			"Asia/Baku"=>"(GMT+04:00) Baku",
			"Asia/Dubai"=>"(GMT+04:00) Dubai",
			"Asia/Muscat"=>"(GMT+04:00) Muscat",
			"Asia/Tbilisi"=>"(GMT+04:00) Tbilisi",
			"Asia/Yerevan"=>"(GMT+04:00) Yerevan",
			"Europe/Samara"=>"(GMT+04:00) Moscow+00 - Samara",
			"Indian/Mahe"=>"(GMT+04:00) Mahe",
			"Indian/Mauritius"=>"(GMT+04:00) Mauritius",
			"Indian/Reunion"=>"(GMT+04:00) Reunion",
			"Asia/Kabul"=>"(GMT+04:30) Kabul",
			"Antarctica/Mawson"=>"(GMT+05:00) Mawson",
			"Asia/Aqtau"=>"(GMT+05:00) Aqtau",
			"Asia/Aqtobe"=>"(GMT+05:00) Aqtobe",
			"Asia/Ashgabat"=>"(GMT+05:00) Ashgabat",
			"Asia/Dushanbe"=>"(GMT+05:00) Dushanbe",
			"Asia/Karachi"=>"(GMT+05:00) Karachi",
			"Asia/Tashkent"=>"(GMT+05:00) Tashkent",
			"Asia/Yekaterinburg"=>"(GMT+05:00) Moscow+02 - Yekaterinburg",
			"Indian/Kerguelen"=>"(GMT+05:00) Kerguelen",
			"Indian/Maldives"=>"(GMT+05:00) Maldives",
			"Asia/Calcutta"=>"(GMT+05:30) India Standard Time",
			"Asia/Colombo"=>"(GMT+05:30) Colombo",
			"Asia/Katmandu"=>"(GMT+05:45) Katmandu",
			"Antarctica/Vostok"=>"(GMT+06:00) Vostok",
			"Asia/Almaty"=>"(GMT+06:00) Almaty",
			"Asia/Bishkek"=>"(GMT+06:00) Bishkek",
			"Asia/Dhaka"=>"(GMT+06:00) Dhaka",
			"Asia/Omsk"=>"(GMT+06:00) Moscow+03 - Omsk, Novosibirsk",
			"Asia/Thimphu"=>"(GMT+06:00) Thimphu",
			"Indian/Chagos"=>"(GMT+06:00) Chagos",
			"Asia/Rangoon"=>"(GMT+06:30) Rangoon",
			"Indian/Cocos"=>"(GMT+06:30) Cocos",
			"Antarctica/Davis"=>"(GMT+07:00) Davis",
			"Asia/Bangkok"=>"(GMT+07:00) Bangkok",
			"Asia/Hovd"=>"(GMT+07:00) Hovd",
			"Asia/Jakarta"=>"(GMT+07:00) Jakarta",
			"Asia/Krasnoyarsk"=>"(GMT+07:00) Moscow+04 - Krasnoyarsk",
			"Asia/Saigon"=>"(GMT+07:00) Hanoi",
			"Indian/Christmas"=>"(GMT+07:00) Christmas",
			"Antarctica/Casey"=>"(GMT+08:00) Casey",
			"Asia/Brunei"=>"(GMT+08:00) Brunei",
			"Asia/Choibalsan"=>"(GMT+08:00) Choibalsan",
			"Asia/Hong_Kong"=>"(GMT+08:00) Hong Kong",
			"Asia/Irkutsk"=>"(GMT+08:00) Moscow+05 - Irkutsk",
			"Asia/Kuala_Lumpur"=>"(GMT+08:00) Kuala Lumpur",
			"Asia/Macau"=>"(GMT+08:00) Macau",
			"Asia/Makassar"=>"(GMT+08:00) Makassar",
			"Asia/Manila"=>"(GMT+08:00) Manila",
			"Asia/Shanghai"=>"(GMT+08:00) China Time - Beijing",
			"Asia/Singapore"=>"(GMT+08:00) Singapore",
			"Asia/Taipei"=>"(GMT+08:00) Taipei",
			"Asia/Ulaanbaatar"=>"(GMT+08:00) Ulaanbaatar",
			"Australia/Perth"=>"(GMT+08:00) Western Time - Perth",
			"Asia/Dili"=>"(GMT+09:00) Dili",
			"Asia/Jayapura"=>"(GMT+09:00) Jayapura",
			"Asia/Pyongyang"=>"(GMT+09:00) Pyongyang",
			"Asia/Seoul"=>"(GMT+09:00) Seoul",
			"Asia/Tokyo"=>"(GMT+09:00) Tokyo",
			"Asia/Yakutsk"=>"(GMT+09:00) Moscow+06 - Yakutsk",
			"Pacific/Palau"=>"(GMT+09:00) Palau",
			"Australia/Adelaide"=>"(GMT+09:30) Central Time - Adelaide",
			"Australia/Darwin"=>"(GMT+09:30) Central Time - Darwin",
			"Antarctica/DumontDUrville"=>"(GMT+10:00) Dumont D'Urville",
			"Asia/Magadan"=>"(GMT+10:00) Moscow+08 - Magadan",
			"Asia/Vladivostok"=>"(GMT+10:00) Moscow+07 - Yuzhno-Sakhalinsk",
			"Australia/Brisbane"=>"(GMT+10:00) Eastern Time - Brisbane",
			"Australia/Hobart"=>"(GMT+10:00) Eastern Time - Hobart",
			"Australia/Sydney"=>"(GMT+10:00) Eastern Time - Melbourne, Sydney",
			"Pacific/Chuuk"=>"(GMT+10:00) Truk",
			"Pacific/Guam"=>"(GMT+10:00) Guam",
			"Pacific/Port_Moresby"=>"(GMT+10:00) Port Moresby",
			"Pacific/Saipan"=>"(GMT+10:00) Saipan",
			"Pacific/Efate"=>"(GMT+11:00) Efate",
			"Pacific/Guadalcanal"=>"(GMT+11:00) Guadalcanal",
			"Pacific/Kosrae"=>"(GMT+11:00) Kosrae",
			"Pacific/Noumea"=>"(GMT+11:00) Noumea",
			"Pacific/Pohnpei"=>"(GMT+11:00) Ponape",
			"Pacific/Norfolk"=>"(GMT+11:30) Norfolk",
			"Asia/Kamchatka"=>"(GMT+12:00) Moscow+08 - Petropavlovsk-Kamchatskiy",
			"Pacific/Auckland"=>"(GMT+12:00) Auckland",
			"Pacific/Fiji"=>"(GMT+12:00) Fiji",
			"Pacific/Funafuti"=>"(GMT+12:00) Funafuti",
			"Pacific/Kwajalein"=>"(GMT+12:00) Kwajalein",
			"Pacific/Majuro"=>"(GMT+12:00) Majuro",
			"Pacific/Nauru"=>"(GMT+12:00) Nauru",
			"Pacific/Tarawa"=>"(GMT+12:00) Tarawa",
			"Pacific/Wake"=>"(GMT+12:00) Wake",
			"Pacific/Wallis"=>"(GMT+12:00) Wallis",
			"Pacific/Apia"=>"(GMT+13:00) Apia",
			"Pacific/Enderbury"=>"(GMT+13:00) Enderbury",
			"Pacific/Fakaofo"=>"(GMT+13:00) Fakaofo",
			"Pacific/Tongatapu"=>"(GMT+13:00) Tongatapu",
			"Pacific/Kiritimati"=>"(GMT+14:00) Kiritimati"
		);
	}
	
	public static function getCurrentPostType() {
		global $post, $typenow, $current_screen;
		
		//we have a post so we can just get the post type from that
		if ( $post && $post->post_type )
			return $post->post_type;
		
		//check the global $typenow - set in admin.php
		elseif( $typenow )
			return $typenow;
		
		//check the global $current_screen object - set in sceen.php
		elseif( $current_screen && $current_screen->post_type )
			return $current_screen->post_type;
		
		//lastly check the post_type querystring
		elseif( isset( $_REQUEST['post_type'] ) )
			return sanitize_key( $_REQUEST['post_type'] );
		else if (!empty($_GET['post']))
			return get_post_type($_GET['post']);
		
		//we do not know the post type!
		return null;
	}

	public static function getWeekNumberFromName($weekName) {
		$date = array(
			'Monday' => 1,
			'Tuesday' => 2,
			'Wednesday' => 3,
			'Thursday' => 4,
			'Friday' => 5,
			'Saturday' => 6,
			'Sunday' => 7
		);

		return $date[$weekName];
	}

	public static function getWeekDayFromDate($date) {
		if (is_object($date)) {
			$date = $date->format('Y-m-d H:i:s');
		}
		//Convert the date string into a unix timestamp.
		$unixTimestamp = strtotime($date);
		 
		//Get the day of the week using PHP's date function.
		$dayOfWeek = date("l", $unixTimestamp);
		 
		return $dayOfWeek;
	}

    public static function getPostTypeData($args = array())
    {
        $query = self::getQueryDataByArgs($args);

        $posts = array();
        foreach ($query->posts as $post) {
            $posts[$post->ID] = $post->post_title;
        }

        return $posts;
    }

    public static function getQueryDataByArgs($args = array())
    {
        $defaultArgs = array(
            'offset'           =>  0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'suppress_filters' => true,
            'post_type'        => 'post',
            'posts_per_page'   => 1000
        );

        $args = wp_parse_args($args, $defaultArgs);
        $query = new WP_Query($args);

        return $query;
    }

    public static function getAllCustomPosts()
	{
		$args = array(
			'public' => true,
			'_builtin' => false
		);

		$allCustomPosts = get_post_types($args);
	
		if(isset($allCustomPosts[YCD_COUNTDOWN_POST_TYPE])) {
			unset($allCustomPosts[YCD_COUNTDOWN_POST_TYPE]);
		}

		return $allCustomPosts;
	}

    public static function separateToActiveAndNotActive($extensions) {
        $result = array(
            'active' => array(),
            'passive' => array()
        );

        foreach($extensions as $extension) {
            if(empty($extension)) {
                continue;
            }
            $key = @$extension['pluginKey'];

            if(is_plugin_active($key)) {
                if($extension['isType']) {
                    $result['active'][] = $extension;
                }
            }
            else {
                $result['passive'][] = $extension;
            }
        }

        return $result;
    }

    public static function getPluginActivationUrl($key) {
        $action = 'install-plugin';
        $contactFormUrl = wp_nonce_url(
            add_query_arg(
                array(
                    'action' => $action,
                    'plugin' => $key
                ),
                admin_url( 'update.php' )
            ),
            $action.'_'.$key
        );

        return $contactFormUrl;
    }

    public static function getYoutubeEmbedUrl($url) {
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube.com/embed/' . $youtube_id ;
    }
	
	/**
	 * Update options
	 *
	 * @since 1.6.9
	 *
	 * @return void
	 */
	public static function updateOption($optionKey, $optionValue)
	{
		if (is_multisite()) {
			update_site_option($optionKey, $optionValue);
		}
		else {
			update_option($optionKey, $optionValue);
		}
	}
	
	public static function getOption($optionKey)
	{
		if (is_multisite()) {
			return get_site_option($optionKey);
		}
		return get_option($optionKey);
	}
	
	public static function deleteOption($optionKey)
	{
		if (is_multisite()) {
			delete_site_option($optionKey);
		}
		else {
			delete_option($optionKey);
		}
	}

	public static function getCreateCountdownUrl() {
		return (YCD_COUNTDOWN_ADMIN_URL.'edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE.'&page='.YCD_COUNTDOWN_POST_TYPE);
	}
}