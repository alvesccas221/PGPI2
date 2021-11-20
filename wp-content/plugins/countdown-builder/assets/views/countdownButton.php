<?php
use ycd\AdminHelper;
use ycd\MultipleChoiceButton;
$defaults = AdminHelper::defaultData();
?>
<div class="ycd-bootstrap-wrapper">
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-countdown-enable-button" class="ycd-label-of-switch"><?php _e('Enable Button', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
            <label class="ycd-switch">
                <input type="checkbox" id="ycd-countdown-enable-button" data-id="0" name="ycd-countdown-enable-button" class="" <?php echo $typeObj->getOptionValue('ycd-countdown-enable-button'); ?>>
                <span class="ycd-slider ycd-round"></span>
            </label>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-countdown-show-after-expire" class="ycd-label-of-switch"><?php _e('Show after Expiration', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
            <label class="ycd-switch">
                <input type="checkbox" id="ycd-countdown-show-after-expire" data-id="0" name="ycd-countdown-show-after-expire" class="" <?php echo $typeObj->getOptionValue('ycd-countdown-show-after-expire'); ?>>
                <span class="ycd-slider ycd-round"></span>
            </label>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-name"><?php _e('Button name', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
            <input id="ycd-button-name" class="form-control" type="text" name="ycd-button-name" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-name'))?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-width"><?php _e('Button width', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
            <input id="ycd-button-width" class="form-control" type="text" name="ycd-button-width" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-width'))?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-height"><?php _e('Button height', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
            <input id="ycd-button-height" class="form-control" type="text" name="ycd-button-height" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-height'))?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-border-width"><?php _e('Border width', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
            <input id="ycd-button-border-width" class="form-control" type="text" name="ycd-button-border-width" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-border-width'))?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-border-width"><?php _e('Border radius', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
            <input id="ycd-button-border-radius" class="form-control" type="number" name="ycd-button-border-radius" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-border-radius'))?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-xs-4">
            <label class="control-label"><?php _e('Margin', YCD_TEXT_DOMAIN);?></label>
        </div>
        <div class="col-xs-2">
            <label for="ycd-button-margin-top" class="ycd-label">Top</label>
            <input type="text" id="ycd-button-margin-top" data-direction="top" name="ycd-button-margin-top" class="form-control button-padding" value="<?php echo $typeObj->getOptionValue('ycd-button-margin-top')?>">
        </div>
        <div class="col-xs-2">
            <label for="ycd-button-margin-right" class="ycd-label">Right</label>
            <input type="text" id="ycd-button-margin-right" data-direction="right" name="ycd-button-margin-right" class="form-control button-padding" value="<?php echo $typeObj->getOptionValue('ycd-button-margin-right')?>">
        </div>
        <div class="col-xs-2">
            <label for="ycd-button-margin-bottom" class="ycd-label">Bottom</label>
            <input type="text" id="ycd-button-margin-bottom" data-direction="bottom" name="ycd-button-margin-bottom" class="form-control button-padding" value="<?php echo $typeObj->getOptionValue('ycd-button-margin-bottom')?>">
        </div>
        <div class="col-xs-2">
            <label for="ycd-button-margin-left" class="ycd-label">Left</label>
            <input type="text" id="ycd-button-margin-left" data-direction="left" name="ycd-button-margin-left" class="form-control button-padding" value="<?php echo $typeObj->getOptionValue('ycd-button-margin-left')?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-opacity" class="ycd-range-slider-wrapper"><?php _e('Opacity', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-7">
            <input type="text" id="ycd-button-opacity" name="ycd-button-opacity" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-opacity')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-border-width"><?php _e('Font size', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
            <input id="ycd-button-font-size" class="form-control" type="text" name="ycd-button-font-size" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-font-size'))?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-border-width"><?php _e('Font family', YCD_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-7">
			<?php echo AdminHelper::selectBox(array(), esc_attr($typeObj->getOptionValue('ycd-button-font-family')), array('name' => 'ycd-button-font-family', 'class' => 'js-ycd-select js-countdown-font-family')); ?>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-bg-color" class=""><?php _e('Background color', YCD_TEXT_DOMAIN);?></label>
        </div>
        <div class="col-md-7">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-button-bg-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-button-bg-color" class=" form-control js-ycd-button-color" value="<?= esc_attr($typeObj->getOptionValue('ycd-button-bg-color')); ?>">
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-color" class=""><?php _e('Color', YCD_TEXT_DOMAIN);?></label>
        </div>
        <div class="col-md-7">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-button-color" data-type="color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-button-color" class=" form-control js-ycd-button-color" value="<?= esc_attr($typeObj->getOptionValue('ycd-button-color')); ?>">
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button--border-color" class=""><?php _e('Border color', YCD_TEXT_DOMAIN);?></label>
        </div>
        <div class="col-md-7">
            <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                <input type="text" id="ycd-button-border-color" data-type="border-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-button-border-color" class=" form-control js-ycd-button-color" value="<?= esc_attr($typeObj->getOptionValue('ycd-button-border-color')); ?>">
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-hover-animation" class="ycd-label-of-switch"><?php _e('Hover Animation', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-7">
            <label class="ycd-switch">
                <input type="checkbox" id="ycd-button-hover-animation" name="ycd-button-hover-animation" class="ycd-accordion-checkbox" <?php echo $typeObj->getOptionValue('ycd-button-hover-animation'); ?>>
                <span class="ycd-slider ycd-round"></span>
            </label>
        </div>
    </div>
    <div class="ycd-accordion-content button-hover-animation-content ycd-hide-content">
        <div class="row form-group">
            <div class="col-md-5">
                <label for="" class="ycd-label-of-input"><?php _e('Select Animation', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-4">
				<?php echo AdminHelper::selectBox($defaults['hover-animation'], esc_attr($typeObj->getOptionValue('ycd-button-hover-animation-name')), array('name' => 'ycd-button-hover-animation-name', 'class' => 'js-ycd-select ycd-button-hover-animation-name')); ?>
            </div>
            <div class="col-md-1">
                <span class="ycd-btn-hover-preview-icon"></span>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-5">
                <label for="ycd-button-hover-animation-speed" class="ycd-label-of-input"><?php _e('Speed', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-4">
                <input type="number" name="ycd-button-hover-animation-speed" class="form-control ycd-button-hover-animation-speed" id="ycd-button-hover-animation-speed" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-hover-animation-speed'))?>">
            </div>
            <div class="col-md-1">
                <span><?php _e('Second(a)', YCD_TEXT_DOMAIN);?></span>
            </div>
        </div>
        <div class="hover-animation-preview ycd-hide-content"></div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-hover-colors" class="ycd-label-of-switch"><?php _e('Hover color', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-7">
            <label class="ycd-switch">
                <input type="checkbox" id="ycd-button-hover-colors" name="ycd-button-hover-colors" class="ycd-accordion-checkbox" <?php echo $typeObj->getOptionValue('ycd-button-hover-colors'); ?>>
                <span class="ycd-slider ycd-round"></span>
            </label>
        </div>
    </div>
    <div class="ycd-accordion-content ycd-hide-content">
        <div class="row form-group">
            <div class="col-md-5">
                <label for="ycd-button-hover-bg-colo" class=""><?php _e('Background color', YCD_TEXT_DOMAIN);?></label>
            </div>
            <div class="col-md-7">
                <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                    <input type="text" id="ycd-button-hover-bg-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-button-hover-bg-color" class=" form-control js-ycd-button-color" value="<?= esc_attr($typeObj->getOptionValue('ycd-button-hover-bg-color')); ?>">
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-5">
                <label for="ycd-button-hover-color" class=""><?php _e('Color', YCD_TEXT_DOMAIN);?></label>
            </div>
            <div class="col-md-7">
                <div class="minicolors minicolors-theme-default minicolors-position-bottom minicolors-position-left">
                    <input type="text" id="ycd-button-hover-color" placeholder="<?php _e('Select color', YCD_TEXT_DOMAIN)?>" name="ycd-button-hover-color" class=" form-control js-ycd-button-color" value="<?= esc_attr($typeObj->getOptionValue('ycd-button-hover-color')); ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-action-url-tab" class=""><?php _e('Horizontal Align', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-7">
			<?php echo AdminHelper::selectBox(array(),$typeObj->getOptionValue('ycd-button-horizontal'), array('class' => 'js-ycd-select', 'name' => 'ycd-button-horizontal')); ?>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <label for="ycd-button-action-url-tab" class="ycd-label-of-switch"><?php _e('Add Button After Countdown', YCD_TEXT_DOMAIN); ?></label>
        </div>
        <div class="col-md-7">
            <label class="ycd-switch">
                <input type="checkbox" id="ycd-button-after-countdown" name="ycd-button-after-countdown" <?php echo $typeObj->getOptionValue('ycd-button-after-countdown'); ?>>
                <span class="ycd-slider ycd-round"></span>
            </label>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label class="ycd-label-of-switch">Action</label>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="ycd-multichoice-wrapper">
		<?php
		$multipleChoiceButton = new MultipleChoiceButton($defaults['countdown-behavior'], esc_attr('redirect'));
		echo $multipleChoiceButton;
		?>
    </div>
    <div id="ycd-countdown-button-redirect" class="ycd-sub-option ycd-hide">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-button-action-url"><?php _e('URL', YCD_TEXT_DOMAIN)?></label>
            </div>
            <div class="col-md-6">
                <input id="ycd-button-action-url" class="form-control" type="url" name="ycd-button-action-url" value="<?php echo esc_url($typeObj->getOptionValue('ycd-button-action-url'))?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-button-action-url-tab" class="ycd-label-of-switch"><?php _e('Redirect to new tab', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <label class="ycd-switch">
                    <input type="checkbox" id="ycd-button-action-url-tab" name="ycd-button-action-url-tab" class="ycd-accordion-checkbox" <?php echo $typeObj->getOptionValue('ycd-button-action-url-tab'); ?>>
                    <span class="ycd-slider ycd-round"></span>
                </label>
            </div>
        </div>
    </div>
    <div id="ycd-countdown-button-scroll" class="ycd-sub-option ycd-hide">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-scroll-to-selector" class="ycd-label-of-input"><?php _e('CSS Selector', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" id="ycd-scroll-to-selector" placeholder="Ex: #myDivID, .myDivClass" name="ycd-scroll-to-selector" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-scroll-to-selector')); ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-animation-speed" class="ycd-label-of-input"><?php _e('Animation speed', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-5">
                <input type="number" class="form-control" id="ycd-animation-speed" name="ycd-animation-speed" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-animation-speed')); ?>">
            </div>
        </div>
    </div>
    <div id="ycd-countdown-button-download" class="ycd-sub-option ycd-hide">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-download-url" class="ycd-label-of-input"><?php _e('URL', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-2">
                <input id="js-ycd-target-link" class="btn btn-primary" type="button" value="Select File">
            </div>
            <div class="col-md-4">
                <input type="url" class="form-control" id="ycd-download-url" name="ycd-download-url" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-download-url')); ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-download-name" class="ycd-label-of-input"><?php _e('File name', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="ycd-download-name" name="ycd-download-name" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-download-name')); ?>">
            </div>
        </div>
    </div>
    <div id="ycd-countdown-button-copy" class="ycd-sub-option ycd-hide">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ycd-button-copy-text" class="ycd-label-of-input"><?php _e('Text', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="ycd-button-copy-text" name="ycd-button-copy-text" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-copy-text')); ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-5">
                <label for="ycd-button-copy-alert" class="ycd-label-of-switch"><?php _e('Show alert', YCD_TEXT_DOMAIN); ?></label>
            </div>
            <div class="col-md-7">
                <label class="ycd-switch">
                    <input type="checkbox" id="ycd-button-copy-alert" name="ycd-button-copy-alert" class="ycd-accordion-checkbox" <?php echo $typeObj->getOptionValue('ycd-button-copy-alert'); ?>>
                    <span class="ycd-slider ycd-round"></span>
                </label>
            </div>
        </div>
        <div class="ycd-accordion-content ycd-hide-content">
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="ycd-button-alert-text" class="ycd-label-of-input"><?php _e('Text', YCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="ycd-button-alert-text" name="ycd-button-alert-text" value="<?php echo esc_attr($typeObj->getOptionValue('ycd-button-alert-text')); ?>">
                </div>
            </div>
        </div>
    </div>
    <a href="<?php echo YCD_COUNTDOWN_BUTTON_URL; ?>">
        <div class="ycd-pro ycd-pro-options-div" style="text-align: right">
            <button class="ycd-upgrade-button-red ycd-extentsion-pro">
                <b class="h2">Unlock</b><br><span class="h5">Extension</span>
            </button>
        </div>
    </a>
</div>