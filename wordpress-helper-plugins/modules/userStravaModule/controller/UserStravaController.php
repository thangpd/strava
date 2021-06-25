<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/24/21
 * Time: 11:49 PM
 */

namespace Elhelper\modules\userStravaModule\controller;


use Elhelper\common\Controller;
use Elhelper\inc\HeplerStrava;
use Elhelper\modules\userStravaModule\model\UserStravaBearerModel;

class UserStravaController extends Controller {
	private $user_id;

	public function __construct( $user_id ) {
		if ( ! empty( $user_id ) ) {
			$this->user_id = $user_id;
		} else {
			write_log( 'no user id' . __FILE__ . __LINE__ );
		}
	}

	public function deauthorizeStrava() {
		$userBearer   = new UserStravaBearerModel( $this->user_id );
		$access_token = $userBearer->getAccessToken();

		$post = array( 'access_token' => $access_token );

		return HeplerStrava::callStravaAPI( 'https://www.strava.com/oauth/deauthorize', $post, 'GET' );

	}

	public function getInfoAthlete() {
		$userBearer = new UserStravaBearerModel( $this->user_id );

		return HeplerStrava::callStravaAPI( 'https://www.strava.com/api/v3/athlete', $userBearer->getAccessToken() );
	}

	public function getListActivities() {
		$userBearer = new UserStravaBearerModel( $this->user_id );
		$post       = array(
//			'before'   => 0,
//			'after'    => 0,
			'page'     => 1,
			'per_page' => 5,
		);

		return HeplerStrava::callStravaAPI( 'https://www.strava.com/api/v3/athlete/activities', $userBearer->getAccessToken(), $post, 'GET' );
	}


}