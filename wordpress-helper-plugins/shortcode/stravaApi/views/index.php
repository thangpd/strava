<?php
/**
 * Date: 2/17/21
 * Time: 1:31 PM
 */

?>

    <h3 class="title">strava OA api shortcode</h3>


<?php
if ( isset( $_POST['delete_strava_info'] ) ) {
	delete_option( 'app_id' );
	delete_option( 'redirect_uri' );
	delete_transient( 'strava_access_token' );
	delete_transient( 'strava_oaId' );
	delete_transient( 'oa_information' );
	echo 'delete success';
}

if ( isset( $_POST['app_id'] ) && ! empty( $_POST['app_id'] ) ) {
	update_option( 'app_id', $_POST['app_id'] );
}
if ( isset( $_POST['redirect_uri'] ) && ! empty( $_POST['redirect_uri'] ) ) {
	update_option( 'redirect_uri', $_POST['redirect_uri'] );
}

$stravaAccessToken = new \Elhelper\modules\stravaApiModule\models\StravaAccessToken();
$callback_url    = \Elhelper\modules\stravaApiModule\models\StravaAccessToken::getCallBackUrlVal();
$opt_at          = $stravaAccessToken->getStravaAccessToken();
$opt_appid       = $stravaAccessToken->getAppID();

if ( ! empty( $opt_appid ) && ! empty( $opt_at ) ) {
	$strava = new \Elhelper\model\TechvsiStravaModel();


	$strava_info = $strava->getOAInformation();
	?>
    <img src="<?php echo $strava_info['data']['cover'] ?>" alt="">
    <h1><?php echo $strava_info['data']['name'] ?></h1>
    <h5><?php echo $strava_info['data']['description'] ?></h5>
    <img src="<?php echo $strava_info['data']['avatar'] ?>" alt="">
    <p> OA ID: <?php echo $strava_info['data']['oa_id'] ?></p>
    <img width="200px" src="<?php echo WP_HELPER_INC_URI . '/assets/img/qr_stravacode.jpg' ?>" alt="qr code">
	<?php

	$list_sub = $strava->getListSubscribers();
	if ( ! empty( $list_sub ) ) {
		echo "<p>Số Lượng Người subscribe: " . $list_sub['data']['total'] . '</p>';
		foreach ( $list_sub['data']['followers'] as $val ) {
			$user = $strava->getInfoUser( $val['user_id'] );
			?>
            <img src="<?php $user['data']['avatar'] ?>" alt="">
            <p>Giới tính: <?php echo $user['data']['user_gender'] == 1 ? 'Nam' : 'Nữ'; ?></p>
            <p>User ID: <?php echo $user['data']['user_id'] ?></p>
            <p>Tên: <?php echo $user['data']['display_name'] ?></p>
            <p>Ngày Sinh: <?php //print_r(getdate( $user['data']['birth_date'] )); ?></p>
            <hr>
			<?php
		}
	}


	if ( isset( $_POST['get_user_info'] ) ) {
		echo 'get user_info';
		var_dump( $strava->getInfoUser( $_POST['user_id'] ) );
	}

	if ( isset( $_POST['send_message'] ) ) {
		echo '<p>success send message</p>';
		$strava->sendMessageToListRecipient( $_POST['user_id'], $_POST['message'] );
	}
	?>
    <form action="" method="post">
        <input type="number" name="user_id" placeholder="User ID" required>
        <input type="submit" name="get_user_info">
    </form>
    <form action="" method="post">
        <input type="number" name="user_id" placeholder="User Id" required>
        <input type="text" name="message" placeholder="Chat" required>
        <input type="submit" name="send_message" value="Send Message"/>
    </form>
    <form action="" method="post">
        <input type="submit" name="delete_strava_info" value="Delete Current OA"/>
    </form>
	<?php
} elseif ( ! empty( $opt_appid ) && ! empty( $callback_url ) ) {
	//3200355550004632180
	//https://gomsu.fun/access-token
	?>
    <a target="popup" class="btn btn-success strava-btn-get-at"
       href="https://oauth.stravaapp.com/v3/oa/permission?app_id=<?php echo $opt_appid ?>&redirect_uri=<?php echo $callback_url ?>">
        Accept gain permission to website
    </a>
    <form action="" method="post">
        <input type="submit" name="delete_strava_info" value="Delete Current OA"/>
    </form>
	<?php
} else {
	?>
    <form action="" class="form-container form-group" method="post">
        <label for="app_id">App ID: <input class="form-control" type="text" id="app_id" name="app_id"
                                           placeholder="App Id"></label>
        <label for="redirect_uri">Redirect Uri: <input class="form-control" type="text" id="redirect_uri"
                                                       name="redirect_uri"
                                                       placeholder="Redirect Uri"></label>
        <input type="submit" value="Get link" class="btn">
    </form>
	<?php
} ?>


<?php


?>