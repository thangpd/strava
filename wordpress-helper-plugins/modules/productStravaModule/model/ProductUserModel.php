<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/29/21
 * Time: 4:24 AM
 */

namespace Elhelper\modules\productStravaModule\model;


class ProductUserModel {

	const PRODUCT_DISTANCE_UNIT = 'metes';
	const PRODUCT_DISTANCE_SLUG = 'strava_distance';

	public function __construct() {
//		if ( ! empty( $user_id ) ) {
//			$this->user_id = $user_id;
//		} else {
//			write_log( 'no user id' . __FILE__ . __LINE__ );
//		}
	}

	public static function getProductsByAthleteID( $athlete_id ) {

	}

	public static function addDistanceToProduct( $product_id, $meter ) {
		//test get data
		$current_meta = get_post_meta( $product_id, self::PRODUCT_DISTANCE_SLUG, true );
//		echo '<pre>';
//		print_r( $current_meta );
//		echo '</pre>';

		$total = (float) $meter + (float) $current_meta;
//		if ( empty( $current_meta ) ) {
		update_post_meta( $product_id, self::PRODUCT_DISTANCE_SLUG, $total );
//		} else {
//			$total = (float) $meter + (float) $current_meta;
//			update_post_meta( $product_id, self::PRODUCT_DISTANCE_SLUG, $total );
//		}

	}

	public function getProductsByUserId( $user_id ) {

	}

}