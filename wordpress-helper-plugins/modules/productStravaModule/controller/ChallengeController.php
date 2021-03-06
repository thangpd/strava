<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/30/21
 * Time: 11:07 PM
 */

namespace Elhelper\modules\productStravaModule\controller;


use Elhelper\common\Singleton;
use Elhelper\mail\Template;
use Elhelper\modules\productStravaModule\db\ChallengeDb;
use Elhelper\modules\productStravaModule\model\ChallengeModel;
use Elhelper\modules\stravaApiModule\db\HistoryChallengeAthleteDb;
use Elhelper\modules\userStravaModule\db\ActivityDb;

class ChallengeController extends Singleton {
	protected static $_instance;

	public static function getDistanceAlreadyOfProduct( $challenge_id, $user_id ) {
		global $wpdb;
		$sql           = 'SELECT DISTINCT h.id ,a.distance FROM  %1$s WHERE %2$s';
		$history_table = HistoryChallengeAthleteDb::get_table() . ' as h, ' . ActivityDb::get_table() . ' as a, ' . ChallengeDb::get_table() . ' as c ';
		$where         = ' a.activity_id = h.activity_id and h.challenge_id=' . $challenge_id . ' and c.id=h.challenge_id and c.user_id=' . $user_id;
		$sql           = $wpdb->prepare( $sql, $history_table, $where );

		$results = $wpdb->get_results( $sql );

		$total = 0;

		if ( ! empty( $results ) ) {
			foreach ( $results as $item ) {
				$total += $item->distance;
			}
			$results = (object) array( 'distance' => $total );
		} else {
			$results = [];
		}

		return $results;
	}

	public function __init() {
		parent::__init(); // TODO: Change the autogenerated stub
//		add_action( 'woocommerce_thankyou', [ $this, 'call_pos_management_call_api' ], 10, 1 );
		add_action( 'woocommerce_order_status_completed', [ $this, 'call_pos_management_call_api' ], 10, 1 );

	}


	function call_pos_management_call_api( $order_id ) {
		if ( ! $order_id ) {
			return;
		}

// Get an instance of the WC_Order object
		$order   = wc_get_order( $order_id );
		$user_id = $order->get_user_id();
		// Loop through order items
		foreach ( $order->get_items() as $item_id => $item ) {
			// Get the product object
			$product = $item->get_product();

			// Get the product Id
			//1.0.2
			$product_id = $product->get_id();

			//1.0.3
			// Get the product name

			$amount_date     = get_field( 'amount_date', $product_id );
			$amount_distance = get_field( 'distance', $product_id );
			ChallengeDb::insert( [
				'order_id'        => $order_id,
				'product_id'      => $product_id,
				'user_id'         => $user_id,
				'status'          => 0,
				'amount_date'     => $amount_date,
				'amount_distance' => $amount_distance
			] );
		}
		//after insert all product. Get all challenge to send mail with email_phase == null and set it to 0
		$challenges = ChallengeDb::getAllChallengeOfUser( $user_id );
		foreach ( $challenges as $challenge ) {
			$challengeModel = new ChallengeModel( $challenge );
			$challengeModel->activeSendMailBaseOnPercentDistance();
		}


	}


}