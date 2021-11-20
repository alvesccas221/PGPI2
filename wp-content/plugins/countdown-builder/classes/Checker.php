<?php
namespace ycd;

class Checker
{
	private $post;
	private $countdownObj;
	
	public function setPost($post) {
		$this->post = $post;
	}
	
	public function getPost() {
		return $this->post;
	}
	
	public function setCountdownObj($countdownObj) {
		$this->countdownObj = $countdownObj;
	}
	
	public function getCountdownObj() {
		return $this->countdownObj;
	}
	
	public static function isAllow($post, $countdownObj) {

		if(empty($countdownObj) || !is_object($countdownObj)) {
			return false;
		}
		if(YCD_PKG_VERSION > YCD_FREE_VERSION) {
			if(!CheckerPro::allowToShow($countdownObj)) {
				return false;
			}
		}
		$obj = new self();
		$obj->setPost($post);
		$obj->setCountdownObj($countdownObj);

        if(YCD_PKG_VERSION > YCD_FREE_VERSION) {
            $allowOptionsToShow = CheckerPro::allowOptionsToShow($countdownObj);
            if($allowOptionsToShow) {
                return $allowOptionsToShow;
            }
        }

        $allowDisplay = DisplayRuleChecker::isAllow($countdownObj);
        if($allowDisplay) {
            return true;
        }
		
		return false;
	}

	private function allowToLoad() {

    }
}