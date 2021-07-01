<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 4/29/21
 * Time: 9:19 AM
 */

namespace Elhelper\modules\productStravaModule\db;

use Elhelper\inc\DB;

class ChallengeDb extends DB {

	static $primary_key = 'inspire_challenge';

	public function __construct() {
	}

	public static function getAllChallenge() {
		global $wpdb;
		$sql = sprintf( 'SELECT * FROM %s', self::get_table() );

		return $wpdb->get_results( $sql );
	}

	public static function getAllChallengeOfUser( $user_id ) {
		global $wpdb;
		$sql = sprintf( 'SELECT * FROM %s WHERE %s', self::get_table(), 'user_id=' . $user_id );

		return $wpdb->get_results( $sql );
	}


	/**
	 * Singletons should not be restorable from strings.
	 */
	public function __wakeup() {
		throw new \Exception( "Cannot unserialize a singleton." );
	}

	/**
	 * Singletons should not be cloneable.
	 */
	protected function __clone() {
	}


}