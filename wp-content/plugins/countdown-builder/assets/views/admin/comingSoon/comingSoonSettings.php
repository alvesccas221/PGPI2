<?php
use ycd\AdminHelper;
use ycd\MultipleChoiceButton;
$defaultData = AdminHelper::defaultData();
$createCountdown = AdminHelper::getCreateCountdownUrl();
$args = array('allowTypes' => array('circle'), 'except' => array('sticky'));
$countdownsIdAndTitle = \ycd\Countdown::getCountdownsIdAndTitle($args);
if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
	$isPro = '-pro';
	$proSpan = '<span class="ycd-pro-span">'.__('pro', YCD_TEXT_DOMAIN).'</span>';
}
?>
<div class="panel panel-default">
	<div class="panel-heading"><?php _e('Settings', YCD_TEXT_DOMAIN)?></div>
	<div class="panel-body">
		<?php wp_nonce_field('ycdSaveComingSoon'); ?>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-enable-coming-soon"><?php _e('Enable'); ?></label>
			</div>
			<div class="col-md-6">
				<label class="ycd-switch">
					<input type="checkbox" id="ycd-enable-coming-soon" name="ycd-enable-coming-soon" class="" <?php echo $this->getOptionValue('ycd-enable-coming-soon'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
        <div class="row form-group">
            <div class="col-md-6">
                <label><?php _e('Mode'); ?></label>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="ycd-sub-options-wrapper">
	        <?php
	        $multipleChoiceButton = new MultipleChoiceButton($defaultData['comingSoonModes'], esc_attr($this->getOptionValue('ycd-coming-soon-mode')));
	        echo $multipleChoiceButton;
	        ?>
        </div>
		<div class="row form-group">
			<div class="col-md-6">
				<label><?php _e('Headline'); ?></label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" name="ycd-coming-soon-headline" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-headline'));?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label><?php _e('Message'); ?></label>
			</div>
			<div class="col-md-12">
				<?php
				$content = $this->getOptionValue('ycd-coming-soon-message');
				$settings = array(
					'wpautop' => false,
					'tinymce' => array(
						'width' => '100%'
					),
					'textarea_rows' => '18',
					'media_buttons' => true
				);
				wp_editor($content, 'ycd-coming-soon-message', $settings);
				?>
			</div>
		</div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-coming-soon-bg-image" class="ycd-label-of-switch"><?php _e('Add Countdown', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
            </div>
            <div class="col-md-6 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
                <label class="ycd-switch">
                    <input type="checkbox" id="ycd-coming-soon-add-countdown" name="ycd-coming-soon-add-countdown" class="ycd-accordion-checkbox" <?php echo $this->getOptionValue('ycd-coming-soon-add-countdown'); ?>>
                    <span class="ycd-slider ycd-round"></span>
                </label>
            </div>
        </div>
        <div class="ycd-accordion-content ycd-hide-content">
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="" class="ycd-label-of-select"><?php _e('Select Countdown', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-6 ycd-circles-width-wrapper">
					<?php
                    if (count(array_keys($countdownsIdAndTitle)) <= 1) {
                        echo '<a href="'.$createCountdown.'">Create Countdown</a>';
                    }
                    else {
	                    echo AdminHelper::selectBox($countdownsIdAndTitle, esc_attr($this->getOptionValue('ycd-coming-soon-countdown')), array('name' => 'ycd-coming-soon-countdown', 'class' => 'js-ycd-select'));
                    }
                    ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="" class="ycd-label-of-select"><?php _e('Position', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-6 ycd-circles-width-wrapper">
					<?php echo AdminHelper::selectBox($defaultData['coming-soon-countdown-position'], esc_attr($this->getOPtionValue('ycd-coming-soon-countdown-position')), array('name' => 'ycd-coming-soon-countdown-position', 'class' => 'js-ycd-select')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <label for="ycd-edtitor-css" class="ycd-label-of-switch"><?php _e('Custom CSS', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <textarea id="ycd-edtitor-css" rows="5" name="ycd-coming-soon-countdown-custom-css" class="widefat textarea"><?php echo esc_attr($this->getOptionValue('ycd-coming-soon-countdown-custom-css')); ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <label for="ycd-edtitor-js" class="ycd-label-of-switch"><?php _e('Custom JS', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <textarea id="ycd-edtitor-js" id="ycd-edtitor-js" rows="5" name="ycd-coming-soon-countdown-custom-js" class="widefat textarea"><?php echo esc_attr($this->getOptionValue('ycd-coming-soon-countdown-custom-js')); ?></textarea>
            </div>
        </div>
	</div>
</div>