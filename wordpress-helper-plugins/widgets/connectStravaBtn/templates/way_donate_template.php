<?php

//		$res      = HeplerStrava::callStravaAPI( 'https://www.strava.com/api/v3/athlete', '2b2e59ccf94e1db66f0eb68d9da54701a09074c5' );


//$url = home_url() . '/' . \Elhelper\modules\stravaApiModule\models\StravaAccessToken::getCallBackUrlVal();

$domain = EL_HELPER_DEBUG == 'DEV' ? URL_DOMAIN : '';

$url     = '' . $domain . '' . \Elhelper\modules\stravaApiModule\models\StravaAccessToken::getCallBackUrlVal();
$user_id = get_current_user_id();
$state   = urlencode( json_encode( array(
	'user_id' => $user_id
) ) );

if ( is_user_logged_in() ):
	$userBearer = new \Elhelper\modules\userStravaModule\model\UserStravaBearerModel( $user_id );

	if ( ! $userBearer->issetBearer() ) {
		?>

        <button class="btn btn-success get-access-token" data-client_id="<?php echo CLIENT_ID ?>"
                data-state="<?php echo $state ?>" data-url="<?php echo $url ?>">
            Connect
            to Strava
        </button>
		<?php
	} else {
		$button_connected = <<<HTML
        <div class="btn btn-success">Đã Kết Nối</div>
        <a href="#" class="deauthorize_strava">Ngắt kết nối</a>
HTML;
		echo $button_connected;
	}

	$userStravaModel = new \Elhelper\modules\userStravaModule\model\UserStravaModel( $user_id );
//	echo '<pre>';
//	print_r( $userStravaModel->getStravaCode() );
//	echo '</pre>';
//	echo '<pre>';
//	print_r( $userStravaModel->getScope() );
//	echo '</pre>';

	echo \Elhelper\modules\userStravaModule\model\UserStravaRenderModel::renderUserProfile( $user_id );

	echo \Elhelper\modules\userStravaModule\model\UserStravaRenderModel::renderUserActivities( $user_id );
else: ?>
    Please login to connect Strava

<?php endif; ?>



