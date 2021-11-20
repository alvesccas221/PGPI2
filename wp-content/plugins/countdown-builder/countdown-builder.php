<?php
/**
 * Plugin Name: Countdown builder
 * Description: The best countdown plugin by Adam skaat
 * Version: 2.2.2
 * Author: Adam Skaat
 * Author URI: https://edmonsoft.com/countdown
 * License: GPLv2
 */

/*If this file is called directly, abort.*/
if(!defined('WPINC')) {
    wp_die();
}

if(!defined('YCD_FILE_NAME')) {
    define('YCD_FILE_NAME', plugin_basename(__FILE__));
}

if(!defined('YCD_FOLDER_NAME')) {
    define('YCD_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

require_once(plugin_dir_path(__FILE__).'config/boot.php');
require_once(plugin_dir_path(__FILE__).'CountdownInit.php');