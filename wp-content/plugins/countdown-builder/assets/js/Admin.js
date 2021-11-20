function YcdAdmin() {
	this.init();
}

YcdAdmin.prototype.init = function() {
	this.initCountdownDateTimePicker();
	this.select2();
	this.accordionContent();
	this.livePreviewToggle();
	this.multipleChoiceButton();
	this.switchCountdown();
	this.soundUpload();
	this.resetSound();
	this.soundPreview();
	this.support();
	this.livePreview();
	this.redirectToProWebpage();
	this.newsletter();
	this.promotionalVideo();
	this.editor();
	this.changeAnimation();
	this.buttonFunctions();
	this.copySortCode();

	/*clock*/
	this.clockLivePreview();
	this.proOptions();
	this.changeTimer();

	this.imageButton();
	var that = this;

	jQuery(window).bind('ycdAccordionTriggered', function () {
		that.imageButton();
	});
	this.comingSonColor();

    if(ycd_admin_localized.pkgVersion == 1) {
        this.redirectToSupportPage();
    }
};

YcdAdmin.prototype.copySortCode = function() {
    jQuery('.countdown-shortcode').bind('click', function() {
    	var currentId = jQuery(this).data('id');
        var copyText = document.getElementById('ycd-shortcode-input-'+currentId);
        copyText.select();
        document.execCommand('copy');

        var tooltip = document.getElementById('ycd-tooltip-'+currentId);
        tooltip.innerHTML = ycd_admin_localized.copied;
    });

    jQuery(document).on('focusout', '.countdown-shortcode',function() {
        var currentId = jQuery(this).data('id');
        var tooltip = document.getElementById('ycd-tooltip-'+currentId);
        tooltip.innerHTML = ycd_admin_localized.copyToClipboard;
    });
};

YcdAdmin.prototype.buttonFunctions = function () {
	var buttonOpacity = jQuery('#ycd-button-opacity');

	if(!buttonOpacity.length) {
		return false;
	}

	buttonOpacity.ionRangeSlider({
        hide_min_max: true,
        keyboard: true,
        min: 0,
        max: 1,
        type: 'single',
        step: 0.1,
        prefix: '',
        grid: false
    });
};

YcdAdmin.prototype.changeTimer = function () {
    var timers = jQuery('.ycd-timer-time-settings');

    if (!timers.length) {
        return false;
    }
    var modeChecker = jQuery('.ycd-timer-mode');
    var clockMode = jQuery('.ycd-clock-mode');

    modeChecker.bind('change', function () {
    	var args = {};
        args.modeValue = jQuery(this).val();
        args.allSeconds = parseInt(jQuery('#ycdTimeHours').val())*3600 + parseInt(jQuery('#ycdTimeMinutes').val())*60 + parseInt(jQuery('#ycdTimeSeconds').val());
        jQuery(window).trigger('YcdClockChangeMode', args);
    });

    timers.bind('change', function () {
        if(!jQuery('#ycdTimeHours').length) {
        	return false;
		}
		var allSeconds = parseInt(jQuery('#ycdTimeHours').val())*3600 + parseInt(jQuery('#ycdTimeMinutes').val())*60 + parseInt(jQuery('#ycdTimeSeconds').val());
        jQuery(window).trigger('YcdClockTimerChange', allSeconds);
    });

    clockMode.bind('change', function () {
        var val = jQuery(this).val();
        jQuery(window).trigger('YcdClockModeChange', val);
	});
};

YcdAdmin.prototype.animateCountdown = function () {
	var circleWrapper = jQuery('.time_circles');

    var animations = jQuery('.ycd-showing-animation');
    var speed = jQuery('.ycd-circle-showing-animation-speed');

    circleWrapper.removeClass(circleWrapper.data('effect'));
    var speedValue = speed.val();
    var animationEffect = animations.val();
    setTimeout(function () {
        circleWrapper.data('effect', animationEffect);
        circleWrapper.css({'animationDuration' : parseInt(speedValue)*1000 + 'ms'});
        circleWrapper.addClass('ycd-animated '+animationEffect);
    }, 0);
};

