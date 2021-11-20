<?php
/**
 * Class PublicKey
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class PublicKey
 *
 * @package LiveChat\Services\Options
 */
class PublicKey extends WritableOption {
	/**
	 * PublicKey constructor.
	 */
	public function __construct() {
		parent::__construct( 'public_key' );
	}
}
