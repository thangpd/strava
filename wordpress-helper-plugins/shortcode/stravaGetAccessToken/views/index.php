<?php
/**
 * Date: 2/17/21
 * Time: 1:31 PM
 */

?><h3>strava api get access token shortcode
</h3><?php
if ( isset( $_GET['access_token'] ) ) {
	set_transient( 'strava_access_token', $_GET['access_token'] );
} else {
	write_log( 'no token ' . __FILE__ );
}

if ( isset( $_GET['oaId'] ) ) {
	set_transient( 'strava_oaId', $_GET['oaId'] );
} else {
	write_log( 'no oaID' . __FILE__ );
}
$transient_at   = get_transient( 'strava_access_token' );
$transient_oaId = get_transient( 'strava_oaId' );
if ( ! empty( $transient_at ) && ! empty( $transient_oaId ) ) {
	echo '<h5>Thanks for your permission</h5>';
} else {
	echo '<h5>Not Found</h5>';
}

echo '<pre>';
echo 'accesstoken<br>';
print_r( $transient_at );
echo '</pre>';

echo '<pre>';
echo 'oaId<br>';
print_r( $transient_oaId );
echo '</pre>';


?>








