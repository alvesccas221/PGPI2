<?php
namespace ycd;
if (YCD_PKG_VERSION > YCD_FREE_VERSION) {
	if (file_exists(WP_PLUGIN_DIR.'/countdown-builder')) {
		echo "<span><strong>Fatal error:</strong> require_once(): Failed opening required '".YCD_CONFIG_PATH."license.php'</span>";
		die();
	}
}
class CircleCountdown extends Countdown {

	public $expireSeconds;
	public $datesNumber;
	public function __construct() {
		parent::__construct();
		add_action('add_meta_boxes', array($this, 'mainOptions'));
		add_action('ycdGeneralMetaboxes', array($this, 'metaboxes'), 10, 1);
		add_filter('ycdCountdownDefaultOptions', array($this, 'defaultOptions'), 1, 1);
	}

	public function defaultOptions($options) {
		return $options;
	}

	public function metaboxes($metaboxes) {
		$metaboxes[YCD_PROGRESS_METABOX_KEY] = array('title' => YCD_PROGRESS_METABOX_TITLE, 'position' => 'normal', 'prioritet' => 'high');
		return $metaboxes;
	}

	public function includeStyles() {
		$this->includeGeneralScripts();
		wp_enqueue_script('jquery');

		if(YCD_PKG_VERSION > YCD_FREE_VERSION) {
            ScriptsIncluder::registerScript('ycdGoogleFonts.js');
            ScriptsIncluder::enqueueScript('ycdGoogleFonts.js');
			ScriptsIncluder::registerScript('CountdownProFunctionality.js');
			ScriptsIncluder::enqueueScript('CountdownProFunctionality.js');
		}
		ScriptsIncluder::registerScript('Countdown.js');
		ScriptsIncluder::enqueueScript('Countdown.js');
		ScriptsIncluder::registerScript('TimeCircles.js');
		ScriptsIncluder::localizeScript('TimeCircles.js', 'YcdArgs', array('isAdmin' => is_admin()));
		ScriptsIncluder::enqueueScript('TimeCircles.js');
		ScriptsIncluder::registerStyle('TimeCircles.css');
		ScriptsIncluder::enqueueStyle('TimeCircles.css');
	}

	public function mainOptions(){
		parent::mainOptions();
		add_meta_box('ycdMainOptions', __('Countdown options', YCD_TEXT_DOMAIN), array($this, 'mainView'), YCD_COUNTDOWN_POST_TYPE, 'normal', 'high');
	}

	public function mainView() {
		$typeObj = $this;
		require_once YCD_VIEWS_PATH.'cricleMainView.php';
	}

	public function renderLivePreview() {
		$typeObj = $this;
	    require_once YCD_PREVIEW_VIEWS_PATH.'circlePreview.php';
    }

	public function getDataAllOptions() {
        $savedData = $this->getSavedData();
        $savedData['id'] = $this->getId();

		return $savedData;
	}

	private function getBgImageStyleStr() {
        $imageUrl = $this->getOptionValue('ycd-bg-image-url');
        $bgImageSize = $this->getOptionValue('ycd-bg-image-size');
        $imageRepeat = $this->getOptionValue('ycd-bg-image-repeat');
        $styles = 'background-image: url('.$imageUrl.'); background-repeat: '.$imageRepeat.'; background-size: '.$bgImageSize.'; ';

        return $styles;
    }

