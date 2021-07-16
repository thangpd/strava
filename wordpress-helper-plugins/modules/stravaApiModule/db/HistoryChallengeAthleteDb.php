<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 4/29/21
 * Time: 9:19 AM
 */

namespace Elhelper\modules\stravaApiModule\db;

use Elhelper\inc\DB;

class HistoryChallengeAthleteDb extends DB {

	static $primary_key = 'inspire_athlete';

	public function __construct() {
	}

	public static function getActivityByIdChallenge( $challenge_id, $activity ) {
		global $wpdb;
		$select = '*';
		$table  = self::get_table();
		$where  = 'challenge_id=' . $challenge_id . ' and activity_id=' . $activity;
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