YcdAdmin.prototype.changeAnimation = function() {
	var previewIcon = jQuery('.ycd-preview-icon');

	if(!previewIcon.length) {
		return false;
	}
	var that = this;
	var animations = jQuery('.ycd-showing-animation');

    previewIcon.bind('click', function() {
        that.animateCountdown();
    });

    animations.bind('change', function () {
        that.animateCountdown();
    });
};

YcdAdmin.prototype.editor = function() {
    (function($){
        $(function(){
            if( $('#ycd-edtitor-head').length ) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2
                    }
                );
                var editor = wp.codeEditor.initialize( $('#ycd-edtitor-head'), editorSettings );
            }

            if( $('#ycd-edtitor-js').length ) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2,
                        mode: 'javascript',
                    }
                );
                var editor = wp.codeEditor.initialize( $('#ycd-edtitor-js'), editorSettings );
            }

            if( $('#ycd-edtitor-css').length ) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2,
                        mode: 'css',
                    }
                );
                var editor = wp.codeEditor.initialize( $('#ycd-edtitor-css'), editorSettings );
            }
        });
    })(jQuery);
};

YcdAdmin.prototype.proOptions = function() {
	var proOptions = jQuery('label .ycd-pro-span');

	if(!proOptions.length) {
		return false;
	}

    proOptions.parent().bind('click', function(e) {
		e.preventDefault();
		window.open(ycd_admin_localized.proUrl);
    });
};

YcdAdmin.prototype.redirectToSupportPage = function() {
	var supportSubMenu = jQuery('#menu-posts-ycdcountdown a[href="edit.php?post_type=ycdcountdown&page=supports"]');

	if(!supportSubMenu.length) {
		return false;
	}

    supportSubMenu.bind('click', function(e) {
    	e.preventDefault();
		window.open(ycd_admin_localized.supportURL);
    });
};

YcdAdmin.prototype.promotionalVideo = function() {
	var target = jQuery('.ycd-play-promotion-video');

	if(!target.length) {
		return false;
	}

	target.bind('click', function(e) {
		e.preventDefault();
		var href = jQuery(this).data('href');
		window.open(href);
	});
};

YcdAdmin.prototype.clockLivePreview = function() {
	this.changeClcokWidth();
	this.changeTimeZone();
	this.changeAlignClock();
	this.changeButtonBoxShadow();
};

YcdAdmin.prototype.changeButtonBoxShadow = function() {
    var spreadSizes = jQuery('#ycd-circle-box-shadow-horizontal, #ycd-circle-box-shadow-vertical, #ycd-circle-box-spread-radius, #ycd-circle-box-blur-radius');

    if (!spreadSizes) {
        return false;
    }
    var liveChangeShadow = function() {
        var shadowHorizontal = jQuery('#ycd-circle-box-shadow-horizontal').val()+'px';
        var shadowVertical = jQuery('#ycd-circle-box-shadow-vertical').val()+'px';
        var spreadRadius = parseInt(jQuery('#ycd-circle-box-spread-radius').val())+'px';
        var blurRadius = jQuery('#ycd-circle-box-blur-radius').val()+'px';
        var color = jQuery('#ycd-circle-box-shadow-color').val();
		setTimeout(function () {
            jQuery('.time_circles').css({'box-shadow': shadowHorizontal+' '+shadowVertical+' '+blurRadius+' '+spreadRadius+' '+color});
        }, 0);
    };

    jQuery('#ycd-circle-box-shadow').bind('change', function () {
		if(!jQuery(this).is(':checked')) {
            jQuery('.time_circles').css({'box-shadow': 'none'});
		}
		else {
            liveChangeShadow();
		}
    });
    spreadSizes.bind('change', function() {
        liveChangeShadow();
    });

    jQuery('#ycd-circle-box-shadow-color').minicolors({
	    format: 'rgb',
	    opacity: 1,
        change: function () {
            liveChangeShadow();
        }
    });
};

