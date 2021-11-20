function YcdTimer() {
	this.ycdAudio = false;
	this.countdown = true;
	this.status = 1;
}

YcdTimer.prototype.setAlarm = function() {
	var options = this.getSettings();
	if (options['ycd-countdown-end-sound']) {
		var soundUrl = options['ycd-countdown-end-sound-url'];
		var ycdAudio = new Audio (soundUrl);
		this.ycdAudio = ycdAudio;
	}
};

YcdTimer.prototype.init = function() {
	this.livePreview();
	var settings = this.getSettings();
	this.setAlarm();

	this.remainingTime = 0;
	this.miliseconds = 1000;
	this.countdownHandle = 0;

	this.stopTimer();

	this.gHours = settings['hours'];
	this.gMinutes = settings['minutes'];
	this.gSeconds = settings['seconds'];

	this.buttonListener();
	this.resetTimer();
    if (settings['timerButton'] && settings['autoCounting'] == '') {
    	this.renderTimer();
        return '';
    }
	this.startTimer();

	jQuery('#shortButton').removeClass('btn-success');
	jQuery('#longButton').removeClass('btn-success');
	jQuery('#pomodoroButton').addClass('btn-success');
};

YcdTimer.prototype.setSettings = function(settings) {
	this.settings = settings;
};

YcdTimer.prototype.getSettings = function() {
	return this.settings;
};

YcdTimer.prototype.setId = function(id) {
	this.id = id;
};

YcdTimer.prototype.getId = function() {
	return this.id;
};

function onShortTimer() {
	stopTimer();

	gHours = 0;
	gMinutes = 5;
	gSeconds = 0;

	resetTimer();

	jQuery('#pomodoroButton').removeClass('btn-success');
	jQuery('#longButton').removeClass('btn-success');
	jQuery('#shortButton').addClass('btn-success');
}

function onLongTimer() {
	stopTimer();

	gHours = 0;
	gMinutes = 15;
	gSeconds = 0;

	resetTimer();

	jQuery('#pomodoroButton').removeClass('btn-success');
	jQuery('#shortButton').removeClass('btn-success');
	jQuery('#longButton').addClass('btn-success');
}

function onStartTimer() {
	var timers = window.YcdTimersInstance;
	timers[timers.length-1].stopTimer();
	timers[timers.length-1].startTimer();
};

YcdTimer.prototype.onStopTimer = function() {
	this.stopTimer();
};

function onResetTimer() {
	var timers = window.YcdTimersInstance;
	timers[timers.length-1].stopTimer();
	timers[timers.length-1].resetTimer();
}

stopTimer = function() {
	var timers = window.YcdTimersInstance;
	timers[timers.length-1].onStopTimer();
};

YcdTimer.prototype.startAlarm = function() {
	if(this.emainingTime < 1000) {
		this.endBehavior();
	}
};

YcdTimer.prototype.endBehavior = function() {

	if(YcdArgs.isAdmin) {
		return false;
	}
	var options = this.getSettings();
	var id = options['id'];

	if (this.ycdAudio) {
		this.ycdAudio.play();
	}
	var behavior = options['ycd-countdown-expire-behavior'];
	var expireText = options['ycd-expire-text'];
	var expireUrl = options['ycd-expire-url'];
	var countdownWrapper = jQuery('.ycd-timer-wrapper-'+id);

	jQuery(window).trigger('YcdExpired', {'id':  id});

	switch(behavior) {
		case 'hideCountdown':
			countdownWrapper.hide();
			break;
		case 'showText':
			countdownWrapper.replaceWith(expireText);
			break;
		case 'redirectToURL':
			countdownWrapper.fadeOut('slow');
			window.location.href = expireUrl;
			break;
	}
};

YcdTimer.prototype.buttonListener = function () {
    var id = this.getId();
    var that = this;
	var button = jQuery('.ycd-timer-start-stop-'+id);
	var resetButton = jQuery('.ycd-timer-reset-'+id);
	var options = this.getSettings();

    button.bind('click', function (e) {
    	e.preventDefault();
		var status = jQuery(this).data('status');
		var title = status ? jQuery(this).data('start') : jQuery(this).data('stop');
		jQuery(this).text(title);
        status = status ? 0: 1;
	    that.status = status;

        if (!status) {
            clearInterval(that.countdownHandle);
		}
		else {
        	that.startTimer();
		}
		jQuery(this).data('status', status);
    });

    resetButton.bind('click', function(e) {
    	e.preventDefault();
    	that.resetTimer();
    	var status = that.status;
    	if (!status && options['ycd-timer-reset-button-run']) {
		    button.click();
	    }

    })
};

