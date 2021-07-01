<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/24/21
 * Time: 11:27 PM
 */

namespace Elhelper\modules\userStravaModule\model;


use Elhelper\modules\stravaApiModule\db\HistoryChallengeAthleteDb;
use Elhelper\modules\userStravaModule\db\ActivityDb;

class UserStravaAthleteModel {

	const ATHLETE_STRAVA = 'athlete_strava';
	const ATHLETE_ID = 'athlete_id';
	//this is total distance only for this site
	const ATHLETE_TOTAL_DISTANCE = 'athlete_total_distance';
	const ATHLETE_DISTANCE_OF_PRODUCT = 'athlete_distance_of_product';
	private $user_id;

	public function __construct( $user_id ) {
		if ( empty( $user_id ) ) {
			throw( new \Exception( "No user id||" . __FILE__ . __LINE__ ) );
		} else {
			$this->setUserId( $user_id );
		}
	}

	public static function getUserIdByAthlete( $athlete_id ) {
		$users = null;
		if ( ! empty( $athlete_id ) ) {
			$users = get_users( array(
				'meta_key'   => self::ATHLETE_ID,
				'meta_value' => $athlete_id
			) );
			$users = array_shift( $users );
		} else {
			write_log( 'cant get user id by athlete' );
		}

		return $users;
	}

	public static function getDistanceAlreadyOfProduct( $challenge_id ) {
		global $wpdb;


		$sql           = 'SELECT round(sum(a.distance),2) as distance FROM  %1$s WHERE %2$s';
		$history_table = HistoryChallengeAthleteDb::get_table() . ' as h, ' . ActivityDb::get_table() . ' as a ';
		$where         = ' a.activity_id = h.activity_id and h.challenge_id=' . $challenge_id . ' ';
		$sql           = $wpdb->prepare( $sql, $history_table, $where );

		$results = $wpdb->get_results( $sql );

		if ( ! empty( $results ) ) {
			$results = array_shift( $results );
		} else {
			$results = [];
		}

		return $results;
	}

	public function saveAthleteObject( $object ) {
		if ( ! empty( $object ) ) {
			update_user_meta( $this->getUserId(), self::ATHLETE_STRAVA, $object );
			update_user_meta( $this->getUserId(), self::ATHLETE_ID, $object->id );
		} else {
			write_log( 'empty object' . __FILE__ . __LINE__ );
		}
	}

	public function getUserId() {
		return $this->user_id;
	}

	public function setUserId( $user_id ) {
		$this->user_id = $user_id;
	}

	public function getAthleteTotalDistance() {
		return get_user_meta( $this->user_id, self::ATHLETE_TOTAL_DISTANCE, true );
	}

	public function addAthleteTotalDistance( $meters ) {
		$currentDistance = get_user_meta( $this->user_id, self::ATHLETE_TOTAL_DISTANCE, true );
		$total           = (float) $currentDistance + (float) $meters;
		update_user_meta( $this->user_id, self::ATHLETE_TOTAL_DISTANCE, $total );
	}

	public function getAthleteObject() {
		return get_user_meta( $this->getUserId(), self::ATHLETE_STRAVA, true );
	}

	public function addDistanceOfUserOfProduct( $product_id, $meters ) {
		$array              = get_user_meta( $this->user_id, self::ATHLETE_DISTANCE_OF_PRODUCT );
		$currentListProduct = array_shift( $array );
		if ( ! empty( $currentListProduct ) ) {
			$total                             = (float) $currentListProduct[ $product_id ] + (float) $meters;
			$currentListProduct[ $product_id ] = $total;
			update_user_meta( $this->user_id, self::ATHLETE_DISTANCE_OF_PRODUCT, $currentListProduct );
		} else {
			add_user_meta( $this->user_id, self::ATHLETE_DISTANCE_OF_PRODUCT, [ $product_id => $meters ] );
		}
	}


}