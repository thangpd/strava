<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 3/1/21
 * Time: 10:34 AM
 */

namespace Elhelper\admin\modules\pages\stravaApiSettingPages\stravaChatBotManager;

use Elhelper\common\Controller;
use Elhelper\common\View;
use Elhelper\Elhelper_Plugin;

class StravaChatBotManager extends Controller {

	private $webhook;

	public function __construct() {
		$this->webhook = new \Elhelper\model\TechvsiChatBotModel();

		add_action( 'elhelper_add_submenu', [ $this, 'register_strava_setting_page' ], 10 );
		add_action( 'wp_ajax_get_setting_webhook', [ $this, 'get_setting_webhook' ] );
		add_action( 'wp_ajax_update_setting_webhook', [ $this, 'update_setting_webhook' ] );
	}

	function register_strava_setting_page() {
		add_submenu_page(
			'strava-api-setting',
			'Strava Chat Bot Manager',
			'Strava Chat Bot Manager',
			'manage_options',
			'strava-chat-bot-manager',
			[ $this, 'strava_chat_bot_page' ],
			10
		);
	}


	public function strava_chat_bot_page() {
		$assets = Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'stravaChatBotManager', [
			// 'js' => true,
			// 'js_dep' => [
			// 	'bootstrap-js',
			// 	'slimselect-js'
			// ],
			'css_dep' => [
				'slimselect',
				'fontawesome-pro-5',
				'bootstrap'
			]
		] );

		$view = new View( $this );

		echo $view->render( 'index.php', [
			'hidden_field_name' => 'test',
		] );
	}

	public function get_setting_webhook() {
		$res = [ 'message' => 'Not found event', 'code' => 200 ];
		$setting = $this->webhook->getSetting();
		
		if($setting) {
			$res = [ 
				'data' => $setting,
				'length' => is_array($setting) ? count($setting) : 0,
				'message' => 'Success', 
				'code' => 200
			];
		}

		wp_die( json_encode( $res ) );
	}

	public function update_setting_webhook() {
		if( isset($_POST['setting']) ) {
			$res = $this->webhook->updateSetting($_POST['setting']);
			wp_die( json_encode( $res ) );
		}
	}


}