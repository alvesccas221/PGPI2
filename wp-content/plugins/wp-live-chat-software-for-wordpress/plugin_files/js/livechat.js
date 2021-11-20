(function ($) {
	var LiveChat = {
		slug: config.slug,
		buttonLoaderHtml:
			'<div class="lc-loader-wrapper lc-btn__loader"><div class="lc-loader-spinner-wrapper lc-loader-spinner-wrapper--small"><div class="lc-loader-spinner lc-loader-spinner--thin" /></div></div>',
		init: function () {
			this.openAgentAppInNewTab();
			this.connectNoticeButtonHandler();
			this.deactivationModalOpenHandler();
			this.deactivationModalCloseHandler();
			this.deactivationFormOptionSelectHandler();
			this.deactivationFormSkipHandler();
			this.deactivationFormSubmitHandler();
		},
		sanitize: function (str) {
			var tmpDiv         = document.createElement( 'div' );
			tmpDiv.textContent = str;
			return tmpDiv.innerHTML;
		},
		openAgentAppInNewTab: function () {
			$( "ul#adminmenu a[href='" + config.agentAppUrl + "']" ).attr( 'target', '_blank' );
		},
		connectNoticeButtonHandler: function () {
			$( '#lc-connect-notice-button' ).click(
				function () {
					window.location.replace( 'admin.php?page=livechat_settings' );
				}
			)
		},
		deactivationFormHelpers: {
			hideErrors: function () {
				$( '.lc-field-error' ).hide();
			},
			toggleModal: function () {
				$( '#lc-deactivation-feedback-modal-overlay' ).toggleClass( 'lc-modal-base__overlay--visible' );
			},
			showError: function (errorType) {
				$( '#lc-deactivation-feedback-form-' + errorType + '-error' ).show();
			},
			redirectToDeactivation: function () {
				return window.location.replace(
					$( 'table.plugins tr[data-slug=' + this.slug + '] span.deactivate a' ).attr( 'href' )
				)
			}
		},
		deactivationModalOpenHandler: function () {
			var that = this;
			$( 'table.plugins tr[data-slug=' + that.slug + '] span.deactivate a' ).click(
				function (e) {
					if ($( '#lc-deactivation-feedback-modal-container' ).length < 1) {
						return;
					}
					e.preventDefault();
					that.deactivationFormHelpers.toggleModal();
				}
			)
		},
		deactivationModalCloseHandler: function () {
			var that         = this;
			var modalOverlay = $( '#lc-deactivation-feedback-modal-overlay' );
			modalOverlay.click(
				function (e) {
					if (
					modalOverlay.hasClass( 'lc-modal-base__overlay--visible' ) &&
					(
					! $( e.target ).closest( '#lc-deactivation-feedback-modal-container' ).length ||
					$( e.target ).closest( '.lc-modal-base__close' ).length
					)
					) {
						that.deactivationFormHelpers.toggleModal();
					}
				}
			);
		},
		deactivationFormOptionSelectHandler: function () {
			var that = this;
			$( '.lc-radio' ).click(
				function () {
					that.deactivationFormHelpers.hideErrors();
					var otherTextField = $( '#lc-deactivation-feedback-other-field' );
					$( '.lc-radio' ).removeClass( 'lc-radio--selected' );
					$( this ).addClass( 'lc-radio--selected' );
					if ($( this ).find( '#lc-deactivation-feedback-option-other' ).length > 0) {
						otherTextField.show();
						otherTextField.find( 'textarea' ).focus();
					} else {
						otherTextField.hide();
					}
				}
			)
		},
		sendFeedback: function (response, comment) {
			var that = this;
			response = response ? this.sanitize( response ) : 'skipped';
			comment  = comment ? this.sanitize( comment ) : '';

			var redirectToDeactivation = this.deactivationFormHelpers.redirectToDeactivation.bind( this );

			var deactivationDetails = window.deactivationDetails;

			if ( ! deactivationDetails) {
				return redirectToDeactivation();
			}

			$.ajax(
				{
					method: 'POST',
					url: 'https://script.google.com/macros/s/AKfycbxqXkuWGYrjhWBQ1pfkJuaQ8o3d2uOrGdNiQdYGIBODL5OvOsI/exec',
					data: $.param(
						{
							plugin: that.slug,
							url: window.location.href.replace( /(.*)wp-admin.*/, '$1' ),
							license: deactivationDetails.license,
							name: deactivationDetails.name,
							wpEmail: deactivationDetails.wpEmail,
							response,
							comment
						}
					),
				dataType: 'jsonp',
				complete: redirectToDeactivation
				}
			);
		},
		deactivationFormSkipHandler: function () {
			var that = this;
			$( '#lc-deactivation-feedback-modal-skip-btn' ).click(
				function () {
					$( this ).addClass( 'lc-btn--loading lc-btn--disabled' ).html(
						$( this ).html() + that.buttonLoaderHtml
					);
					$( '#lc-deactivation-feedback-modal-submit-btn' )
					.attr( 'disabled', true )
					.addClass( 'lc-btn--disabled' );
					that.sendFeedback();
				}
			);
		},
		deactivationFormSubmitHandler: function () {
			var that = this;
			$( '#lc-deactivation-feedback-modal-submit-btn' ).click(
				function (e) {
					e.preventDefault();
					that.deactivationFormHelpers.hideErrors();
					var response = $( '.lc-radio.lc-radio--selected .lc-radio__input' ).val();
					if ( ! response) {
						that.deactivationFormHelpers.showError( 'option' );
						return;
					}
					var comment = $( '#lc-deactivation-feedback-other-field .lc-textarea' ).val();
					if (response.toLowerCase() === 'other' && ! comment) {
						that.deactivationFormHelpers.showError( 'other' );
						return;
					}
					$( this ).addClass( 'lc-btn--loading lc-btn--disabled' ).html(
						$( this ).html() + that.buttonLoaderHtml
					);
					$( '#lc-deactivation-feedback-modal-skip-btn' )
					.attr( 'disabled', true )
					.addClass( 'lc-btn--disabled' );
					that.sendFeedback( response, comment );
				}
			)
		}
	};

	$( document ).ready( LiveChat.init.bind( LiveChat ) );
})( jQuery );
