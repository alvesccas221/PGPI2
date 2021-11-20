function YcdSimpleCountdown()
{
	this.countdownRun = true;
	this.seconds = 0;
	this.id = 0;
	this.doubeleDigits = false;
	this.countdownContainer = jQuery('.ycd-simple-container');
}

YcdSimpleCountdown.prototype = new YcgGeneral();

YcdSimpleCountdown.run = function()
{
	var simpleCountdown = jQuery('.ycd-simple-container');

	if (!simpleCountdown.length) {
		return false;
	}

	simpleCountdown.each(function () {
	   var options = jQuery(this).data('options');
	   var id = jQuery(this).data('id');
		var obj = new YcdSimpleCountdown();
		options['id'] = id;
		obj.options = options;
		obj.id = id;
		obj.init();
	});
};

YcdSimpleCountdown.prototype.init = function()
{
	this.doubeleDigits = this.options['ycd-enable-simple-double-digits'];

	this.render();
	this.livePreview();
};

YcdSimpleCountdown.prototype.responsive = function() {
	var scale = function () {
		jQuery('.ycd-simple-content-wrapper').each(function () {
			var wrapperWidth = jQuery('.ycd-simple-mode-textUnderCountdown', this).get(0).scrollWidth;
			var scaleDegree =  jQuery(this).width()/wrapperWidth;

			if(wrapperWidth > jQuery(this).width()) {
				jQuery('.ycd-simple-container', this).css({
					'transform': 'scale('+ scaleDegree +', '+scaleDegree+')'
				});
			}
			else {
				jQuery('.ycd-simple-container', this).css({
					'transform': 'scale('+ 1 +', '+1+')'
				});
			}
		});
	};

	scale();
	jQuery(window).resize(function () {
		scale();
	})
};

YcdSimpleCountdown.prototype.changeDate = function() {
	var datePicker = jQuery('#ycd-date-time-picker, #ycd-coming-soon-start');
	if(!datePicker.length) {
		return false;
	}

	datePicker.change(function () {
		jQuery(window).trigger('ycdChangeDate');
	})
};

YcdSimpleCountdown.prototype.changeTimeZone = function() {
	var timeZone = jQuery('.js-circle-time-zone');

	if(!timeZone.length) {
		return false;
	}

	timeZone.bind('change', function() {
		jQuery(window).trigger('ycdChangeDate');
	});
};

YcdSimpleCountdown.prototype.changeDateDuration = function() {
	var types = jQuery('.ycd-timer-time-settings');

	if(!types.length) {
		return false;
	}
	var that = this;
	var countdown = this.countdownContainer;
	types.bind('change', function() {
		var val = jQuery(this).val();

		if (val == '') {
			val = 0;
			jQuery(this).val(val);
		}
		var timeName = jQuery(this).attr('name');
		var options = countdown.data('options');
		options[timeName] = parseInt(val);

		that.reInitSecondsByOptions(options);
	});
};

YcdSimpleCountdown.prototype.changeFontFamily = function() {
	var types = jQuery('.js-simple-font-family');

	if(!types.length) {
		return false;
	}
	types.bind('change', function() {
		var val = jQuery(this).val();
		var type = jQuery(this).data('field-type');

		jQuery('.ycd-simple-countdown-'+type).css({'font-family': val});
	});
};

YcdSimpleCountdown.prototype.changeFontSizes = function() {
	var types = jQuery('.ycd-simple-font-size');

	if(!types.length) {
		return false;
	}
	var that = this;
	var countdown = this.countdownContainer;
	types.bind('change', function() {
		var val = jQuery(this).val();
		var type = jQuery(this).data('field-type');

		jQuery('.ycd-simple-countdown-'+type).css({'font-size': val});
	});
};

YcdSimpleCountdown.prototype.changeColor = function() {
	var types = jQuery('.js-ycd-simple-time-color');

	if(!types.length) {
		return false;
	}
	var that = this;
	var countdown = this.countdownContainer;
	types.minicolors({
		format: 'rgb',
		opacity: 1,
		change: function () {
			var val = jQuery(this).val();
			var type = jQuery(this).data('time-type');
			jQuery('.ycd-simple-countdown-'+type).css({color: val});
		}
	});
};

YcdSimpleCountdown.prototype.eventListener = function ()
{
	var that = this;

	jQuery(window).bind('ycdChangeDate', function () {
		var val = jQuery('#ycd-date-time-picker').val()+':00';
		var selectedTimezone = jQuery('.js-circle-time-zone option:selected').val();
		var seconds = that.setCounterTime(val, selectedTimezone);
		that.seconds = seconds*1000;
		that.countdown();
	});
};

