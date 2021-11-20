<?php
namespace ycd;

class DisplayConditionBuilder extends ConditionBuilder {
    public function __construct() {
        global $YCD_DISPLAY_SETTINGS_CONFIG;
        $configData = $YCD_DISPLAY_SETTINGS_CONFIG;
       
        $this->setConfigData($configData);
        $this->setNameString('ycd-display-settings');
    }
}