<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}
use ycd\Installer;
if (!defined('YCD_FILE_NAME')) {
	define('YCD_FILE_NAME', plugin_basename(__FILE__));
}

if (!defined('YCD_FOLDER_NAME')) {
	define('YCD_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

require_once(plugin_dir_path(__FILE__).'config/boot.php');
require_once(YCD_HELPERS_PATH.'ShowReviewNotice.php');
require_once(YCD_CLASSES_PATH.'Installer.php');
Installer::uninstall();
