<?php
/**
 * Class ConnectTokenFactory
 *
 * @package LiveChat\Services\Factories
 */

namespace LiveChat\Services\Factories;

use LiveChat\Services\ConnectToken;

/**
 * Class ConnectTokenFactory
 *
 * @package LiveChat\Services\Factories
 */
class ConnectTokenFactory {
	/**
	 * Returns new instance of ConnectToken.
	 *
	 * @return ConnectToken
	 */
	public function create() {
		return new ConnectToken();
	}

	/**
	 * Returns new instance of ConnectTokenFactory.
	 *
	 * @return static
	 */
	public static function get_instance() {
		return new static();
	}
}
