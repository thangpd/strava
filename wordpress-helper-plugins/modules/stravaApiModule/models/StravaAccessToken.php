<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 3/15/21
 * Time: 4:01 PM
 */

namespace Elhelper\modules\stravaApiModule\models;

class StravaAccessToken extends StravaApiModel {

	const EL_STRAVA_CALLBACK_URL_VAL = 'access-token';


	private $strava_access_token;
	private $strava_oaID;

	public function __construct() {
		parent::__construct();

	}

	public static function getCallBackUrlVal() {
		if ( EL_HELPER_DEBUG == 'DEV' ) {
			return '/' . self::EL_API_CAT_RULE . DIRECTORY_SEPARATOR . self::EL_STRAVA_CALLBACK_URL_VAL;
		} else {
			return home_url() . '/' . self::EL_API_CAT_RULE . DIRECTORY_SEPARATOR . self::EL_STRAVA_CALLBACK_URL_VAL;
		}
	}


	public function getStravaOaID() {
		$this->strava_oaID = get_option( self::EL_STRAVA_OAID );

		return $this->strava_oaID;
	}

	public function setStravaOaID( $oaID ) {
		$this->strava_oaID = $oaID;
	}

	public function getStravaAccessToken() {
		$this->strava_access_token = get_option( self::EL_STRAVA_ACCESS_TOKEN );

		return $this->strava_access_token;
	}

	public function setStravaAccessToken( $access_token ) {
		$this->strava_access_token = $access_token;
	}


}