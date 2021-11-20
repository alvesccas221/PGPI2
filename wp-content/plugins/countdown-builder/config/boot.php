<?php
require_once dirname(__FILE__).'/config.php';

if(YCD_PKG_VERSION > YCD_FREE_VERSION) {
	if(file_exists(WP_PLUGIN_DIR.'/countdown-builder')) {
		echo "<span><strong>Fatal error:</strong> require_once(): Failed opening required '".YCD_CONFIG_PATH."license.php'</span>";
		die();
	}
}
require_once(dirname(__FILE__).'/optionsConfig.php');
require_once(dirname(__FILE__).'/dataAccess.php');