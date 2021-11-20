<?php
use ycd\MultipleChoiceButton;
use ycd\AdminHelper;
use ycd\AdminHelperPro;

$proSpan = '';
$isPro = '';
if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
	$isPro = '-pro';
	$proSpan = '<span class="ycd-pro-span">'.__('pro', YCD_TEXT_DOMAIN).'</span>';
}
$defaultData = AdminHelper::defaultData();
$dueDate = $this->getOptionValue('ycd-date-time-picker');

if (class_exists('ycd\AdminHelperPro')) {
	$couponsInfo = AdminHelperPro::getWooCommerceCouponsInfo();
}
?>
<div class="ycd-bootstrap-wrapper">
    <div class="ycd-multichoice-wrapper">
    <?php
        $multipleChoiceButton = new MultipleChoiceButton($defaultData['countdown-date-type'], esc_attr($this->getOptionValue('ycd-countdown-date-type')));
        echo $multipleChoiceButton;
    ?>
    </div>
    <div id="ycd-date-wooCoupon" class="ycd-countdown-show-text ycd-hide">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-woo-time-zone" class="ycd-label-of-input"><?php _e('Time Zone', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
				    <?php echo AdminHelper::selectBox($defaultData['time-zone'], esc_attr($this->getOptionValue('ycd-woo-time-zone')), array('name' => 'ycd-woo-time-zone', 'class' => 'js-ycd-select js-ycd-woo-time-zone')); ?>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-schedule-time-picker" class="ycd-label-of-input"><?php _e('Coupon', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
                    <?php
                    $savedWooCouponId = $this->getOptionValue('ycd-woo-coupon');
                    ?>
				    <?php echo AdminHelper::selectBox($couponsInfo['idAndTitle'], esc_attr($savedWooCouponId), array('name' => 'ycd-woo-coupon', 'class' => 'js-ycd-select js-ycd-woo-coupon')); ?>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-schedule-time-picker" class="ycd-label-of-input"><?php _e('Date', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
                    <input type="text" readonly class="form-control ycd-woo-coupon-date" name="ycd-woo-coupon-date" data-dates=<?php echo json_encode($couponsInfo['idAndDates']); ?> value="<?php echo $couponsInfo['idAndDates'][$savedWooCouponId]; ?>">
                </div>
            </div>
        </div>
    </div>
    <div id="ycd-countdown-due-date" class="ycd-countdown-show-text ycd-hide">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-date-time-picker" class="ycd-label-of-input"></label>
            </div>
            <div class="col-md-6">
                <input type="text" id="ycd-date-time-picker" class="form-control ycd-date-time-picker" name="ycd-date-time-picker" value="<?php echo esc_attr($dueDate); ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-date-time-picker" class="ycd-label-of-input"><?php _e('Time Zone', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
                <?php echo AdminHelper::selectBox($defaultData['time-zone'], esc_attr($this->getOptionValue('ycd-circle-time-zone')), array('name' => 'ycd-circle-time-zone', 'class' => 'js-ycd-select js-circle-time-zone')); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="ycd-date-duration" class="ycd-countdown-show-text ycd-hide">
        <div class="row">
            <div class="col-md-6">
                <label for="ycd-countdown-save-duration" class="ycd-label-of-switch"><?php _e('Save Duration', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <label class="ycd-switch">
                    <input type="checkbox" id="ycd-countdown-save-duration" class="ycd-accordion-checkbox" name="ycd-countdown-save-duration" <?php echo $this->getOptionValue('ycd-countdown-save-duration'); ?>>
                    <span class="ycd-slider ycd-round"></span>
                </label>
            </div>
        </div>
        <div class="ycd-accordion-content ycd-hide-content">
            <div class="row">
                <div class="col-md-6">
                    <label for="ycd-countdown-save-duration-each-user" class="ycd-label-of-switch"><?php _e('Save For Each User', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                </div>
                <div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-save-duration-each-user" class="" name="ycd-countdown-save-duration-each-user" <?php echo $this->getOptionValue('ycd-countdown-save-duration-each-user'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="ycd-countdown-restart" class="ycd-label-of-switch"><?php _e('Restart', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
                </div>
                <div class="col-md-6 ycd-option-wrapper<?php echo $isPro; ?>">
                    <label class="ycd-switch">
                        <input type="checkbox" id="ycd-countdown-restart" class="ycd-accordion-checkbox" name="ycd-countdown-restart" <?php echo $this->getOptionValue('ycd-countdown-restart'); ?>>
                        <span class="ycd-slider ycd-round"></span>
                    </label>
                </div>
            </div>
            <div class="ycd-accordion-content ycd-hide-content">
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="ycd-countdown-save-duration-restart" class="ycd-label-of-switch"><?php _e('Every', YCD_TEXT_DOMAIN);  ?></label>
                    </div>
                    <div class="col-md-2 ycd-option-wrapper">
                        <input type="number" class="form-control" name="ycd-countdown-restart-hour" value="<?php echo $this->getOptionValue('ycd-countdown-restart-hour'); ?>">
                    </div>
                    <div class="col-md-1">
                        <label><?php _e('Hour(s)', YCD_TEXT_DOMAIN); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-4">
            </div>
            <div class="col-md-2">
                <label for="ycdCountdownTimeHours"><?php _e('Days', YCD_TEXT_DOMAIN); ?></label>
                <input type="number" name="ycd-countdown-duration-days" id="ycdCountdownTimeDays" min="0" max="60" class="form-control ycd-timer-time-settings" data-type="days" value="<?php echo esc_attr($this->getOptionValue('ycd-countdown-duration-days'))?>">
            </div>
            <div class="col-md-2">
                <label for="ycdCountdownTimeHours"><?php _e('Hrs', YCD_TEXT_DOMAIN); ?></label>
                <input type="number" name="ycd-countdown-duration-hours" id="ycdCountdownTimeHours" min="0" max="60" class="form-control ycd-timer-time-settings" data-type="hours" value="<?php echo esc_attr($this->getOptionValue('ycd-countdown-duration-hours'))?>">
            </div>
            <div class="col-md-2">
                <label for="ycdCountdownTimeMinutes"><?php _e('Mins', YCD_TEXT_DOMAIN); ?></label>
                <input type="number" name="ycd-countdown-duration-minutes" id="ycdCountdownTimeMinutes" min="0" max="60" class="form-control ycd-timer-time-settings" data-type="minutes" value="<?php echo esc_attr($this->getOptionValue('ycd-countdown-duration-minutes'))?>">
            </div>
            <div class="col-md-2">
                <label for="ycdCountdownTimeSeconds"><?php _e('Secs', YCD_TEXT_DOMAIN); ?></label>
                <input type="number" name="ycd-countdown-duration-seconds" id="ycdCountdownTimeSeconds" min="0" max="60" class="form-control ycd-timer-time-settings" data-type="seconds" value="<?php echo esc_attr($this->getOptionValue('ycd-countdown-duration-seconds'))?>">
            </div>
        </div>
    </div>
    <div id="ycd-date-schedule" class="ycd-countdown-show-text ycd-hide">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-schedule-time-picker" class="ycd-label-of-input"><?php _e('Time Zone', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
                    <?php echo AdminHelper::selectBox($defaultData['time-zone'], esc_attr($this->getOptionValue('ycd-schedule-time-zone')), array('name' => 'ycd-schedule-time-zone', 'class' => 'js-ycd-select js-ycd-schedule-time-zone')); ?>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label><?php _e('Start', YCD_TEXT_DOMAIN); ?></label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label><?php _e('Week day', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
                <?php echo AdminHelper::selectBox(
                    $defaultData['week-days'],
                    esc_attr($this->getOptionValue('ycd-schedule-start-day')),
                    array(
                        'name' => 'ycd-schedule-start-day',
                        'data-week-number-key' => 'startDayNumber',
                        'class' => 'js-ycd-select ycd-date-week-day js-ycd-schedule-start-day'
                    )); ?>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
            </div>
            <div class="col-md-2">
                <label class="ycd-label-of-input"><?php _e('from', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-4">
            	<input type="text" name="ycd-schedule-start-from" class="form-control js-datetimepicker-seconds" value="<?php echo esc_attr($this->getOptionValue('ycd-schedule-start-from')); ?>" autocomplete="off">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label><?php _e('End', YCD_TEXT_DOMAIN); ?></label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label><?php _e('Week day', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
                <?php echo AdminHelper::selectBox($defaultData['week-days'],
                    esc_attr($this->getOptionValue('ycd-schedule-end-day')),
                    array(
                        'name' => 'ycd-schedule-end-day',
                        'data-week-number-key' => 'endDayNumber',
                        'class' => 'js-ycd-select ycd-date-week-day js-ycd-schedule-end-day'
                    )
                ); ?>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
            </div>
            <div class="col-md-2">
                <label class="ycd-label-of-input"><?php _e('to', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-4">
            	<input type="text" name="ycd-schedule-end-to" class="form-control js-datetimepicker-seconds" value="<?php echo esc_attr($this->getOptionValue('ycd-schedule-end-to')); ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <div  id="ycd-date-schedule2" class="ycd-countdown-show-text ycd-hide">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-schedule2-time-zone" class="ycd-label-of-input"><?php _e('Time Zone', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
				    <?php echo AdminHelper::selectBox($defaultData['time-zone'], esc_attr($this->getOptionValue('ycd-schedule2-time-zone')), array('name' => 'ycd-schedule2-time-zone', 'class' => 'js-ycd-select js-ycd-schedule-time-zone')); ?>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label><?php _e('Week day(s)', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <div class="ycd-select-wrapper">
				    <?php echo AdminHelper::selectBox(
					    $defaultData['week-days'],
					    $this->getOptionValue('ycd-schedule2-day'),
					    array(
						    'name' => 'ycd-schedule2-day[]',
                            'multiple' => 'multiple',
						    'data-week-number-key' => 'startDayNumber',
						    'class' => 'js-ycd-select ycd-date-week-day js-ycd-schedule-start-day'
					    )); ?>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
            </div>
            <div class="col-md-2">
                <label class="ycd-label-of-input" for="ycd-schedule2-from"><?php _e('from', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-4">
                <input type="text" name="ycd-schedule2-from" id="ycd-schedule2-from" class="form-control js-datetimepicker-seconds" value="<?php echo esc_attr($this->getOptionValue('ycd-schedule2-from')); ?>" autocomplete="off">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
            </div>
            <div class="col-md-2">
                <label class="ycd-label-of-input" for="ycd-schedule2-to"><?php _e('to', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-4">
                <input type="text" name="ycd-schedule2-to" id="ycd-schedule2-to" class="form-control js-datetimepicker-seconds" value="<?php echo esc_attr($this->getOptionValue('ycd-schedule2-to')); ?>" autocomplete="off">
            </div>
        </div>
    </div>
	<div  id="ycd-date-schedule3" class="ycd-countdown-show-text ycd-hide">
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-schedule3-time-zone" class="ycd-label-of-input"><?php _e('Time Zone', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<div class="ycd-select-wrapper">
					<?php echo AdminHelper::selectBox($defaultData['time-zone'], esc_attr($this->getOptionValue('ycd-schedule3-time-zone')), array('name' => 'ycd-schedule3-time-zone', 'class' => 'js-ycd-select js-ycd-schedule-time-zone')); ?>
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label><?php _e('Week day', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<div class="ycd-select-wrapper">
					<?php echo AdminHelper::selectBox(
						$defaultData['week-days'],
						$this->getOptionValue('ycd-schedule3-day'),
						array(
							'name' => 'ycd-schedule3-day',
							'data-week-number-key' => 'endDayNumber',
							'class' => 'js-ycd-select ycd-date-week-day js-ycd-schedule-start-day'
						)); ?>
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
			</div>
			<div class="col-md-2">
				<label class="ycd-label-of-input" for="ycd-schedule3-time"><?php _e('time', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-4">
				<input type="text" name="ycd-schedule3-time" id="ycd-schedule3-time" class="form-control js-datetimepicker-seconds" value="<?php echo esc_attr($this->getOptionValue('ycd-schedule3-time')); ?>" autocomplete="off">
			</div>
		</div>
	</div>
<div class="row">
    <div class="col-md-6">
        <label for="ycd-countdown-end-sound" class="ycd-label-of-switch"><?php _e('Display On', YCD_TEXT_DOMAIN); ?></label>
    </div>
    <div class="col-md-6">
        <label class="ycd-switch">
            <input type="checkbox" id="ycd-countdown-display-on" name="ycd-countdown-display-on" class="ycd-accordion-checkbox" <?php echo $this->getOptionValue('ycd-countdown-display-on'); ?>>
            <span class="ycd-slider ycd-round"></span>
        </label>
    </div>
</div>
<div class="ycd-accordion-content ycd-hide-content">
    <?php require_once dirname(__FILE__).'/displaySettings.php'; ?>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="ycd-countdown-end-sound" class="ycd-label-of-switch"><?php _e('Timer End Sound', YCD_TEXT_DOMAIN); ?></label>
    </div>
    <div class="col-md-6">
        <label class="ycd-switch">
            <input type="checkbox" id="ycd-countdown-end-sound" name="ycd-countdown-end-sound" class="ycd-accordion-checkbox" <?php echo $this->getOptionValue('ycd-countdown-end-sound'); ?>>
            <span class="ycd-slider ycd-round"></span>
        </label>
    </div>
</div>
<div class="ycd-accordion-content ycd-hide-content">
    <div class="row form-group">
        <div class="col-md-2">
            <input id="js-upload-countdown-end-sound" class="btn btn-sm" type="button" value="<?php _e('Change sound', YCD_TEXT_DOMAIN); ?>">
        </div>
        <div class="col-md-2">
            <input type="button" data-default-song="<?= $this->getDefaultValue('ycd-countdown-end-sound-url'); ?>" id="js-reset-to-default-song" class="btn btn-sm btn-danger" value="<?php _e('Reset', YCD_TEXT_DOMAIN); ?>">
        </div>
        <div class="col-md-5">
            <input type="text" id="js-sound-open-url" readonly="" class="form-control input-sm" name="ycd-countdown-end-sound-url" value="<?= esc_attr($this->getOptionValue('ycd-countdown-end-sound-url')); ?>">
        </div>
        <div class="col-md-1">
            <span class="dashicons dashicons-controls-volumeon js-preview-sound"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div>
            <label for="ycd-edtitor-css" class="ycd-label-of-switch"><?php _e('Custom CSS', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <textarea id="ycd-edtitor-css" id="ycd-edtitor-css" rows="5" name="ycd-custom-css" class="widefat textarea"><?php echo esc_attr($this->getOptionValue('ycd-custom-css')); ?></textarea>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div>
            <label for="ycd-edtitor-js" class="ycd-label-of-switch"><?php _e('Custom JS', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <textarea id="ycd-edtitor-js" id="ycd-edtitor-js" rows="5" name="ycd-custom-js" class="widefat textarea"><?php echo esc_attr($this->getOptionValue('ycd-custom-js')); ?></textarea>
    </div>
</div>
</div>

<style type="text/css">
    .edit-post-status,
    .edit-visibility,
    .edit-timestamp {
        display: none;
    }
</style>
