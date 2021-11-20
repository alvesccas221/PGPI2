jQuery(document).on('tinymce-editor-setup', function( event, editor ) {
	editor.settings.toolbar1 += ',mybutton';
	editor.addButton( 'mybutton', {
		text: 'Countdowns',
		icon: false,
		onclick: function () {
			jQuery('#ycd-dialog').dialog({
				width: 450,
				modal: true,
				title: "Insert the shortcode",
				dialogClass: "ycd-countdown-builder"
			});
		}
	});
});