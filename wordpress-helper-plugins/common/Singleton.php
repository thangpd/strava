<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 1/25/21
 * Time: 1:47 PM
 */

namespace Elhelper\common;


abstract class Singleton {

	protected static $_instance;

	private function __construct() {
		$this->__init();
	}

	/**
	 * Init function is used for WP hook instead of construct
	 */
	public function __init() {

	}

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Controller An instance of the class.
	 */
	public static function instance() {
		if ( is_null( static::$_instance ) ) {
			static::$_instance = new static();
		}

		return static::$_instance;

	}

}