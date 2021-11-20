<?php
namespace ycd;

class Tickbox {
	private $isEditorButton = false;
	private $isLoadedMediaData = false;

	public function __construct($isEditorButton = false, $isLoadedMediaData = false) {
		if (isset($isEditorButton)) {
			$this->isEditorButton = $isEditorButton;
		}
		if (isset($isLoadedMediaData)) {
			$this->isLoadedMediaData = $isLoadedMediaData;
		}
		$this->mediaButton();
		if(!$this->isLoadedMediaData) {
			add_action( 'admin_footer', array($this, 'ycdAdminTickBox'));
		}
	}

	private function mediaButton() {
		global $pagenow, $typenow;
		$output = '';

		/** Only run in post/page creation and edit screens */
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) && $typenow != 'download' ) {
			wp_enqueue_script('jquery-ui-dialog');
			wp_register_style('ycd_jQuery_ui', YCD_COUNTDOWN_CSS_URL.'jQueryDialog/jquery-ui.css');
			wp_enqueue_style('ycd_jQuery_ui');
			$img = '<span class="wp-media-buttons-icon dashicons dashicons-clock" id="ycd-media-button" style="margin-right: 5px !important;"></span>';
			$output = '<a href="javascript:void(0);" class="button ycd-thickbox" style="padding-left: .4em;">' . $img . __('Countdown Builder', YCD_TEXT_DOMAIN) . '</a>';

		}

		if (!$this->isEditorButton) {
			echo $output;
		}
	}


	function ycdAdminTickBox() {
		global $pagenow, $typenow;

		// Only run in post/page creation and edit screens
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) && $typenow != 'download' ) { ?>
			<script type="text/javascript">
				function insertCountdownDownload() {
					var id = jQuery('.ycd-countdowns').val();

					// Return early if no download is selected
					if (!id) {
						alert('<?php _e('Select your countdown', YCD_TEXT_DOMAIN); ?>');
						return;
					}

					function getTextTabSelectionText() // javascript
					{
						// obtain the object reference for the <textarea>
						var txtarea = document.querySelector("textarea[name='content']");
						// obtain the index of the first selected character
						var start = txtarea.selectionStart;
						// obtain the index of the last selected character
						var finish = txtarea.selectionEnd;
						// obtain the selected text
						var sel = txtarea.value.substring(start, finish);
						// do something with the selected content

                        return sel;
					}

					if (tinyMCE.activeEditor == null) {
						var selection = getTextTabSelectionText();
                    }
                    else {
						var selection = tinyMCE.activeEditor.selection.getContent();
                    }

					// Send the shortcode to the editor
					window.send_to_editor('[ycd_countdown id="'+id+'"]'+selection+'[/ycd_countdown]');
					jQuery('#ycd-dialog').dialog('close')
				}
				jQuery(document).ready(function ($) {
					$('.ycd-thickbox').bind('click', function() {
						jQuery('#ycd-dialog').dialog({
                            width: 450,
                            modal: true,
                            title: "Insert the shortcode",
                            dialogClass: "ycd-countdown-builder"
                        });
					});
				});
			</script>
			<?php
			$popups = Countdown::getCountdownsObj();
			$idTitle = Countdown::shapeIdTitleData($popups);
			?>

			<div id="ycd-dialog" style="display: none;">
				<div class="wrap" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
					<p>
						<label><?php _e('Select countdown', YCD_TEXT_DOMAIN); ?>:</label>
                        <?php if(!empty($idTitle)): ?>
						    <?php echo HelperFunction::createSelectBox($idTitle, '', array('name' => 'ycdOption', 'class' => 'ycd-countdowns')); ?>
                        <?php else: ?>
                            <a href="<?php echo YCD_ADMIN_URL.'edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE.'&page='.YCD_COUNTDOWN_POST_TYPE; ?>"><?php _e('Add New Countdown', YCD_TEXT_DOMAIN); ?></a>
                        <?php endif; ?>
					</p>
					<p class="submit">
						<input type="button" id="edd-insert-download" class="button-primary" value="<?php _e('Insert', YCD_TEXT_DOMAIN)?>" onclick="insertCountdownDownload();" />
						<a id="edd-cancel-download-insert" class="button-secondary" onclick="jQuery('#ycd-dialog').dialog('close')();"><?php _e( 'Cancel', 'easy-digital-downloads' ); ?></a>
					</p>
				</div>
			</div>
			<?php
		}
	}
}