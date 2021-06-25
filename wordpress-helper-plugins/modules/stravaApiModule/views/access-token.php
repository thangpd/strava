<?php
/**
 * Date: 2/17/21
 * Time: 1:31 PM
 */
wp_head();

?><h3 class="strava_access_token_page">strava api get access token shortcode
</h3><?php
/*
 * ?state=success&code=3e51c76363defc58168da20982c9812af043d136&scope=read,activity:read
 *
 *
 * */
if ( isset( $_GET['state'] ) ) {
	write_log( 'isset state' );
	$state = $_GET['state'];
	$state = json_decode( str_replace( "\\", "", $state ) );
	write_log( 'state user id' . $state->user_id );
	$userStravaModel = new \Elhelper\modules\userStravaModule\model\UserStravaModel( $state->user_id );
	$res             = $userStravaModel->receiveAndSaveAccessToken($state->user_id);
} else {
	write_log( 'not have state' );
}
//$transient_at   = get_option( \Elhelper\admin\modules\pages\stravaApiSettingPages\StravaApiSettingPage::EL_STRAVA_ACCESS_TOKEN );
//$transient_oaID = get_option( \Elhelper\admin\modules\pages\stravaApiSettingPages\StravaApiSettingPage::EL_STRAVA_OAID );
if ( $res['code'] = 200 ) {
	echo '<h5>Thanks for your permission</h5>';
} else {
	echo '<h5>Not Found</h5>';
}


wp_footer();
?>




