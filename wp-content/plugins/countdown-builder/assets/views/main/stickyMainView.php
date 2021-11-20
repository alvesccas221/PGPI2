<?php
use ycd\AdminHelper;
use ycd\MultipleChoiceButton;
$defaultData = AdminHelper::defaultData();
$type = $this->getCurrentTypeFromOptions();

$proSpan = '';
$isPro = '';
if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
	$isPro = '-pro';
	$proSpan = '<span class="ycd-pro-span">'.__('pro', YCD_TEXT_DOMAIN).'</span>';
}
$createCountdown = AdminHelper::getCreateCountdownUrl();
$args = array('allowTypes' => array('circle'), 'except' => array('sticky'));
$countdownsIdAndTitle = \ycd\Countdown::getCountdownsIdAndTitle($args);
$stickySectionsOrder = $defaultData['stickySectionsOrder'];
$stickyExpiration = $defaultData['stickyButtonExpiration'];
?>
<div class="ycd-bootstrap-wrapper">
	<!-- Button settings start -->
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input"><?php _e('Button settings', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">
		</div>
	</div>
	<div class="ycd-sub-options-settings">
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input" for="ycd-sticky-button-text"><?php _e('Text', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">
			<input type="text" class="form-control" id="ycd-sticky-button-text" name="ycd-sticky-button-text" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-button-text')); ?>">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input" for="ycd-sticky-button-bg-color"><?php _e('Background color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
		</div>
		<div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
			<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
				<input type="text" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-sticky-bg-color" class="minicolors-input form-control js-ycd-sticky-bg-color" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-bg-color')); ?>">
			</div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input" for="ycd-sticky-button-color"><?php _e('Text color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
		</div>
		<div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
			<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
				<input type="text" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-sticky-button-color" class="minicolors-input form-control js-ycd-sticky-color" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-button-color')); ?>">
			</div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input" for="ycd-sticky-button-color"><?php _e('Button click behavior', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">
		</div>
	</div>


	<div class="ycd-sub-option">
		<div class="ycd-multichoice-wrapper">
			<?php
			$multipleChoiceButton = new MultipleChoiceButton($stickyExpiration, esc_attr($this->getOptionValue('ycd-sticky-expire-behavior')));
			echo $multipleChoiceButton;
			?>
		</div>
	</div>
	<div id="ycd-sticky-expire-redirect-url" class="ycd-countdown-show-text ycd-sub-option ycd-hide">
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-input" for="ycd-sticky-url"><?php _e('URL', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-5">
				<input type="url" placeholder="https://www.example.com" name="ycd-sticky-url" id="ycd-sticky-url" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-url')); ?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-sticky-button-redirect-new-tab" class="ycd-label-of-switch"><?php _e('Redirect to new tab', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<label class="ycd-switch">
					<input type="checkbox" id="ycd-sticky-button-redirect-new-tab" class="" name="ycd-sticky-button-redirect-new-tab" <?php echo $this->getOptionValue('ycd-sticky-button-redirect-new-tab'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
	</div>
	<div id="ycd-sticky-expire-copy" class="ycd-countdown-show-text ycd-sub-option ycd-hide">
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-sticky-button-copy" class="ycd-label-of-switch"><?php _e('Text', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ycd-sticky-button-copy" class="form-control" placeholder="<?php echo _e('Copy to clipboard'); ?>" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-button-copy')); ?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-sticky-button-copy" class="ycd-label-of-switch"><?php _e('Show alert', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<label class="ycd-switch">
					<input type="checkbox" id="ycd-sticky-copy-alert" name="ycd-sticky-copy-alert" class="ycd-accordion-checkbox" <?php echo $typeObj->getOptionValue('ycd-sticky-copy-alert'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
		<div class="ycd-accordion-content ycd-hide-content">
			<div class="row form-group">
				<div class="col-md-6">
					<label for="ycd-sticky-alert-text" class="ycd-label-of-input"><?php _e('Text', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-6">
					<input type="text" placeholder="<?php _e('Alert text'); ?>" class="form-control" id="ycd-sticky-alert-text" name="ycd-sticky-alert-text" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-sticky-alert-text')); ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-sticky-button-padding-enable" class="ycd-label-of-switch"><?php _e('Enable padding', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6">
			<label class="ycd-switch">
				<input type="checkbox" id="ycd-sticky-button-padding-enable" class="ycd-accordion-checkbox" name="ycd-sticky-button-padding-enable" <?php echo $this->getOptionValue('ycd-sticky-button-padding-enable'); ?>>
				<span class="ycd-slider ycd-round"></span>
			</label>
		</div>
	</div>
	<div class="ycd-accordion-content ycd-hide-content">
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-input" for="ycd-sticky-button-padding"><?php _e('Padding', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-5">
				<input type="text" name="ycd-sticky-button-padding" id="ycd-sticky-button-padding" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-button-padding')); ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label for="ycd-sticky-button-border-enable" class="ycd-label-of-switch"><?php _e('Enable border', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6">
			<label class="ycd-switch">
				<input type="checkbox" id="ycd-sticky-button-border-enable" class="ycd-sticky-button-border-enable ycd-accordion-checkbox" name="ycd-sticky-button-border-enable" <?php echo $this->getOptionValue('ycd-sticky-button-border-enable'); ?>>
				<span class="ycd-slider ycd-round"></span>
			</label>
		</div>
	</div>
	<div class="ycd-accordion-content ycd-hide-content">
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-input" for="ycd-sticky-button-border-width"><?php _e('width', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-5">
				<input type="text" name="ycd-sticky-button-border-width" id="ycd-sticky-button-border-width" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-button-border-width')); ?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-input" for="ycd-sticky-button-border-radius"><?php _e('radius', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-5">
				<input type="text" name="ycd-sticky-button-border-radius" id="ycd-sticky-button-border-radius" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-button-border-radius')); ?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-input" for="ycd-sticky-button-border-color"><?php _e('Background color', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
				<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
					<input type="text" id="ycd-sticky-button-border-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-sticky-button-border-color" class="minicolors-input form-control js-ycd-sticky-color" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-button-border-color')); ?>">
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- Button settings end -->
	<!-- Text start -->
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input"><?php _e('Text section', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">
		</div>
	</div>
	<div class="ycd-sub-options-settings">
	<div class="row form-group">
		<div class="col-md-12">
			<?php
				$editorId = 'ycd-sticky-text';
				$settings = array(
					'textarea_rows' => '18',
				);
				$content = $this->getOptionValue($editorId);
			?>
			<?php wp_editor($content, $editorId, $settings); ?>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input" for="ycd-sticky-text-color"><?php _e('Color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
		</div>
		<div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
			<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
				<input type="text" id="ycd-sticky-text-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-sticky-text-color" class="minicolors-input form-control js-ycd-sticky-color" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-text-color')); ?>">
			</div>
		</div>
	</div>
	</div>
	<!-- Text End -->
	<!-- Countdown Section Start -->
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input"><?php _e('Countdown', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">

		</div>
	</div>
	<div class="ycd-sub-options-settings">
		<div class="ycd-multichoice-wrapper">
			<?php
			$multipleChoiceButton = new MultipleChoiceButton($defaultData['stickyCountdownMode'], esc_attr($this->getOptionValue('ycd-sticky-countdown-mode')));
			echo $multipleChoiceButton;
			?>
		</div>
		<div id="ycd-sticky-countdown-custom" class="ycd-sub-option ycd-hide">
			<div class="row form-group">
				<div class="col-md-6">
					<label class="ycd-label-of-input"><?php _e('Select Countdown', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-4">
					<?php
						if (count(array_keys($countdownsIdAndTitle)) <= 1) {
							echo '<a href="'.$createCountdown.'">Create Countdown</a>';
						}
						else {
							echo AdminHelper::selectBox($countdownsIdAndTitle, esc_attr($this->getOptionValue('ycd-sticky-countdown')), array('name' => 'ycd-sticky-countdown', 'class' => 'js-ycd-select'));
						}
					?>
				</div>
			</div>
		</div>
		<div id="ycd-sticky-countdown-default" class="ycd-sub-option ycd-hide">
		
			<div class="row form-group">
				<div class="col-md-4">
					<label class="ycd-label-of-input"><?php _e('Texts', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-2">
					<label for="ycd-sticky-countdown-days" class="yrm-label"><?php _e('Days', YCD_TEXT_DOMAIN); ?></label>
					<input type="text" id="ycd-sticky-countdown-days" name="ycd-sticky-countdown-days" class="form-control button-padding" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-countdown-days')); ?>">
				</div>
				<div class="col-md-2">
					<label for="ycd-sticky-countdown-hours" class="yrm-label"><?php _e('Hours', YCD_TEXT_DOMAIN); ?></label>
					<input type="text" id="ycd-sticky-countdown-hours" name="ycd-sticky-countdown-hours" class="form-control button-padding" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-countdown-hours')); ?>">
				</div>
				<div class="col-md-2">
					<label for="ycd-sticky-countdown-minutes" class="yrm-label"><?php _e('Minutes', YCD_TEXT_DOMAIN); ?></label>
					<input type="text" id="ycd-sticky-countdown-minutes" name="ycd-sticky-countdown-minutes" class="form-control button-padding" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-countdown-minutes')); ?>">
				</div>
				<div class="col-md-2">
					<label for="ycd-sticky-countdown-seconds" class="yrm-label"><?php _e('Seconds', YCD_TEXT_DOMAIN); ?></label>
					<input type="text" id="ycd-sticky-countdown-seconds" name="ycd-sticky-countdown-seconds" class="form-control button-padding" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-countdown-seconds')); ?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<label class="ycd-label-of-input"><?php _e('Color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
				</div>
				<div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
					<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
						<input type="text" id="ycd-sticky-countdown-text-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-sticky-countdown-text-color" class="minicolors-input form-control js-ycd-sticky-color" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-countdown-text-color')); ?>">
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<label class="ycd-label-of-input"><?php _e('Font wight', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-5">
					<?php echo AdminHelper::selectBox($defaultData['font-weight'], $this->getOptionValue('ycd-stick-countdown-font-weight'), array('name' => 'ycd-stick-countdown-font-weight', 'class' => 'js-ycd-select'))?>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<label class="ycd-label-of-input"><?php _e('Font size', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-5">
					<input type="number" class="form-control" name="ycd-stick-countdown-font-size" value="<?php echo esc_attr($this->getOptionValue('ycd-stick-countdown-font-size'));?>">
				</div>
				<div class="col-md-1">
					<?php _e('Px', YCD_TEXT_DOMAIN); ?>
				</div>
			</div>
		</div>
	</div>
	<!-- Countdown Section End -->
	
	<!-- General Section Start -->
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input"><?php _e('General', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">

		</div>
	</div>
	<div class="ycd-sub-options-settings">
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-input"><?php _e('Background color', YCD_TEXT_DOMAIN);  echo $proSpan; ?></label>
			</div>
			<div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
				<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
					<input type="text" id="ycd-sticky-text-background-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-sticky-text-background-color" class="minicolors-input form-control js-ycd-sticky-color" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-text-background-color')); ?>">
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-input" for="ycd-sticky-enable-close"><?php _e('Enable close', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-5">
                <label class="ycd-switch">
                    <input type="checkbox" id="ycd-sticky-enable-close" class="ycd-accordion-checkbox" name="ycd-sticky-enable-close" <?php echo $this->getOptionValue('ycd-sticky-enable-close'); ?>>
                    <span class="ycd-slider ycd-round"></span>
                </label>
			</div>
		</div>
        <div class="ycd-accordion-content ycd-hide-content">
            <div class="row form-group">
                <div class="col-md-6">
                    <label class="ycd-label-of-input" for="ycd-sticky-close-text"><?php _e('Text', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-5">
                    <input type="text" name="ycd-sticky-close-text" id="ycd-sticky-close-text" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ycd-sticky-close-text')); ?>">
                </div>
            </div>
        </div>
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-input"><?php _e('Sections order', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-5">
				<?php echo  AdminHelper::selectBox($stickySectionsOrder, esc_attr($this->getOptionValue('ycd-sticky-countdown-sections')), array('name' => 'ycd-sticky-countdown-sections', 'class' => 'js-ycd-select')); ?>
			</div>
		</div>
	</div>
	<?php if(YCD_PKG_VERSION != YCD_FREE_VERSION) : ?>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input"><?php _e('Display rule', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">

		</div>
	</div>
	<div class="ycd-sub-options-settings">
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input" for="ycd-sticky-all-pages"><?php _e('All pages', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">
			<label class="ycd-switch">
				<input type="checkbox" id="ycd-sticky-all-pages" name="ycd-sticky-all-pages" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $this->getOptionValue('ycd-sticky-all-pages'); ?>>
				<span class="ycd-slider ycd-round"></span>
			</label>
		</div>
	</div>
	</div>
	<?php endif; ?>
	<!-- General Section Start -->
</div>
<input type="hidden" name="ycd-type" value="<?php echo esc_attr($type); ?>"> 