<div class="ycd-bootstrap-wrapper">
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-enable-subscribe-form" class="ycd-label-of-input"><?php _e('Enable Subscribe Form', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
            <label class="ycd-switch">
                <input type="checkbox" id="ycd-enable-subscribe-form" name="ycd-enable-subscribe-form" class="ycd-enable-subscribe-form" <?php echo $this->getOptionValue('ycd-enable-subscribe-form'); ?>>
                <span class="ycd-slider ycd-round"></span>
            </label>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-subscribe-width" class="ycd-label-of-input"><?php _e('Subscribe Form Width', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ycd-subscribe-width" class="form-control" id="ycd-subscribe-width" value="<?php echo $this->getOptionValue('ycd-subscribe-width'); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-form-above-text" class="ycd-label-of-input"><?php _e('Form Above Text', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ycd-form-above-text" class="form-control" id="ycd-form-above-text" value="<?php echo esc_attr($this->getOptionValue('ycd-form-above-text')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-form-input-text" class="ycd-label-of-input"><?php _e('Form Input Text', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ycd-form-input-text" class="form-control" id="ycd-form-input-text" value="<?php echo esc_attr($this->getOptionValue('ycd-form-input-text')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-form-submit-text" class="ycd-label-of-input"><?php _e('Form Submit Text', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ycd-form-submit-text" class="form-control" id="ycd-form-submit-text" value="<?php echo esc_attr($this->getOptionValue('ycd-form-submit-text')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-form-submit-color" class="ycd-label-of-input"><?php _e('Submit Button Color', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-form-submit-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-form-submit-color" class=" minicolors-input form-control" value="<?php echo esc_attr($this->getOptionValue('ycd-form-submit-color')); ?>">
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-subscribe-success-message" class="ycd-label-of-input"><?php _e('Thank You Message', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ycd-subscribe-success-message" class="form-control" id="ycd-subscribe-success-message" value="<?php echo esc_attr($this->getOptionValue('ycd-subscribe-success-message'))?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-subscribe-error-message" class="ycd-label-of-input"><?php _e('Error Message', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ycd-subscribe-error-message" class="form-control" id="ycd-subscribe-error-message" value="<?php echo esc_attr($this->getOptionValue('ycd-subscribe-error-message'))?>">
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