YcdAdmin.prototype.comingSonColor = function () {
	jQuery('.ycd-coming-soon-color').minicolors({
		format: 'rgb',
		opacity: 1,
		change: function () {
			liveChangeShadow();
		}
	});
};

YcdAdmin.prototype.changeClcokWidth = function() {
	var width = jQuery('.ycd-clock-width');

	if (width.length) {
		var that = this;
		width.bind('change', function() {
			var targetId = jQuery(this).data('target-index');
			var widthVal = parseInt(jQuery(this).val())+'px';
			var cnavas = jQuery('.ycdClock'+targetId);

			cnavas.attr('width', widthVal);
			cnavas.attr('height', widthVal);

			that.reinitClock(targetId);
		});
	}
};

YcdAdmin.prototype.changeTimeZone = function() {
	var timeZone = jQuery('.js-circle-time-zone');

	if(!timeZone.length) {
		return false;
	}
	var that = this;
	
	timeZone.bind('change', function() {
		var val = jQuery(this).val();
		var targetId = jQuery(this).data('target-index');

		if(!targetId) {
			return false;
		}
		var options = jQuery('.ycdClock'+targetId).data('options');
		if(!options) {
			return false;
		}
		options['timeZone'] = val;
		jQuery('.ycdClock'+targetId).attr('data-options', options);

		that.reinitClock(targetId);
	});
};

YcdAdmin.prototype.changeAlignClock = function() {
	var alignement = jQuery('.ycd-clock-alignment');

	if(!alignement.length) {
		return false;
	}
	var that = this;

	alignement.bind('change', function() {
		var val = jQuery(this).val();
		jQuery('.ycd-countdown-wrapper').css({'text-align': val});
	});
};

YcdAdmin.prototype.reinitClock = function(targetId) {
	var targetClassName = '.ycdClock'+targetId;
	var cnavas = jQuery(targetClassName);
	var dataArgs = cnavas.data('args');
	var dataOptions = cnavas.data('options');

	var width = jQuery(targetClassName).width();
	var height = jQuery(targetClassName).height();

	jQuery(targetClassName).remove();
	jQuery('.ycd-countdown-wrapper').prepend('<canvas data-args='+JSON.stringify(dataArgs)+' data-options='+JSON.stringify(dataOptions)+' class="ycdClock'+targetId+'" width="'+width+'px" height="'+height+'px"></canvas>');

	if (typeof YcdClock != 'undefined') {
		var obj = new YcdClock();
	}
	else if (typeof YcdClockPro != 'ndefined') {
		var obj = new YcdClockPro();
	}

	obj.init()
};

YcdAdmin.prototype.getTinymceContent = function()
{
	if (jQuery('.wp-editor-wrap').hasClass('tmce-active')) {
		return tinyMCE.activeEditor.getContent();
	}

	return jQuery('#ycd-newsletter-text').val();
};

