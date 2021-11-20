<?php
namespace ycd;
use \YcdCountdownOptionsConfig;
use \YcdShowReviewNotice;
use \YcdCountdownConfig;

class Actions {
	public $customPostTypeObj;
	private $isLoadedMediaData = false;

	public function isLoadedMediaData() {
		return $this->isLoadedMediaData;
	}

	public function setIsLoadedMediaData($isLoadedMediaData) {
		$this->isLoadedMediaData = $isLoadedMediaData;
	}

	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action('admin_init', array($this, 'userRolesCaps'));
		add_action('init', array($this, 'postTypeInit'));
		add_action('admin_menu', array($this, 'addSubMenu'));
		add_action('save_post', array($this, 'savePost'), 10, 3);
		add_shortcode('ycd_countdown', array($this, 'shortcode'));
		add_action('manage_'.YCD_COUNTDOWN_POST_TYPE.'_posts_custom_column' , array($this, 'tableColumnValues'), 10, 2);
		add_action('add_meta_boxes', array($this, 'generalOptions'));
		add_action('widgets_init', array($this, 'loadWidgets'));
		add_action('media_buttons', array($this, 'ycdMediaButton'), 11);
		add_action('admin_post_ycdSaveSettings', array($this, 'saveSettings'), 10, 1);
		add_action('admin_post_ycdComingSoon', array($this, 'comingSoon'), 10, 1);
		add_action('wp_head', array($this, 'wpHead'), 10, 1);
        add_action('admin_head', array($this, 'adminHead'));
		add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
		add_filter('mce_external_plugins', array($this, 'editorButton'));
		add_action("admin_menu", array($this, 'adminMenu'));
		add_action('admin_action_ycd_duplicate_post_as_draft', array($this, 'duplicatePostSave'));
    }

	public function beforeDeactivateCountdown() {
		wp_enqueue_style('before-deactivate-countdown-css', YCD_COUNTDOWN_ADMIN_CSS_URL.'deactivationSurvey.css');
		wp_enqueue_script('before-deactivate-countdown-js', YCD_COUNTDOWN_ADMIN_JS_URL.'deactivationSurvey.js', array('jquery'));

		wp_localize_script('before-deactivate-countdown-js', 'COUNTDOWN_DEACTIVATE_ARGS', array(
			'nonce' => wp_create_nonce('countdownBuilderAjaxNonce'),
			'areYouSure' => __('Are you sure?', YCD_TEXT_DOMAIN)
		));

		require_once YCD_ADMIN_VIEWS_PATH.'uninstallSurveyPopup.php';
	}

	public function duplicatePostSave() {
		
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}
		/*
		 * Nonce verification
		 */
		if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], YCD_COUNTDOWN_POST_TYPE ) )
			return;
		
		/*
		 * get the original post id
		 */
		$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		/*
		 * and all the original post data then
		 */
		$post = get_post( $post_id );
		
		/*
		 * if you don't want current user to be the new post author,
		 * then change next couple of lines to this: $new_post_author = $post->post_author;
		 */
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
		
		/*
		 * if post data exists, create the post duplicate
		 */
		if (isset( $post ) && $post != null) {
			
			/*
			 * new post data array
			 */
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'publish',
				'post_title'     => $post->post_title.'(clone)',
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
			
			/*
			 * insert the post by wp_insert_post() function
			 */
			$new_post_id = wp_insert_post( $args );
			
			/*
			 * get all current post terms ad set them to the new post draft
			 */
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
			
			/*
			 * duplicate all post meta just in two SQL queries
			 */
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if( $meta_key == '_wp_old_slug' ) continue;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}
			
			
			/*
			 * finally, redirect to the edit post screen for the new draft
			 */
			wp_redirect(admin_url('edit.php?post_type=' . YCD_COUNTDOWN_POST_TYPE));
			exit;
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}
    
    public function adminMenu() {
	    if (!get_option('ycd-hide-coming-soon-menu')) {
		    add_menu_page(__('Coming Soon', YCD_TEXT_DOMAIN), __('Coming Soon', YCD_TEXT_DOMAIN), 'manage_options', 'ycdComingSoon', array($this, 'comingSoonMenu'), 'dashicons-clock', 11);
	    }
	}
    
    public function comingSoonMenu() {
	    $comingSoonObj = new ComingSoon();
	    $comingSoonObj->adminView();
    }

	public function editorButton($buttons) {
		$isLoadedMediaData = $this->isLoadedMediaData();
		new Tickbox(true, $isLoadedMediaData);
		$buttons['countdownBuilder'] = plugins_url('/../assets/js/admin/ycd-tinymce-plugin.js',__FILE__ );

		return $buttons;
	}
	
	public function enqueueScripts() {
        $includeManager = new IncludeManager();
	}
	
	public function adminHead() {
        $script = '';

        $script = "
			<script>jQuery(document).ready(function() {jQuery('#menu-posts-ycdcountdown a[href*=\"page=ycdIdeas\"]').css({color: '#55efc3', 'font-size': '17px'});jQuery('#menu-posts-ycdcountdown a[href*=\"page=ycdIdeas\"]').bind('click', function(e) {e.preventDefault(); window.open('https://wordpress.org/support/plugin/countdown-builder/')}) });</script>";

		$script .= "<script>jQuery(document).ready(function() {jQuery('#menu-posts-ycdcountdown a[href*=\"page=supports\"]').css({color: 'yellow'});jQuery('#menu-posts-ycdcountdown a[href*=\"page=supports\"]').bind('click', function(e) {e.preventDefault(); window.open('https://wordpress.org/support/plugin/countdown-builder/')}) });</script>";
        if (YCD_PKG_VERSION == YCD_FREE_VERSION) {
            $script .=  '<script>';
            $script .= "jQuery(document).ready(function() {jQuery('[href*=\"ycdSubscribers\"]').attr(\"href\", '".YCD_COUNTDOWN_PRO_URL."').attr('target', '_blank');jQuery('[href*=\"ycdNewsletter\"]').attr(\"href\", '".YCD_COUNTDOWN_PRO_URL."').attr('target', '_blank')});";
            $script .= '</script>';
        }

		echo $script;
	}

	public static function wpHead() {
		echo YcdCountdownConfig::headerScript();
	}

	public function userRolesCaps() {
		$userSavedRoles = AdminHelper::getCountdownPostAllowedUserRoles();

		foreach ($userSavedRoles as $theRole) {
			$role = get_role($theRole);
			;
			$role->add_cap('read');
			$role->add_cap('read_post');
			$role->add_cap('read_private_ycd_countdowns');
			$role->add_cap('edit_ycd_countdown');
			$role->add_cap('edit_ycd_countdowns');
			$role->add_cap('edit_others_ycd_countdowns');
			$role->add_cap('edit_published_ycd_countdowns');
			$role->add_cap('publish_ycd_countdowns');
			$role->add_cap('delete_ycd_countdowns');
			$role->add_cap('delete_published_posts');
			$role->add_cap('delete_others_ycd_countdowns');
			$role->add_cap('delete_private_ycd_countdowns');
			$role->add_cap('delete_private_ycd_countdown');
			$role->add_cap('delete_published_ycd_countdowns');

			// For countdown builder sub-menus and terms
			$role->add_cap('ycd_manage_options');
		}

		return true;
	}


	function ycdMediaButton() {
		$this->setIsLoadedMediaData(true);
		new Tickbox();
	}

	public function loadWidgets() {
		register_widget('ycd_countdown_widget');
	}

	public function postTypeInit() {
		add_action('admin_footer', array($this, 'beforeDeactivateCountdown'));
		$this->revieNotice();
		$this->customPostTypeObj = new RegisterPostType();
		$currentPostType = AdminHelper::getCurrentPostType();

        if ($currentPostType == YCD_COUNTDOWN_POST_TYPE) {
			YcdCountdownConfig::displaySettings();
		}
		
		if (YCD_PKG_VERSION != YCD_FREE_VERSION) {
			new Updates();
        }
	}

	private function revieNotice() {
		add_action('admin_notices', array($this, 'showReviewNotice'));
		add_action('network_admin_notices', array($this, 'showReviewNotice'));
		add_action('user_admin_notices', array($this, 'showReviewNotice'));
	}

	public function showReviewNotice() {
		echo new YcdShowReviewNotice();
	}

	public function addSubMenu() {
		$this->customPostTypeObj->addSubMenu();
	}

	public function savePost($postId, $post, $update) {
		if(!$update) {
			return false;
		}
		
		$postData = Countdown::parseCountdownDataFromData($_POST);
		$postData = apply_filters('ycdSavedData', $postData);
		
		if(empty($postData)) {
			return false;
		}
		$postData['ycd-post-id'] = $postId;

		if (!empty($postData['ycd-type'])) {
			$type = $postData['ycd-type'];
			$typePath = Countdown::getTypePathFormCountdownType($type);
			$className = Countdown::getClassNameCountdownType($type);

			require_once($typePath.$className.'.php');
			$className = __NAMESPACE__.'\\'.$className;

			$className::create($postData);
		}

		return true;
	}

	public function shortcode($args, $content) {
		YcdCountdownOptionsConfig::optionsValues();

		$id = $args['id'];

		if(empty($id)) {
			return '';
		}
		$typeObj = Countdown::find($id);
		$isActive = Countdown::isActivePost($id);

		if (empty($typeObj) || !$isActive) {
			return '';
		}

		if(!$typeObj->allowOpen()) {
			return '';
		}

		$typeObj->setShortCodeArgs($args);
		$typeObj->setShortCodeContent($content);

		if(YCD_PKG_VERSION > YCD_FREE_VERSION) {
			if(!CheckerPro::allowToShow($typeObj)) {
				return '';
			}
		}
		ob_start();
		$typeObj->chanegSavedDataFromArgs();

		echo $typeObj->renderView();

		if(!empty($content)) {
			echo "<a href='javascript:void(0)' class='ycd-circle-popup' data-id=".esc_attr($id).">$content</a>";
		}
		$content = ob_get_contents();
		ob_get_clean();

		return apply_filters('ycdCountdownContent', $content, $typeObj);
	}

	public function tableColumnValues($column, $postId) {
		$countdownObj = Countdown::find($postId);

		if ($column == 'shortcode') {
			echo '<div class="ycd-tooltip">
                    <span class="ycd-tooltiptext" id="ycd-tooltip-'.$postId.'">'.__('Copy to clipboard', YCD_TEXT_DOMAIN).'</span><input type="text" data-id="'.$postId.'" onfocus="this.select();" readonly id="ycd-shortcode-input-'.$postId.'" value="[ycd_countdown id='.$postId.']" class="large-text code countdown-shortcode"></div>';
		}
		if ($column == 'type') {
			$title = '';
			if (!empty($countdownObj)) {
				$title = $countdownObj->getTypeTitle();
			}
			echo $title;
			if(!empty($countdownObj) && is_object($countdownObj)) {
                $allowToShowExpiration = $countdownObj->allowToShowExpiration();
                if(is_object($countdownObj) && $countdownObj->getIsCountdown() && $allowToShowExpiration) {
                    if($countdownObj->isExpired()) {
                        echo '<div>Date: Expired</div>';
                    }
                    else {
                        $dateString = $countdownObj->getExpireDate();

                        echo '<div>Expires after '.$dateString.'</div>';
                    }
                }
            }
		}
		if ($column == 'onof') {
			$checked = '';
			$isActive = Countdown::isActivePost($postId);

			if ($isActive) {
				$checked = 'checked';
			}
			?>
			<label class="ycd-switch">
				<input type="checkbox" data-id="<?= esc_attr($postId); ?>" name="ycd-countdown-show-mobile" class="ycd-accordion-checkbox ycd-countdown-enable" <?= $checked; ?> >
				<span class="ycd-slider ycd-round"></span>
			</label>
			<?php
		}
	}

	public function generalOptions() {
		if(YCD_PKG_VERSION == YCD_FREE_VERSION) {
			add_meta_box('ycdUpgrade', __('Upgrade', YCD_TEXT_DOMAIN), array($this, 'upgradeToPro'), YCD_COUNTDOWN_POST_TYPE, 'side', 'high');
		}
        add_meta_box('ycdSupport', __('Support', YCD_TEXT_DOMAIN), array($this, 'support'), YCD_COUNTDOWN_POST_TYPE, 'side');
        add_meta_box('ycdShortcodeMetabox', __('Info', YCD_TEXT_DOMAIN), array($this, 'shortcodeMetabox'), YCD_COUNTDOWN_POST_TYPE, 'side');
    }

	public function upgradeToPro() {
		require_once(YCD_VIEWS_PATH.'upgrade.php');
	}

	public function support() {
		require_once(YCD_VIEWS_PATH.'supportMetabox.php');
	}
	
	public function shortcodeMetabox() {
		require_once(YCD_ADMIN_VIEWS_PATH.'shortcodeMetabox.php');
	}

	public function saveSettings() {
		$post = $_POST;

		if(
			!isset($_POST[YCD_ADMIN_POST_NONCE])
			|| !wp_verify_nonce($_POST[YCD_ADMIN_POST_NONCE], 'YCD_ADMIN_POST_NONCE')
		) {
			_e('Sorry, your nonce did not verify.', YRM_LANG);die();
		}
		$userRoles = $post['ycd-user-roles'];

		if (isset($post['ycd-dont-delete-data'])) {
			update_option('ycd-delete-data', true);
		}
		else {
			delete_option('ycd-delete-data');
		}
		
		if (isset($post['ycd-hide-coming-soon-menu'])) {
			update_option('ycd-hide-coming-soon-menu', true);
		}
		else {
			delete_option('ycd-hide-coming-soon-menu');
		}

		if (isset($post['ycd-print-scripts-to-page'])) {
			update_option('ycd-print-scripts-to-page', true);
		}
		else {
			delete_option('ycd-print-scripts-to-page');
		}

		update_option('ycd-user-roles', $userRoles);
		wp_redirect(admin_url().'edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE.'&page='.YCD_COUNTDOWN_SETTINGS.'&saved=1');
	}
	
	public function comingSoon() {
		check_admin_referer('ycdSaveComingSoon');
		$postData = $_POST;
		ComingSoon::saveComingSoonSettings($postData);
		$adminUrl = admin_url().'/edit.php';
		
		$url = add_query_arg( array(
			'post_type' => YCD_COUNTDOWN_POST_TYPE,
			'page' => YCD_COUNTDOWN_COMING_SOON,
			'saved' => 1
		), $adminUrl);
		
		wp_redirect($url);
    }
}
