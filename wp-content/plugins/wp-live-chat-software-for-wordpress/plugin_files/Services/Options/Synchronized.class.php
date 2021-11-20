<?php
/**
 * Class OptionsSynchronized
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class OptionsSynchronized
 *
 * @package LiveChat\Services\Options
 */
class Synchronized extends WritableOption {
	/**
	 * Class OptionsSynchronized
	 *
	 * @package LiveChat\Services\Options
	 */
	public function __construct() {
		parent::__construct( 'synchronized', false );
	}

	/**
	 * Returns value of option.
	 *
	 * @return bool
	 */
	public function get() {
		return (bool) parent::get();
	}

	/**
	 * Sets option as true.
	 *
	 * @return bool
	 */
	public function yes() {
		return parent::set( true );
	}
}