YcdAdmin.prototype.newsletter = function() {
	var sendButton = jQuery('.js-send-newsletter');

	if (!sendButton.length) {
		return false;
	}
	var that = this;

	sendButton.bind('click', function(e) {
		e.preventDefault();
		jQuery('.ycd-validation-error').addClass('ycd-hide');
		var validationStatus = true;
		var fromEmail = jQuery('.ycd-newsletter-from-email').val();
		var subscriptionFormId = jQuery('.js-ycd-newsletter-forms option:selected').val();
		subscriptionFormId = parseInt(subscriptionFormId);
		var validateEmail =  fromEmail.search(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,10})+$/);
		var emailsInFlow = jQuery('.ycd-emails-in-flow').val();
		emailsInFlow = parseInt(emailsInFlow);

		if (isNaN(subscriptionFormId)) {
			jQuery('.ycd-newsletter-error').removeClass('ycd-hide');
			validationStatus = false;
		}

		/*When the sent email isn't valid or the user hasn't selected any subscription form.*/
		if (validateEmail == -1 ) {
			validationStatus = false;
			jQuery('.ycd-newsletter-from-email-error').removeClass('ycd-hide');
		}

		if (isNaN(emailsInFlow)) {
			jQuery('.ycd-emails-in-flow-error').removeClass('ycd-hide');
			validationStatus = false;
		}

		if (!validationStatus) {
			return false;
		}

		var newsletterSubject = jQuery('.ycd-newsletter-subject').val();
		var messageBody = that.getTinymceContent();

		var data = {
			nonce: ycd_admin_localized.nonce,
			action: 'ycd_send_newsletter',
			newsletterData: {
				subscriptionFormId: subscriptionFormId,
				beforeSend: function() {
					jQuery('.ycd-js-newsletter-spinner').removeClass('ycd-hide');
					jQuery('.ycd-newsletter-notice').addClass('ycd-hide');
				},
				fromEmail: fromEmail,
				emailsInFlow: emailsInFlow,
				newsletterSubject: newsletterSubject,
				messageBody: messageBody
			}
		};

		jQuery.post(ajaxurl, data, function() {
			jQuery('.ycd-newsletter-notice').removeClass('ycd-hide');
			jQuery('.ycd-js-newsletter-spinner').addClass('ycd-hide');
		});
	});
};

YcdAdmin.prototype.redirectToProWebpage = function() {
	jQuery('.ycd-upgrade-button-red').bind('click', function(e) {
		window.open(ycd_admin_localized.proUrl);
	})
};

YcdAdmin.prototype.livePreview = function() {
	var preview = jQuery('.ycd-live-preview');

	if (!preview.length) {
		return false;
	}

	preview.draggable({
        stop: function(e, ui) {
        },
		drag: function () {
			jQuery('.ycd-live-preview').css({'right': 'inherit', 'bottom': 'inherit'})
		}
	});
};

function validateEmail(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}

YcdAdmin.prototype.support = function() {
	var submit = jQuery('#ycd-support-request-button');

	if(!submit.length) {
		return false;
	}
	jQuery('#ycd-form').submit(function(e) {
		e.preventDefault();
		var isValid = true;
		var emailError = jQuery('.ycd-validate-email-error');
		emailError.addClass('ycd-hide');
		jQuery('.ycd-required-fields').each(function() {
			var currentVal = jQuery(this).val();
			jQuery('.'+jQuery(this).data('error')).addClass('ycd-hide');

			if(!currentVal) {
				isValid = false;
				jQuery('.'+jQuery(this).data('error')).removeClass('ycd-hide');
			}
		});

		if(!isValid) {
			return false;
		}

		if(!validateEmail(jQuery('#ycd-email').val())) {
			emailError.removeClass('ycd-hide');
			return false;
		}
		var data = {
			action: 'ycdSupport',
			nonce: ycd_admin_localized.nonce,
			formData: jQuery(this).serialize(),
			beforeSend: function() {
				submit.prop('disabled', true);
				jQuery('.ycd-support-spinner').removeClass('ycd-hide')
			}
		};

		jQuery.post(ajaxurl, data, function(result) {
			submit.prop('disabled', false);
			jQuery('.ycd-support-spinner').addClass('ycd-hide');
			jQuery('#ycd-form').remove();
			jQuery('.ycd-support-success').removeClass('ycd-hide');
		});
	});
};

