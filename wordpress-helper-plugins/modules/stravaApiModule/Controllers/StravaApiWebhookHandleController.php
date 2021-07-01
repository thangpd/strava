<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 3/9/21
 * Time: 1:25 PM
 */

namespace Elhelper\modules\stravaApiModule\Controllers;

use Elhelper\common\Singleton;
use Elhelper\modules\productStravaModule\db\ChallengeDb;
use Elhelper\modules\productStravaModule\model\ChallengeModel;
use Elhelper\modules\stravaApiModule\db\HistoryChallengeAthleteDb;
use Elhelper\modules\userStravaModule\db\ActivityDb;
use Elhelper\modules\userStravaModule\model\UserStravaAthleteModel;

class StravaApiWebhookHandleController extends Singleton {
	//Override $_instance. If not. It'll have the last object instance is initialized before this class.
	protected static $_instance;

	public function __init() {
		parent::__init(); // TODO: Change the autogenerated stub
	}



	/*  String update
		 * {\"aspect_type\":\"update\",\"event_time\":1624915141,\"object_id\":5544776569,\"object_type\":\"activity\",\"owner_id\":72408224,\"subscription_id\":194550,\"updates\":{\"title\":\"Run13e\"}}
		 * */

	/*
	 * String created
	 * string(206) "json"
	 * {\"aspect_type\":\"create\",
	 * \"event_time\":1624913616,
	 * \"object_id\":5544776569,
	 * \"object_type\":\"activity\",
	 * \"owner_id\":72408224,
	 * \"subscription_id\":194550,
	 * \"updates\":{}}"||
	 * time: 28-06-2021 20:06:38"
	 * */

	public function verifyWebhookStrava() {
		$json    = file_get_contents( "php://input" );
		$headers = getallheaders();
//		write_log( 'header' . json_encode( $headers ) );
		write_log( 'json' . json_encode( $json ) );
//		$json = str_replace( "\\", '', $json );
//		write_log( $json );
		$json = phpJson_decode( $json );
//		write_log( $json );
		write_log( 'aspect_type|||' . $json['aspect_type'] );

		//aspect_type ['update','create');
//		if ( $json['aspect_type'] == 'update' && $json['object_type'] == 'activity' ) {
		if ( $json['aspect_type'] == EVENT_TYPE && $json['object_type'] == 'activity' ) {
			$user_objs = UserStravaAthleteModel::getUserIdByAthlete( $json['owner_id'] );
			write_log( $user_objs->ID );
			write_log( $user_objs->username );
			if ( ! empty( $user_objs ) ) {
				write_log( 'has user_object' );
				$userAthlete = new UserStravaAthleteModel( $user_objs->ID );
//				$products    = inspire_get_list_purchased_product_by_user_object( $user_objs );
				$challenges = ChallengeDb::getAllChallenge();
				$activity   = new \Elhelper\modules\activityModule\model\ActivityStravaModel();
				$res        = $activity->getActivityInfo( $user_objs->ID, $json['object_id'] );
				//Type of activity. For example - Run, Ride etc.
				if ( ! empty( $challenges ) ) {
					if ( $res->type == 'Run' || true ) {
						write_log( 'added_athlete_total_distance' );
						$userAthlete->addAthleteTotalDistance( $res->distance );
						$activity_history = new ActivityDb();
						$activity_history->insert( [
							'athlete_id'  => $res->athlete->id,
							'type'        => $res->type,
							'activity_id' => $res->id,
							'distance'    => $res->distance,
							'moving_time' => $res->distance
						] );

						/*	foreach ( $products as $product_id ) {
								if ( ! empty( $res ) ) {
									$userAthlete->addDistanceOfUserOfProduct( $product_id, $res->distance );
									write_log( 'added distance to productid' . __FILE__ . __LINE__ );
								} else {
									write_log( 'Empty activity distance' . __FILE__ . __LINE__ );
								}
							}*/
						//add activity to history challenge run
						foreach ( $challenges as $challenge ) {
							$challengeModel = new ChallengeModel( $challenge );
							if ( $challengeModel->canInsertDistanceToChallenge() ) {
								$history_chal_ath = new HistoryChallengeAthleteDb();
								$history_chal_ath->insert( [
									'challenge_id' => $challenge->id,
									'activity_id'  => $res->id
								] );
								if ( $challengeModel->checkIfCanFinishChallenge() ) {
									$challengeModel->activeFinishedEventChallenge();
								}

							}
						}
					}
				}
			} else {
				write_log( 'not have user_obj' );
			}

			return true;
		} else {
			write_log( 'not activity created' . __FILE__ . __LINE__ );

			return false;
		}

	}

	public function verifyAccessTokenStrava() {

		return true;
	}

}