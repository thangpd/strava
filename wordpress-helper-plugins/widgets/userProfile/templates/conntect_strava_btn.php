<?php
$domain = EL_HELPER_DEBUG == 'DEV' ? URL_DOMAIN : '';

$url     = '' . $domain . '' . \Elhelper\modules\stravaApiModule\models\StravaAccessToken::getCallBackUrlVal();
$user_id = get_current_user_id();
$state   = urlencode( json_encode( array(
	'user_id' => $user_id
) ) );
ob_start();
if ( is_user_logged_in() ):
	$button_logout = '<a href="' . wp_logout_url() . '" class="button btn-logout">ĐĂNG XUẤT</a>';

	$userBearer = new \Elhelper\modules\userStravaModule\model\UserStravaBearerModel( $user_id );
	if ( ! $userBearer->issetBearer() ) {
		?>
        <button class="button popup-strava-challenges get-access-token" data-client_id="<?php echo CLIENT_ID ?>"
                data-state="<?php echo $state ?>" data-url="<?php echo $url ?>">
            KẾT NỐI STRAVA
        </button>
		<?php
		echo $button_logout;
	} else {

		$button_connected_strava = <<<HTML
					
        <div class="button popup-strava-challenges btn-connected-strava">Đã Kết Nối Strava
			<a href="#" data-user_id="{$user_id}" class="deauthorize_strava"><span class="logout">ngắt kết nối với Strava</span></a>
		</div>	
HTML;
		echo $button_logout . $button_connected_strava;
	}

	$userStravaModel = new \Elhelper\modules\userStravaModule\model\UserStravaModel( $user_id );
//	echo '<pre>';
//	print_r( $userStravaModel->getStravaCode() );
//	echo '</pre>';
//	echo '<pre>';
//	print_r( $userStravaModel->getScope() );
//	echo '</pre>';

// get UserID by Athlete ------------------------------------------------
/*$users = \Elhelper\modules\userStravaModule\model\UserStravaAthleteModel::getUserIdByAthlete( 72408224 );
echo '<pre>';
print_r($users);
echo '</pre>';

if ( ! empty( $users ) && is_array($users) ) {
	echo '<pre>';
	print_r($users);
	echo '</pre>';

}*/
// -----------------------------------------------------------------
//  getProducts by userobj

/*$user_objs = \Elhelper\modules\userStravaModule\model\UserStravaAthleteModel::getUserIdByAthlete( 72408224 );

$products = inspire_get_list_purchased_product_by_user_object( $user_objs );
if ( ! empty( $products ) ) {
	echo '<pre>';
	print_r( $products );
	echo '</pre>';

	foreach ( $products as $product_id ) {
//				\Elhelper\modules\productStravaModule\model\ProductUserModel::addDistanceToProduct( $product_id, 53 );
		$distance = get_post_meta( $product_id, \Elhelper\modules\productStravaModule\model\ProductUserModel::PRODUCT_DISTANCE_SLUG, true );
		echo '<pre>';
		print_r( $distance );
		echo '</pre>';

	}
}*/


//-------------------------------------------------
// get Object activity

/*
$activity = new \Elhelper\modules\activityModule\model\ActivityStravaModel();
	$res      = $activity->getActivityInfo( 2, 5544776569 );
	echo '<pre>';
	print_r( $res );
	echo '</pre>';
if(!empty($res)){
	echo '<pre>';
	print_r( $res->distance );
	echo '</pre>';
}
*/
/*Athlete User ID*/
//	$userAthlete = new \Elhelper\modules\userStravaModule\model\UserStravaAthleteModel( 2 );
//	$userAthlete->addDistanceOfUserOfProduct( 887, 42 );

//----------------------------
//	echo \Elhelper\modules\userStravaModule\model\UserStravaRenderModel::renderUserProfile( $user_id );

//	echo \Elhelper\modules\userStravaModule\model\UserStravaRenderModel::renderUserActivities( $user_id );
else: ?>
    Please login to connect Strava

<?php endif;

return ob_get_clean();
?>