YcdTimer.prototype.startTimer = function() {
	var that = this;
	this.countdownHandle = setInterval(function() {
		that.decrementTimer();
	}, 100);
};

YcdTimer.prototype.stopTimer = function() {
	clearInterval(this.countdownHandle);
	this.startAlarm();
};

YcdTimer.prototype.resetTimer = function() {
	var settings = this.getSettings();
	this.remainingTime = (settings['days'] * 24 * 60 * 60 * 1000) + (settings['hours'] * 60 * 60 * 1000) +
		(settings['minutes'] * 60 * 1000) +
		(settings['seconds'] * 1000);
	this.renderTimer();
};

YcdTimer.prototype.renderTimer =  function() {
	var deltaTime = this.remainingTime;

	var daysValue = Math.floor(deltaTime / (1000 * 60 * 60* 24));
	deltaTime = deltaTime % (1000 * 60 * 60* 24);

	var hoursValue = Math.floor(deltaTime / (1000 * 60 * 60));
	deltaTime = deltaTime % (1000 * 60 * 60);

	var minutesValue = Math.floor(deltaTime / (1000 * 60));
	deltaTime = deltaTime % (1000 * 60);

	var secondsValue = Math.floor(deltaTime / (1000));

	this.animateTime(daysValue, hoursValue, minutesValue, secondsValue);
};

YcdTimer.prototype.animateTime = function(remainingDays, remainingHours, remainingMinutes, remainingSeconds) {
	var id = this.getId();
	/* position */
	var daysValueTarget = jQuery('.ycd-days-value-'+id);
	var hoursValueTarget = jQuery('.ycd-hours-value-'+id);
	var minutesValueTarget = jQuery('.ycd-minutes-value-'+id);
	var secondsValueTarget = jQuery('.ycd-seconds-value-'+id);

	hoursValueTarget.css('top', '0em');
	minutesValueTarget.css('top', '0em');
	secondsValueTarget.css('top', '0em');

	var daysNext = jQuery('.ycd-days-next-value-'+id);
	var hoursNext = jQuery('.ycd-hours-next-value-'+id);
	var minutesNext = jQuery('.ycd-minutes-next-value-'+id);
	var secondsNext = jQuery('.ycd-seconds-next-value-'+id);

	daysNext.css('top', '0em');
	hoursNext.css('top', '0em');
	minutesNext.css('top', '0em');
	secondsNext.css('top', '0em');

	var olDaysString = daysNext.first().text();
	var oldHoursString = hoursNext.first().text();
	var oldMinutesString = minutesNext.first().text();
	var oldSecondsString = secondsNext.first().text();

	var daysString = this.formatTime(remainingDays);
	var hoursString = this.formatTime(remainingHours);
	var minutesString = this.formatTime(remainingMinutes);
	var secondsString = this.formatTime(remainingSeconds);

	daysValueTarget.text(olDaysString);
	hoursValueTarget.text(oldHoursString);
	minutesValueTarget.text(oldMinutesString);
	secondsValueTarget.text(oldSecondsString);

	daysNext.text(daysString);
	hoursNext.text(hoursString);
	minutesNext.text(minutesString);
	secondsNext.text(secondsString);

	/* set and animate */
	if(olDaysString !== daysString) {
		daysValueTarget.animate({top: '-=1em'});
		jQuery('.ycd-hours-next-value-'+id).animate({top: '-=1em'});
	}

	if(oldHoursString !== hoursString) {
		hoursValueTarget.animate({top: '-=1em'});
		jQuery('.ycd-hours-next-value-'+id).animate({top: '-=1em'});
	}

	if(oldMinutesString !== minutesString) {
		minutesValueTarget.animate({top: '-=1em'});
		jQuery('.ycd-miuntes-next-value-'+id).animate({top: '-=1em'});
	}

	if(oldSecondsString !== secondsString) {
		secondsValueTarget.animate({top: '-=1em'});
		jQuery('.ycd-seconds-next-value-'+id).animate({top: '-=1em'});
	}
	jQuery('.ycd-milliseconds-value-'+id).text(this.miliseconds)
};


YcdTimer.prototype.formatTime = function(intergerValue) {
	return intergerValue > 9 ? intergerValue.toString() : '0' + intergerValue.toString();
};

YcdTimer.prototype.decrementTimer = function() {
    var options = this.getSettings();
    var behavior = options['ycd-countdown-expire-behavior'];

    if(behavior == 'countToUp' && this.remainingTime < 1000) {
	   this.countdown = false;
	}

    if (!this.countdown) {
	   this.remainingTime += (1 * 100);
	}
	else {
	   this.remainingTime -= (1 * 100);
	}

	if (!this.miliseconds) {
		this.miliseconds = 1000;
	}
	else {
		this.miliseconds -= 100;
	}


	if(this.remainingTime < 1000) {
    	this.finalize();
		this.endBehavior();
		this.onStopTimer();
	}

	this.renderTimer();
};

