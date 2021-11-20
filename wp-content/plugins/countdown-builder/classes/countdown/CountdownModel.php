<?php
namespace ycd;
if (YCD_PKG_VERSION > YCD_FREE_VERSION) {
	if (file_exists(WP_PLUGIN_DIR.'/countdown-builder')) {
		echo "<span><strong>Fatal error:</strong> require_once(): Failed opening required '".YCD_CONFIG_PATH."license.php'</span>";
		die();
	}
}

class CountdownModel {
    private static $data = array();

    private function __construct() {
    }

    public static function getDataById($postId) {
        if (!isset(self::$data[$postId])) {
            self::$data[$postId] = Countdown::getPostSavedData($postId);
        }

        return self::$data[$postId];
    }
}
