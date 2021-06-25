<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 1/25/21
 * Time: 11:12 AM
 */

namespace Elhelper\modules\stravaApiModule;

use Elhelper\admin\modules\pages\stravaApiSettingPages\StravaApiSettingPage;
use Elhelper\common\Controller;
use Elhelper\common\SingleController;
use Elhelper\Elhelper_Plugin;
use Elhelper\modules\stravaApiModule\Controllers\StravaApiWebhookHandle;
use Elhelper\modules\stravaApiModule\models\StravaAccessToken;
use Elhelper\modules\stravaApiModule\models\StravaApiModel;
use Elhelper\modules\stravaApiModule\models\StravaWebHookModel;

/**Template include template test
 * How to use:
 *      + check if == post_name
 *      + Include template
 */
class StravaApiController extends SingleController {
	//Override $_instance. If not. It'll have the last object instance is initialized before this class.
	protected static $_instance;

	public function __init() {
//		add_filter( 'template_include', [ $this, 'leefee_template_include' ] );
		$this->view_path = plugin_dir_path( __FILE__ );
		add_action( 'wp_enqueue_scripts', [ $this, 'add_enqueue_scripts' ] );

	}


	//can't separate enqueue specifically
	public function add_enqueue_scripts() {

		//general css both frontend and backend. TODO:: Find the way to separate it into right place.
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'stravaapiModel' );
	}


	function templateInclude( $template ) {
		//we can't use query arg because can't coverage multiple dimension like : test/test/test
		//add_query_arg( [] ) return request uri when empty array is pass as parameter.
		//if ( str_replace( '/', '', add_query_arg( [] ) ) == 'test' ) {
		//domain.tm/strava_api_url/receive-webhook
		if ( get_query_var( StravaApiModel::EL_STRAVA_SLUG ) == StravaWebHookModel::EL_STRAVA_WEBHOOK_URL_VAL ) {
			write_log( 'Error verify Webhook Strava' );

			//method POST
			/*set_transient( 'receive_webhook_header', json_encode( getallheaders() ) );
			set_transient( 'receive_webhook_body', json_encode( file_get_contents( 'php://input' ) ) );*/
			$controllerHandle = StravaApiWebhookHandle::instance();
			if ( $controllerHandle->verifyWebhookStrava() ) {

			} else {
				write_log( 'Error verify Webhook Strava' );
			}

			$template = $this->render( 'index.php' );
		}
		//domain.tm/strava_api_url/access-token
		if ( get_query_var( StravaApiModel::EL_STRAVA_SLUG ) == StravaAccessToken::EL_STRAVA_CALLBACK_URL_VAL ) {

//			$plugin_dir_path = plugin_dir_path( __FILE__ ) . 'views/index.php';
//			$template        = $plugin_dir_path;
			//method POST

			if ( StravaApiWebhookHandle::instance()->verifyAccessTokenStrava() ) {
				$stravaAccessToken = new StravaAccessToken();
				if ( isset( $_GET['access_token'] ) ) {
					$stravaAccessToken->setStravaAccessToken( $_GET['access_token'] );
				} else {
					write_log( 'no token ' . __FILE__ );
				}

				if ( isset( $_GET['oaId'] ) ) {
					$stravaAccessToken->setStravaOaID( $_GET['oaId'] );
				} else {
					write_log( 'no oaID' . __FILE__ );
				}
				$template = $this->render( 'access-token.php' );
			}


		}

		if ( get_query_var( StravaApiModel::EL_STRAVA_SLUG ) == 'sendgrid-test' ) {

//			$plugin_dir_path = plugin_dir_path( __FILE__ ) . 'views/index.php';
//			$template        = $plugin_dir_path;
			//method POST
			$template = $this->render( 'sendgrid.php' );

		}


		return $template;
	}


}