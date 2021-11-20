<?php
use ycd\AdminHelper;
$defaultData = AdminHelper::defaultData();
$type = $this->getCurrentTypeFromOptions();

$isPro = '';
$proSpan = '';
if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
    $isPro = '-pro';
    $proSpan = '<span class="ycd-pro-span">'.__('pro', YCD_TEXT_DOMAIN).'</span>';
}
?>
<div class="ycd-bootstrap-wrapper">
    <?php require_once(dirname(__FILE__).'/clockTimerSettings.php'); ?>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ycd-clock2-width" class="ycd-label-of-input"><?php _e('Dimension', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">
			<input type="number" name="ycd-clock2-width" data-target-index="2" class="form-control ycd-clock-width" id="ycd-clock2-width" value="<?php echo esc_attr($this->getOptionValue('ycd-clock2-width')); ?>">
		</div>
		<div class="col-md-1 ycd-label-of-input">
			<?php _e('px', YCD_TEXT_DOMAIN); ?>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ycd-label-of-input"><?php _e('Alignment', YCD_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-5">
			<?php echo AdminHelper::selectBox($defaultData['horizontal-alignment'], esc_attr($this->getOptionValue('ycd-clock2-alignment')), array('name' => 'ycd-clock2-alignment', 'class' => 'js-ycd-select ycd-clock2-alignment ycd-clock-alignment')); ?>
		</div>
	</div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-clock2-dial1-color" class=""><?php _e('Detail 1 color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
        </div>
        <div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-clock2-dial1-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-clock2-dial1-color" class="minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($this->getOptionValue('ycd-clock2-dial1-color')); ?>">
            </div>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-clock2-dial2-color" class=""><?php _e('Detail 2 color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
        </div>
        <div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-clock2-dial2-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-clock2-dial2-color" class="minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($this->getOptionValue('ycd-clock2-dial2-color')); ?>">
            </div>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-clock2-dial3-color" class=""><?php _e('Detail 3 color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
        </div>
        <div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-clock2-dial3-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-clock2-dial3-color" class="minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($this->getOptionValue('ycd-clock2-dial3-color')); ?>">
            </div>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-clock2-time-color" class=""><?php _e('Time color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
        </div>
        <div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-clock2-time-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-clock2-time-color" class="minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($this->getOptionValue('ycd-clock2-time-color')); ?>">
            </div>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="ycd-clock2-date-color" class=""><?php _e('Date color', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
        </div>
        <div class="col-md-5 ycd-option-wrapper<?php echo $isPro; ?>">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-clock2-date-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-clock2-date-color" class="minicolors-input form-control js-ycd-time-color" value="<?php echo esc_attr($this->getOptionValue('ycd-clock2-date-color')); ?>">
            </div>
        </div>
    </div>
</div>
<?php
require_once YCD_VIEWS_PATH.'preview.php';
?>
<input type="hidden" name="ycd-type" value="<?php echo esc_attr($type); ?>">