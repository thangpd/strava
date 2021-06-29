<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/24/21
 * Time: 6:05 PM
 */

namespace Elhelper\modules\userStravaModule\model;


use Elhelper\common\Model;
use Elhelper\inc\HeplerStrava;

class UserStravaBearerModel extends Model {
	const TOKEN_TYPE = 'token_type';
	const EXPIRES_AT = 'expires_at';
	const EXPIRES_IN = 'expires_in';
	const REFRESH_TOKEN = 'refresh_token';
	const ACCESS_TOKEN = 'access_token';
	const ALL_META = [ self::TOKEN_TYPE, self::EXPIRES_IN, self::EXPIRES_AT, self::REFRESH_TOKEN, self::ACCESS_TOKEN ];
	private $user_id, $token_type, $expires_at, $expires_in, $refresh_token, $access_token;

	public function __construct( $user_id ) {
		if ( empty( $user_id ) ) {
			throw( new \Exception( "No user id||" . __FILE__ . __LINE__ ) );
		} else {
			$this->setUserId( $user_id );
		}
	}

	public function deleteBearerUser() {
		foreach ( self::ALL_META as $val ) {
			delete_user_meta( $this->getUserId(), $val );
		}
	}

	public function getUserId() {
		return $this->user_id;
	}

	public function setUserId( $user_id ) {
		$this->user_id = $user_id;
	}

	public function saveObjectBearer( $object ) {

		if ( ! empty( $object ) && ! isset( $object->errors ) ) {
			$this->setAccessToken( $object->access_token );
			$this->setExpiresAt( $object->expires_at );
			$this->setExpiresIn( $object->expires_in );
			$this->setRefreshToken( $object->refresh_token );
			$this->setToken_type( $object->token_type );
		} else {
			write_log( 'Empty Bearer Object' . __FILE__ . __LINE__ );
		}
	}

	public function setAccessToken( $value ) {
		if ( ! empty( $value ) ) {
			update_user_meta( $this->getUserId(), self::ACCESS_TOKEN, $value );
		} else {
			write_log( 'empty access token' . __FILE__ . __LINE__ );
		}
	}

	public function setExpiresAt( $value ) {
		if ( ! empty( $value ) ) {
			update_user_meta( $this->getUserId(), self::EXPIRES_AT, $value );
		} else {
			write_log( 'empty expires at' . __FILE__ . __LINE__ );
		}
	}

	public function setExpiresIn( $value ) {
		if ( ! empty( $value ) ) {
			update_user_meta( $this->getUserId(), self::EXPIRES_IN, $value );
		} else {
			write_log( 'empty expires in' . __FILE__ . __LINE__ );
		}
	}

	public function setRefreshToken( $value ) {
		if ( ! empty( $value ) ) {
			update_user_meta( $this->getUserId(), self::REFRESH_TOKEN, $value );
		} else {
			write_log( 'empty refresh token' . __FILE__ . __LINE__ );
		}
	}

	public function setToken_type( $value ) {
		if ( ! empty( $value ) ) {
			update_user_meta( $this->getUserId(), self::TOKEN_TYPE, $value );
		} else {
			write_log( 'empty Token Type' . __FILE__ . __LINE__ );
		}
	}

	public function getAllInfo() {
		return array(
			'access_token'  => $this->getAccessToken(),
			'refresh_token' => $this->getRefreshToken(),
			'token_type'    => $this->getToken_type(),
			'expires_at'    => $this->getExpiresAt(),
			'expires_in'    => $this->getExpiresIn(),
		);
	}

	public function getAccessToken() {
		HeplerStrava::refreshToken( $this->user_id );

		return get_user_meta( $this->getUserId(), self::ACCESS_TOKEN, true );
	}

	public function getRefreshToken() {
		return get_user_meta( $this->getUserId(), self::REFRESH_TOKEN, true );

	}

	public function getToken_type() {
		return get_user_meta( $this->getUserId(), self::TOKEN_TYPE, true );
	}

	public function getExpiresAt() {
		return get_user_meta( $this->getUserId(), self::EXPIRES_AT, true );
	}

	public function getExpiresIn() {
		return get_user_meta( $this->getUserId(), self::EXPIRES_IN, true );
	}

	public function issetBearer() {
		if ( ! empty( $this->getAccessToken() ) ) {
			return true;
		} else {
			return false;
		}
	}


}