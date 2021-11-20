<?php
$type = $this->getCurrentTypeFromOptions();
use ycd\AdminHelper;
$proSpan = '';
$isPro = '';
if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
	$isPro = '-pro';
	$proSpan = '<span class="ycd-pro-span">'.__('pro', YCD_TEXT_DOMAIN).'</span>';
}
$defaultData = AdminHelper::defaultData();
?>
<div class="ycd-bootstrap-wrapper">
    <!-- Labels start  -->
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-countdown-timer-days" class="ycd-label-of-switch"><?php _e('Labels', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
	        <!--  Mounts section start -->
	        <div class="row form-group">
		        <div class="col-md-6">
			        <label for="ycd-simple-enable-months"><?php _e('Months', YCD_TEXT_DOMAIN); ?></label>
		        </div>
		        <div class="col-md-6">
			        <label class="ycd-switch">
				        <input type="checkbox" id="ycd-simple-enable-months" data-time-type="months" name="ycd-simple-enable-months" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $typeObj->getOptionValue('ycd-simple-enable-months'); ?>>
				        <span class="ycd-slider ycd-round"></span>
			        </label>
		        </div>
	        </div>
	        <div class="ycd-accordion-content ycd-hide-content">
		        <div class="row form-group">
			        <div class="col-md-6">
				        <label for="ycd-simple-months-text"><?php _e('label', YCD_TEXT_DOMAIN); ?></label>
			        </div>
			        <div class="col-md-6">
				        <input type="text" id="ycd-simple-months-text" class="form-control ycd-simple-text" data-time-type="months" name="ycd-simple-months-text" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-months-text')); ?>" >
			        </div>
		        </div>
	        </div>
	        <!--  Mounts section end -->
            <!--  Days section start -->
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ycd-simple-enable-days"><?php _e('Days', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-6">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-simple-enable-days" data-time-type="days" name="ycd-simple-enable-days" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $typeObj->getOptionValue('ycd-simple-enable-days'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="ycd-simple-days-text"><?php _e('label', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="ycd-simple-days-text" class="form-control ycd-simple-text" data-time-type="days" name="ycd-simple-days-text" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-days-text')); ?>" >
                    </div>
                </div>
            </div>
            <!--  Days section end -->
        </div>
        <div class="col-md-6">
            <!--  Hours section start -->
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ycd-simple-enable-hours"><?php _e('Hours', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-6">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-simple-enable-hours" data-time-type="hours" name="ycd-simple-enable-hours" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $typeObj->getOptionValue('ycd-simple-enable-hours'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="ycd-simple-hours-text"><?php _e('label', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="ycd-simple-hours-text" class="form-control ycd-simple-text" data-time-type="hours" name="ycd-simple-hours-text" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-hours-text')); ?>" >
                    </div>
                </div>
            </div>
            <!--  Hours section end -->
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <!--  Minutes section start -->
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ycd-simple-enable-minutes"><?php _e('Minutes', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-6">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-simple-enable-minutes" data-time-type="minutes" name="ycd-simple-enable-minutes" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $typeObj->getOptionValue('ycd-simple-enable-minutes'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="ycd-simple-minutes-text"><?php _e('label', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="ycd-simple-minutes-text" class="form-control ycd-simple-text" data-time-type="minutes" name="ycd-simple-minutes-text" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-minutes-text')); ?>" >
                    </div>
                </div>
            </div>
            <!--  Minutes section end -->
        </div>
        <div class="col-md-6">
            <!--  Seconds section start -->
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ycd-simple-enable-seconds"><?php _e('Seconds', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-6">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-simple-enable-seconds" data-time-type="seconds" name="ycd-simple-enable-seconds" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $typeObj->getOptionValue('ycd-simple-enable-seconds'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="ycd-simple-seconds-text"><?php _e('label', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="ycd-simple-seconds-text" class="form-control ycd-simple-text" data-time-type="seconds" name="ycd-simple-seconds-text" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-seconds-text')); ?>" >
                    </div>
                </div>
            </div>
            <!--  Seconds section end -->
        </div>
    </div>
    <!-- Labels end  -->
    <!-- Styles start -->
    <div class="row form-group">
        <div class="col-md-6">
            <label class="ycd-label-of-switch"><?php _e('Styles', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
        </div>
    </div>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-simple-numbers-font-size"><?php _e('Numbers', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6">
		</div>
	</div>

	<div class="ycd-sub-option-wrapper">
		<!-- Numbers Styles start -->
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-simple-numbers-font-size"><?php _e('font size', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<input type="text" id="ycd-simple-numbers-font-size" class="form-control ycd-simple-font-size" data-field-type="number" name="ycd-simple-numbers-font-size" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-numbers-font-size')); ?>" >
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-simple-numbers-font-family" class="ycd-label-of-select"><?php _e('font family', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
				<?php echo AdminHelper::selectBox($defaultData['font-family'], esc_attr($typeObj->getOptionValue('ycd-simple-numbers-font-family')), array('name' => 'ycd-simple-numbers-font-family', 'class' => 'js-ycd-select js-simple-font-family ycd-custom-value-accordion', 'data-field-type' => 'number', 'data-custom' => 'customFont')); ?>
			</div>
		</div>
        <div class="ycd-accordion-content ycd-hide-content">
            <div class="row">
                <div class="col-xs-6">
                    <label class="control-label" for="ycd-simple-numbers-font-family-custom"><?php _e('custom font family', YCD_TEXT_DOMAIN);?>:</label>
                </div>
                <div class="col-xs-6">
                    <input type="text" id="ycd-simple-numbers-font-family-custom" class="form-control input-md custom-font-family" name="ycd-simple-numbers-font-family-custom" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-numbers-font-family-custom'))?>" placeholder="Custom Font Family"><br>
                </div>
            </div>
        </div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-simple-numbers-color" class=""><?php _e('color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
				<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
					<input type="text" id="ycd-simple-numbers-color" data-time-type="number" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-simple-numbers-color" class=" minicolors-input form-control js-ycd-simple-time-color" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-numbers-color')); ?>">
				</div>
			</div>
		</div>
		<!-- Numbers Styles end -->
	</div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-simple-text-font-size"><?php _e('Text', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-6">
        </div>
    </div>
	<div class="ycd-sub-option-wrapper">
		<!-- Text Styles start -->
		<div class="row form-group">
	        <div class="col-md-6">
	            <label for="ycd-simple-text-font-size"><?php _e('font size', YCD_TEXT_DOMAIN); ?></label>
	        </div>
	        <div class="col-md-6">
	            <input type="text" id="ycd-simple-text-font-size" class="form-control ycd-simple-font-size" data-field-type="label" name="ycd-simple-text-font-size" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-text-font-size')); ?>" >
	        </div>
	    </div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-countdown-text-size" class="ycd-label-of-select"><?php _e('font family', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
				<?php echo AdminHelper::selectBox($defaultData['font-family'], esc_attr($typeObj->getOptionValue('ycd-simple-text-font-family')), array('name' => 'ycd-simple-text-font-family', 'class' => 'js-ycd-select js-simple-font-family  ycd-custom-value-accordion', 'data-field-type' => 'label', 'data-custom' => 'customFont')); ?>
			</div>
		</div>
        <div class="ycd-accordion-content ycd-hide-content">
            <div class="row">
                <div class="col-xs-6">
                    <label class="control-label" for="ycd-simple-text-font-family-custom"><?php _e('custom font family', YCD_TEXT_DOMAIN);?>:</label>
                </div>
                <div class="col-xs-6">
                    <input type="text" id="ycd-simple-text-font-family-custom" class="form-control input-md custom-font-family" name="ycd-simple-text-font-family-custom" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-text-font-family-custom'))?>" placeholder="Custom Font Family"><br>
                </div>
            </div>
        </div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-simple-text-color" class=""><?php _e('color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
				<div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
					<input type="text" id="ycd-simple-text-color" data-time-type="label" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-simple-text-color" class=" minicolors-input form-control js-ycd-simple-time-color" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-simple-text-color')); ?>">
				</div>
			</div>
		</div>
		<!-- Text Styles end -->
	</div>
    <!-- Styles end -->
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-switch"><?php _e('Settings', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="ycd-sub-option-wrapper">
		<div class="row form-group">
			<div class="col-md-6">
				<label class="ycd-label-of-switch" for="enable-double-digits"><?php _e('Double Digits', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<label class="ycd-switch">
					<input type="checkbox" id="enable-double-digits" data-time-type="hours" name="ycd-enable-simple-double-digits" class="ycd-accordion-checkbox" <?php echo $typeObj->getOptionValue('ycd-enable-simple-double-digits'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
	</div>
    <?php
        require_once YCD_VIEWS_PATH.'preview.php';
    ?>
</div>
<input type="hidden" name="ycd-type" value="<?php echo esc_attr($type); ?>">