<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/24/21
 * Time: 11:27 PM
 */

namespace Elhelper\modules\userStravaModule\model;


class UserStravaAthleteModel {

	const ATHLETE_STRAVA = 'athlete_strava';
	const ATHLETE_ID = 'athlete_id';
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

	public function getAthleteObject() {
		return get_user_meta( $this->getUserId(), self::ATHLETE_STRAVA, true );
	}

}