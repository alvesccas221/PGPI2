<?php
/**
 * Class QualityBadgeWidgetURL
 *
 * @package LiveChat\Services\Options\Elementor
 */

namespace LiveChat\Services\Options\Elementor;

use Exception;
use LiveChat\Services\Options\WritableOption;

/**
 * Class QualityBadgeWidgetURL
 *
 * @package LiveChat\Services\Options\Elementor
 */
class QualityBadgeWidgetURL extends WritableOption {
	/**
	 * QualityBadgeWidgetURL constructor.
	 *
	 * @throws Exception Can be thrown by parent constructor.
	 */
	public function __construct() {
		parent::__construct( 'quality_badge_widget_url' );
	}
}
