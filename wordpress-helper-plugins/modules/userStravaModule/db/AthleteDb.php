<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 4/29/21
 * Time: 9:19 AM
 */

namespace Elhelper\modules\userStravaModule\db;

use Elhelper\inc\DB;

class AthleteDb extends DB {

	static $primary_key = 'inspire_athlete';

	public function __construct() {
	}

	public static function get_history() {
		global $wpdb;

		return $wpdb->get_results( self::_fetch_history_sql() );
	}


	public function get_duration_ad( $from, $to, $type_ads, $ads_id = '' ) {
		global $wpdb;
		$sql = 'SELECT ads_id, sum(case when device_type = 1 then 1 else 0 end) as desktop,sum(case when device_type = 0 then 1 else 0 end) as mobile, count(ip_impressed) AS view,%%s as date FROM ' . self::get_table() . ' WHERE( ( created_at ) BETWEEN %%s AND %%s) and type_ads =%%s %s GROUP BY ads_id ';
		if ( ! empty( $ads_id ) ) {
			$sql = sprintf( $sql, ' and ads_id = ' . $ads_id );
		} else {
			$sql = sprintf( $sql, '' );
		}
		$prepare = $wpdb->prepare( $sql, $from, $from, $to, $type_ads );

		$results = $wpdb->get_results( $prepare );
		if ( empty( $results ) ) {
			$results[] = (object) array(
				'ads_id' => $ads_id,
				'date'   => $from,
			);
		}

		return $results;
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