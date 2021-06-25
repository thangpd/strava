<?php
/**
 * Created by PhpStorm.
 * User: 
 * Date: 
 * Time: 
 */

namespace Elhelper\model;

use Elhelper\common\Model;
use Strava\Builder\MessageBuilder;
use Strava\Exceptions\StravaSDKException;
use Strava\Strava;
use Strava\StravaEndPoint;
use Strava\FileUpload\StravaFile;
use Elhelper\inc\HeplerStrava;

class TechvsiChatBotModel extends Model {

	private $CHAT_BOT_SETTING = 'chat_box_setting';

	public function __construct() {
		if($this->getSetting() === false) {
			set_transient($this->CHAT_BOT_SETTING, []);
		}
	}

	public function getSetting() {
		$data = get_transient($this->CHAT_BOT_SETTING);

		if ( $data ) {
			return $data;
		}
		else {
			return false;
		}
	}

	public function updateSetting( $data ) {
		$res = false;

		if ( empty( $data ) ) {
			return $res;
		}

		delete_transient($this->CHAT_BOT_SETTING);
		$updated = set_transient($this->CHAT_BOT_SETTING, $data);

		if ( $updated ) {
			$res = true;
		}
		else {
			$res = [ 'message' => 'Can\'t updpate JSON', 'code' => 200 ];
		}

		return $res;
	}

}