YcdAdmin.prototype.soundPreview = function()  {
	var songValue = 1;
	var lastSong = undefined;

	jQuery('.js-preview-sound').bind('click', function() {
		var uploadFile = jQuery('#js-sound-open-url').val();
		if (typeof lastSong == 'undefined') {
			lastSong = new Audio (uploadFile);
		}

		/*
		 * songValue == 1 should be song
		 * songValue == 2 song should be pause
		 */
		if(songValue == 1) {
			lastSong.play();
			songValue = 2;

		}
		else if(songValue == 2) {
			lastSong.pause();
			songValue = 1;

		}

		lastSong.onended = function()
		{
			lastSong = undefined;
			songValue = 1;
		}
	});

	jQuery('#js-sound-open-url').change(function() {
		if(typeof lastSong != 'undefined') {
			lastSong.pause();
			lastSong = undefined;
		}
		songValue = 1;
	});

	jQuery('#js-reset-to-default-song').click(function(e) {
		e.preventDefault();

		if(typeof lastSong != 'undefined') {
			lastSong.pause();
			lastSong = undefined;
		}
		songValue = 1;

		var defaultSong = jQuery(this).data('default-song');
		jQuery('#js-sound-open-url').val(defaultSong).change();
	});
};

YcdAdmin.prototype.resetSound = function() {
	var resetButton = jQuery('#js-reset-to-default-song');

	if(!resetButton.length) {
		return false;
	}

	resetButton.bind('click', function() {
		var defaultSoundUrl = jQuery(this).data('default-song');
		jQuery('#js-sound-open-url').val(defaultSoundUrl).change();
	});
};

YcdAdmin.prototype.soundUpload = function() {
	var uploadButton = jQuery('#js-upload-countdown-end-sound');

	if(!uploadButton.length) {
		return false;
	}
	var uploader;
	uploadButton.bind('click', function(e) {
		e.preventDefault();

		if(uploader) {
			uploader.open();
			return false;
		}

		/* Extend the wp.media object */
		uploader = wp.media.frames.file_frame = wp.media({
			titleFF : ycd_admin_localized.changeSound,
			button : {
				text : ycd_admin_localized.changeSound
			},
			library : {type : ['audio/mpeg', 'audio/wav', 'audio/mp3']},
			multiple : false
		});

		/* When a file is selected, grab the URL and set it as the text field's value */
		uploader.on('select', function() {
			var attachment = uploader.state().get('selection').first().toJSON();
			jQuery('#js-sound-open-url').val(attachment.url).change();
		});
		/* Open the uploader dialog */
		uploader.open();
	});
};

YcdAdmin.prototype.switchCountdown = function() {
	var switchCountdown = jQuery('.ycd-countdown-enable');

	if(!switchCountdown.length) {
		return false;
	}

	switchCountdown.each(function() {
		jQuery(this).bind('change', function() {
			var data = {
				action: 'ycd-switch',
				nonce: ycd_admin_localized.nonce,
				id: jQuery(this).data('id'),
				checked: jQuery(this).is(':checked')
			};

			jQuery.post(ajaxurl, data, function() {

			});
		})
	});
};

YcdAdmin.prototype.multipleChoiceButton = function() {
	var choiceOptions = jQuery('.ycd-choice-option-wrapper input');
	if(!choiceOptions.length) {
		return false;
	}

	var that = this;

	choiceOptions.each(function() {

		if(jQuery(this).is(':checked')) {
			that.buildChoiceShowOption(jQuery(this));
		}

		jQuery(this).on('change', function() {
			that.hideAllChoiceWrapper(jQuery(this).parents('.ycd-multichoice-wrapper').first());
			that.buildChoiceShowOption(jQuery(this));
		});
	})
};

YcdAdmin.prototype.hideAllChoiceWrapper = function(choiceOptionsWrapper) {
	choiceOptionsWrapper.find('input').each(function() {
		var choiceInputWrapperId = jQuery(this).attr('data-attr-href');
		jQuery('#'+choiceInputWrapperId).addClass('ycd-hide');
	})
};

YcdAdmin.prototype.buildChoiceShowOption = function(currentRadioButton)  {
	var choiceOptions = currentRadioButton.attr('data-attr-href');
	var currentOptionWrapper = currentRadioButton.parents('.ycd-choice-wrapper').first();
	var choiceOptionWrapper = jQuery('#'+choiceOptions).removeClass('ycd-hide');
	currentOptionWrapper.after(choiceOptionWrapper);
};