YcdSimpleCountdown.prototype.changeDateType = function() {
	var types = jQuery('.ycd-date-type');

	if(!types.length) {
		return false;
	}
	var that = this;
	var countdowns = this.countdownContainer;
	types.bind('change', function() {
		var val = jQuery(this).val();
		var timeName = jQuery(this).attr('name');
		var options = countdowns.data('options');
		options[timeName] = val;

		that.reInitSecondsByOptions(options);
	});
};

YcdSimpleCountdown.prototype.reInitSecondsByOptions = function (options)
{
	var seconds = this.getSeconds(options);

	this.seconds = seconds*1000;
	this.countdown();
};


YcdSimpleCountdown.prototype.livePreview = function()
{
	var adminElement = jQuery('.ycd-simple-text');
	if (!adminElement.length) {
		return false;
	}

	this.eventListener();
	this.changeText();
	this.changeSwitch();
	this.changeDateType();
	this.changeDate();
	this.changeTimeZone();
	this.changeDateDuration();
	this.changeFontSizes();
	this.changeFontFamily();
	this.changeColor();
	this.changeDoubeleDigits();
};

YcdSimpleCountdown.prototype.changeText = function()
{
	var texts = jQuery('.ycd-simple-text');

	texts.bind('input', function () {
	   var unite = jQuery(this).data('time-type');
	   jQuery('.ycd-simple-countdown-'+unite+'-label').html(jQuery(this).val());
	});
};

YcdSimpleCountdown.prototype.changeDoubeleDigits = function()
{
	var texts = jQuery('#enable-double-digits');
	var that = this;

	texts.bind('change', function () {
	   var status = jQuery(this).is(':checked');
	   that.doubeleDigits = status;
	});
};

YcdSimpleCountdown.prototype.changeSwitch = function()
{
	var status = jQuery('.js-ycd-time-status');

	if (!status.length) {
		return false;
	}

	status.bind('change', function () {
	   var currentStatus = jQuery(this).is(':checked');
	   var type = jQuery(this).data('time-type');
	   var wrapper = jQuery('.ycd-simple-current-unite-'+type);
	   if (currentStatus) {
		   jQuery(wrapper).prev().find('.ycd-simple-timer-dots').removeClass('ycd-hide');
			wrapper.removeClass('ycd-hide');
	   }
	   else {
	   	    if (jQuery(wrapper).nextAll().not(".ycd-hide").length == 0) {
		        jQuery(wrapper).prev().find('.ycd-simple-timer-dots').addClass('ycd-hide');
	        }
			wrapper.addClass('ycd-hide');
	   }
	});
};

YcdSimpleCountdown.prototype.render = function()
{
	this.addTimeToClock();
	this.countdown();
	this.responsive();
};

YcdSimpleCountdown.prototype.countdown = function()
{
	var unites = ['months', 'days', 'hours', 'minutes', 'seconds'];
	var that = this;
	var id = that.id;
	var options = this.options;

	var countdownWrapper = jQuery('.ycd-simple-wrapper-'+this.id);
	var runCountdown = function() {

		// Get today's date and time
		var now = new Date().getTime();

		// Find the distance between now and the count down date
		var distance = that.seconds;
		// If the count down is finished, write some text
		if (distance <= 0) {
			clearInterval(x);
			that.endBehavior(countdownWrapper, that.options);
			return;
		}
		// Time calculations for days, hours, minutes and seconds
		var unitesValues = {};
		unitesValues.months = Math.floor(distance / (2678400000));
		if (options['ycd-simple-enable-months']) {
			distance = distance %  2678400000
		}
		unitesValues.days = Math.floor(distance/ (1000 * 60 * 60 * 24));
		unitesValues.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		unitesValues.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		unitesValues.seconds = Math.floor((distance % (1000 * 60)) / 1000);

		for (var i in unites) {
			var unite = unites[i];
			var selector = '.ycd-simple-mode-textUnderCountdown-'+id+' .ycd-simple-countdown-'+unite+'-time';
			var currentUniteValue = unitesValues[unite];
			if (currentUniteValue < 10 && that.doubeleDigits) {
				currentUniteValue = "0" +currentUniteValue;
			}
			jQuery(selector).text(currentUniteValue);
		}
		if (options['ycd-countdown-expire-behavior'] == 'countToUp' && that.seconds <= 1000) {
			that.countdownRun = false;
		}
		if (!that.countdownRun) {
			that.seconds += 1000;
		}
		else {
			that.seconds -= 1000;
		}
	};
	runCountdown();

	var x = setInterval(function() {
		runCountdown();
	}, 1000);
};

YcdSimpleCountdown.prototype.addTimeToClock = function()
{
	var options = this.options;
	var seconds = this.getSeconds(options);
	this.seconds = seconds*1000;
	this.id = options['id'];
	this.options['allSeconds'] = seconds;
	this.savedOptions = this.options;
};

jQuery(document).ready(function() {
	YcdSimpleCountdown.run();
});