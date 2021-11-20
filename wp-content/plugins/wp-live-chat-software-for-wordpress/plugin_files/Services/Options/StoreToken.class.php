<?php
/**
 * Class StoreToken
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class StoreToken
 *
 * @package LiveChat\Services\Options
 */
class StoreToken extends WritableOption {
	/**
	 * StoreToken constructor.
	 */
	public function __construct() {
		parent::__construct( 'store_token' );
	}
}
