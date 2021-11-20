<div class="ycd-live-preview" id="ycd-live-preview">
	<div class="ycd-live-preview-text">
		<h3><?php _e('Live preview',YCD_TEXT_DOMAIN)?></h3>
		<div class="ycd-toggle-icon ycd-toggle-icon-open"></div>
	</div>
	<div class="ycd-livew-preview-content">
		<?php
		if(method_exists($typeObj, 'renderLivePreview')) {
			$typeObj->renderLivePreview();
		}
		?>
	</div>
</div>