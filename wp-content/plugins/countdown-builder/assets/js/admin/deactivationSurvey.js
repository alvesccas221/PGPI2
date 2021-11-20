function YcdDeactivateJs() {
    this.init();
}

YcdDeactivateJs.prototype.init = function () {
    this.deactivate();
};

YcdDeactivateJs.prototype.deactivate = function () {
    var that = this;
    jQuery("tr[data-slug='countdown-builder'] .deactivate a").click(function(event) {
        event.preventDefault();
        that.deactivationUrl = jQuery(this).attr("href");
        jQuery("#countdown-builder-deactivation-survey-popup-container").show();
    });

    jQuery('.countdown-builder-deactivation-survey-popup-overlay').bind('click', function () {
        jQuery("#countdown-builder-deactivation-survey-popup-container").hide();
    });

    jQuery('.countdown-builder-survey-skip').bind('click', function (e) {
        jQuery("#countdown-builder-deactivation-survey-popup-container").hide();
        window.location.replace(that.deactivationUrl);
    });

    jQuery('.countdown-builder-deactivation-survey-content-form').submit(function (event) {
        event.preventDefault();
        var savedData = jQuery(this).serialize();
        jQuery("#countdown-builder-deactivation-survey-popup-container").hide();
        var data = {
            action: 'countdown-builder_storeSurveyResult',
            savedData: savedData,
            token: COUNTDOWN_DEACTIVATE_ARGS.nonce
        };

        jQuery.post(ajaxurl, data, function(response) {
            console.log(response);
        }).always(function() {
            window.location.replace(that.deactivationUrl);
        });
    });
};

jQuery(document).ready(function () {
    new YcdDeactivateJs;
});