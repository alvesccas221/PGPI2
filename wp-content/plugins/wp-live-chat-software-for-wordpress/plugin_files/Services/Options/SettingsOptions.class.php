<?php
/**
 * Class SettingsOptions
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

use LiveChat\Services\Options\Deprecated\DeprecatedOptions;
use LiveChat\Services\Options\Elementor\ElementorWidgetsOptions;

/**
 * Class SettingsOptions
 *
 * @package LiveChat\Services\Options
 */
class SettingsOptions extends OptionsSet {
	/**
	 * ReviewNoticeOptions instance.
	 *
	 * @var ReviewNoticeOptions
	 */
	public $review_notice;

	/**
	 * DeprecatedOptions instance.
	 *
	 * @var DeprecatedOptions
	 */
	public $deprecated;

	/**
	 * WidgetURL instance.
	 *
	 * @var WidgetURL
	 */
	public $widget_url;

	/**
	 * SettingsOptions constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'review_notice'     => ReviewNoticeOptions::get_instance(),
				'deprecated'        => DeprecatedOptions::get_instance(),
				'elementor_widgets' => ElementorWidgetsOptions::get_instance(),
				'widget_url'        => WidgetURL::get_instance(),
				'platform'          => Platform::get_instance(),
				'public_key'        => PublicKey::get_instance(),
				'synchronized'      => Synchronized::get_instance(),
			)
		);
	}
}