YcdTimer.prototype.finalize = function () {
	this.miliseconds = '000';
	var id = this.getId();
	var secondsNext = jQuery('.ycd-seconds-next-value-'+id);
	secondsNext.text('00');
	secondsNext.css('top', '0em');

};

YcdTimer.prototype.livePreview = function() {
	this.changeTime();
	this.changeFontFamily();
	this.changeFontSize();
	this.changeContnetPadding();
	this.changeColor();
	this.imageUpload();
	this.changeBackgroundImage();
	this.changeAlignment();
	this.changeMilliseconds();
	this.changeDays();
	this.changeLabels();
	this.changeLabelFontSize();
};

YcdTimer.prototype.changeMilliseconds = function () {
	var millisecondsCheckbox = jQuery('#ycd-countdown-timer-milliseconds');
	if (!millisecondsCheckbox.length) {
		return false;
	}

	millisecondsCheckbox.bind('change', function () {
		var milliseconds = jQuery('.ycd-milliseconds');
		if (jQuery(this).is(':checked')) {
			milliseconds.removeClass('ycd-hide');
		}
		else {
			milliseconds.addClass('ycd-hide');
		}
	});
};

YcdTimer.prototype.changeDays = function () {
	var daysCheckbox = jQuery('#ycd-countdown-timer-days');
	if (!daysCheckbox.length) {
		return false;
	}

	daysCheckbox.bind('change', function () {
		var days = jQuery('.ycd-days-span');
		if (jQuery(this).is(':checked')) {
			days.removeClass('ycd-hide');
		}
		else {
			days.addClass('ycd-hide');
		}
	});
};

YcdTimer.prototype.changeLabels = function () {
	var daysCheckbox = jQuery('#ycd-countdown-timer-labels');
	if (!daysCheckbox.length) {
		return false;
	}

	daysCheckbox.bind('change', function () {
		var days = jQuery('.ycd-timer-unit-text');
		if (jQuery(this).is(':checked')) {
			days.removeClass('ycd-hide-label');
		}
		else {
			days.addClass('ycd-hide-label');
		}
	});
};

YcdTimer.prototype.changeAlignment = function() {
	var alignment = jQuery('.ycd-timer-content-alignment');

	if (!alignment.length) {
		return false;
	}

	var postId = parseInt(jQuery('#post_ID').val());
	var timerWrapper = jQuery('.ycd-timer-wrapper-'+postId);

	alignment.bind('change', function() {
		timerWrapper.css({'text-align': jQuery(this).val()})
	});
};

YcdTimer.prototype.changeBackgroundImage = function() {
	var bgSize = jQuery('.js-ycd-bg-size');

	if(!bgSize.length) {
		return false;
	}
	var postId = parseInt(jQuery('#post_ID').val());
	var timerWrapper = jQuery('.ycd-timer-wrapper-'+postId);
	bgSize.bind('change', function() {
		var val = jQuery(this).val();
		timerWrapper.css({'background-size': val});
	});

	jQuery('.js-bg-image-repeat').bind('change', function() {
		var val = jQuery(this).val();
		timerWrapper.css({'background-repeat': val});
	});

	jQuery('#ycd-bg-image-url').bind('change', function() {
		var url = jQuery(this).val();
		timerWrapper.css('background-image', 'url('+url+')');
	});
};

YcdTimer.prototype.imageUpload = function() {
	var custom_uploader;
	jQuery('#js-upload-image-button').click(function(e) {
		e.preventDefault();

		/* If the uploader object has already been created, reopen the dialog */
		if (custom_uploader) {
			custom_uploader.open();
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
		/* When a file is selected, grab the URL and set it as the text field's value */
		custom_uploader.on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			var imageURL = jQuery('#ycd-bg-image-url');
			imageURL.val(attachment.url);
			imageURL.trigger('change');
		});
		/* Open the uploader dialog */
		custom_uploader.open();
	});

	/* its finish image uploader */
};

