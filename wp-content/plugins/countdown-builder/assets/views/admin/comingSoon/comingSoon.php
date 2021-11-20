<?php
use ycd\AdminHelper;
$defaultData = AdminHelper::defaultData();
?>
<?php if(!empty($_GET['saved'])) : ?>
    <div id="default-message" class="updated notice notice-success is-dismissible">
        <p><?php echo _e('Settings saved.', YCD_TEXT_DOMAIN);?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo _e('Dismiss this notice.', YCD_TEXT_DOMAIN);?></span></button>
    </div>
<?php endif; ?>
<div class="ycd-bootstrap-wrapper ycd-settings-wrapper">
    <form method="POST" action="<?php echo admin_url().'admin-post.php?action=ycdComingSoon'?>">
	<div class="row">
		<div class="col-lg-8">
            <div class="row form-group">
                <label class="savae-changes-label"><?php _e('Change settings'); ?></label>
                <div class="pull-right">
                    <input type="submit" class="btn btn-primary" value="Save Changes">
                </div>
            </div>
			<?php require_once YCD_ADMIN_COMING_VIEWS_PATH.'comingSoonSettings.php'; ?>
			<?php require_once YCD_ADMIN_COMING_VIEWS_PATH.'comingSoonHeader.php'; ?>
            <?php require_once YCD_ADMIN_COMING_VIEWS_PATH.'comingSoonDesign.php'; ?>
            <?php require_once YCD_ADMIN_COMING_VIEWS_PATH.'comingSoonOptions.php'; ?>
		</div>
		<div class="col-lg-4">
			<?php require_once YCD_ADMIN_COMING_VIEWS_PATH.'comingSoonSupport.php'; ?>
		</div>
	</div>
    </form>
</div>
