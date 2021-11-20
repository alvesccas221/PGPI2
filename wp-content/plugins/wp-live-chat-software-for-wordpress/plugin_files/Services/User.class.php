<?php
/**
 * Class User
 *
 * @package LiveChat\Services
 */

namespace LiveChat\Services;

use LiveChat\Services\Options\UserAuthOptions;
use WP_User;

/**
 * Class User
 *
 * @package LiveChat\Services
 */
class User {
	/**
	 * Instance of User class (singleton pattern)
	 *
	 * @var User|null
	 */
	private static $instance = null;

	/**
	 * Instance of UserAuthOptions.
	 *
	 * @var UserAuthOptions
	 */
	private $options;

	/**
	 * Currently logged in user data
	 *
	 * @var WP_User
	 */
	private $current_user;

	/**
	 * User constructor.
	 *
	 * @param UserAuthOptions $options UserAuthOptions instance.
	 */
	public function __construct( $options ) {
		$this->options      = $options;
		$this->current_user = wp_get_current_user();
	}

	/**
	 * Checks if visitor is logged in
	 *
	 * @return boolean
	 */
	public function check_logged() {
		if ( property_exists( $this->current_user->data, 'ID' ) && ! empty( $this->current_user->data->ID ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Get visitor's name and email
	 *
	 * @return array
	 */
	public function get_user_data() {
		$user = array(
			'id'    => '',
			'name'  => '',
			'email' => '',
		);

		if ( ! $this->check_logged() ) {
			return $user;
		}

		$user['id'] = $this->current_user->ID;

		if ( ! empty( $this->current_user->user_email ) ) {
			$user['email'] = $this->current_user->user_email;
		}

		if ( ! empty( $this->current_user->user_firstname ) || ! empty( $this->current_user->user_lastname ) ) {
			$user['name'] = implode(
				' ',
				array_filter(
					array(
						$this->current_user->user_firstname,
						$this->current_user->user_lastname,
					)
				)
			);
		} else {
			$user['name'] = $this->current_user->user_login;
		}

		return $user;
	}

	/**
	 * Return array of users authorized in LiveChat
	 *
	 * @return array
	 */
	private function get_authorized_users() {
		$authorized_users = $this->options->authorized_users->get();
		return empty( $authorized_users )
			? array()
			: array_values(
				array_filter( $authorized_users )
			);
	}

	/**
	 * Stores user token in WP database
	 *
	 * @param int    $user_id User's id.
	 * @param string $token User authorization token.
	 *
	 * @return bool
	 */
	private function set_user_token( $user_id, $token ) {
		return $this->options->user_token->set( $user_id, $token );
	}

	/**
	 * Removes current user tokens from WP database
	 */
	public function remove_current_user_token() {
		return $this->options->user_token->remove( $this->current_user->ID );
	}

	/**
	 * Removes all users tokens from WP database
	 */
	public function remove_authorized_users() {
		$authorized_users = $this->get_authorized_users();

		if ( empty( $authorized_users ) ) {
			return false;
		}

		$was_successful = true;

		foreach ( $authorized_users as $user_id ) {
			$was_successful &= $this->options->user_token->remove( $user_id );
		}

		return $this->options->authorized_users->remove() && $was_successful;
	}

	/**
	 * Stores user token in WP database and adds user to list of users
	 * authorized in LiveChat.
	 *
	 * @param string $user_token User authorization token.
	 *
	 * @return bool
	 */
	public function authorize_current_user( $user_token ) {
		$authorized_users = $this->get_authorized_users();
		$user_id          = $this->current_user->ID;

		if ( false === array_search( (string) $user_id, $authorized_users, true ) ) {
			$authorized_users[] = $user_id;
			return $this->options->user_token->set( $user_id, $user_token ) &&
					$this->options->authorized_users->set( $authorized_users );
		}

		return $this->options->user_token->set( $user_id, $user_token );
	}

	/**
	 * Returns token of current user
	 *
	 * @return mixed|string|void
	 */
	public function get_current_user_token() {
		$user_token = $this->options->user_token->get( $this->current_user->ID );
		if ( ! $user_token ) {
			return '';
		}
		return $user_token;
	}

	/**
	 * Returns new instance of User class
	 *
	 * @return User
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static( UserAuthOptions::get_instance() );
		}

		return static::$instance;
	}
}
