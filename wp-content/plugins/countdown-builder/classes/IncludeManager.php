<?php
namespace ycd;
use \WP_Query;

class IncludeManager {
	
	private $allowedCountdowns;
	
	public function __construct() {
		$this->init();
	}
	
	public function setAllowedCountdowns($allowedCountdowns)
	{
		$this->allowedCountdowns = $allowedCountdowns;
	}
	
	public function getAllowedCountdowns()
	{
		return $this->allowedCountdowns;
	}
	
	public function init() {
		$countdownPosts = new WP_Query(
			array(
				'post_type'      => YCD_COUNTDOWN_POST_TYPE,
				'posts_per_page' => - 1
			)
		);
		$posts = array();
		
		while ($countdownPosts->have_posts()) {
			$countdownPosts->next_post();
			$countdownPost = $countdownPosts->post;
			
			if (empty($countdownPost) || empty($countdownPost->ID) || !Countdown::isActivePost($countdownPost->ID)) {
				continue;
			}
			$countdownObj = Countdown::find($countdownPost->ID);

			if(empty($countdownObj) || !is_object($countdownObj)) {
				continue;
			}
			$isAllow = Countdown::allowToLoad($countdownPost, $countdownObj);
			
			if(!$isAllow) {
				continue;
			}

			$posts[] = $countdownObj;
		}
		$this->setAllowedCountdowns($posts);
		$this->includeCountdowns();
	}
	
	private function includeCountdowns() {
		$countdowns = $this->getAllowedCountdowns();

		if(empty($countdowns)) {
			return false;
		}
		
		foreach($countdowns as $countdown) {
			$this->includeCountdown($countdown);
		}
		
		return true;
	}
	
	private function includeCountdown($countdown) {
		$content = $countdown->addToContent();

		add_action('wp_head',function() use ($content) {
			echo $content;
		});
	}
}