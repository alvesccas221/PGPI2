<?php
use ycd\AdminHelper;
$defaultData = AdminHelper::defaultData();
$proSpan = '';
?>
<div class="panel panel-default">
	<div class="panel-heading"><?php _e('Design', YCD_TEXT_DOMAIN)?></div>
	<div class="panel-body ycd-bootstrap-wrapper">
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-title"><?php _e('Background Color', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
					<input type="text" id="ycd-coming-soon-background-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-coming-soon-background-color" class="minicolors-input form-control ycd-coming-soon-color" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-background-color')); ?>">
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-headline-color"><?php _e('Headline Color', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
					<input type="text" id="ycd-coming-headline-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-coming-headline-color" class="minicolors-input form-control ycd-coming-soon-color" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-headline-color')); ?>">
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-headline-color"><?php _e('Message Color', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
					<input type="text" id="ycd-coming-message-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-coming-message-color" class="minicolors-input form-control ycd-coming-soon-color" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-message-color')); ?>">
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-headline-color"><?php _e('Font Family', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<?php echo AdminHelper::selectBox($defaultData['font-family'], esc_attr($this->getOptionValue('ycd-coming-soon-page-font-family')), array('name' => 'ycd-coming-soon-page-font-family', 'class' => 'js-ycd-select js-countdown-font-family')); ?>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-bg-image" class="ycd-label-of-switch"><?php _e('Background Image', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
				<label class="ycd-switch">
					<input type="checkbox" id="ycd-coming-soon-bg-image" name="ycd-coming-soon-bg-image" class="ycd-accordion-checkbox js-ycd-bg-image" <?php echo $this->getOptionValue('ycd-coming-soon-bg-image'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
		<div class="ycd-accordion-content ycd-hide-content">
			<div class="row form-group">
				<div class="col-md-6">
					<label for="" class="ycd-label-of-select"><?php _e('Background Size', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-6 ycd-circles-width-wrapper">
					<?php echo AdminHelper::selectBox($defaultData['bg-image-size'], esc_attr($this->getOPtionValue('ycd-coming-soon-image-size')), array('name' => 'ycd-coming-soon-image-size', 'class' => 'js-ycd-select js-ycd-bg-size')); ?>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<label for="" class="ycd-label-of-select"><?php _e('Background Repeat', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-6 ycd-circles-width-wrapper">
					<?php echo AdminHelper::selectBox($defaultData['bg-image-repeat'], esc_attr($this->getOPtionValue('ycd-coming-soon-bg-image-repeat')), array('name' => 'ycd-coming-soon-bg-image-repeat', 'class' => 'js-ycd-select js-bg-image-repeat')); ?>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<input id="js-coming-soon-upload-image-button" class="js-ycd-image-btn btn btn-primary" data-src-id="ycd-coming-soon-bg-image-url" type="button" value="<?php _e('Select Image', YCD_TEXT_DOMAIN)?>">
				</div>
				<div class="col-md-6 ycd-circles-width-wrapper">
					<input type="url" name="ycd-coming-soon-bg-image-url" id="ycd-coming-soon-bg-image-url" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-bg-image-url')); ?>">
				</div>
			</div>
		</div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-coming-soon-bg-video" class="ycd-label-of-switch"><?php _e('Background Video', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
            </div>
            <div class="col-md-6 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
                <label class="ycd-switch">
                    <input type="checkbox" id="ycd-coming-soon-bg-video" name="ycd-coming-soon-bg-video" class="ycd-accordion-checkbox js-ycd-bg-video" <?php echo $this->getOptionValue('ycd-coming-soon-bg-video'); ?>>
                    <span class="ycd-slider ycd-round"></span>
                </label>
            </div>
        </div>
        <div class="ycd-accordion-content ycd-hide-content">
            <div class="row form-group">
                <div class="col-md-6">
                    <input id="js-upload-video-button" class="js-countdown-video-btn btn btn-primary" type="button" value="<?php _e('Select Video', YCD_TEXT_DOMAIN)?>">
                </div>
                <div class="col-md-6 ycd-circles-width-wrapper">
                    <input type="url" name="ycd-coming-soon-bg-video-url" id="ycd-bg-video-url" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-bg-video-url')); ?>">
                </div>
            </div>
        </div>
		<?php if(YCD_PKG_VERSION == YCD_FREE_VERSION): ?>
			<a href="<?= YCD_COUNTDOWN_PRO_URL; ?>" target="_blank">
				<div class="ycd-pro ycd-pro-options-div">
					<p class="ycd-pro-options-title">PRO Features</p>
				</div>
			</a>
		<?php endif;?>
	</div>
</div>