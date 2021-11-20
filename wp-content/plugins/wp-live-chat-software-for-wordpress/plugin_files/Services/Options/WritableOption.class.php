<?php
/**
 * Class WritableOption
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class WritableOption
 *
 * @package LiveChat\Services\Options
 */
class WritableOption extends ReadableOption {
	/**
	 * Sets value for an option.
	 *
	 * @param mixed $value Option value.
	 *
	 * @return bool
	 */
	public function set( $value ) {
		return update_option( $this->key, $value );
	}
}
