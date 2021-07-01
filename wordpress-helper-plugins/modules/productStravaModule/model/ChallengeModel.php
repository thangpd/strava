<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 7/1/21
 * Time: 2:33 PM
 */

namespace Elhelper\modules\productStravaModule\model;


use Elhelper\common\Model;
use Elhelper\modules\productStravaModule\controller\ChallengeController;
use Elhelper\modules\productStravaModule\db\ChallengeDb;

class ChallengeModel extends Model {


	/*
	 *          [id] => 2
				[product_id] => 485
				[user_id] => 2
				[status] => 0
				[amount_date] => 4
				[amount_distance] => 200
				[created_at] => 2021-06-28 23:46:59
				[order_id] => 0
	 * */
	private $challenge;

	public function __construct( $challenge ) {
		$this->challenge = $challenge;
	}

	//status=0 not yet
	// status=1 finised
	// status=2 failed.
	public function canInsertDistanceToChallenge() {
		switch ( $this->challenge->status ) {
			case 0:
				return true;
				break;
			case 1:
				return false;
				break;
			case 2:
				return false;
				break;
		}
	}


	public function checkIfChallengeExpired() {
		$start_date = $this->challenge->created_at;

//		$amount_date = get_field( 'amount_date', $product_id );
		$amount_date = $this->challenge->amount_date;
		$now         = new \DateTime( 'now' );
		if ( empty( $start_date ) && empty( $amount_date ) ) {
			write_log( 'empty_start_date,amount_date' . __FILE__ . __LINE__ );
		}
		$start_date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $start_date );
		$end_date   = clone( $start_date );
		$end_date->modify( '+' . $amount_date . 'days' );
		$end_datetime = $end_date->modify( 'tomorrow' );
		$end_date     = $end_date->setTimestamp( $end_datetime->getTimestamp() - 1 );
		//end date
		if ( $now < $end_date ) {
			return true;
		} else {
			return false;
		}

	}

	public function checkIfCanFinishChallenge() {
		$distance_already = ChallengeController::getDistanceAlreadyOfProduct( $this->challenge->id, $this->challenge->user_id );
		$distance_already = $distance_already->distance * 0.001;
		$amount_distance  = $this->challenge->amount_distance;
		if ( $distance_already > $amount_distance ) {
			write_log( 'distance already' . $distance_already );
			write_log( 'amount_distance' . $amount_distance );

			return true;
		} else {
			return false;
		}


	}

	public function activeFinishedEventChallenge() {
		ChallengeDb::update( [ 'status' => 1, 'finished_at' => date( 'Y-m-d H:i:s' ) ], [
			'id'      => $this->challenge->id,
			'user_id' => $this->challenge->user_id
		] );

	}

	public function activeFailEventChallenge() {
		ChallengeDb::update( [ 'status' => 2, 'failed_at' => date( 'Y-m-d H:i:s' ) ], [
			'id'      => $this->challenge->id,
			'user_id' => $this->challenge->user_id
		] );
	}

	public function activeOngoingChallenge() {
		ChallengeDb::update( [ 'status' => 0 ], [
			'id'      => $this->challenge->id,
			'user_id' => $this->challenge->user_id
		] );
	}

}