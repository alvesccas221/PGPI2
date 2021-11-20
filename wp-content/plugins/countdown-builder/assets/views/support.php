<div class="ycd-bootstrap-wrapper ycd-settings-wrapper">
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading"><?php _e('Support', YCD_TEXT_DOMAIN)?></div>
				<div class="panel-body">
					<form id="ycd-form">
					<div class="row form-group">
						<div class="col-md-3">
							<label style="margin-top: 8px;"> <?php _e('Choose Support Type', YCD_TEXT_DOMAIN)?> </label>
						</div>
						<div class="col-md-3">
							<span>
								<input type="radio" checked="" name="report_type" value="Technical Support" id="ycd_tab_pr"><label class="ycd-inline-label-radio radio" for="ycd_tab_pr"><?php _e('Technical Support', YCD_TEXT_DOMAIN)?></label>
							</span>
						</div>
						<div class="col-md-3">
							<span>
								<input type="radio" name="report_type" value="Suggestion" id="ycd_tab_sug"> <label class="ycd-inline-label-radio radio" for="ycd_tab_sug"><?php _e('Suggestion', YCD_TEXT_DOMAIN)?></label>
							</span>
						</div>
						<div class="col-md-3">
							<span>
								<input type="radio" name="report_type" value="Feature Request" id="ycd_tab_q"> <label class="ycd-inline-label-radio radio" for="ycd_tab_q"><?php _e('Feature Request', YCD_TEXT_DOMAIN)?></label>
							</span>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3">
							<label for="ycd-name"><?php _e('Name', YCD_TEXT_DOMAIN)?>*</label>
						</div>
						<div class="col-md-5">
							<input type="text" id="ycd-name" class="form-control input-sm ycd-required-fields" data-error="ycd-error-name" name="name" value="">
						</div>
					</div>
                    <div class="row form-group ycd-hide ycd-error-name">
                        <div class="col-md-12">
                            <label class="ycd-error"><?= __('This filed is required', YCD_TEXT_DOMAIN)?></label>
                        </div>
                    </div>
					<div class="row form-group">
						<div class="col-md-3">
							<label for="ycd-email"><?php _e('Email Address', YCD_TEXT_DOMAIN)?>*</label>
						</div>
						<div class="col-md-5">
							<input type="text" id="ycd-email" class="form-control input-sm ycd-required-fields" data-error="ycd-error-email" name="email" value="<?= get_option('admin_email'); ?>">
						</div>
					</div>
                    <div class="row form-group ycd-hide ycd-error-email">
                        <div class="col-md-12">
                            <label class="ycd-error"><?= __('This filed is required', YCD_TEXT_DOMAIN)?></label>
                        </div>
                    </div>
                    <div class="row form-group ycd-hide ycd-validate-email-error">
                        <div class="col-md-12">
                            <label class="ycd-error"><?= __('Please enter a valid email address', YCD_TEXT_DOMAIN)?></label>
                        </div>
                    </div>
					<div class="row form-group">
						<div class="col-md-3">
							<label for="ycd-website"><?php _e('Website', YCD_TEXT_DOMAIN)?>*</label>
						</div>
						<div class="col-md-5">
							<input type="text" id="ycd-website" class="form-control input-sm ycd-required-fields" data-error="ycd-error-website" name="website" value="<?= get_option('siteurl'); ?>">
						</div>
					</div>
					<div class="row form-group ycd-hide ycd-error-website">
                        <div class="col-md-12">
                            <label class="ycd-error"><?= __('This filed is required', YCD_TEXT_DOMAIN)?></label>
                        </div>
					</div>
					<div class="row form-group">
						<div class="col-md-3">
							<label for="ycd-message"><?php _e('Message', YCD_TEXT_DOMAIN)?></label>
						</div>
						<div class="col-md-5">
							<textarea name="ycd-message" for="ycd-message" class="form-control">

							</textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input class="button-primary gfbutton" type="submit" id="ycd-support-request-button" name="" value="<?php _e('Request Support', YCD_TEXT_DOMAIN)?>">
                            <img src="<?= YCD_COUNTDOWN_IMG_URL.'ajax.gif'; ?>" alt="gif" class="ycd-support-spinner js-ycd-spinner ycd-hide" width="20px">
						</div>
					</div>
					</form>
                    <div class="row ycd-support-success ycd-hide">
                        <div class="col-md-12">
	                        <?php _e('Thank you for contacting us!', YCD_TEXT_DOMAIN)?>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		<div class="col-lg-6"></div>
	</div>
</div>

