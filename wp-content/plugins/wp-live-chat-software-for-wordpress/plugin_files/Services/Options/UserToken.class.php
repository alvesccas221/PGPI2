<?php
/**
 * Class UserToken
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class UserToken
 *
 * @package LiveChat\Services\Options
 */
class UserToken extends UserOption {
	/**
	 * UserToken constructor.
	 */
	public function __construct() {
		parent::__construct( 'user_%s_token' );
	}
}
