<?php

class YcdShowReviewNotice {
	
	public function __toString() {
		$content = '';
		$allowToShow = $this->allowToShowUsageDays();

		if(!$allowToShow) {
			return $content;
		}

		$contet = $this->getReviewContent('usageDayes');
		
		return $contet;
	}

	private function allowToShowUsageDays() {
		$shouldOpen = true;
		
		$dontShowAgain = get_option('YcdDontShowReviewNotice');
		$periodNextTime = get_option('YcdShowNextTime');

		if($dontShowAgain) {
			return !$shouldOpen;
		}

		// When period next time does not exits it means the user is old
		if(!$periodNextTime) {
			YcdShowReviewNotice::setInitialDates();

			return !$shouldOpen;
		}
		$currentData = new DateTime('now');
		$timeNow = $currentData->format('Y-m-d H:i:s');
		$timeNow = strtotime($timeNow);

		return $periodNextTime < $timeNow;
	}

	private function getReviewContent($type) {
		$content = $this->getMaxOpenDaysMessage($type);
		ob_start();
		?>
			<div id="welcome-panel" class="welcome-panel ycd-review-block">
				<div class="welcome-panel-content">
					<?php echo $content; ?>
				</div>
			</div>
		<?php
		$reviewContent = ob_get_contents();
		ob_end_clean();

		return $reviewContent;
	}

	private function getMainTableCreationDate() {
		global $wpdb;

		$query = $wpdb->prepare('SELECT table_name, create_time FROM information_schema.tables WHERE table_schema="%s" AND  table_name="%s"', DB_NAME, $wpdb->prefix.'expm_maker');
		$results = $wpdb->get_results($query, ARRAY_A);

		if(empty($results)) {
			return 0;
		}

		$createTime = $results[0]['create_time'];
		$createTime = strtotime($createTime);
		update_option('YcdInstallDate', $createTime);
		$diff = time()-$createTime;
		$days  = floor($diff/(60*60*24));

		return $days;
	}

