<?php
/**
 * Class AuthorizedUsers
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class AuthorizedUsers
 *
 * @package LiveChat\Services\Options
 */
class AuthorizedUsers extends WritableOption {
	/**
	 * AuthorizedUsers constructor.
	 *
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct( 'authorized_users' );
	}

	/**
	 * Gets authorized user IDs.
	 *
	 * @return string[]|null
	 */
	public function get() {
		$stringified = parent::get();

		if ( ! $stringified ) {
			return null;
		}

		return explode( ',', $stringified );
	}

	/**
	 * Sets authorized user IDs.
	 *
	 * @param string[] $authorized_users Array of authorized user IDs.
	 *
	 * @return bool
	 */
	public function set( $authorized_users ) {
		return parent::set( implode( ',', $authorized_users ) );
	}
}
