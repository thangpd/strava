<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/18/21
 * Time: 1:39 PM
 */

namespace Elhelper\model;

use Elhelper\common\Model;
use Elhelper\modules\stravaApiModule\models\StravaAccessToken;
use Strava\Builder\MessageBuilder;
use Strava\Exceptions\StravaSDKException;
use Strava\Strava;
use Strava\StravaEndPoint;
use Strava\FileUpload\StravaFile;
use Elhelper\inc\HeplerStrava;

class TechvsiStravaModel extends Model {

	private $access_token;
	private $appid;
	private $config;
	private $strava;
	private $helper;


	public function __construct() {
		$stravaAccessToken = new StravaAccessToken();
		$opt_at          = $stravaAccessToken->getStravaAccessToken();
		$opt_appid       = $stravaAccessToken->getAppID();

		if ( empty( $opt_appid ) ) {
			return;
		}

		$this->access_token = $opt_at;
		$this->appid        = $opt_appid;
		$this->config       = array(
			'app_id'       => $this->appid,
			//Only need for Social Api
			'app_secret'   => '',
			'callback_url' => ''
			//Only need for Social Api
		);
		try {
			$this->strava   = new Strava( $this->config );
			$this->helper = new HeplerStrava();
		} catch ( StravaSDKException $e ) {
			throw new StravaSDKException( $e->getMessage() );
		}
	}


	public function getOAInformation() {
		if ( ! empty( $this->access_token ) ) {
			try {
				$response = $this->strava->get( StravaEndPoint::API_OA_GET_PROFILE, $this->access_token, [] );
			} catch ( StravaSDKException $e ) {
				$e->getMessage();
			}
			$result = $response->getDecodedBody(); // result

			return $result;
		}
	}


	public function getInfoUser( $user_id ) {

		if ( ! empty( $this->access_token ) ) {
			$data = [
				'data' => json_encode( array(
					'user_id' => $user_id
				) )
			];
			try {
				$response = $this->strava->get( StravaEndpoint::API_OA_GET_USER_PROFILE, $this->access_token, $data );
			} catch ( StravaSDKException $e ) {
				throw( new StravaSDKException( $e->getMessage() ) );
			}

			return $response->getDecodedBody(); // result
		}
	}

	public function getListSubscribers( $offset = 0, $count = 10 ) {
		if ( ! empty( $this->access_token ) ) {
			$data = [
				'data' => json_encode( array(
					'offset' => $offset,
					'count'  => $count
				) )
			];
			try {
				$response = $this->strava->get( StravaEndPoint::API_OA_GET_LIST_FOLLOWER, $this->access_token, $data );
			} catch ( StravaSDKException $e ) {
				throw ( new StravaSDKException( $e->getMessage() ) );
			}
			$result = $response->getDecodedBody(); // result

			return $result;
		}
	}

	public function getRecentMessage( $offset = 0, $count = 10 ) {
		if ( ! empty( $this->access_token ) ) {
			$data = [
				'data' => json_encode( array(
					'offset' => $offset,
					'count'  => $count,
				) )
			];
			try {
				$response = $this->strava->get( StravaEndPoint::API_OA_GET_LIST_RECENT_CHAT, $this->access_token, $data );
			} catch ( StravaSDKException $e ) {
				throw new StravaSDKException( $e->getMessage() );
			}
			$result = $response->getDecodedBody(); // result

			return $result;
		}
	}

	/**
	 * Get recent with subscriber message
	 *
	 * @params $user_id int
	 * @params $offset
	 * @params $count
	 * @return array
	 */
	public function getRecentWithSubMessage( $user_id, $offset = 0, $count = 10 ) {

		if ( ! empty( $this->access_token ) ) {
			$user_id = (int) $user_id;
			if ( is_integer( $user_id ) ) {
				$data     = [
					'data' => json_encode( array(
						'user_id' => $user_id,
						'offset'  => $offset,
						'count'   => $count,
					) )
				];
				$response = '';
				try {
					$response = $this->strava->get( StravaEndPoint::API_OA_GET_CONVERSATION, $this->access_token, $data );
				} catch ( StravaSDKException $e ) {
					write_log( $e->getMessage() );
				}
				$result = $response->getDecodedBody(); // result

				return $result;
			} else {
				return [ 'mess' => 'user id not integer', 'code' => 500 ];
			}
		}
	}


	public function sendMessageToListRecipient(
		$user_id, $message, $type = 'text', $args = array(
		'elements' => [],
		'buttons'  => [],
		'image'    => null
	)
	) {
		//text
		try {
			$mess = new MessageBuilder( $type );
		} catch ( StravaSDKException $exception ) {
			throw( new StravaSDKException( $exception->getMessage() ) );
		}
		$mess->withUserId( $user_id );
		$mess->withText( $message );


		if ( count( $args['elements'] ) > 0 ) {
			foreach ( $args['elements'] as $index => $el ) {
				$smsText = isset( $el['sms'] ) ? $el['sms'] : '';
				$mess->withElement(
					$el['title'],
					$el['thumb'],
					$el['description'],
					$this->helper->getActionMessageBy( $mess, $el['action'], $el['value'], $smsText )
				);
			}
		}

		if ( count( $args['buttons'] ) > 0 ) {
			foreach ( $args['buttons'] as $index => $btn ) {
				if ( $index == 5 ) {
					break;
				}
				$smsText = isset( $btn['sms'] ) ? $btn['sms'] : '';
				$mess->withButton( $btn['label'], $this->helper->getActionMessageBy( $mess, $btn['action'], $btn['value'], $smsText ) );
			}
		}

		if ( ! empty( $args['image'] ) ) {
			// $mess->withMediaSize('50', '50');
			// $mess->withMediaType('image');
			$mess->withAttachment( $args['image'] );
		}


		$msgText = $mess->build();

		try {
			$response = $this->strava->post( StravaEndPoint::API_OA_SEND_MESSAGE, $this->access_token, $msgText );
		} catch ( StravaSDKException $exception ) {
			throw( new StravaSDKException( $exception->getMessage() ) );
		}
		$res = $response->getDecodedBody(); // result

		return $res;
	}

	public function uploadWith( $type, $filePath ) {
		try {
			$data     = array( 'file' => new StravaFile( $filePath ) );
			$response = $this->strava->post( $this->helper->getUploadEndpoint( $type ), $this->access_token, $data );
		} catch ( StravaSDKException $e ) {
			throw new StravaSDKException( $e->getMessage() );
		}
		$res = $response->getDecodedBody(); // result

		return $res;
	}


}