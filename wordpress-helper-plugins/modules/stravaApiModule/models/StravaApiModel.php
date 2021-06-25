<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 3/15/21
 * Time: 4:07 PM
 */

namespace Elhelper\modules\stravaApiModule\models;


use Elhelper\common\Model;

class StravaApiModel extends Model {
	const EL_API_CAT_RULE = 'el_strava_api';
	const EL_STRAVA_SLUG = 'strava_api_url';
	const EL_STRAVA_CONST = 'el_strava_const';
	const EL_STRAVA_APP_ID = self::EL_STRAVA_CONST . '_app_id';
	const EL_STRAVA_CALLBACK_URL = self::EL_STRAVA_CONST . '_callback';
	const EL_STRAVA_WEBHOOK_URL = self::EL_STRAVA_CONST . '_webhook';
	const EL_STRAVA_OATH_WEBHOOK = self::EL_STRAVA_CONST . '_oa_webhook';
	const EL_STRAVA_OAID = self::EL_STRAVA_CONST . '_oaid';
	const EL_STRAVA_ACCESS_TOKEN = self::EL_STRAVA_CONST . '_accesstoken';


	private $appID;


	public function __construct() {
		$this->appID = get_option( self::EL_STRAVA_APP_ID );
	}


	public function getAppID() {

		return $this->appID;
	}

	public function setAppID( $appID ) {
		$this->appID = $appID;
		update_option( self::EL_STRAVA_APP_ID, $this->appID );
	}


}