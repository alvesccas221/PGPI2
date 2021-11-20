<div id="countdown-builder-deactivation-survey-popup-container" class="countdown-builder-deactivation-survey-popup-container is-dismissible" style="display: none;">
	<div class="countdown-builder-deactivation-survey-popup-overlay"></div>

	<div class="countdown-builder-deactivation-survey-popup-tbl">
		<div class="countdown-builder-deactivation-survey-popup-cel">
			<div class="countdown-builder-deactivation-survey-popup-content">

				<div class="countdown-builder-deactivation-survey-header">
					<span class="countdown-builder-uninstall-header-title">Quick Feedback</span>
				</div>
				<div class="countdown-builder-deactivation-survey-content">
					<form class="countdown-builder-deactivation-survey-content-form">
						<p class="countdown-builder-deactivation-survey-content-p">If you have a moment, please share why you are deactivating Countdown Builder:</p>
						<div class="countdown-builder-deactivation-survey-choises-wrapper">

							<div class="countdown-builder-deactivate-feedback-dialog-input-wrapper">
								<input id="countdown-builder-deactivate-feedback-no_longer_needed" class="countdown-builder-deactivate-feedback-dialog-input" type="radio" name="countdown-builder_reason_key" value="no_longer_needed"><label for="countdown-builder-deactivate-feedback-no_longer_needed" class="countdown-builder-deactivate-feedback-dialog-label">I no longer need the plugin</label></div>
							<div class="countdown-builder-deactivate-feedback-dialog-input-wrapper">
								<input id="countdown-builder-deactivate-feedback-found_a_better_plugin" class="countdown-builder-deactivate-feedback-dialog-input" type="radio" name="countdown-builder_reason_key" value="found_a_better_plugin">
								<label for="countdown-builder-deactivate-feedback-found_a_better_plugin" class="countdown-builder-deactivate-feedback-dialog-label">I found a better plugin</label>
								<input class="countdown-builder-feedback-text countdown-builder-survey-sub-choice" type="text" name="countdown-builder_reason_found_a_better_plugin" placeholder="Please share which plugin">
							</div>
							<div class="countdown-builder-deactivate-feedback-dialog-input-wrapper">
								<input id="countdown-builder-deactivate-feedback-couldnt_get_the_plugin_to_work" class="countdown-builder-deactivate-feedback-dialog-input" type="radio" name="countdown-builder_reason_key" value="couldnt_get_the_plugin_to_work">
								<label for="countdown-builder-deactivate-feedback-couldnt_get_the_plugin_to_work" class="countdown-builder-deactivate-feedback-dialog-label">I couldn't get the plugin to work</label>
                                <div class="countdown-builder-feedback-text countdown-builder-survey-sub-choice">
                                    <?php _e('Write Support here'); ?>
                                    <a href="https://wordpress.org/support/plugin/countdown-builder/" target="_blank">
                                        <button type="button" id="ycd-report-problem-button" class="ycd-deactivate-button-red pull-right">
                                            <i class="glyphicon glyphicon-alert"></i>Report issue
                                        </button>
                                    </a>
                                </div>
                            </div>
							<div class="countdown-builder-deactivate-feedback-dialog-input-wrapper">
								<input id="countdown-builder-deactivate-feedback-temporary_deactivation" class="countdown-builder-deactivate-feedback-dialog-input" type="radio" name="countdown-builder_reason_key" value="temporary_deactivation">
								<label for="countdown-builder-deactivate-feedback-temporary_deactivation" class="countdown-builder-deactivate-feedback-dialog-label">It's a temporary deactivation</label>
							</div>
							<div class="countdown-builder-deactivate-feedback-dialog-input-wrapper">
								<input id="countdown-builder-deactivate-feedback-other" class="countdown-builder-deactivate-feedback-dialog-input" type="radio" name="countdown-builder_reason_key" value="other">
								<label for="countdown-builder-deactivate-feedback-other" class="countdown-builder-deactivate-feedback-dialog-label">Other</label>
								<input class="countdown-builder-feedback-text countdown-builder-survey-sub-choice" type="text" name="countdown-builder_reason_other" placeholder="Please share the reason">
							</div>
						</div>
				</div>
				<div class="countdown-builder-deactivation-survey-footer">
					<div class="dialog-buttons-wrapper dialog-lightbox-buttons-wrapper">
						<button class="countdown-builder-survey-btn countdown-builder-survey-submit">Submit &amp; Deactivate</button>
						<button class="countdown-builder-survey-btn countdown-builder-survey-skip">Skip &amp; Deactivate</button></div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
