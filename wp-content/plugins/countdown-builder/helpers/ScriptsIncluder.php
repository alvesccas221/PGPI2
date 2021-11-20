<?php
namespace ycd;

class ScriptsIncluder {
    /**
     * Countdown register style
     *
     * @since 1.0.0
     *
     * @param string $fileName file address
     * @param array $args wordpress register  style args dep|ver|media|dirUrl
     *
     * @return void
     */
    public static function registerStyle($fileName, $args = array()) {
        if(empty($fileName)) {
            return;
        }

        $dep = array();
        $ver = YCD_VERSION;
        $media = 'all';
        $dirUrl = YCD_COUNTDOWN_CSS_URL;

        if(!empty($args['dep'])) {
            $dep = $args['dep'];
        }

        if(!empty($args['ver'])) {
            $ver = $args['ver'];
        }

        if(!empty($args['media'])) {
            $media = $args['media'];
        }

        if(!empty($args['dirUrl'])) {
            $dirUrl = $args['dirUrl'];
        }

        wp_register_style($fileName, $dirUrl.''.$fileName, $dep, $ver, $media);
    }

    /**
     * Countdown register style
     *
     * @since 1.0.0
     *
     * @param string $fileName file address
     *
     * @return void
     */
    public static function enqueueStyle($fileName) {
        if(empty($fileName)) {
            return;
        }
	    $printScripts = get_option('ycd-print-scripts-to-page');
        $isAdmin = is_admin();

	    if (empty($printScripts) || $isAdmin) {
		    wp_enqueue_style($fileName);
	    }
	    else {
		    wp_print_styles($fileName);
	    }
    }

    /**
     * @since 1.9.4
     * @param $styleName
     */
    public static function loadStyle($styleName) {
        self::registerStyle($styleName);
        self::enqueueStyle($styleName);
    }

    /**
     * Countdown register style
     *
     * @since 1.0.0
     *
     * @param string $fileName file address
     * @param array $args wordpress register  script args dep|ver|inFooter|dirUrl
     *
     * @return void
     */
    public static function registerScript($fileName, $args = array()) {
        if(empty($fileName)) {
            return;
        }

        $dep = array();
        $ver = YCD_VERSION;
        $inFooter = false;
        $dirUrl = YCD_COUNTDOWN_JS_URL;

        if(!empty($args['dep'])) {
            $dep = $args['dep'];
        }

        if(!empty($args['ver'])) {
            $ver = $args['ver'];
        }

        if(!empty($args['inFooter'])) {
            $inFooter = $args['inFooter'];
        }

        if(!empty($args['dirUrl'])) {
            $dirUrl = $args['dirUrl'];
        }

        wp_register_script($fileName, $dirUrl.''.$fileName, $dep, $ver, $inFooter);
    }

    /**
     * Countdown register style
     *
     * @since 1.0.0
     *
     * @param string $fileName file address
     *
     * @return void
     */
    public static function enqueueScript($fileName) {
        if(empty($fileName)) {
            return;
        }
        $printScripts = get_option('ycd-print-scripts-to-page');
	    $isAdmin = is_admin();
        if (empty($printScripts) || $isAdmin) {
	        wp_enqueue_script($fileName);
        }
        else {
        	wp_print_scripts($fileName);
        }
    }

    public static function localizeScript($handle, $name, $data) {
        wp_localize_script($handle, $name, $data);
    }
    
    public static function loadScript($scriptName) {
	    self::registerScript($scriptName);
	    self::enqueueScript($scriptName);
    }
}