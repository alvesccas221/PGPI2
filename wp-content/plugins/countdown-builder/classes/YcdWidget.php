<?php
use ycd\Countdown;
use ycd\HelperFunction;

// Creating the widget
class ycd_countdown_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
// Base ID of your widget
			YCD_COUNTDOWN_WIDGET,
// Widget name will appear in UI
			YCD_COUNTDOWN_MENU_TITLE,
// Widget description
			array('description' => __('Countdown Builder widget', YCD_TEXT_DOMAIN),)
		);
	}

// Creating widget front-end
	public function widget($args, $instance) {
	    $cdId = (int)@$instance['ycdOption'];

	    echo do_shortcode('[ycd_countdown id='.$cdId.']');
	}

// Widget Backend
	public function form($instance) {
		$popups = Countdown::getCountdownsObj();
        $idTitle = Countdown::shapeIdTitleData($popups);
        // Widget admin form
        $optionSaved = @$this->get_field_name('ycdOption');
        $optionName = @$instance['ycdOption'];
		?>
		<p>
			<label><?php _e('Select countdown', YCD_TEXT_DOMAIN); ?>:</label>
			<?php echo HelperFunction::createSelectBox($idTitle, $optionName, array('name' => $optionSaved)); ?>
		</p>
		<?php
	}

// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance = array()) {
		
		$instance = array();

		$instance['ycdOption'] = $new_instance['ycdOption'];
		return $instance;
	}
} // Class wpb_widget ends here
