<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 3/1/21
 * Time: 10:34 AM
 */

namespace Elhelper\admin\modules\pages\stravaApiSettingPages\stravaChat;

use Elhelper\common\Controller;
use Elhelper\common\View;
use Elhelper\Elhelper_Plugin;

class StravaChat extends Controller {

	private $strava;

	public function __construct() {
		$this->strava = new \Elhelper\model\TechvsiStravaModel();

		add_action( 'elhelper_add_submenu', [ $this, 'register_strava_setting_page' ] );
		add_action( 'wp_ajax_get_history_message_of_subscriber', [ $this, 'get_history_message_of_subscriber' ] );
		add_action( 'wp_ajax_get_list_subscribers', [ $this, 'get_list_subscribers' ] );
		add_action( 'wp_ajax_send_strava_message', [ $this, 'send_strava_message' ] );
	}

	function register_strava_setting_page() {
		add_submenu_page(
			'strava-api-setting',
			'Strava Chat',
			'Strava Chat',
			'manage_options',
			'strava-chat',
			[ $this, 'mt_settings_page' ],
			10
		);
	}


	public function mt_settings_page() {
		$assets = Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'stravaChat', [
			'css_dep' => [
//				'font-awesome-all',
//				'font-awesome',
//				'fontawesome-pro-5',
			],
		] );

		$view = new View( $this );

		echo $view->render( 'strava-chat.php', [
			'hidden_field_name' => 'test',
		] );
	}

	public function send_strava_message() {
		if ( isset( $_POST['message'] ) && isset( $_POST['user_id'] ) ) {
			$user_id   = $_POST['user_id'];
			$message   = $_POST['message'];
			$list_mess = $this->strava->sendMessageToListRecipient( $user_id, $message );
			wp_die( json_encode( $list_mess ) );
		}
	}

	public function get_history_message_of_subscriber() {
		if ( isset( $_GET['user_id'] ) ) {
			$list_mess = $this->strava->getRecentWithSubMessage( $_GET['user_id'] );
			wp_die( json_encode( $list_mess ) );
		}

	}

	public function get_list_subscribers() {
		$list_subscribers = $this->strava->getListSubscribers();
		$data             = [];
		if ( ! empty( $list_subscribers ) && isset( $list_subscribers['data'] ) ) {

			if ( $list_subscribers['data']['total'] > 0 ) {

				foreach ( $list_subscribers['data']['followers'] as $value ) {
					if ( isset( $value['user_id'] ) ) {
						$data[ $value['user_id'] ] = $this->strava->getInfoUser( $value['user_id'] );
					}
				}
			}
		} else {

		}
		$code = 200;

		echo json_encode( [ 'data' => $data, 'code' => $code ] );
		wp_die();
	}


}