YcdAdmin.prototype.livePreviewToggle = function() {
	var livePreviewText = jQuery('.ycd-toggle-icon');

	if (!livePreviewText.length) {
		return false;
	}
	livePreviewText.attr('checked', true);
	livePreviewText.bind('click', function() {
		var isChecked = jQuery(this).attr('checked');

		if (isChecked) {
			jQuery('.ycd-toggle-icon').removeClass('ycd-toggle-icon-open').addClass('ycd-toggle-icon-close');
		}
		else {
			jQuery('.ycd-toggle-icon').removeClass('ycd-toggle-icon-close').addClass('ycd-toggle-icon-open');
		}
	    jQuery('.ycd-countdown-wrapper').slideToggle(1000, 'swing', function () {
	    });
		livePreviewText.attr('checked', !isChecked);
	});
};

YcdAdmin.prototype.accordionContent = function() {

	var that = this;
	var accordionCheckbox = jQuery('.ycd-accordion-checkbox');

	if (!accordionCheckbox.length) {
		return false;
	}
	accordionCheckbox.each(function () {
		that.doAccordion(jQuery(this), jQuery(this).is(':checked'));
	});
	var customValueAccordion = jQuery('.ycd-custom-value-accordion');
	if (customValueAccordion.length) {
        customValueAccordion.bind('change', function() {
            var val = jQuery('option:selected', this).val() == jQuery(this).data('custom');
            var currentCheckbox = jQuery(this);
            that.doAccordion(currentCheckbox, val);
        });
        customValueAccordion.change();
	}
	accordionCheckbox.each(function () {
		jQuery(this).bind('change', function () {
			var attrChecked = jQuery(this).is(':checked');
			var currentCheckbox = jQuery(this);
			that.doAccordion(currentCheckbox, attrChecked);
		});
	});
};

YcdAdmin.prototype.doAccordion = function(checkbox, isChecked) {
	var accordionContent = checkbox.parents('.row').nextAll('.ycd-accordion-content').first();
	jQuery(window).trigger('ycdAccordionTriggered');
	if(isChecked) {
		accordionContent.removeClass('ycd-hide-content');
	}
	else {
		accordionContent.addClass('ycd-hide-content');
	}
};

YcdAdmin.prototype.select2 = function() {
	var select2 = jQuery('.js-ycd-select');

	if(!select2.length) {
		return false;
	}

	select2.select2();
};

YcdAdmin.prototype.initCountdownDateTimePicker = function() {
	var countdown = jQuery('.ycd-date-time-picker');

	if(!countdown.length) {
		return false;
	}

	countdown.ycddatetimepicker({
		format: 'Y-m-d H:i',
		minDate: 0
	});
};

YcdAdmin.prototype.imageButton = function() {
	var custom_uploader;
	jQuery('.js-ycd-image-btn').each(function () {
		jQuery(this).click(function(e) {
			e.preventDefault();
			var currentButton = jQuery(this);
			/* If the uploader object has already been created, reopen the dialog */
			if (window.custom_uploader) {
				return;
			}
			/* Extend the wp.media object */
			custom_uploader = wp.media.frames.file_frame = wp.media({
				titleFF: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: false
			});
			window.custom_uploader = custom_uploader;
			/* When a file is selected, grab the URL and set it as the text field's value */
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				var imageURL = jQuery('#'+jQuery(currentButton).data('src-id'));
				imageURL.val(attachment.url);
				imageURL.trigger('change');
				custom_uploader, window.custom_uploader = '';
			});
			/* Open the uploader dialog */
			custom_uploader.open();
		});
	});

	/* its finish image uploader */
};

jQuery(document).ready(function() {
	new YcdAdmin();
});

/*Conditions builder*/
function YcdConditionBuilder() {
}