	private function getPopupUsageDays() {
		$installDate = get_option('YcdInstallDate');

		$timeDate = new DateTime('now');
		$timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));

		$diff = $timeNow-$installDate;

		$days  = floor($diff/(60*60*24));

		return $days;
	}
	
	private function getCurrentUserDisplayName() {
		$user = wp_get_current_user();
		
		return $user->display_name;
    }

	private  function getMaxOpenDaysMessage($type) {
		$getUsageDays = $this->getPopupUsageDays();
		$userName = $this->getCurrentUserDisplayName();
		$firstHeader = '<h1 class="ycd-review-h1"><strong class="ycd-review-strong">Wow! '.$userName.'</strong> You’ve been using Countdown on your site for '.$getUsageDays.' days</h1>';
		$popupContent = $this->getMaxOepnContent($firstHeader, $type);

		$popupContent .= $this->showReviewBlockJs();

		return $popupContent;
	}

	private function getMaxOepnContent($firstHeader, $type) {
		$ajaxNonce = wp_create_nonce('ycdReviewNotice');

		ob_start();
		?>
			<style>
				.ycd-buttons-wrapper .press{
					box-sizing:border-box;
					cursor:pointer;
					display:inline-block;
					font-size:1em;
					margin:0;
					padding:0.5em 0.75em;
					text-decoration:none;
					transition:background 0.15s linear
				}
				.ycd-buttons-wrapper .press-grey {
					background-color:#9E9E9E;
					border:2px solid #9E9E9E;
					color: #FFF;
                    font-weight: bold;
				}
                .ycd-buttons-wrapper .press-grey:hover {
                    background-color: #ffffff;
                    color: #9E9E9E;
                }
				.ycd-buttons-wrapper .press-lightblue {
					background-color:#ff7864;
					border:2px solid #ff7864;
					color: #FFF;
                    font-weight: bold;
                    margin: 0 10px;
				}
                .ycd-buttons-wrapper .press-lightblue:hover {
                    background-color: #ffffff;
                    color: #ff7864;
                }
				.ycd-review-wrapper{
					text-align: center;
					padding: 20px;
				}
				.ycd-review-wrapper p {
					color: black;
				}
				.ycd-review-h1 {
					font-size: 22px;
					font-weight: normal;
					line-height: 1.384;
                    margin-top: 0px;
                    margin-bottom: 5px;
				}
				.ycd-review-h2{
					font-size: 20px;
					font-weight: normal;
				}
				:root {
					--main-bg-color: #ff7864;
				}
				.ycd-review-strong{
					color: #ff7864;
				}
				.ycd-review-mt20{
					margin-top: 8px
				}
                .welcome-panel.ycd-review-block {
                    padding-top: 0px;
                    margin-right: 20px;
                }
                .ycd-banner-close {
                    position: absolute;
                    top: 8px;
                    right: 15px;
                    font-size: 15px;
                    font-weight: bold;
                    color: #23282d;
                    cursor: pointer;
                }
			</style>
			<div class="ycd-review-wrapper">
                <span class="ycd-banner-close ycd-already-did-review" data-ajaxnonce="<?php echo esc_attr($ajaxNonce); ?>" data-message-type="<?php echo $type; ?>">X</span>
				<div class="ycd-review-description">
					<?php echo $firstHeader; ?>
					<h2 class="ycd-review-h2">This is really great for your website score.</h2>
					<p class="ycd-review-mt20">Have your input in the development of our plugin, and we’ll provide better conversions for your site!<br /> Leave your 5-star positive review and help us go further to the perfection!</p>
				</div>
				<div class="ycd-buttons-wrapper">
					<button class="press press-grey ycd-button-1 ycd-already-did-review" data-ajaxnonce="<?php echo esc_attr($ajaxNonce); ?>">I already did</button>
					<button class="press press-lightblue ycd-button-3 ycd-already-did-review" data-ajaxnonce="<?php echo esc_attr($ajaxNonce); ?>" onclick="window.open('<?php echo YCD_COUNTDOWN_REVIEW_URL; ?>')">You worth it!</button>
					<button class="press press-grey ycd-button-2 ycd-show-popup-period" data-ajaxnonce="<?php echo esc_attr($ajaxNonce); ?>" data-message-type="<?php echo $type; ?>">Maybe later</button>
				</div>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	private function showReviewBlockJs() {
		ob_start();
		?>
			<script type="text/javascript">
				jQuery('.ycd-already-did-review').each(function () {
					jQuery(this).on('click', function () {
						var ajaxNonce = jQuery(this).attr('data-ajaxnonce');

						var data = {
							action: 'ycd_dont_show_review_notice',
							ajaxNonce: ajaxNonce
						};
						jQuery.post(ajaxurl, data, function(response,d) {
							if(jQuery('.ycd-review-block').length) {
								jQuery('.ycd-review-block').remove();
							}
						});
					});
				});

				jQuery('.ycd-show-popup-period').on('click', function () {
					var ajaxNonce = jQuery(this).attr('data-ajaxnonce');
					var messageType = jQuery(this).attr('data-message-type');

					var data = {
						action: 'ycd_change_review_show_period',
						messageType: messageType,
						ajaxNonce: ajaxNonce
					};
					jQuery.post(ajaxurl, data, function(response,d) {
						if(jQuery('.ycd-review-block').length) {
							jQuery('.ycd-review-block').remove();
						}
					});
				});
			</script>
		<?php
		$script = ob_get_contents();
		ob_end_clean();

		return $script;
	}

	public static function setInitialDates() {
		$usageDays = get_option('YcdUsageDays');
		if(!$usageDays) {
			update_option('YcdUsageDays', 0);

			$timeDate = new DateTime('now');
			$installTime = strtotime($timeDate->format('Y-m-d H:i:s'));
			update_option('YcdInstallDate', $installTime);
			$timeDate->modify('+'.YCD_SHOW_REVIEW_PERIOD.' day');

			$timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));
			update_option('YcdShowNextTime', $timeNow);
		}
	}

	public static function deleteInitialDates() {
		delete_option('YcdUsageDays');
		delete_option('YcdInstallDate');
		delete_option('YcdShowNextTime');
	}
}