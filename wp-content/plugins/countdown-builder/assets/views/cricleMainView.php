<?php
use ycd\AdminHelper;
$proSpan = '';
$isPro = '';
if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
	$isPro = '-pro';
	$proSpan = '<span class="ycd-pro-span">'.__('pro', YCD_TEXT_DOMAIN).'</span>';
}
$defaultData = AdminHelper::defaultData();
$animation = $typeObj->getOptionValue('ycd-circle-animation');
$countdownWidth = $typeObj->getOptionValue('ycd-countdown-width');
$dimensionMeasure = $typeObj->getOptionValue('ycd-dimension-measure');
$countdownDays = $typeObj->getOptionValue('ycd-countdown-days');
$countdownMonths = $typeObj->getOptionValue('ycd-countdown-months');
$countdownYears = $typeObj->getOptionValue('ycd-countdown-years');
$countdownBackgroundCircle = $typeObj->getOptionValue('ycd-countdown-background-circle');
$countdownDaysText = $typeObj->getOptionValue('ycd-countdown-days-text');
$countdownMonthsText = $typeObj->getOptionValue('ycd-countdown-months-text');
$countdownYearsText = $typeObj->getOptionValue('ycd-countdown-years-text');
$countdownHours= $typeObj->getOptionValue('ycd-countdown-hours');
$countdownHoursText = $typeObj->getOptionValue('ycd-countdown-hours-text');
$countdownMinutes= $typeObj->getOptionValue('ycd-countdown-minutes');
$countdownMinutesText = $typeObj->getOptionValue('ycd-countdown-minutes-text');
$countdownSeconds = $typeObj->getOptionValue('ycd-countdown-seconds');
$countdownSecondsText = $typeObj->getOptionValue('ycd-countdown-seconds-text');
$countdownDirection = $typeObj->getOptionValue('ycd-countdown-direction');
$type = $this->getCurrentTypeFromOptions();
$countdownDaysTextColor = $typeObj->getOptionValue('ycd-countdown-days-text-color');
$countdownMonthsTextColor = $typeObj->getOptionValue('ycd-countdown-months-text-color');
$countdownYearsTextColor = $typeObj->getOptionValue('ycd-countdown-years-text-color');
$countdownDaysColor = $typeObj->getOptionValue('ycd-countdown-days-color');
$countdownMonthsColor = $typeObj->getOptionValue('ycd-countdown-months-color');
$countdownYearsColor = $typeObj->getOptionValue('ycd-countdown-years-color');
$countdownHoursColor = $typeObj->getOptionValue('ycd-countdown-hours-color');
$countdownHoursTextColor = $typeObj->getOptionValue('ycd-countdown-hours-text-color');
$countdownMinutesColor = $typeObj->getOptionValue('ycd-countdown-minutes-color');
$countdownMinutesTextColor = $typeObj->getOptionValue('ycd-countdown-minutes-text-color');
$countdownSecondsColor = $typeObj->getOptionValue('ycd-countdown-seconds-color');
$countdownSecondsTextColor = $typeObj->getOptionValue('ycd-countdown-seconds-text-color');
$circleWidth = $typeObj->getOptionValue('ycd-circle-width');
$circleBgWidth = $typeObj->getOptionValue('ycd-circle-bg-width');
$circleStartAngle = $typeObj->getOptionValue('ycd-circle-start-angle');
$countdownBgImage = $typeObj->getOptionValue('ycd-countdown-bg-image');
$bgImageSize = $typeObj->getOptionValue('ycd-bg-image-size');
$bgImageRepeat = $typeObj->getOptionValue('ycd-bg-image-repeat');
$bgImageUrl = $typeObj->getOptionValue('ycd-bg-image-url');
$countdownBgCircleColor = $typeObj->getOptionValue('ycd-countdown-bg-circle-color');
$textFontSize = $typeObj->getOptionValue('ycd-text-font-size');
$countdownFontWeight = $typeObj->getOptionValue('ycd-countdown-font-weight');
$countdownFontStyle = $typeObj->getOptionValue('ycd-countdown-font-style');
$textFontFamily = $typeObj->getOptionValue('ycd-text-font-family');
$countdownPadding = (int)$typeObj->getOptionValue('ycd-countdown-padding');
if (YCD_PKG_VERSION > YCD_FREE_VERSION) {
	if (file_exists(WP_PLUGIN_DIR.'/countdown-builder')) {
		echo "<span><strong>Fatal error:</strong> require_once(): Failed opening required '".YCD_CONFIG_PATH."license.php'</span>";
		die();
	}
}
?>
<div class="ycd-bootstrap-wrapper">
    <div class="row">
        <div class="col-md-6">
            <!-- Countdown fonts start -->
                <!-- text styles start -->
            <div class="row form-group">
                <div class="col-md-7">
                    <label><?php _e('Countdown Text Styles', YCD_TEXT_DOMAIN); ?></label>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-text-size" class="ycd-label-of-select"><?php _e('Font Size', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
			        <?php echo AdminHelper::selectBox($defaultData['font-size'], esc_attr($textFontSize), array('name' => 'ycd-text-font-size', 'class' => 'js-ycd-select js-countdown-font-size')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-text-size" class="ycd-label-of-select"><?php _e('Margin Top', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
			        <?php echo AdminHelper::selectBox($defaultData['circleTextMarginTop'], esc_attr($this->getOptionValue('ycd-text-margin-top')), array('name' => 'ycd-text-margin-top', 'class' => 'js-ycd-select js-countdown-text-margin-top js-countdown-text-style')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-font-weight" class="ycd-label-of-select"><?php _e('Font Weight', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
			        <?php echo AdminHelper::selectBox($defaultData['font-weight'], esc_attr($countdownFontWeight), array('name' => 'ycd-countdown-font-weight', 'class' => 'js-ycd-select js-countdown-font-weight')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-font-style" class="ycd-label-of-select"><?php _e('Font Style', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
			        <?php echo AdminHelper::selectBox($defaultData['font-style'], esc_attr($countdownFontStyle), array('name' => 'ycd-countdown-font-style', 'class' => 'js-ycd-select js-countdown-font-style')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-text-size" class="ycd-label-of-select"><?php _e('Font Family', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                </div>
                <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
			        <?php echo AdminHelper::selectBox($defaultData['font-family'], esc_attr($textFontFamily), array('name' => 'ycd-text-font-family', 'class' => 'js-ycd-select js-countdown-font-family ycd-custom-value-accordion', 'data-custom' => 'customFont')); ?>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row">
                    <div class="col-xs-5">
                        <label class="control-label" for="ycd-text-font-family-custom"><?php _e(' custom font family', YCD_TEXT_DOMAIN);?>:</label>
                    </div>
                    <div class="col-xs-7">
                        <input type="text" id="ycd-text-font-family-custom" class="form-control input-md custom-font-family" name="ycd-text-font-family-custom" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-text-font-family-custom'))?>" placeholder="Custom Font Family"><br>
                    </div>
                </div>
            </div>
                <!-- text styles end -->
                <!-- Number styles start -->
            <div class="row form-group">
                <div class="col-md-7">
                    <label><?php _e('Countdown Number Styles', YCD_TEXT_DOMAIN); ?></label>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-number-size" class="ycd-label-of-select"><?php _e('Font Size', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
			        <?php echo AdminHelper::selectBox($defaultData['font-size-number'], esc_attr($this->getOptionValue('ycd-countdown-number-size')), array('name' => 'ycd-countdown-number-size', 'class' => 'js-ycd-select js-countdown-number-size')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-text-size" class="ycd-label-of-select"><?php _e('Margin Top', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
			        <?php echo AdminHelper::selectBox($defaultData['circleNumberMarginTop'], esc_attr($this->getOptionValue('ycd-number-margin-top')), array('name' => 'ycd-number-margin-top', 'class' => 'js-ycd-select js-countdown-number-margin-bottom js-countdown-number-style')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-number-font-weight" class="ycd-label-of-select"><?php _e('Font Weight', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
			        <?php echo AdminHelper::selectBox($defaultData['font-weight'], esc_attr($this->getOptionValue('ycd-countdown-number-font-weight')), array('name' => 'ycd-countdown-number-font-weight', 'class' => 'js-ycd-select js-countdown-number-font-weight')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-number-font-style" class="ycd-label-of-select"><?php _e('Font Style', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
			        <?php echo AdminHelper::selectBox($defaultData['font-style'], esc_attr($this->getOptionValue('ycd-countdown-number-font-style')), array('name' => 'ycd-countdown-number-font-style', 'class' => 'js-ycd-select js-countdown-number-font-style')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-number-font" class="ycd-label-of-select"><?php _e('Font Family', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                </div>
                <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
			        <?php echo AdminHelper::selectBox($defaultData['font-family'], esc_attr($this->getOptionValue('ycd-countdown-number-font')), array('name' => 'ycd-countdown-number-font', 'class' => 'js-ycd-select js-countdown-number-font ycd-custom-value-accordion', 'data-custom' => 'customFont')); ?>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row">
                    <div class="col-xs-5">
                        <label class="control-label" for="ycd-number-font-family-custom"><?php _e('custom font family', YCD_TEXT_DOMAIN);?>:</label>
                    </div>
                    <div class="col-xs-7">
                        <input type="text" id="ycd-number-font-family-custom" class="form-control input-md custom-font-family" name="ycd-number-font-family-custom" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-number-font-family-custom'))?>" placeholder="Custom Font Family"><br>
                    </div>
                </div>
            </div>
                <!-- Number styles end -->
            <!-- Countdown fonts end -->

            <!-- -->
            <div class="row form-group">
                <div class="col-md-5">
                    <label><?php _e('Countdown Format', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                </div>
            </div>

            <!-- Countdown formats general start -->

            <!-- Countdown formats years start -->

            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-years" class="ycd-label-of-switch"><?php _e('Years', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-years" data-time-type="Years" name="ycd-countdown-years" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $countdownYears; ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-years-text" class="ycd-label-of-input"><?php _e('text', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="ycd-countdown-years-text" data-time-type="Years" name="ycd-countdown-years-text" class="form-control js-ycd-time-text" value="<?php echo esc_attr($countdownYearsText); ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-years-color" class=""><?php _e('circle background color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-years-color" data-time-type="Years" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-years-color" class=" minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($countdownYearsColor); ?>">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-years-color" class=""><?php _e('text color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-years-text-color" data-time-type="Years" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-years-text-color" class=" minicolors-input form-control js-ycd-time-text-color" value="<?php echo esc_attr($countdownYearsTextColor); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Countdown formats years end -->

            <!-- Countdown formats months start -->

            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-months" class="ycd-label-of-switch"><?php _e('Months', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-months" data-time-type="Months" name="ycd-countdown-months" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $countdownMonths; ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-months-text" class="ycd-label-of-input"><?php _e('text', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="ycd-countdown-months-text" data-time-type="Months" name="ycd-countdown-months-text" class="form-control js-ycd-time-text" value="<?php echo esc_attr($countdownMonthsText); ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-months-color" class=""><?php _e('circle background color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-months-color" data-time-type="Months" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-months-color" class=" minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($countdownMonthsColor); ?>">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-months-color" class=""><?php _e('text color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-months-text-color" data-time-type="Months" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-months-text-color" class=" minicolors-input form-control js-ycd-time-text-color" value="<?php echo esc_attr($countdownMonthsTextColor); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Countdown formats months end -->

            <!-- Countdown formats Days start -->

            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-days" class="ycd-label-of-switch"><?php _e('Days', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-days" data-time-type="Days" name="ycd-countdown-days" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $countdownDays; ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-days-text" class="ycd-label-of-input"><?php _e('text', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="ycd-countdown-days-text" data-time-type="Days" name="ycd-countdown-days-text" class="form-control js-ycd-time-text" value="<?php echo esc_attr($countdownDaysText); ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-days-color" class=""><?php _e('circle background color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-days-color" data-format="rgb" data-time-type="Days" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-days-color" class=" minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($countdownDaysColor); ?>">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-days-color" class=""><?php _e('text color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-days-text-color" data-time-type="Days" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-days-text-color" class=" minicolors-input form-control js-ycd-time-text-color" value="<?php echo esc_attr($countdownDaysTextColor); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Countdown formats Days end -->

            <!-- Countdown formats Hours start -->

            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-hours" class="ycd-label-of-switch"><?php _e('Hours', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <label class="ycd-switch">
                        <input type="checkbox" data-time-type="Hours" id="ycd-countdown-hours" name="ycd-countdown-hours" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $countdownHours; ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content form-group">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-hours-text" class="ycd-label-of-input"><?php _e('text', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="ycd-countdown-hours-text" data-time-type="Hours" name="ycd-countdown-hours-text" class="form-control js-ycd-time-text" value="<?php echo esc_attr($countdownHoursText); ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-hours-color" class=""><?php _e('circle background color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-hours-color" data-time-type="Hours" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-hours-color" class=" minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($countdownHoursColor); ?>">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-hours-color" class=""><?php _e('text color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-hours-text-color" data-time-type="Hours" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-hours-text-color" class=" minicolors-input form-control js-ycd-time-text-color" value="<?php echo esc_attr($countdownHoursTextColor); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Countdown formats Hours end -->

            <!-- Countdown formats Minutes start -->

            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-minutes" class="ycd-label-of-switch"><?php _e('Minutes', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <label class="ycd-switch">
                        <input type="checkbox" data-time-type="Minutes" id="ycd-countdown-minutes" name="ycd-countdown-minutes" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $countdownMinutes; ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-minutes-text" class="ycd-label-of-input"><?php _e('text', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="ycd-countdown-minutes-text" data-time-type="Minutes" name="ycd-countdown-minutes-text" class="form-control js-ycd-time-text" value="<?php echo esc_attr($countdownMinutesText); ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-minutes-color" class=""><?php _e('circle background color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-minutes-color" data-time-type="Minutes" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-minutes-color" class=" minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($countdownMinutesColor); ?>">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-minutes-color" class=""><?php _e('text color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-minutes-text-color" data-time-type="Minutes" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-minutes-text-color" class=" minicolors-input form-control js-ycd-time-text-color" value="<?php echo esc_attr($countdownMinutesTextColor); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Countdown formats Minutes end -->

            <!-- Countdown formats Seconds start -->

            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-seconds" class="ycd-label-of-switch"><?php _e('Seconds', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <label class="ycd-switch">
                        <input type="checkbox" data-time-type="Seconds" id="ycd-countdown-seconds" name="ycd-countdown-seconds" class="ycd-accordion-checkbox js-ycd-time-status" <?php echo $countdownSeconds; ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-seconds-text" class="ycd-label-of-input"><?php _e('text', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="ycd-countdown-seconds-text" data-time-type="Seconds" name="ycd-countdown-seconds-text" class="form-control js-ycd-time-text" value="<?php echo esc_attr($countdownSecondsText); ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-seconds-color" class=""><?php _e('circle background color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-seconds-color" data-time-type="Seconds" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-seconds-color" class=" minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($countdownSecondsColor); ?>">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-seconds-color" class="ycd-label-of-color"><?php _e('text color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-seconds-text-color" data-time-type="Seconds" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-seconds-text-color" class="minicolors-input form-control js-ycd-time-text-color" value="<?php echo esc_attr($countdownSecondsTextColor); ?>">
                        </div>
                    </div>
                </div>

                <!-- Countdown formats Seconds end -->

            </div>
            <!-- -->
        </div>
        <div class="col-md-6">
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-date-time-picker" class="ycd-label-of-input"><?php _e('Alignment', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
	                <?php echo AdminHelper::selectBox($defaultData['horizontal-alignment'], esc_attr($this->getOptionValue('ycd-circle-alignment')), array('name' => 'ycd-circle-alignment', 'class' => 'js-ycd-select ycd-circle-alignment')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label class="ycd-label-of-select"><?php _e('Animation', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <?php echo AdminHelper::selectBox($defaultData['ycd-circle-animation'], esc_attr($animation), array('name' => 'ycd-circle-animation', 'class' => 'js-ycd-select js-circle-animation')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-width" class="ycd-label-of-input"><?php _e('Countdown Width', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control js-ycd-dimension js-ycd-dimension-number" id="ycd-countdown-width" name="ycd-countdown-width" value="<?php echo $countdownWidth; ?>" style="margin-right: 5px">
                </div>
                <div class="col-md-3">
                    <?php echo AdminHelper::selectBox($defaultData['ycd-dimension-measure'], esc_attr($dimensionMeasure), array('name' => 'ycd-dimension-measure', 'class' => 'js-ycd-select js-ycd-dimension js-ycd-dimension-measure')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label for="ycd-countdown-background-circle" class="ycd-label-of-switch"><?php _e('Background Circle', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-background-circle" name="ycd-countdown-background-circle" class="ycd-accordion-checkbox js-ycd-background-circle" <?php echo $countdownBackgroundCircle; ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="" class="ycd-range-slider-wrapper"><?php _e('width', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper">
                        <input title="Circle background width" id="ycd-js-circle-bg-width" type="text" name="ycd-circle-bg-width" value="<?php echo esc_attr($circleBgWidth); ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-bg-circle-color" class="ycd-range-slider-wrapper"><?php _e('color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-countdown-bg-circle-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-countdown-bg-circle-color" class=" minicolors-input form-control js-countdown-bg-circle-color" value="<?php echo esc_attr($countdownBgCircleColor); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="" class="ycd-label-of-select"><?php _e('Direction', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <?php echo AdminHelper::selectBox($defaultData['ycd-countdown-direction'], esc_attr($countdownDirection), array('name' => 'ycd-countdown-direction', 'class' => 'js-ycd-select js-ycd-direction')); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="" class="ycd-range-slider-wrapper"><?php _e('Circle Width', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7 ycd-circles-width-wrapper">
                    <input type="text" id="ycd-circle-width" name="ycd-circle-width" value="<?php echo esc_attr($circleWidth); ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="" class="ycd-range-slider-wrapper"><?php _e('Start Angle', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7 ycd-circles-width-wrapper">
                    <input id="ycd-js-circle-start-angle" type="text" name="ycd-circle-start-angle" value="<?php echo esc_attr($circleStartAngle); ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-bg-image" class="ycd-label-of-switch"><?php _e('Background Image', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                </div>
                <div class="col-md-7 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-bg-image" name="ycd-countdown-bg-image" class="ycd-accordion-checkbox js-ycd-bg-image" <?php echo $countdownBgImage; ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="" class="ycd-label-of-select"><?php _e('Background Size', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper">
	                    <?php echo AdminHelper::selectBox($defaultData['bg-image-size'], esc_attr($bgImageSize), array('name' => 'ycd-bg-image-size', 'class' => 'js-ycd-select js-ycd-bg-size')); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="" class="ycd-label-of-select"><?php _e('Background Repeat', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper">
	                    <?php echo AdminHelper::selectBox($defaultData['bg-image-repeat'], esc_attr($bgImageRepeat), array('name' => 'ycd-bg-image-repeat', 'class' => 'js-ycd-select js-bg-image-repeat')); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <input id="js-upload-image-button" class="button js-countdown-image-btn" type="button" value="<?php _e('Select Image', YCD_TEXT_DOMAIN)?>">
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper">
	                    <input type="url" name="ycd-bg-image-url" id="ycd-bg-image-url" class="form-control" value="<?php echo esc_attr($bgImageUrl); ?>">
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-bg-video" class="ycd-label-of-switch"><?php _e('Background Video', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                </div>
                <div class="col-md-7 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-bg-video" name="ycd-countdown-bg-video" class="ycd-accordion-checkbox js-ycd-bg-video" <?php echo $typeObj->getOptionValue('ycd-countdown-bg-video'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <input id="js-upload-video-button" class="button js-countdown-video-btn" type="button" value="<?php _e('Select Video', YCD_TEXT_DOMAIN)?>">
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper">
                        <input type="url" name="ycd-bg-video-url" id="ycd-bg-video-url" class="form-control" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-bg-video-url')); ?>">
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-content-click" class="ycd-label-of-switch"><?php _e('Switch Text And Number', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7 ycd-circles-width-wrapper ycd-option-wrapper">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-switch-number" name="ycd-countdown-switch-number" class="js-ycd-countdown-switch-number" <?php echo $typeObj->getOptionValue('ycd-countdown-switch-number'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-content-click" class="ycd-label-of-switch"><?php _e('Action on countdown content click', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7 ycd-circles-width-wrapper ycd-option-wrapper">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-content-click" name="ycd-countdown-content-click" class="ycd-accordion-checkbox js-ycd-countdown-content-click" <?php echo $typeObj->getOptionValue('ycd-countdown-content-click'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-content-click-url" class="ycd-label-of-switch"><?php _e('URL', YCD_TEXT_DOMAIN) ?></label>
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper">
                        <input type="url" name="ycd-countdown-content-click-url" id="ycd-countdown-content-click-url" class="form-control" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-countdown-content-click-url')); ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-content-click-url-tab" class="ycd-label-of-switch"><?php _e('Redirect to new tab', YCD_TEXT_DOMAIN) ?></label>
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper">
                        <label class="ycd-switch">
                            <input type="checkbox" id="ycd-countdown-content-click-url-tab" name="ycd-countdown-content-click-url-tab" class="" <?php echo $typeObj->getOptionValue('ycd-countdown-content-click-url-tab'); ?>>
                            <span class="ycd-slider ycd-round"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-showing-limitation" class="ycd-label-of-switch"><?php _e('Countdown Showing Limitation', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7 ycd-circles-width-wrapper ycd-option-wrapper">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-showing-limitation" name="ycd-countdown-showing-limitation" class="ycd-accordion-checkbox js-ycd-countdown-content-click" <?php echo $typeObj->getOptionValue('ycd-countdown-showing-limitation'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-countdown-expiration-time" class="ycd-label-of-switch"><?php _e('Expiration time', YCD_TEXT_DOMAIN) ?></label>
                    </div>
                    <div class="col-md-7 ycd-circles-width-wrapper">
                        <input type="number" name="ycd-countdown-expiration-time" id="ycd-countdown-expiration-time" class="form-control" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-countdown-expiration-time')); ?>">
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-showing-animation" class="ycd-label-of-switch"><?php _e('Countdown Showing Animation', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7 ycd-circles-width-wrapper ycd-option-wrapper">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-showing-animation" name="ycd-countdown-showing-animation" class="ycd-accordion-checkbox js-ycd-countdown-showing-animation" <?php echo $typeObj->getOptionValue('ycd-countdown-showing-animation'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="" class="ycd-label-of-input"><?php _e('Select Animation', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-4">
                        <?php echo AdminHelper::selectBox($defaultData['showing-animation'], esc_attr($this->getOptionValue('ycd-circle-showing-animation')), array('name' => 'ycd-circle-showing-animation', 'class' => 'js-ycd-select ycd-showing-animation')); ?>
                    </div>
                    <div class="col-md-1">
                        <span class="ycd-preview-icon"></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-circle-showing-animation-speed" class="ycd-label-of-input"><?php _e('Speed', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="ycd-circle-showing-animation-speed" class="form-control ycd-circle-showing-animation-speed" id="ycd-circle-showing-animation-speed" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-circle-showing-animation-speed'))?>">
                    </div>
                    <div class="col-md-1">
                        <span><?php _e('Second(a)', YCD_TEXT_DOMAIN);?></span>
                    </div>
                </div>
            </div>
            <!-- Box shadow start -->
            <div class="row form-group">
                <div class="col-xs-5">
                    <label class="control-label" for="ycd-circle-box-shadow"><?php _e('Countdown Shadow', YCD_TEXT_DOMAIN);?>:</label>
                </div>
                <div class="col-xs-4">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-circle-box-shadow" name="ycd-circle-box-shadow" class="ycd-accordion-checkbox js-ycd-countdown-showing-animation" <?php echo $typeObj->getOptionValue('ycd-circle-box-shadow'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row row-static-margin-bottom">
                    <div class="col-xs-5">
                        <label class="control-label" for="ycd-circle-box-shadow-horizontal"><?php _e('Horizontal Length', YCD_TEXT_DOMAIN);?>:</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="number" class="input-md form-control" id="ycd-circle-box-shadow-horizontal" placeholder="example 5 or -5" name="ycd-circle-box-shadow-horizontal-length" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-circle-box-shadow-horizontal-length'))?>"><br>
                    </div>
                    <div class="col-xs-1">
                        <label class="control-label"><?php _e('px', YCD_TEXT_DOMAIN);?></label>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-5">
                        <label class="control-label" for="ycd-circle-box-shadow-vertical"><?php _e('Vertical Length', YCD_TEXT_DOMAIN);?>:</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="number" class="input-md form-control" placeholder="example 5 or -5" id="ycd-circle-box-shadow-vertical" name="ycd-circle-box-shadow-vertical-length" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-circle-box-shadow-vertical-length'))?>"><br>
                    </div>
                    <div class="col-xs-1">
                        <label class="control-label"><?php _e('px', YCD_TEXT_DOMAIN);?></label>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-5">
                        <label class="control-label" for="ycd-circle-box-blur-radius"><?php _e('Blur Radius', YCD_TEXT_DOMAIN);?>:</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="number" class="input-md form-control" placeholder="example 5 or -5" id="ycd-circle-box-blur-radius" name="ycd-circle-box-blur-radius" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-circle-box-blur-radius'))?>"><br>
                    </div>
                    <div class="col-xs-1">
                        <label class="control-label"><?php _e('px', YCD_TEXT_DOMAIN);?></label>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-5">
                        <label class="control-label" for="ycd-circle-box-spread-radius"><?php _e('Spread Radius', YCD_TEXT_DOMAIN);?>:</label>
                    </div>
                    <div class="col-xs-4">
                        <input type="number" class="input-md form-control" placeholder="example 5 or -5" id="ycd-circle-box-spread-radius" name="ycd-circle-box-spread-radius" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-circle-box-spread-radius'))?>"><br>
                    </div>
                    <div class="col-xs-1">
                        <label class="control-label"><?php _e('px', YCD_TEXT_DOMAIN);?></label>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-5">
                        <label class="control-label" for="ycd-circle-box-shadow-color"><?php _e('Shadow Color', YCD_TEXT_DOMAIN); echo $proSpan;?>:</label>
                    </div>
                    <div class="col-xs-4 ycd-option-wrapper<?php echo $isPro; ?>">
                        <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                            <input type="text" id="ycd-circle-box-shadow-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-circle-box-shadow-color" class=" minicolors-input form-control" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-circle-box-shadow-color')); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Box shadow end -->
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="ycd-countdown-padding" class="ycd-label-of-input"><?php _e('Countdown Padding', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-5">
                    <input type="number" id="ycd-countdown-padding" class="form-control" name="ycd-countdown-padding" value="<?php echo esc_attr($countdownPadding); ?>">
                </div>
                <div class="col-md-2">
                    <label class="ycd-label-of-input"><?= _e('px', YCD_TEXT_DOMAIN); ?></label>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-6">
                    <label class="ycd-label-of-input" for="ycd-circle-countdown-before-countdown"><?php _e('Before countdown', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-12">
                    <?php
                    $editorId = 'ycd-circle-countdown-before-countdown';
                    $beforeCountdown = $this->getOptionValue($editorId);
                    $settings = array(
                        'wpautop' => false,
                        'tinymce' => array(
                            'width' => '100%'
                        ),
                        'textarea_rows' => '6',
                        'media_buttons' => true
                    );
                    wp_editor($beforeCountdown, $editorId, $settings);
                    ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-6">
                    <label class="ycd-label-of-input" for="ycd-circle-countdown-after-countdown"><?php _e('After countdown', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-12">
                    <?php
                    $editorId = 'ycd-circle-countdown-after-countdown';
                    $afterCountdown = $this->getOptionValue($editorId);
                    $settings = array(
                        'wpautop' => false,
                        'tinymce' => array(
                            'width' => '100%'
                        ),
                        'textarea_rows' => '6',
                        'media_buttons' => true
                    );
                    wp_editor($afterCountdown, $editorId, $settings);
                    ?>
                </div>
            </div>
	        <div class="row form-group">
		        <div class="col-md-5">
			        <label for="ycd-countdown-content-click" class="ycd-label-of-switch"><?php _e('After Expiration Change Texts', YCD_TEXT_DOMAIN); ?></label>
		        </div>
		        <div class="col-md-7 ycd-circles-width-wrapper ycd-option-wrapper">
			        <label class="ycd-switch">
				        <input type="checkbox" id="ycd-countdown-expiration-text-change" name="ycd-countdown-expiration-text-change" class="ycd-accordion-checkbox js-ycd-countdown-content-click" <?php echo $typeObj->getOptionValue('ycd-countdown-expiration-text-change'); ?>>
				        <span class="ycd-slider ycd-round"></span>
			        </label>
		        </div>
	        </div>
	        <div class="ycd-accordion-content ycd-hide-content">

		        <div class="row form-group">
			        <div class="col-md-6">
				        <label class="ycd-label-of-input" for="ycd-circle-countdown-before-countdown"><?php _e('Before Countdown', YCD_TEXT_DOMAIN); ?></label>
			        </div>
			        <div class="col-md-12">
				        <?php
				        $editorId = 'ycd-circle-countdown-expiration-before-countdown';
				        $beforeCountdown = $this->getOptionValue($editorId);
				        $settings = array(
					        'wpautop' => false,
					        'tinymce' => array(
						        'width' => '100%'
					        ),
					        'textarea_rows' => '6',
					        'media_buttons' => true
				        );
				        wp_editor($beforeCountdown, $editorId, $settings);
				        ?>
			        </div>
		        </div>
		        <div class="row form-group">
			        <div class="col-md-6">
				        <label class="ycd-label-of-input" for="ycd-circle-countdown-before-countdown"><?php _e('After Countdown', YCD_TEXT_DOMAIN); ?></label>
			        </div>
			        <div class="col-md-12">
				        <?php
				        $editorId = 'ycd-circle-countdown-expiration-after-countdown';
				        $beforeCountdown = $this->getOptionValue($editorId);
				        $settings = array(
					        'wpautop' => false,
					        'tinymce' => array(
						        'width' => '100%'
					        ),
					        'textarea_rows' => '6',
					        'media_buttons' => true
				        );
				        wp_editor($beforeCountdown, $editorId, $settings);
				        ?>
			        </div>
	            </div>
	        </div>
        </div>
</div>
    <?php
        require_once YCD_VIEWS_PATH.'preview.php';
    ?>
</div>
<input type="hidden" name="ycd-type" value="<?php echo esc_attr($type); ?>">