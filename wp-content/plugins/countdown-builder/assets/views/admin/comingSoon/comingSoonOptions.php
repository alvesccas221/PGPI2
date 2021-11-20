<?php
use ycd\AdminHelper;
use ycd\HelperFunction;
$defaultData = AdminHelper::defaultData();
$userSavedRoles = $this->getOptionValue('ycd-coming-soon-user-roles');

if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
	$isPro = '-pro';
	$proSpan = '<span class="ycd-pro-span">'.__('pro', YCD_TEXT_DOMAIN).'</span>';
}
?>
<div class="panel panel-default">
	<div class="panel-heading"><?php _e('Options', YCD_TEXT_DOMAIN)?></div>
	<div class="panel-body">
		<?php if (YcdDataAccess::isHidden('comingSoonSchedule')): ?>
		<!-- Start automatically enable countdown -->
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-automat-enable" class="ycd-label-of-switch"><?php _e('Automatically start by date', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
				<label class="ycd-switch">
					<input type="checkbox" id="ycd-coming-soon-automat-enable" name="ycd-coming-soon-automat-enable" class="ycd-accordion-checkbox" <?php echo $this->getOptionValue('ycd-coming-soon-automat-enable'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
		<div class="ycd-accordion-content ycd-hide-content">
			<div class="row form-group">
				<div class="col-md-6">
					<label for="ycd-coming-soon-start-timezone" class="ycd-label-of-input"><?php _e('Time Zone', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-6">
					<div class="ycd-select-wrapper">
						<?php echo AdminHelper::selectBox($defaultData['time-zone'], esc_attr($this->getOptionValue('ycd-coming-soon-start-timezone')), array('name' => 'ycd-coming-soon-start-timezone', 'class' => 'js-ycd-select')); ?>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<label for="ycd-coming-soon-user-roles"><?php _e('Select start date', YCD_TEXT_DOMAIN)?></label>
				</div>
				<div class="col-md-6">
					<input type="text" id="ycd-coming-soon-start" class="form-control ycd-date-time-picker" name="ycd-coming-soon-start" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-start')); ?>">
				</div>
			</div>
		</div>
		<!-- End automatically enable countdown -->
		<!-- Start automatically expiration countdown -->
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-automat-expiration" class="ycd-label-of-switch"><?php _e('Automatically Expire by date', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
				<label class="ycd-switch">
					<input type="checkbox" id="ycd-coming-soon-automat-expiration" name="ycd-coming-soon-automat-expiration" class="ycd-accordion-checkbox" <?php echo $this->getOptionValue('ycd-coming-soon-automat-expiration'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
		<div class="ycd-accordion-content ycd-hide-content">
			<div class="row form-group">
				<div class="col-md-6">
					<label for="ycd-coming-soon-expiration-timezone" class="ycd-label-of-input"><?php _e('Time Zone', YCD_TEXT_DOMAIN); ?></label>
				</div>
				<div class="col-md-6">
					<div class="ycd-select-wrapper">
						<?php echo AdminHelper::selectBox($defaultData['time-zone'], esc_attr($this->getOptionValue('ycd-coming-soon-expiration-timezone')), array('name' => 'ycd-coming-soon-expiration-timezone', 'class' => 'js-ycd-select')); ?>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<label for="ycd-coming-soon-expiration"><?php _e('Select expiration date', YCD_TEXT_DOMAIN)?></label>
				</div>
				<div class="col-md-6">
					<input type="text" id="ycd-coming-soon-expiration" class="form-control ycd-date-time-picker" name="ycd-coming-soon-expiration" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-expiration')); ?>">
				</div>
			</div>
		</div>
		<!-- End automatically expiration countdown -->
		<?php endif; ?>
		<!-- start User role options -->
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-for-loggdin" class="ycd-label-of-switch"><?php _e('Show on selected user roles', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
				<label class="ycd-switch">
					<input type="checkbox" id="ycd-coming-soon-for-loggdin" name="ycd-coming-soon-for-loggdin" class="ycd-accordion-checkbox" <?php echo $this->getOptionValue('ycd-coming-soon-for-loggdin'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
		<div class="row form-group ycd-accordion-content ycd-hide-content">
			<div class="col-md-6">
				<label for="ycd-coming-soon-user-roles"><?php _e('Select user role(s)', YCD_TEXT_DOMAIN)?></label>
			</div>
			<div class="col-md-6">
				<?php echo HelperFunction::createSelectBox($defaultData['userRoles'], $userSavedRoles, array('name' => 'ycd-coming-soon-user-roles[]', 'class' => 'js-ycd-select  ycd-countdowns', 'multiple' => 'multiple', 'id' => 'ycd-coming-soon-user-roles')); ?>
			</div>
		</div>
		<!-- end User role options -->
		<!-- start white list option -->
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-whitelist-ip" class="ycd-label-of-switch"><?php _e('White list IP address', YCD_TEXT_DOMAIN); echo $proSpan; ?></label>
			</div>
			<div class="col-md-6 ycd-circles-width-wrapper ycd-option-wrapper<?php echo $isPro; ?>">
				<label class="ycd-switch">
					<input type="checkbox" id="ycd-coming-soon-whitelist-ip" name="ycd-coming-soon-whitelist-ip" class="ycd-accordion-checkbox" <?php echo $this->getOptionValue('ycd-coming-soon-whitelist-ip'); ?>>
					<span class="ycd-slider ycd-round"></span>
				</label>
			</div>
		</div>
		<div class="ycd-accordion-content ycd-hide-content">
			<div class="col-md-6">
				<label for="ycd-coming-soon-ip-address"><?php _e('IP address(s)', YCD_TEXT_DOMAIN);?></label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" name="ycd-coming-soon-ip-address" placeholder="<?php _e('You can enter multiple IP address, just separate them with comma', YCD_TEXT_DOMAIN)?>" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-ip-address'))?>">
			</div>
		</div>
		<!-- end white list option -->
	</div>
</div>