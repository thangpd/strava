<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/23/21
 * Time: 11:33 PM
 */

namespace Elhelper\modules\userStravaModule\model;

use Elhelper\common\Model;
use Elhelper\inc\HeplerStrava;

class UserStravaModel extends Model {
	const STRAVA_CODE = 'strava_code';
	const STRAVA_SCOPE = 'strava_scope';
	const STRAVA_STATE = 'strava_state';
	const STRAVA_BEARER = 'strava_bearer';

	private $scope, $strava_code, $state, $user_id;

	public function __construct( $user_id ) {
		$this->user_id = $user_id;
	}

	public function getStravaCode( $user_id = null ) {
		if ( $user_id == null ) {
			return get_user_meta( $this->getModelUserId(), 'strava_code', true );
		} else {
			return get_user_meta( $user_id, 'strava_code', true );
		}
	}

	public function getModelUserId() {
		return $this->user_id;
	}

	public function getState( $user_id = null ) {
		if ( $user_id == null ) {
			return get_user_meta( $this->getModelUserId(), 'strava_state', true );
		} else {
			return get_user_meta( $user_id, 'strava_state', true );
		}
	}

	public function saveState( $value, $user_id = null ) {
		if ( $user_id == null ) {
			$user_id = $this->getModelUserId();
			write_log( 'User_id is null' . __FILE__ . __LINE__ . 'this user is' . $this->getModelUserId() );
		}
		$current_meta = get_user_meta( $user_id, self::STRAVA_STATE );
		if ( empty( $current_meta ) ) {
			add_user_meta( $user_id, self::STRAVA_STATE, $value );
		} elseif ( $current_meta != $value ) {
			update_user_meta( $user_id, self::STRAVA_STATE, $value );
		}

	}

	public function getScope( $user_id = null ) {
		if ( $user_id == null ) {
			return get_user_meta( $this->getModelUserId(), 'strava_scope', true );
		} else {
			return get_user_meta( $user_id, 'strava_scope', true );
		}

	}

	public function receiveAndSaveAccessToken( $user_id ) {
		$res = [ 'code' => 500 ];

		if ( isset( $_GET['code'] ) ) {
			$this->saveStravaCode( $_GET['code'] );
			write_log( 'Accesstoken Strava:' . $_GET['code'] );
		} else {
			write_log( 'no Accesstoken Strava ' . __FILE__ );
		}

		if ( isset( $_GET['scope'] ) ) {
			$this->saveScope( $_GET['scope'] );
			write_log( 'scope' . $_GET['scope'] );
		} else {
			write_log( 'no scope' . __FILE__ );
		}
		if ( isset( $_GET['code'] ) && isset( $_GET['scope'] ) ) {
			$code          = $_GET['code'];
			$url           = 'https://www.strava.com/api/v3/oauth/token';
			$client_id     = CLIENT_ID;
			$client_secret = CLIENT_SECRET;
			$grant_type    = 'authorization_code';
			$post          = [
				'client_id'     => $client_id,
				'client_secret' => $client_secret,
				'code'          => $code,
				'grant_type'    => $grant_type
			];

			$objectTokenExchange = HeplerStrava::callApiTokenExchange( $url, $post );
			$userBearer          = new UserStravaBearerModel( $user_id );
			$userBearer->saveObjectBearer( $objectTokenExchange );
			$userAthlete = new UserStravaAthleteModel( $user_id );
			$userAthlete->saveAthleteObject( $objectTokenExchange->athlete );


//			write_log( $objectTokenExchange );
			$res = [ 'code' => 200 ];
		} else {
			write_log( 'Missing code or scope' . __FILE__ );
		}

		return $res;

	}

	//Strava code means first time customer allow permission
	public function saveStravaCode( $value, $user_id = null ) {
		if ( $user_id == null ) {
			$user_id = $this->getModelUserId();
			write_log( 'User_id is null' . __FILE__ . __LINE__ . 'this user is' . $this->getModelUserId() );
		}
		$current_meta = get_user_meta( $user_id, self::STRAVA_CODE );

		if ( empty( $current_meta ) ) {
			add_user_meta( $user_id, self::STRAVA_CODE, $value );
			write_log( 'addUserMeta Code' . $value );
		} elseif ( $current_meta != $value ) {
			update_user_meta( $user_id, self::STRAVA_CODE, $value );
		}
	}

	public function saveScope( $value, $user_id = null ) {
		if ( $user_id == null ) {
			$user_id = $this->getModelUserId();
			write_log( 'User_id is null' . __FILE__ . __LINE__ . 'this user is' . $this->getModelUserId() );
		}
		$current_meta = get_user_meta( $user_id, self::STRAVA_SCOPE );
		if ( empty( $current_meta ) ) {
			add_user_meta( $user_id, self::STRAVA_SCOPE, $value );
		} elseif ( $current_meta != $value ) {
			update_user_meta( $user_id, self::STRAVA_SCOPE, $value );
		}
	}


}