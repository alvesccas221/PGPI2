<?php
namespace ycd;
use \YcdShowReviewNotice;
use \YcdCountdownOptionsConfig;

class Installer {

	public static function uninstall() {

		if (!get_option('ycd-delete-data')) {
			return false;
		}

		YcdShowReviewNotice::deleteInitialDates();
		self::deleteCountdowns();
	}

	/**
	 * Delete all countdown builder post types posts
	 *
	 * @since 1.2.2
	 *
	 * @return void
	 *
	 */
	private static function deleteCountdowns()
	{
		$countdowns = get_posts(
			array(
				'post_type' => YCD_COUNTDOWN_POST_TYPE,
				'post_status' => array(
					'publish',
					'pending',
					'draft',
					'auto-draft',
					'future',
					'private',
					'inherit',
					'trash'
				)
			)
		);

		foreach ($countdowns as $countdown) {
			if (empty($countdown)) {
				continue;
			}
			wp_delete_post($countdown->ID, true);
		}
		delete_option('YcdInserted');
	}

	public static function install() {
		self::createTables();
		YcdShowReviewNotice::setInitialDates();

		if(is_multisite() && get_current_blog_id() == 1) {
			global $wp_version;

			if($wp_version > '4.6.0') {
				$sites = get_sites();
			}
			else {
				$sites = wp_get_sites();
			}

			foreach($sites as $site) {

				if($wp_version > '4.6.0') {
					$blogId = $site->blog_id."_";
				}
				else {
					$blogId = $site['blog_id']."_";
				}
				if($blogId != 1) {
					self::createTables($blogId);
				}
			}
		}
        self::insertDefaultData();
	}

    private static function insertDefaultData() {
        $isInserted = get_option('YcdInserted');

        if ($isInserted) {
            return false;
        }

        $defaultPost = array(
            'post_title'    => __('Default', YCD_TEXT_DOMAIN),
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'=> YCD_COUNTDOWN_POST_TYPE,
            'post_category' => array()
        );

        // Insert the post into the database
        wp_insert_post($defaultPost);
        global $wpdb;
        $lastid = $wpdb->insert_id;

        $options = YcdCountdownOptionsConfig::getDefaultValuesData();
        $options['ycd-type'] = 'circle';
        $options['ycd-post-id'] = $lastid;
        update_post_meta($lastid, 'ycd_options', $options);
        update_option('YcdInserted', 1);

        return false;
    }

	public static function createTables($blogId = '') {
		global $wpdb;
		$createTableHeader = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.$blogId;

		$subscriberTableQuery = $createTableHeader.YCD_COUNTDOWN_SUBSCRIBERS_TABLE.' (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`email` varchar(255) NOT NULL,
			`cDate` date,
			`type` int(12),
			`status` varchar(255) NOT NULL,
			PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8; ';

		$wpdb->query($subscriberTableQuery);
	}
}