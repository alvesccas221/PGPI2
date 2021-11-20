<?php
    use ycd\AdminHelper;
    use ycd\HelperFunction;
    $defaultData = AdminHelper::defaultData();
    $userSavedRoles = get_option('ycd-user-roles');
    $dontDeleteData = (get_option('ycd-delete-data') ? 'checked': '');
    $hideComingSoon = (get_option('ycd-hide-coming-soon-menu') ? 'checked': '');
    $printScripts = (get_option('ycd-print-scripts-to-page') ? 'checked': '');
?>
<?php if(!empty($_GET['saved'])) : ?>
    <div id="default-message" class="updated notice notice-success is-dismissible">
        <p><?php echo _e('Settings saved.', YCD_TEXT_DOMAIN);?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo _e('Dismiss this notice.', YCD_TEXT_DOMAIN);?></span></button>
    </div>
<?php endif; ?>
<div class="ycd-bootstrap-wrapper ycd-settings-wrapper">
<div class="row">
<div class="col-lg-8">
    <form method="POST" action="<?php echo admin_url().'admin-post.php?action=ycdSaveSettings'?>">
	    <?php wp_nonce_field('YCD_ADMIN_POST_NONCE', YCD_ADMIN_POST_NONCE);?>
        <div class="panel panel-default">
            <div class="panel-heading"><?php _e('Settings', YCD_TEXT_DOMAIN)?></div>
            <div class="panel-body">
                <div class="row form-group">
                    <div class="col-md-3">
                        <label class="ycd-label-of-switch"><?php _e('Remove Settings', YCD_TEXT_DOMAIN)?></label>
                    </div>
                    <div class="col-md-2">
                        <label class="ycd-switch">
                            <input type="checkbox" id="ycd-dont-delete-data" name="ycd-dont-delete-data" class="ycd-accordion-checkbox" <?= $dontDeleteData ?> >
                            <span class="ycd-slider ycd-round"></span>
                        </label>
                    </div>
                    <div class="col-md-7">
                        <label class="ycd-label-of-switch">
                            <?php _e('This option will remove all settings and styles when <b>Delete plugin</b>', YCD_TEXT_DOMAIN)?>
                        </label>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-hide-coming-soon-menu"><?php _e('Hide Coming soon menu', YCD_TEXT_DOMAIN)?></label>
                    </div>
                    <div class="col-md-4">
                        <label class="ycd-switch">
                            <input type="checkbox" id="ycd-hide-coming-soon-menu" name="ycd-hide-coming-soon-menu" class="ycd-accordion-checkbox" <?= $hideComingSoon ?> >
                            <span class="ycd-slider ycd-round"></span>
                        </label>
                    </div>
                </div>
	            <div class="row form-group">
                    <div class="col-md-5">
                        <label for="ycd-print-scripts-to-page"><?php _e('Print scripts to the page', YCD_TEXT_DOMAIN)?></label>
                    </div>
                    <div class="col-md-4">
                        <label class="ycd-switch">
                            <input type="checkbox" id="ycd-print-scripts-to-page" name="ycd-print-scripts-to-page" class="ycd-accordion-checkbox" <?= $printScripts ?> >
                            <span class="ycd-slider ycd-round"></span>
                        </label>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5">
                        <label><?php _e('User role who can use plugin', YCD_TEXT_DOMAIN)?></label>
                    </div>
                    <div class="col-md-4">
			            <?php echo HelperFunction::createSelectBox($defaultData['userRoles'], $userSavedRoles, array('name' => 'ycd-user-roles[]', 'class' => 'js-ycd-select  ycd-countdowns', 'multiple' => 'multiple')); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <input type="submit" value="<?php _e('Save Changes',YCD_TEXT_DOMAIN)?>" class="button-primary">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="col-lg-6"></div>
</div>

</div>

