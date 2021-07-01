<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 4/29/21
 * Time: 9:19 AM
 */

namespace Elhelper\modules\productStravaModule\db;

use Elhelper\inc\DB;
use Elhelper\modules\stravaApiModule\db\HistoryChallengeAthleteDb;
use Elhelper\modules\userStravaModule\db\ActivityDb;

class ChallengeDb extends DB {

	static $primary_key = 'inspire_challenge';

	public function __construct() {
	}

	public static function getAllChallenge() {
		global $wpdb;
		$sql = sprintf( 'SELECT * FROM %s', self::get_table() );

		return $wpdb->get_results( $sql );
	}

	/**
	 * @param $product_id
	 * @param $status 0,1,2
	 */
	public static function getAllChallengeByProduct( $product_id, $status = 0 ) {
		global $wpdb;
		$sql = sprintf( 'SELECT * FROM %s WHERE %s', self::get_table(), 'product_id=' . $product_id . ' and status=' . $status );

		return $wpdb->get_results( $sql );
	}

	public static function getAllChallengeOfUser( $user_id ) {
		global $wpdb;
		$sql = sprintf( 'SELECT * FROM %s WHERE %s', self::get_table(), 'user_id=' . $user_id );

		return $wpdb->get_results( $sql );
	}


	public static function getPaceOfChallengeById( $challenge_id ) {
		global $wpdb;
		$select = 'DISTINCT h.activity_id, a.distance, a.moving_time';
		$table  = HistoryChallengeAthleteDb::get_table() . ' as h,' . ActivityDb::get_table() . ' as a';
		$where  = 'h.challenge_id=' . $challenge_id . ' and a.activity_id = h.activity_id';
		$sql    = sprintf( 'SELECT %s FROM %s WHERE %s', $select, $table, $where );

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