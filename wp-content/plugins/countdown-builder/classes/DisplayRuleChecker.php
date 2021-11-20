<?php
namespace ycd;

class DisplayRuleChecker {
    private $typeObj;

    public function setTypeObj($typeObj) {
        $this->typeObj = $typeObj;
    }

    public function getTypeObj() {
        return $this->typeObj;
    }

    public static function isAllow($countdownObj) {
        $obj = new self();
        $obj->setTypeObj($countdownObj);
        $isDisplayOn = $countdownObj->getOptionValue('ycd-countdown-display-on');

        if(!$isDisplayOn) {
            return $isDisplayOn;
        }

        $status = $obj->checkDisplaySettings();

        return $status;
    }

    private function checkDisplaySettings() {
        $countdownObj = $this->getTypeObj();

        $settings = $countdownObj->getOptionValue('ycd-display-settings');

        if(empty($settings)) {
            return false;
        }
        $status = array();

        foreach ($settings as $setting) {

            if($setting['key1'] == 'everywhere') {
                return true;
            }

            $isAllowSettings = $this->checkSetting($setting);
            $status[] = $isAllowSettings;
        }

        return (in_array('is1', $status) && !in_array('isnot1', $status));
    }

    private function checkSetting($setting) {
        global $post;
        $post_type = get_post_type($post->ID);

        if('selected_'.$post_type == $setting['key1']) {

            if(in_array($post->ID, array_keys($setting['key3']))) {
                return ($setting['key2'].'1');
            }
            return '';
        }

        if('all_'.$post_type == $setting['key1']) {
            return ($setting['key2'].'1');
        }

        return '';
    }
}