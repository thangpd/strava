<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 7/1/21
 * Time: 2:33 PM
 */

namespace Elhelper\modules\productStravaModule\model;


use Elhelper\common\Model;
use Elhelper\inc\HeplerStrava;
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
	/** (
	 * [id] => 2
	 * [product_id] => 485
	 * [user_id] => 2
	 * [status] => 1
	 * [amount_date] => 4
	 * [amount_distance] => 200
	 * [created_at] => 2021-06-28 23:46:59
	 * [order_id] => 0
	 * [finished_at] => 2021-07-01 09:47:42
	 * [failed_at] =>
	 * [email_phase] =>
	 * )*/
	public static function getListFinisherInfo( $product_id ) {
		$challenges = ChallengeDb::getAllChallengeByProduct( $product_id, 1 );

		$list_finisher = array();
		foreach ( $challenges as $challenge ) {
			$user           = get_user_by( 'id', $challenge->user_id );
			$challengeModel = new ChallengeModel( $challenge );
			//pace
			$paceOfChallenge = $challengeModel->getPaceOfChallenge();

			$floatMinuteToSecond = sprintf( '%02d:%02d', (int) $paceOfChallenge, fmod( $paceOfChallenge, 1 ) * 60 );
			//endpace
			$item            = [
				'user_name'            => $user->data->user_nicename,
				'total_km'             => $challengeModel->getDistanceAlreadyRun(),
				'amount_time_finished' => $challengeModel->getAmountTimeFinished(),
				'pace'                 => $floatMinuteToSecond,
			];
			$list_finisher[] = $item;
		}

		return $list_finisher;
	}

	public function getPaceOfChallenge() {
		$list_pace = ChallengeDb::getPaceOfChallengeById( $this->challenge->id );
		if ( ! empty( $list_pace ) ) {
			$distance_mile = 0;
			$moving_time   = 0;
			foreach ( $list_pace as $pace ) {
				$distance_mile += HeplerStrava::getMiles( $pace->distance );
				$moving_time   += $pace->moving_time;
			}
		}


		$distance_mile = round( $distance_mile, 0 );

		$moving_time = $moving_time / 60;

		return $moving_time / $distance_mile;
	}

	public function getDistanceAlreadyRun() {
		$distance_already = ChallengeController::getDistanceAlreadyOfProduct( $this->challenge->id, $this->challenge->user_id );
		if ( ! empty( $distance_already ) ) {
			$distance_already = round( $distance_already->distance * 0.001, 3 );
		} else {
			$distance_already = 0;
		}

		return $distance_already;
	}

	public function getAmountTimeFinished() {
		if ( ! empty( $this->challenge->finished_at ) ) {
			$start_date  = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->challenge->finished_at );
			$end_date    = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->challenge->created_at );
			$amount_time = $start_date->diff( $end_date );

			return $amount_time->days;
		} else {
			return false;
		}

	}

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

	//return km

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
		$distance_already = $this->getDistanceAlreadyRun();
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