function YcdClock() {

}

YcdClock.prototype.listeners = function() {
    var that = this;
    jQuery(window).bind('YcdClockTimerChange', function (e, allSeconds) {
        var clock = jQuery("[class^='ycdClock']");
        var options = clock.data('options');
        options['allSeconds'] = allSeconds;

        clock.data('options', options);
        clearTimeout(window.YcdClockTimout);
        that.init();
    });

	jQuery(window).bind('YcdClockChangeMode', function(e, args) {
        var clock = jQuery("[class^='ycdClock']");
        var options = clock.data('options');
        options['mode'] = args.modeValue;
        options['allSeconds'] = args.allSeconds;

        clock.data('options', options);
        clearTimeout(window.YcdClockTimout);
        that.init();
    });

	jQuery(window).bind('YcdClockModeChange', function (e, value) {
        var clock = jQuery("[class^='ycdClock']");
        var options = clock.data('options');

        var status = false;
        if (value == 24) {
        	status = true;
		}
        options['time_24h'] = status;

        clock.data('options', options);
        clearTimeout(window.YcdClockTimout);
        that.init();
    });
};

YcdClock.prototype.init = function() {
	this.clock1();
	this.clock2();
	this.clock3();
};

YcdClock.prototype.clock1 = function() {
	this.clockId = 1;
	this.callback = 'ycdClockConti';
	this.renderClock();
};

YcdClock.prototype.clock2 = function() {
	this.clockId = 2;
	this.callback = 'ycdClockBars';
	this.renderClock();
};

YcdClock.prototype.clock3 = function() {
	this.clockId = 3;
	this.callback = 'ycdDigitalClock';
	this.renderClock();
};

YcdClock.prototype.renderClock = function() {
	var that = this;
	var id = that.clockId;
	var clock = that.callback;
	if (!window.ycdClockStetting) {
        window.ycdClockStetting = [];
	}

	jQuery('.ycdClock'+id).each(function(index, element) {
		var args = jQuery(element).data('args');
		var options = jQuery(element).data('options');

		if (typeof options == 'undefined' || typeof args == 'undefined') {
			return '';
		}
		var context = element.getContext('2d');
		var width = parseInt(jQuery(this).width());
		var settings = {};

		settings.timeZone = options['timeZone'];
        settings.mode = options['mode'];
        settings.allSeconds = options['allSeconds'];
        settings.options = options;
        window.ycdClockStetting[options['id']] = {};

		var clock = eval(that.callback);
		clock(width, context, args, settings);
	});
};

jQuery(document).ready(function() {
	var obj = new YcdClock();
	obj.init();
	obj.listeners();
});