YcdTimer.prototype.changeColor = function() {
	var timerColor = jQuery('#ycd-timer-color');
	
	if (!timerColor.length) {
		return false;
	}
    timerColor.minicolors({
	    format: 'rgb',
	    opacity: 1,
		change: function() {
			var val = jQuery(this).val();
			jQuery('.ycd-timer-box span').css({color: val})
		}
	});

	var stopBgColor = jQuery('#ycd-timer-stop-bg-color');

    stopBgColor.minicolors({
	    format: 'rgb',
	    opacity: 1,
        change: function() {
            var val = jQuery(this).val();
            jQuery('.ycd-timer-start-stop').css({'background-color': val})
        }
    });

    var stopColor = jQuery('#ycd-timer-stop-color');

    stopColor.minicolors({
	    format: 'rgb',
	    opacity: 1,
        change: function() {
            var val = jQuery(this).val();
            jQuery('.ycd-timer-start-stop').css({color: val})
        }
    });

    var resetBgColor = jQuery('#ycd-timer-reset-bg-color');

    resetBgColor.minicolors({
	    format: 'rgb',
	    opacity: 1,
        change: function() {
            var val = jQuery(this).val();
            jQuery('.ycd-timer-reset').css({'background-color': val})
        }
    });

    var resetColor = jQuery('#ycd-timer-reset-color');

    resetColor.minicolors({
	    format: 'rgb',
	    opacity: 1,
        change: function() {
            var val = jQuery(this).val();
            jQuery('.ycd-timer-reset').css({color: val})
        }
    });
};

YcdTimer.prototype.changeContnetPadding = function() {
	var padding = jQuery('#ycd-timer-content-padding');

	if (!padding.length) {
		return false;
	}
	var postId = parseInt(jQuery('#post_ID').val());

	padding.bind('change', function() {
		var val = parseInt(jQuery(this).val())+'px';
		jQuery('.ycd-timer-content-wrapper-'+postId).css({padding: val})
	});
};

YcdTimer.prototype.changeFontSize = function() {
	var fontSlider = jQuery('#ycd-js-digital-font-size');

	if (!fontSlider.length) {
		return false;
	}
	var postId = parseInt(jQuery('#post_ID').val());

	fontSlider.ionRangeSlider({
		hide_min_max: true,
		keyboard: false,
		min: 3,
		max: 10,
		type: 'single',
		step: 1,
		prefix: '',
		grid: false
	}).change(function() {
		var val = jQuery(this).val();
		jQuery('#ycd-digit-font-size').remove();
		jQuery('#ycd-digit-font-size-'+postId).remove();
		jQuery('body').append('<style id="ycd-digit-font-size">.ycd-timer-time {font-size: '+val+'em;}</style>');
	});

};

YcdTimer.prototype.changeLabelFontSize = function() {
	var fontSlider = jQuery('#ycd-js-digital-label-font-size');

	if (!fontSlider.length) {
		return false;
	}

	fontSlider.bind('change', function () {
		var val = parseInt(jQuery(this).val());
		jQuery('.ycd-timer-unit-text').css({'font-size': val+'px'})
	});
};

YcdTimer.prototype.changeFontFamily = function() {
	var fontFamily = jQuery('.js-countdown-font-family');

	if (!fontFamily.length) {
		return false;
	}
	var postId = parseInt(jQuery('#post_ID').val());
	fontFamily.bind('change', function() {

		jQuery('#ycd-digit-font-family').remove();
		jQuery('#ycd-digit-font-family-'+postId).remove();
		var fontFamily = jQuery('option:selected', this).val();
		jQuery('body').append('<style id="ycd-digit-font-family">.ycd-timer-box > span {font-family: '+fontFamily+'}</style>');
	});
};

YcdTimer.prototype.changeTime = function() {
	var timeSettings = jQuery('.ycd-timer-time-settings');

	if (!timeSettings.length) {
		return false;
	}
	var that = this;
	var settings = that.getSettings();

	timeSettings.bind('change', function() {
		var type = jQuery(this).data('type');
		var val = jQuery(this).val();

		if (val == '') {
			val = 0;
			jQuery(this).val(val);
		}
		settings[type] = val;
		that.setSettings(settings);
		that.resetTimer();
		that.this.startTimer();
	})
};

YcdTimer.prototype.changeTime = function() {
	var timeSettings = jQuery('.ycd-timer-time-label');

	if (!timeSettings.length) {
		return false;
	}
	var that = this;
	var settings = that.getSettings();

	timeSettings.bind('change', function() {
		var type = jQuery(this).data('type');
		jQuery('.ycd-timer-unit-text-'+type).html(jQuery(this).val())
	})
};

jQuery(document).ready(function() {
	window.YcdTimersInstance = [];
	var renderIds = [];
	jQuery('.ycd-timer-time').each(function() {
		var options = jQuery(this).data('options');
		var id = jQuery(this).data('id');
		if (renderIds.indexOf(id) != '-1') {
			return true;
		}
		renderIds.push(id);
		var timerObj = new YcdTimer();
		timerObj.setSettings(options);
		timerObj.setId(id);
		timerObj.init();
		window.YcdTimersInstance.push(timerObj);
	});
});