    private function renderStyles() {
	    $id = $this->getId();
	    // text styles
	    $fontSize = $this->getOptionValue('ycd-text-font-size');
	    $marginTop = $this->getOptionValue('ycd-text-margin-top');
	    $fontWeight = $this->getOptionValue('ycd-countdown-font-weight');
	    $fontStyle = $this->getOptionValue('ycd-countdown-font-style');
	    $fontFamily = $this->getFontFamilyByName('ycd-text-font-family');
	    // numbers styles
	    $fontSizeNumber = $this->getOptionValue('ycd-countdown-number-size');
	    $marginToNumber = $this->getOptionValue('ycd-number-margin-top');
	    $fontWeightNumber = $this->getOptionValue('ycd-countdown-number-font-weight');
	    $fontStyleNumber = $this->getOptionValue('ycd-countdown-number-font-style');
	    $fontFamilyNumber = $this->getFontFamilyByName('ycd-countdown-number-font');
	    
	    $yearsColor = $this->getOptionValue('ycd-countdown-years-text-color');
	    $monthsColor = $this->getOptionValue('ycd-countdown-months-text-color');
	    $daysTextColor = $this->getOptionValue('ycd-countdown-days-text-color');
	    $hoursTextColor = $this->getOptionValue('ycd-countdown-hours-text-color');
	    $minutesTextColor = $this->getOptionValue('ycd-countdown-minutes-text-color');
	    $secondsTextColor = $this->getOptionValue('ycd-countdown-seconds-text-color');
	    $circleAlignment = $this->getOptionValue('ycd-circle-alignment');
	    $padding = $this->getOptionValue('ycd-countdown-padding').'px';

        $shadowHorizontal = $this->getOptionValue('ycd-circle-box-shadow-horizontal-length').'px';
        $shadowVertical = $this->getOptionValue('ycd-circle-box-shadow-vertical-length').'px';
        $shadowBlurRadius = $this->getOptionValue('ycd-circle-box-blur-radius').'px';
        $shadowSpreadRadius = $this->getOptionValue('ycd-circle-box-spread-radius').'px';
        $shadowColor = $this->getOptionvalue('ycd-circle-box-shadow-color');

	    ob_start();
	    ?>
	    <style type="text/css">
            #ycd-circle-<?php echo $id; ?> {
                padding: <?php echo $padding; ?>;
                box-sizing: border-box;
                display: inline-block;
            }
            #ycd-circle-<?php echo $id; ?> h4 {
                font-size: <?php echo $fontSize; ?>px !important;
                margin-top: <?php echo $marginTop; ?>px !important;
                font-weight: <?php echo $fontWeight; ?> !important;
                font-style: <?php echo $fontStyle; ?> !important;
                font-family: <?php echo $fontFamily; ?> !important;
            }
            #ycd-circle-<?php echo $id; ?> span {
                font-size: <?php echo $fontSizeNumber; ?>px !important;
                margin-top: <?php echo $marginToNumber; ?>px !important;
                font-weight: <?php echo $fontWeightNumber; ?> !important;
                font-style: <?php echo $fontStyleNumber; ?> !important;
                font-family: <?php echo $fontFamilyNumber; ?> !important;
            }
            #ycd-circle-<?php echo $id; ?> .textDiv_Years h4,
            #ycd-circle-<?php echo $id; ?> .textDiv_Years span {
                color: <?php echo $yearsColor; ?>
            }
            #ycd-circle-<?php echo $id; ?> .textDiv_Months h4, 
            #ycd-circle-<?php echo $id; ?> .textDiv_Months span {
                color: <?php echo $monthsColor; ?>
            }
            #ycd-circle-<?php echo $id; ?> .textDiv_Days h4, 
            #ycd-circle-<?php echo $id; ?> .textDiv_Days span {
                color: <?php echo $daysTextColor; ?>
            }
            #ycd-circle-<?php echo $id; ?> .textDiv_Hours h4,
            #ycd-circle-<?php echo $id; ?> .textDiv_Hours span {
                color: <?php echo $hoursTextColor; ?>
            }

            #ycd-circle-<?php echo $id; ?> .textDiv_Minutes h4, 
            #ycd-circle-<?php echo $id; ?> .textDiv_Minutes span {
                color: <?php echo $minutesTextColor; ?>
            }
            #ycd-circle-<?php echo $id; ?> .textDiv_Seconds h4,
            #ycd-circle-<?php echo $id; ?> .textDiv_Seconds span {
                color: <?php echo $secondsTextColor; ?>
            }
            .ycd-circle-<?php echo $id; ?>-wrapper {
                text-align: <?php echo $circleAlignment; ?>;
            }
            <?php if($this->getOptionValue('ycd-circle-box-shadow')): ?>
            .ycd-circle-<?php echo $id; ?>-wrapper .time_circles {
                -webkit-box-shadow: <?php echo $shadowHorizontal.' '.$shadowVertical.' '.$shadowBlurRadius.' '.$shadowSpreadRadius.' '.$shadowColor; ?>;
                -moz-box-shadow: <?php echo $shadowHorizontal.' '.$shadowVertical.' '.$shadowBlurRadius.' '.$shadowSpreadRadius.' '.$shadowColor; ?>;
                box-shadow: <?php echo $shadowHorizontal.' '.$shadowVertical.' '.$shadowBlurRadius.' '.$shadowSpreadRadius.' '.$shadowColor; ?>;
            }
            <?php endif; ?>
        </style>
        <?php
	    $styles = ob_get_contents();
	    ob_get_clean();

	    echo $styles;
    }

    public function addToContent() {
        add_filter('the_content', array($this, 'getTheContentFilter'),99999999, 1);
    }
    
	public function getViewContent() {
		$this->includeStyles();
        $id = $this->getId();

        $seconds = $this->getCountdownTimerAttrSeconds();
		$bgImageStyleStr = $this->getBgImageStyleStr();
		$bgImageStyleStr .= $this->renderStyles();
		$allDataOptions = $this->getDataAllOptions();
		$allDataOptions = json_encode($allDataOptions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
		$prepareOptions = $this->getCircleOptionsData();
		$prepareOptions = json_encode($prepareOptions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
		$width = (int)$this->getOptionValue('ycd-countdown-width');
		$widthMeasure = $this->getOptionValue('ycd-dimension-measure');
		$width .= $widthMeasure;
		$content = '<div class="ycd-countdown-wrapper">';
		$content .= apply_filters('ycdCircleCountdownPrepend', '', $this);
        $content .= '<div class="ycd-circle-expiration-before-countdown" style="display: none">'.do_shortcode($this->getOptionValue('ycd-circle-countdown-expiration-before-countdown')).'</div>';
        $content .= '<div class="ycd-circle-before-countdown">'.do_shortcode($this->getOptionValue('ycd-circle-countdown-before-countdown')).'</div>';
		ob_start();
		?>
        <div class="ycd-circle-<?php echo esc_attr($id); ?>-wrapper ycd-circle-wrapper">
            <div id="ycd-circle-<?php echo esc_attr($id); ?>" class="ycd-time-circle" data-options='<?php echo $prepareOptions; ?>' data-all-options='<?php echo $allDataOptions; ?>' data-timer="<?php echo $seconds ?>" style="<?php echo $bgImageStyleStr ?> width: <?php echo $width; ?>; height: 100%; padding: 0; box-sizing: border-box; background-color: inherit"></div>
        </div>
		<?php
		$content .= ob_get_contents();
		ob_get_clean();
		$content .= $this->additionalFunctionality();
        $content .= '<div class="ycd-circle-expiration-after-countdown" data-key="" style="display: none">'.do_shortcode($this->getOptionValue('ycd-circle-countdown-expiration-after-countdown')).'</div>';
        $content .= '<div class="ycd-circle-after-countdown" data-key="">'.do_shortcode($this->getOptionValue('ycd-circle-countdown-after-countdown')).'</div>';
		$content .= '</div>';

        return $content;
	}
}