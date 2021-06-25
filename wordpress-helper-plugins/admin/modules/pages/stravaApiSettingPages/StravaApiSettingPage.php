<?php
/**
 * Date: 2/24/21
 * Time: 5:37 PM
 */

namespace Elhelper\admin\modules\pages\stravaApiSettingPages;

use Elhelper\common\Controller;
use Elhelper\common\View;
use Elhelper\Elhelper_Plugin;
use Elhelper\model\TechvsiStravaModel;
use Elhelper\modules\stravaApiModule\Controllers\StravaApiWebhookHandle;
use Elhelper\modules\stravaApiModule\models\StravaAccessToken;
use Elhelper\modules\stravaApiModule\models\StravaApiModel;
use Elhelper\modules\stravaApiModule\models\StravaWebHookModel;

class StravaApiSettingPage extends Controller {


	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_strava_setting_page' ] );

	}

	public function enqueue_scripts_general() {
		$assets      = Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'stravaApiSettingPage' );
		$entry_point = array_pop( $assets['js'] );
		wp_localize_script( $entry_point['handle'], StravaApiModel::EL_STRAVA_CONST, [
			'field_names' => [
				'opt_appid'       => StravaApiModel::EL_STRAVA_APP_ID,
				'opt_accesstoken' => StravaAccessToken::EL_STRAVA_ACCESS_TOKEN,
				'opt_callback'    => StravaAccessToken::getCallBackUrlVal(),
			],
			'siteurl'     => site_url(),
		] );
	}

	function register_strava_setting_page() {
		$page_title = 'Strava Api Settings';
		$menu_title = 'Strava Api Settings';
		$capability = 'manage_options';
		$menu_slug  = 'strava-api-setting';
		$function   = [ $this, 'strava_api_setting_page' ];
		$icon_url   = 'dashicons-media-code';
		$position   = 70;
		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		do_action( 'elhelper_add_submenu' );
	}


	function strava_api_setting_page() {
		$stravaAccessToken = new StravaAccessToken();
		$webhookStrava     = new StravaWebHookModel();
		//must check that the user has the required capability
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		// variables for the field and option names
		$hidden_field_name = StravaApiModel::EL_STRAVA_CONST . 'mt_submit_hidden';
		// See if the user has posted us some information
		// If they did, this hidden field will be set to 'multiform'
		if ( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'multiform' ) {
			// Read their posted value
			$opt_appid_val        = $_POST[ StravaApiModel::EL_STRAVA_APP_ID ];
			$opt_oath_webhook_val = $_POST[ StravaWebHookModel::EL_STRAVA_OATH_WEBHOOK ];
			$opt_accesstoken_val  = $_POST[ StravaAccessToken::EL_STRAVA_ACCESS_TOKEN ];
			// Save the posted value in the database
			$stravaAccessToken->setAppID( $opt_appid_val );
			$stravaAccessToken->setStravaAccessToken( $opt_accesstoken_val );
			$webhookStrava->setOauthWebhook( $opt_oath_webhook_val );


			// Put a "settings saved" message on the screen

			?>
            <div class="updated"><p><strong><?php _e( 'settings saved.', 'menu-test' ); ?></strong></p></div>
			<?php

		}
		//delete all settings
		if ( isset( $_POST['delete'] ) ) {
			$this->detele_option_page();
			?>
            <div class="deleted"><p><strong><?php _e( 'Deleted options', 'el-helper' ); ?></strong></p></div>
			<?php
		}
		// Read in existing option value from database
		$opt_appid_val        = $stravaAccessToken->getAppID();
		$opt_accesstoken_val  = $stravaAccessToken->getStravaAccessToken();
		$opt_oath_webhook_val = $webhookStrava->getOauthWebhook();


		// render settings form
		$view = new View( $this );
		echo $view->render( 'index.php', [
			'hidden_field_name' => $hidden_field_name,
			'opt_appid'         => [
				'key'   => StravaApiModel::EL_STRAVA_APP_ID,
				'value' => $opt_appid_val,
			],
			'opt_callback'      => [
				'key'   => StravaAccessToken::EL_STRAVA_CALLBACK_URL,
				'value' => StravaAccessToken::getCallBackUrlVal(),
			],
			'opt_accesstoken'   => [
				'key'   => StravaAccessToken::EL_STRAVA_ACCESS_TOKEN,
				'value' => $opt_accesstoken_val,
			],
			'opt_webhook'       => [
				'key'   => StravaWebHookModel::EL_STRAVA_WEBHOOK_URL,
				'value' => StravaWebHookModel::getReceiveWebhook()
			],
			'opt_oath_webhook'  => [
				'key'   => StravaWebHookModel::EL_STRAVA_OATH_WEBHOOK,
				'value' => $opt_oath_webhook_val
			],
		] );
	}


	public function detele_option_page() {
		//for delete all, and call js name purpose
		$field_names = [
			StravaAccessToken::EL_STRAVA_ACCESS_TOKEN,
		];
		foreach ( $field_names as $value ) {
			delete_option( $value );
		}
	}


}