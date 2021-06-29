<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 3/15/21
 * Time: 4:00 PM
 */

namespace Elhelper\modules\stravaApiModule\models;

class StravaWebHookModel extends StravaApiModel {


	const EL_STRAVA_WEBHOOK_URL_VAL = 'receive-webhook';

	private $webhookAuth;

	public function __construct() {
		parent::__construct();
		$this->webhookAuth = get_option( self::EL_STRAVA_OATH_WEBHOOK );
	}


	public static function getReceiveWebhookUrl() {
		if ( EL_HELPER_DEBUG == 'DEV' ) {
			return DIRECTORY_SEPARATOR . self::EL_API_CAT_RULE . DIRECTORY_SEPARATOR . self::EL_STRAVA_WEBHOOK_URL_VAL;
		} else {
			return home_url() . DIRECTORY_SEPARATOR . self::EL_API_CAT_RULE . DIRECTORY_SEPARATOR . self::EL_STRAVA_WEBHOOK_URL_VAL;

		}
	}

	public function getOauthWebhook() {
		return $this->webhookAuth;
	}

	public function setOauthWebhook( $webhook ) {
		$this->webhookAuth = $webhook;
		update_option( self::EL_STRAVA_OATH_WEBHOOK, $this->webhookAuth );
	}
}