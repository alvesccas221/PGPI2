<div class="ycd-bootstrap-wrapper">
	<?php require_once YCD_ADMIN_VIEWS_PATH.'demo.php'; ?>
    <div class="row">
        <div class="col-md-12">
            <label>
		        <?php _e('Shortcode', YCD_TEXT_DOMAIN); ?>
            </label>
	        <?php
	        $postId = @$_GET['post'];
	        if (empty($postId)) : ?>
                <p>Please do save the Countdown, to getting the shortcode.</p>
	        <?php else: ?>
                <div class="ycd-tooltip">
                    <span class="ycd-tooltiptext" id="ycd-tooltip-<?php echo $postId; ?>">Copy to clipboard</span><input type="text" data-id="<?php echo $postId; ?>" onfocus="this.select();" readonly="" id="ycd-shortcode-input-<?php echo $postId; ?>" value="[ycd_countdown id=<?php echo $postId; ?>]" class="large-text code countdown-shortcode"></div>
	        <?php endif; ?>
            <br>
            <label>
		        <?php _e('Current version', YCD_TEXT_DOMAIN); ?>
            </label>
            <p class="current-version-text" style="color: #3474ff;"><?php echo YCD_VERSION_TEXT; ?></p>
            <label>
		        <?php _e('Last update date', YCD_TEXT_DOMAIN); ?>
            </label>
            <p style="color: #11ca79;"><?php echo YCD_LAST_UPDATE; ?></p>
            <label>
		        <?php _e('Next update date', YCD_TEXT_DOMAIN); ?>
            </label>
            <p style="color: #efc150;"><?php echo YCD_NEXT_UPDATE; ?></p>
        </div>
    </div>
</div>