<?php
use ycd\AdminHelper;
$defaultData = AdminHelper::defaultData();
?>
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
			<?php require_once YCD_ADMIN_VIEWS_PATH.'comingSoonSettings.php'; ?>
			<?php require_once YCD_ADMIN_VIEWS_PATH.'comingSoonHeader.php'; ?>
            <?php require_once YCD_ADMIN_VIEWS_PATH.'comingSoonDesign.php'; ?>
		</div>
		<div class="col-lg-6">
		</div>
	</div>
    </form>
</div>
