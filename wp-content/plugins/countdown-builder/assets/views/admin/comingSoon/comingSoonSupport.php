<div class="panel panel-default"style="margin-top: 48px;">
	<div class="panel-heading"><?php _e('Support', YCD_TEXT_DOMAIN)?></div>
	<div class="panel-body">
		<h3 style="margin-top: 0;"><?php _e('Support', YCD_TEXT_DOMAIN)?> <span class="dashicons dashicons-megaphone"></span></h3>
		<p style="text-align: center">
			We love our plugin and do the best to improve all features for You. But sometimes issues happened, or you can't find required feature that you need. Don't worry, just  pressing here
			<br>
			<a href="<?php echo YCD_COUNTDOWN_SUPPORT_URL; ?>" style="font-size: 18px; cursor: pointer;" target="_blank">
				<button type="button" id="ycd-report-problem-button" class="ycd-support-button-red" style="margin: 10px;">
					<i class="ai1wm-icon-notification"></i>
					<?php _e('Report issue', YCD_TEXT_DOMAIN)?>
				</button>
			</a><br>
			and we will be happy to help you!</p>
		<style>
			.ycd-support-metabox {
				text-align: left !important;
			}
		</style>
	</div>
	<?php require_once YCD_ADMIN_VIEWS_PATH.'demo.php'; ?>
</div>