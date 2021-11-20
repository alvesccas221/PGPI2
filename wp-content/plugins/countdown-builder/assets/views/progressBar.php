<?php
use ycd\AdminHelper;
$defaultData = AdminHelper::defaultData();
$id = $this->getId();
?>
<div class="ycd-bootstrap-wrapper">
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-countdown-enable-progress" class="ycd-label-of-switch"><?php _e('Enable Progress', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6">
			<label class="ycd-switch">
				<input type="checkbox" id="ycd-countdown-enable-progress" data-id="<?php echo esc_attr($id);?>" name="ycd-countdown-enable-progress" class="" <?php echo $this->getOptionValue('ycd-countdown-enable-progress'); ?> >
				<span class="ycd-slider ycd-round"></span>
			</label>
		</div>
	</div>
	<div class="row form-group ycd-start-date ycd-hide">
		<div class="col-md-6">
			<label for="ycd-date-progress-start-date" class="ycd-label-of-input"><?php _e('Start Date', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6">
			<input type="text" id="ycd-date-progress-start-date" class="form-control ycd-date-time-picker" name="ycd-date-progress-start-date" value="<?php echo esc_attr($this->getOptionValue('ycd-date-progress-start-date')); ?>">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-progress-width" class=""><?php _e('Width', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
			<input type="text" name="ycd-progress-width" class="form-control" id="ycd-progress-width" value="<?php echo $this->getOptionValue('ycd-progress-width'); ?>">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-progress-height" class=""><?php _e('Height', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
			<input type="text" name="ycd-progress-height" class="form-control" id="ycd-progress-height" value="<?php echo $this->getOptionValue('ycd-progress-height'); ?>">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-progress-main-color" class=""><?php _e('Background Color', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
			<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
				<input type="text" id="ycd-progress-main-color" data-type="bgColor" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-progress-main-color" class="minicolors-input form-control js-ycd-progress-main-color" value="<?php echo esc_attr($this->getOptionValue('ycd-progress-main-color')); ?>">
			</div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-progress-color" class=""><?php _e('Progress Color', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
			<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
				<input type="text" id="ycd-progress-color" data-type="progressColor" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-progress-color" class="minicolors-input form-control js-ycd-progress-color" value="<?php echo esc_attr($this->getOptionValue('ycd-progress-color')); ?>">
			</div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-progress-text-color" class=""><?php _e('Progress Text Color', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
			<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
				<input type="text" id="ycd-progress-text-color" data-type="color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-progress-text-color" class="minicolors-input form-control js-ycd-progress-text-color" value="<?php echo esc_attr($this->getOptionValue('ycd-progress-text-color')); ?>">
			</div>
		</div>
	</div>
	<?php if(YCD_PKG_VERSION == YCD_FREE_VERSION): ?>
        <a href="<?php echo YCD_COUNTDOWN_PRO_URL; ?>" target="_blank">
            <div class="ycd-pro ycd-pro-options-div">
                <p class="ycd-pro-options-title"><?php _e('PRO Features', YCD_TEXT_DOMAIN); ?></p>
            </div>
        </a>
	<?php endif;?>
</div>