YcdConditionBuilder.prototype.init = function() {
    this.conditionsBuilder();
    this.select2();
};

YcdConditionBuilder.prototype.select2 = function() {
    var select2 = jQuery('.js-ycd-select');

    if(!select2.length) {
        return false;
    }
    select2.each(function() {
        var type = jQuery(this).data('select-type');

        var options = {
            width: '100%'
        };

        if (type == 'ajax') {
            options = jQuery.extend(options, {
                minimumInputLength: 1,
                ajax: {
                    url: ajaxurl,
                    dataType: 'json',
                    delay: 250,
                    type: "POST",
                    data: function(params) {

                        var searchKey = jQuery(this).attr('data-value-param');
                        var postType = jQuery(this).attr('data-post-type');

                        return {
                            action: 'ycd_select2_search_data',
                            nonce_ajax: ycd_admin_localized.nonce,
                            postType: postType,
                            searchTerm: params.term,
                            searchKey: searchKey
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: jQuery.map(data.items, function(item) {

                                return {
                                    text: item.text,
                                    id: item.id
                                }

                            })
                        };
                    }
                }
            });
        }

        jQuery(this).select2(options);
    });
};

YcdConditionBuilder.prototype.conditionsBuilder = function() {
    this.conditionsBuilderEdit();
    this.conditionsBuilderAdd();
    this.conditionsBuilderDelte();
};

YcdConditionBuilder.prototype.conditionsBuilderAdd = function() {
    var params = jQuery('.ycd-condition-add');

    if(!params.length) {
        return false;
    }
    var that = this;
    params.bind('click', function() {
        var currentWrapper = jQuery(this).parents('.ycd-condion-wrapper').first();
        var selectedParams = currentWrapper.find('.js-conditions-param').val();

        that.addViaAjax(selectedParams, currentWrapper);
    });
};

YcdConditionBuilder.prototype.conditionsBuilderDelte = function() {
    var params = jQuery('.ycd-condition-delete');

    if(!params.length) {
        return false;
    }

    params.bind('click', function() {
        var currentWrapper = jQuery(this).parents('.ycd-condion-wrapper').first();

        currentWrapper.remove();
    });
};

YcdConditionBuilder.prototype.conditionsBuilderEdit = function() {
    var params = jQuery('.js-conditions-param');

    if(!params.length) {
        return false;
    }
    var that = this;
    params.bind('change', function() {
        var selectedParams = jQuery(this).val();
        var currentWrapper = jQuery(this).parents('.ycd-condion-wrapper').first();

        that.changeViaAjax(selectedParams, currentWrapper);
    });
};

YcdConditionBuilder.prototype.addViaAjax = function(selectedParams, currentWrapper) {
    var conditionId = parseInt(currentWrapper.data('condition-id'))+1;
    var conditionsClassName = currentWrapper.parent().data('child-class');

    var that = this;

    var data = {
        action: 'ycd_add_conditions_row',
        nonce: ycd_admin_localized.nonce,
        conditionId: conditionId,
        conditionsClassName: conditionsClassName,
        selectedParams: selectedParams
    };

    jQuery.post(ajaxurl, data, function(response) {
        currentWrapper.after(response);
        that.init();
    });
};

YcdConditionBuilder.prototype.changeViaAjax = function(selectedParams, currentWrapper) {
    var conditionId = currentWrapper.data('condition-id');
    var conditionsClassName = currentWrapper.parent().data('child-class');

    var that = this;

    var data = {
        action: 'ycd_edit_conditions_row',
        nonce: ycd_admin_localized.nonce,
        conditionId: conditionId,
        conditionsClassName: conditionsClassName,
        selectedParams: selectedParams
    };

    jQuery.post(ajaxurl, data, function(response) {
        currentWrapper.replaceWith(response);
        that.init();
    });
};

jQuery(document).ready(function() {
    var obj = new YcdConditionBuilder();
    obj.init();
});