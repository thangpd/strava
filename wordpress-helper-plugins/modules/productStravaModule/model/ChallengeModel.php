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
use Elhelper\mail\Template;
use Elhelper\modules\productStravaModule\controller\ChallengeController;
use Elhelper\modules\productStravaModule\db\ChallengeDb;
use Elhelper\modules\stravaApiModule\db\HistoryChallengeAthleteDb;

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
	public $challenge;

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
		$challenges = ChallengeDb::getAllChallengeByProductOrderbyFinishedTime( $product_id, 1 );

		$list_finisher = array();
		if ( ! empty( $challenges ) ) {
			foreach ( $challenges as $challenge ) {
				$user           = get_user_by( 'id', $challenge->user_id );
				$challengeModel = new ChallengeModel( $challenge );
				//pace
				$paceOfChallenge = $challengeModel->getPaceOfChallenge();

				$floatMinuteToSecond = sprintf( '%02d:%02d', (int) $paceOfChallenge, fmod( $paceOfChallenge, 1 ) * 60 );
				//endpace
				if ( isset( $user->data ) ) {
					$user_nicename = $user->data->user_nicename;
				} else {
					$user_nicename = "Anonymous";
				}
				$item            = [
					'user_name'            => $user_nicename,
					'total_km'             => $challengeModel->getDistanceAlreadyRun(),
					'amount_time_finished' => $challengeModel->getAmountTimeFinished(),
					'pace'                 => $floatMinuteToSecond,
				];
				$list_finisher[] = $item;
			}
		}

		return $list_finisher;
	}

	public function getPaceOfChallenge() {
		$list_pace     = ChallengeDb::getPaceOfChallengeById( $this->challenge->id );
		$distance_mile = 0;
		$moving_time   = 0;
		if ( ! empty( $list_pace ) ) {

			foreach ( $list_pace as $pace ) {
				$distance_mile += HeplerStrava::getMiles( $pace->distance );
				$moving_time   += $pace->moving_time;
			}
		}
		$distance_mile = round( $distance_mile, 0 );

		$moving_time = $moving_time / 60;
		if ( $distance_mile != 0 ) {
			$f = $moving_time / $distance_mile;
		} else {
			$f = 0;
		}

		return $f;
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
		//sort array multiple dimension
		//https://stackoverflow.com/questions/2699086/how-to-sort-a-multi-dimensional-array-by-value
		if ( ! empty( $this->challenge->finished_at ) ) {
			$start_date  = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->challenge->finished_at );
			$end_date    = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->challenge->created_at );
			$amount_time = $start_date->diff( $end_date );

			return $amount_time->days;
		} else {
			return false;
		}

	}

	public static function getChallengeByProductIdAndUserId( $product_id, $user_id ) {
		$res = ChallengeDb::getChallengeByProductIdAndUserId( $product_id, $user_id );
//		echo '<pre>';
//		print_r($res);
//		echo '</pre>';

	}

	public function activeSendMailBaseOnPercentDistance() {
		$percentDistanceOff = (int) $this->getPercentDistanceOff();
		write_log( 'Active_sendmail at' . $percentDistanceOff . '%' );
		$phase = 0;
		if ( $percentDistanceOff > 25 && $percentDistanceOff < 50 ) {
			$phase = 1;
		}
		if ( $percentDistanceOff > 50 && $percentDistanceOff < 75 ) {
			$phase = 2;
		}
		if ( $percentDistanceOff > 75 && $percentDistanceOff < 75 ) {
			$phase = 3;
		}
		if ( $percentDistanceOff == 100 || $percentDistanceOff > 100 ) {
			$phase = 4;
		}
		$current_phase = $this->getEmailPhaseOfProduct();
		if ( $current_phase->email_phase == null ) {
			$current_phase = 0;
			write_log( 'sent mail template 0 for challengeid' . $this->challenge->id );
			Template::action_sendmail( $this->challenge->product_id, $this->challenge->user_id, $current_phase );
			$this->updateEmailPhase( $phase );
		} else {
			$current_phase = $current_phase->email_phase;
		}

		if ( $current_phase < $phase ) {
			write_log( 'current phast' . $current_phase );
			write_log( 'phase send' . $phase );
			for ( $i = $current_phase + 1; $i <= $phase; $i ++ ) {
				Template::action_sendmail( $this->challenge->product_id, $this->challenge->user_id, $i );
			}
			$this->updateEmailPhase( $phase );
		}
	}

	public function getPercentDistanceOff() {
		$distance_already = $this->getDistanceAlreadyRun();
		$amount_distance  = $this->challenge->amount_distance;
		if ( $distance_already < $amount_distance ) {
			$percent_distance_left = round( $distance_already / $amount_distance * 100, 0 );

		} else {
			$percent_distance_left = 100;
		}

		return $percent_distance_left;
	}

	public function getEmailPhaseOfProduct() {
		$res = ChallengeDb::getEmailPhaseOfProduct( $this->challenge->id );
		if ( ! empty( $res ) ) {


			return array_shift( $res );
		} else {
			return [];
		}
	}

	//return km

	public function updateEmailPhase( $email_phase ) {
		ChallengeDb::update( [ 'email_phase' => $email_phase ], [
			'id'      => $this->challenge->id,
			'user_id' => $this->challenge->user_id
		] );
	}

	public function canInsertDistanceToChallenge() {
		switch ( $this->challenge->status ) {
			case 0:
				$res = true;
				break;
			case 1:
				$res = false;
				break;
			case 2:
				$res = false;
				break;
		}

		return $res;

	}

	public function checkIfChallengeIsExpired() {
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
			return false;
		} else {
			return true;
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

	public function ifExistsActivity( $activity ) {
		$res = HistoryChallengeAthleteDb::getActivityByIdChallenge( $this->challenge->id, $activity );
		if ( ! empty( $res ) ) {
			return true;
		} else {
			return false;
		}
	}


}