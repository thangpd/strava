<?php

//		$res      = HeplerStrava::callStravaAPI( 'https://www.strava.com/api/v3/athlete', '2b2e59ccf94e1db66f0eb68d9da54701a09074c5' );


//$url = home_url() . '/' . \Elhelper\modules\stravaApiModule\models\StravaAccessToken::getCallBackUrlVal();

$client_id = 67628;
$domain    = EL_HELPER_DEBUG == 'DEV' ? 'http://www.inspiretrails.life/' : '';

$url     = '' . $domain . '' . \Elhelper\modules\stravaApiModule\models\StravaAccessToken::getCallBackUrlVal();
$user_id = EL_HELPER_DEBUG == 'DEV' ? 2 : get_current_user_id();
$state   = urlencode( json_encode( array(
	'user_id' => $user_id
) ) );
if ( is_user_logged_in() || EL_HELPER_DEBUG == 'DEV' ):
	?>

    <button class="btn btn-success get-access-token" data-client_id="<?php echo $client_id ?>"
            data-state="<?php echo $state ?>" data-url="<?php echo $url ?>">
        Connect
        to Strava
    </button>
	<?php


	$userStravaModel = new \Elhelper\modules\userStravaModule\model\UserStravaModel( $user_id );
//	echo '<pre>';
//	print_r( $userStravaModel->getStravaCode() );
//	echo '</pre>';
//	echo '<pre>';
//	print_r( $userStravaModel->getScope() );
//	echo '</pre>';
	/*
	echo '<pre>';
	print_r( $userStravaModel->getBearer() );
	echo '</pre>';*/
	$userBearer  = new \Elhelper\modules\userStravaModule\model\UserStravaBearerModel( $user_id );
	$userAthlete = new \Elhelper\modules\userStravaModule\model\UserStravaAthleteModel( $user_id );

//	$ath_obj    = $userAthlete->getAthleteObject();
	$bearer_obj = $userBearer->getAllInfo();
//	echo '<pre>';
//	print_r( $ath_obj );
//	echo '</pre>';
//	echo '<pre>';
//	print_r( $bearer_obj );
//	echo '</pre>';


	echo \Elhelper\modules\userStravaModule\model\UserStravaRenderModel::renderUserProfile( $userAthlete );

	echo \Elhelper\modules\userStravaModule\model\UserStravaRenderModel::renderUserActivities( $user_id );
else: ?>
    Please login to connect Strava

<?php endif; ?>



