<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/29/21
 * Time: 5:53 AM
 */

namespace Elhelper\modules\activityModule\model;


use Elhelper\inc\HeplerStrava;
use Elhelper\modules\userStravaModule\model\UserStravaBearerModel;

class ActivityStravaModel {
	public function __construct() {
	}


	/**
	 * stdClass Object
	 * (
	 * [resource_state] => 3
	 * [athlete] => stdClass Object
	 * (
	 * [id] => 72408224
	 * [resource_state] => 1
	 * )
	 *
	 * [name] => Run13ed
	 * [distance] => 14.9
	 * [moving_time] => 20
	 * [elapsed_time] => 20
	 * [total_elevation_gain] => 0
	 * [type] => EBikeRide
	 * [id] => 5544776569
	 * [external_id] => cca255f3-5293-48a4-b4c8-749723213c45-activity.fit
	 * [upload_id] => 5901126642
	 * [start_date] => 2021-06-28T20:53:00Z
	 * [start_date_local] => 2021-06-29T03:53:00Z
	 * [timezone] => (GMT+07:00) Asia/Ho_Chi_Minh
	 * [utc_offset] => 25200
	 * [start_latlng] => Array
	 * (
	 * [0] => 10.8
	 * [1] => 106.68
	 * )
	 *
	 * [end_latlng] => Array
	 * (
	 * [0] => 10.8
	 * [1] => 106.68
	 * )
	 *
	 * [location_city] =>
	 * [location_state] =>
	 * [location_country] =>
	 * [start_latitude] => 10.8
	 * [start_longitude] => 106.68
	 * [achievement_count] => 0
	 * [kudos_count] => 0
	 * [comment_count] => 0
	 * [athlete_count] => 1
	 * [photo_count] => 0
	 * [map] => stdClass Object
	 * (
	 * [id] => a5544776569
	 * [polyline] => _e}`ActcjSGD@T
	 * [resource_state] => 3
	 * [summary_polyline] => _e}`ActcjSGD@T
	 * )
	 *
	 * [trainer] =>
	 * [commute] =>
	 * [manual] =>
	 * [private] =>
	 * [visibility] => everyone
	 * [flagged] =>
	 * [gear_id] =>
	 * [from_accepted_tag] =>
	 * [upload_id_str] => 5901126642
	 * [average_speed] => 0.745
	 * [max_speed] => 2.2
	 * [device_watts] =>
	 * [has_heartrate] =>
	 * [heartrate_opt_out] =>
	 * [display_hide_heartrate_option] =>
	 * [elev_high] => 7.1
	 * [elev_low] => 7
	 * [pr_count] => 0
	 * [total_photo_count] => 0
	 * [has_kudoed] =>
	 * [description] =>
	 * [calories] => 0
	 * [perceived_exertion] =>
	 * [prefer_perceived_exertion] =>
	 * [segment_efforts] => Array
	 * (
	 * )
	 *
	 * [splits_metric] => Array
	 * (
	 * [0] => stdClass Object
	 * (
	 * [distance] => 14.9
	 * [elapsed_time] => 20
	 * [elevation_difference] => 0.1
	 * [moving_time] => 20
	 * [split] => 1
	 * [average_speed] => 0.75
	 * [average_grade_adjusted_speed] =>
	 * [pace_zone] => 0
	 * )
	 *
	 * )
	 *
	 * [splits_standard] => Array
	 * (
	 * [0] => stdClass Object
	 * (
	 * [distance] => 14.9
	 * [elapsed_time] => 20
	 * [elevation_difference] => 0.1
	 * [moving_time] => 20
	 * [split] => 1
	 * [average_speed] => 0.75
	 * [average_grade_adjusted_speed] =>
	 * [pace_zone] => 0
	 * )
	 *
	 * )
	 *
	 * [laps] => Array
	 * (
	 * [0] => stdClass Object
	 * (
	 * [id] => 18032607313
	 * [resource_state] => 2
	 * [name] => Lap 1
	 * [activity] => stdClass Object
	 * (
	 * [id] => 5544776569
	 * [resource_state] => 1
	 * )
	 *
	 * [athlete] => stdClass Object
	 * (
	 * [id] => 72408224
	 * [resource_state] => 1
	 * )
	 *
	 * [elapsed_time] => 20
	 * [moving_time] => 20
	 * [start_date] => 2021-06-28T20:53:00Z
	 * [start_date_local] => 2021-06-29T03:53:00Z
	 * [distance] => 14.89
	 * [start_index] => 0
	 * [end_index] => 6
	 * [total_elevation_gain] => 0
	 * [average_speed] => 0.74
	 * [max_speed] => 2.2
	 * [device_watts] =>
	 * [lap_index] => 1
	 * [split] => 1
	 * )
	 *
	 * )
	 *
	 * [photos] => stdClass Object
	 * (
	 * [primary] =>
	 * [count] => 0
	 * )
	 *
	 * [device_name] => Strava Android App
	 * [embed_token] => 959880cd4977f11b5e0c47919e1297afb7647995
	 * [available_zones] => Array
	 * (
	 * )
	 *
	 * )
	 */
	public function getActivityInfo( $user_id, $activity_id ) {
		$userBearer = new UserStravaBearerModel( $user_id );

		$callStravaAPI = HeplerStrava::callStravaAPI( 'https://www.strava.com/api/v3/activities/' . $activity_id, $userBearer->getAccessToken() );
		if ( isset( $callStravaAPI->errors ) ) {
			write_log( json_encode( (array) $callStravaAPI ) . __FILE__ . __LINE__ );

			return false;
		} else {
			return $callStravaAPI;
		}
	}
}