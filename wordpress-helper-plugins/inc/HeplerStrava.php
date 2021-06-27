<?php
/**
 * Date: 11/25/20
 * Time: 3:36 PM
 */

namespace Elhelper\inc;


use Elhelper\modules\userStravaModule\model\UserStravaBearerModel;

class HeplerStrava {


	public static function callStravaAPIbk( $url, $bearerToken, $post = [], $method = 'GET' ) {

		$result = [];
		if ( ! empty( $url ) ) {
//			$bearerToken  = "080042cad6356ad5dc0a720c18b53b8e53d4c274";
			$authorization = "Authorization: Bearer " . $bearerToken;
			$ch            = curl_init( $url ); // Initialise cURL
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', $authorization ) );
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $method );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			$result = curl_exec( $ch );
			curl_close( $ch );
		}

		return json_decode( $result );
	}

	public static function callStravaAPI( $url, $bearerToken, $post = [], $method = 'GET' ) {

		$curl = curl_init();

		$headers = array(
			'Authorization: Bearer ' . $bearerToken
		);
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => $method,
			CURLOPT_POSTFIELDS     => $post,
			CURLOPT_HTTPHEADER     => $headers,
		) );

		$response = curl_exec( $curl );

		curl_close( $curl );

		return json_decode( $response );

	}

	public
	static function callGetInfoApi(
		$url, $code, $post = [], $method = 'POST'
	) {
		$result = [];
		if ( ! empty( $code ) ) {
			$ch      = curl_init( $url ); // Initialise cURL
			$options = array(
				CURLOPT_POSTFIELDS     => $post,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING       => '',
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST  => $method,
			);
			curl_setopt_array( $ch, $options );
			$result = curl_exec( $ch );
			curl_close( $ch );
		}

		return json_decode( $result );


	}

	public static function refreshToken( $user_id ) {
		$userBearer = new UserStravaBearerModel( $user_id );
		if ( $userBearer->getExpiresAt() < time() ) {
			$url           = 'https://www.strava.com/api/v3/oauth/token';
			$client_id     = CLIENT_ID;
			$client_secret = CLIENT_SECRET;
			$post          = [
				'client_id'     => $client_id,
				'client_secret' => $client_secret,
				'grant_type'    => 'refresh_token',
				'refresh_token' => $userBearer->getRefreshToken(),
			];

			$objectTokenExchange = HeplerStrava::callApiTokenExchange( $url, $post );
			$userBearer          = new UserStravaBearerModel( $user_id );
			$userBearer->saveObjectBearer( $objectTokenExchange );
		}
	}

	public static function callApiTokenExchange( $url, $post = [], $method = 'POST' ) {

		$result = [];
		if ( ! empty( $url ) ) {
			$ch      = curl_init( $url ); // Initialise cURL
			$options = array(
				CURLOPT_POSTFIELDS     => $post,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING       => '',
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST  => $method,
			);
			curl_setopt_array( $ch, $options );
			$result = curl_exec( $ch );
			curl_close( $ch );
		}

		return json_decode( $result );


	}
}