<?php
namespace ycd;

class StickyCountdown extends Countdown {

	public function __construct() {
		parent::__construct();
		add_action('add_meta_boxes', array($this, 'mainOptions'));
		add_filter('ycdCountdownDefaultOptions', array($this, 'defaultOptions'), 1, 1);
		add_action('ycdGeneralMetaboxes', array($this, 'metaboxes'), 10, 1);
	}

	public function metaboxes($metaboxes) {
		$metaboxes[YCD_PROGRESS_METABOX_KEY] = array('title' => YCD_PROGRESS_METABOX_TITLE, 'position' => 'normal', 'prioritet' => 'high');
	   
		return $metaboxes;
	}

	public function defaultOptions($options) {

		return $options;
	}

	public function includeStyles() {
		$this->includeGeneralScripts();
		$data = array(
			'days' => $this->getOptionValue('ycd-sticky-countdown-days'),
			'hours' => $this->getOptionValue('ycd-sticky-countdown-hours'),
			'minutes' => $this->getOptionValue('ycd-sticky-countdown-minutes'),
			'seconds' => $this->getOptionValue('ycd-sticky-countdown-seconds')
		);
		ScriptsIncluder::registerScript('Sticky.js', array('dirUrl' => YCD_COUNTDOWN_JS_URL, 'dep' => array('jquery')));
		ScriptsIncluder::localizeScript('Sticky.js', 'YCD_STICKY_ARGS', $data);
		ScriptsIncluder::enqueueScript('Sticky.js');
	}

	public function mainOptions(){
		parent::mainOptions();
		add_meta_box('ycdMainOptions', __('Sticky countdown options', YCD_TEXT_DOMAIN), array($this, 'mainView'), YCD_COUNTDOWN_POST_TYPE, 'normal', 'high');
	}

	public function mainView() {
		$typeObj = $this;
		require_once YCD_VIEWS_MAIN_PATH.'stickyMainView.php';
	}

	public function renderLivePreview() {
		$typeObj = $this;
		require_once YCD_PREVIEW_VIEWS_PATH.'circlePreview.php';
	}

