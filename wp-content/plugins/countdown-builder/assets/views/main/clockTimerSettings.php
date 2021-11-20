<?php
use ycd\AdminHelper;
use ycd\MultipleChoiceButton;
?>
<div class="ycd-multichoice-wrapper">
    <?php
    $multipleChoiceButton = new MultipleChoiceButton($defaultData['clockMode'], esc_attr($this->getOptionValue('ycd-countdown-clock-mode')));
    echo $multipleChoiceButton;
    ?>
</div>
<div id="ycd-countdown-clock-mode-clock" class="ycd-countdown-show-text ycd-hide">
    <div class="row form-group">
        <div class="col-md-6">
            <label class="ycd-label-of-input"><?php _e('Time zone', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-5">
            <?php echo AdminHelper::selectBox($defaultData['clock-time-zone'], esc_attr($this->getOptionValue('ycd-clock-time-zone')), array('name' => 'ycd-clock-time-zone','data-target-index' => '4', 'class' => 'js-ycd-select js-circle-time-zone')); ?>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label class="ycd-label-of-input"><?php _e('Clock mode', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-5">
            <?php echo AdminHelper::selectBox($defaultData['clock-mode'], esc_attr($this->getOptionValue('ycd-clock-mode')), array('name' => 'ycd-clock-mode','data-target-index' => '4', 'class' => 'js-ycd-select ycd-clock-mode')); ?>
        </div>
    </div>
</div>
<div id="ycd-countdown-clock-mode-countdown" class="ycd-countdown-show-text ycd-hide">
    <div class="row form-group">
        <div class="col-md-6">
            <label class="ycd-label-of-input"><?php _e('Time Settings', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-2">
            <label for="ycdTimeHours"><?php _e('Hrs', YCD_TEXT_DOMAIN); ?></label>
            <input type="number" name="ycd-clock-timer-hours" id="ycdTimeHours" min="0" max="60" class="form-control ycd-timer-time-settings" data-type="hours" value="<?php echo esc_attr($this->getOptionValue('ycd-clock-timer-hours'))?>">
        </div>
        <div class="col-md-2">
            <label for="ycdTimeMinutes"><?php _e('Mins', YCD_TEXT_DOMAIN); ?></label>
            <input type="number" name="ycd-clock-timer-minutes" id="ycdTimeMinutes" min="0" max="60" class="form-control ycd-timer-time-settings" data-type="minutes" value="<?php echo esc_attr($this->getOptionValue('ycd-clock-timer-minutes'))?>">
        </div>
        <div class="col-md-2">
            <label for="ycdTimeSeconds"><?php _e('Secs', YCD_TEXT_DOMAIN); ?></label>
            <input type="number" name="ycd-clock-timer-seconds" id="ycdTimeSeconds" min="0" max="60" class="form-control ycd-timer-time-settings" data-type="seconds" value="<?php echo esc_attr($this->getOptionValue('ycd-clock-timer-seconds'))?>">
        </div>
    </div>
</div>