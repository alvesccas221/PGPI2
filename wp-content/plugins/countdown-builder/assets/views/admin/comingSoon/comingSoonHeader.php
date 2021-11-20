<div class="panel panel-default">
	<div class="panel-heading"><?php _e('Header Settings', YCD_TEXT_DOMAIN)?></div>
	<div class="panel-body">
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-title"><?php _e('Title', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" name="ycd-coming-soon-title" id="ycd-coming-soon-title" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-title'));?>" placeholder="<?php _e('Header title', YCD_TEXT_DOMAIN)?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-seo-description"><?php _e('SEO Meta Description', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-6">
				<textarea name="ycd-coming-soon-seo-description" id="ycd-coming-soon-seo-description" class="form-control" placeholder="<?php _e('SEO description', YCD_TEXT_DOMAIN)?>"><?php echo esc_attr($this->getOptionValue('ycd-coming-soon-seo-description'));?></textarea>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ycd-coming-soon-favicon"><?php _e('Favicon', YCD_TEXT_DOMAIN); ?></label>
			</div>
			<div class="col-md-4">
				<input type="text" class="form-control" name="ycd-coming-soon-favicon" id="ycd-coming-soon-favicon" value="<?php echo esc_attr($this->getOptionValue('ycd-coming-soon-favicon'));?>" placeholder="<?php _e('Favicon', YCD_TEXT_DOMAIN)?>">
			</div>
			<div class="col-md-2">
				<button class="js-ycd-image-btn btn btn-primary" data-src-id="ycd-coming-soon-favicon"><?php _e('Select Image', YCD_TEXT_DOMAIN); ?></button>
			</div>
		</div>
	</div>
</div>