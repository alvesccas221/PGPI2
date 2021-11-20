<?php

namespace LiveChat\Services\Options;

use Exception;

class Option {
	/**
	 * Option storage key prefix.
	 *
	 * @var string
	 */
	public $prefix;

	/**
	 * Option storage key name.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Option storage name with prefix.
	 *
	 * @var string
	 */
	public $key;

	/**
	 * Fallback value.
	 *
	 * @var mixed
	 */
	public $fallback;

	/**
	 * ReadableOption constructor.
	 *
	 * @param string $name     Option storage key name.
	 * @param mixed  $fallback Fallback value.
	 * @param string $prefix   Option storage key prefix.
	 *
	 * @throws Exception Can be thrown when $key is not provided.
	 */
	public function __construct( $name, $fallback = null, $prefix = WPLC_OPTION_PREFIX ) {
		if ( empty( $name ) ) {
			throw new Exception( 'Option cannot be declared without a storage key.' );
		}

		$this->prefix   = $prefix;
		$this->name     = $name;
		$this->fallback = $fallback;
		$this->key      = $this->prefix . $this->name;
	}

	/**
	 * Returns fallback for option and performs legacy WooCommerce key migration if necessary.
	 *
	 * @param mixed $id User ID.
	 * @return mixed
	 */
	public function get_option_fallback( $id ) {
		return $this->fallback;
	}

	/**
	 * Returns instance of ReadableOption (singleton pattern).
	 *
	 * @return static
	 * @throws Exception Can be thrown from ReadableOption constructor.
	 */
	public static function get_instance() {
		return new static();
	}
}
