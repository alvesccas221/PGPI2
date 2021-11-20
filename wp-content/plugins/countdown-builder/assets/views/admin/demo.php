<?php if(YCD_PKG_VERSION == YCD_FREE_VERSION): ?>
	<div class="row form-group">
		<div class="col-md-6">
			<label><?php _e('DEMO')?></label>
		</div>
		<div class="col-md-6">

		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-4">
			<span><?php _e('Website')?></span><br><br>
			<label><a href="<?php echo YCD_DEMO_URL; ?>" target="_blank">Visit</a></label>
		</div>
		<div class="col-md-4">
			<span><?php _e('Login')?></span><br><br>
			<label><span>demo</span></label>
		</div>
		<div class="col-md-4">
			<span><?php _e('Password')?></span><br><br>
			<label><span>demo</span></label>
		</div>
	</div>
<?php endif; ?>