	private function renderStyles() {
		$id = $this->getId();
		$important = ' !important';
		
		if(is_admin()) {
			$important = '';
		}
		$paddingEnable = $this->getOptionValue('ycd-sticky-button-padding-enable');
		$buttonPadding = $this->getOptionValue('ycd-sticky-button-padding');
		$inputBgColor = $this->getOptionValue('ycd-sticky-bg-color');
		$inputColor = $this->getOptionValue('ycd-sticky-button-color');
		$stickyTextColor = $this->getOptionValue('ycd-sticky-text-color');
		$stickyBgColor = $this->getOptionValue('ycd-sticky-text-background-color');
		$stickyCountdownColor = $this->getOptionValue('ycd-sticky-countdown-text-color');
		$countdownSize = (int)$this->getOptionValue('ycd-stick-countdown-font-size');
		$countdownWeight = $this->getOptionValue('ycd-stick-countdown-font-weight');
		
		$enableBorder = $this->getOptionValue('ycd-sticky-button-border-enable');
		$borderWidth = $this->getOptionValue('ycd-sticky-button-border-width');
		$borderRadius = $this->getOptionValue('ycd-sticky-button-border-radius');
		$borderColor = $this->getOptionValue('ycd-sticky-button-border-color');

		$sectionsOrder = $this->getOptionValue('ycd-sticky-countdown-sections');
		$sectionsOrderArray = explode('-', $sectionsOrder);
		$countCols = count($sectionsOrderArray);
		$sectionsWidth = '33';

		if ($countCols == 1) {
			$sectionsWidth = '100';
		}
		else if ($countCols == 2) {
			$sectionsWidth = '49';
		}
		ob_start();
		?>
		<style type="text/css">
			.ycd-sticky-header-countdown {
				color: <?php echo $stickyCountdownColor; ?>;
				font-size: <?php echo $countdownSize; ?>px;
				font-weight: <?php echo $countdownWeight; ?>;
			}
			/* Style the header */
			.ycd-sticky-header {
				padding: 10px 16px;
				background: <?php echo esc_attr($stickyBgColor); ?>;
				color: <?php echo $stickyTextColor; ?>;
				position: relative;
			}
			
			.ycd-sticky-header-child {
				width: <?php echo $sectionsWidth; ?>%;
				display: inline-block;
				text-align: center;
				vertical-align: middle;
			}

			/* Page content */
			.ycd-sticky-content {
				padding: 16px;
			}

			/* The sticky class is added to the header with JS when it reaches its scroll position */
			.ycd-sticky {
				position: fixed;
				top: 0;
				width: 100%;
				z-index: 9999999999999999999999999999999999999999;
			}

			/* Add some top padding to the page content to prevent sudden quick movement (as the header gets a new position at the top of the page (position:fixed and top:0) */
			.ycd-sticky + .ycd-sticky-content {
				padding-top: 102px;
			}
			.ycd-sticky-button {
				background-color: <?php echo $inputBgColor.$important; ?>;
				color: <?php echo $inputColor.$important; ?>;
			}
			<?php if (!empty($paddingEnable)): ?>
				.ycd-sticky-button {
					padding: <?php echo $buttonPadding.' '.$important; ?>;
				}
			<?php endif; ?>
			<?php if (!empty($enableBorder)): ?>
				.ycd-sticky-button {
					border: <?php echo $borderWidth.'  solid '.$borderColor.' '.$important; ?>;
					border-radius: <?php echo $borderRadius.' '.$important; ?>;
			<?php endif; ?>
		</style>
		<?php
		$styles = ob_get_contents();
		ob_get_clean();

		echo $styles;
	}

	private function renderCountdown() {
		$type = $this->getOptionValue('ycd-sticky-countdown-mode');

		if ($type == 'stickyCountdownDefault') {
			return '<div class="ycd-sticky-clock"></div>';
		}
		$id = $this->getOptionValue('ycd-sticky-countdown');
		$content = do_shortcode('[ycd_countdown id='.$id.']');

		return $content;
	}
	
	private function getCloseSectionHTML() {
		$allowCloseSection = $this->getOptionValue('ycd-sticky-enable-close');
		
		if (empty($allowCloseSection)) {
			return '';
		}
		$id = $this->getId();
		$text = $this->getOptionValue('ycd-sticky-close-text');
		ob_start();
		?>
		<div class="ycd-sticky-close-wrapper ycd-sticky-close-wrapper-<?php echo esc_attr($id); ?> " data-id="<?php echo esc_attr($id); ?>">
			<span class="ycd-sticky-close-text ycd-sticky-close-text-<?php echo esc_attr($id); ?>"><?php echo esc_attr($text); ?></span>
		</div>
		<style type="text/css">
			.ycd-sticky-close-wrapper {
				display: inline-block;
				position: absolute;
				top: 8px;
				right: 8px;
				line-height: 1;
			}
			.ycd-sticky-close-text {
				cursor: pointer;
			}
		</style>
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
	private function getStickyContent() {
		$id = $this->getId();
		
		// time setting
		$settings = array();
		$endDate = $this->getOptionValue('ycd-date-time-picker');
		$timeZone = $this->getOptionValue('ycd-circle-time-zone');
		$settings['endDate'] = $endDate;
		$settings['timeZone'] = $timeZone;
		$settings['ycd-countdown-end-sound'] = $this->getOptionValue('ycd-countdown-end-sound');
		$settings['ycd-countdown-end-sound-url'] = $this->getOptionValue('ycd-countdown-end-sound-url');
		$settings['ycd-countdown-expire-behavior'] = $this->getOptionValue('ycd-countdown-expire-behavior');
		$settings['ycd-expire-text'] = $this->getOptionValue('ycd-expire-text');
		$settings['ycd-expire-url'] = $this->getOptionValue('ycd-expire-url');
		$settings['id'] = $id;
		$settings['ycd-countdown-date-type'] = $this->getOptionValue('ycd-countdown-date-type');
		// end behavior
		$settings['ycd-sticky-expire-behavior'] = $this->getOptionValue('ycd-sticky-expire-behavior');
		$settings['ycd-sticky-url'] = $this->getOptionValue('ycd-sticky-url');
		$settings['ycd-sticky-url-new-tab'] = $this->getOptionValue('ycd-sticky-button-redirect-new-tab');
		$settings['ycd-sticky-button-copy'] = $this->getOptionValue('ycd-sticky-button-copy');
		$settings['ycd-sticky-copy-alert'] = $this->getOptionValue('ycd-sticky-copy-alert');
		$settings['ycd-sticky-alert-text'] = $this->getOptionValue('ycd-sticky-alert-text');
		$settings += $this->generalOptionsData();
	  
		$settings = json_encode($settings);

		$stickyUrl = $this->getOptionValue('ycd-sticky-url');

		$actionUrl = "window.location.href = '$stickyUrl'";


		$textContent = $this->getOptionValue('ycd-sticky-text');
		$buttonText = $this->getOptionValue('ycd-sticky-button-text');
		$sectionsOrder = $this->getOptionValue('ycd-sticky-countdown-sections');
		$sectionsOrderArray = explode('-', $sectionsOrder);
		
		$closeSectionHtml = $this->getCloseSectionHTML();

		$sectionsHtml = array();

		ob_start();
		?>
			<div class="ycd-sticky-header-child ycd-sticky-header-text">
				<?php echo $textContent; ?>
			</div>
		<?php
		$sectionsHtml['Text']  = ob_get_contents();
		ob_end_clean();

		ob_start();
		?>
			<div class="ycd-sticky-header-child ycd-sticky-header-countdown">
				<?php echo $this->renderCountdown(); ?>
				<?php echo $this->renderProgressBar(); ?>
			</div>
		<?php
		$sectionsHtml['Countdown']  = ob_get_contents();
		ob_end_clean();

		ob_start();
		?>
			<div class="ycd-sticky-header-child ycd-sticky-header-button">
				<input type="button" data-id = "<?php echo esc_attr($id); ?>" class="ycd-sticky-button" value="<?php echo  esc_attr($buttonText); ?>">
			</div>
		<?php
		$sectionsHtml['Button']  = ob_get_contents();
		ob_end_clean();

		
		ob_start();
		?>
			<div class="ycd-sticky-header ycd-sticky-header-<?php echo esc_attr($id); ?>" data-id="<?php echo esc_attr($id); ?>" data-settings="<?php echo esc_attr($settings); ?>">
				<?php echo $closeSectionHtml; ?>
				<?php foreach ($sectionsOrderArray as $sectionKey) {
					echo $sectionsHtml[$sectionKey];
				}?>

				<div>
					<?php echo $this->renderSubscriptionForm(); ?>
				</div>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		$content .= $this->renderStyles();
		
		return $content;
	}

	public function addToContent() {
		return $this->getViewContent();
	}

	public function getViewContent() {
		$this->includeStyles();
		$content = $this->getStickyContent();
		
		return $content;
	}
}