<?php
/**
 * Date: 1/17/21
 * Time: 2:53 PM
 */
$res = [ 'code' => 200 ];
//write_log( 'get'.json_encode( $_GET ) );
//echo json_encode( $res );
if ( isset( $_GET['hub_challenge'] ) ) {
	$hub_challenge = $_GET['hub_challenge'];
} else {
	$hub_challenge = '';

}
$data = [ 'code' => 200, 'hub.challenge' => $hub_challenge ];
header( 'Content-type:application/json;charset=utf-8' );
echo json_encode( $data );


?>

