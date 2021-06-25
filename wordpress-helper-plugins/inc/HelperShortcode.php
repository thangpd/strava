<?php
/**
 * Date: 11/25/20
 * Time: 3:36 PM
 */

namespace Elhelper\inc;


class HelperShortcode {
	public static function convertAddressToUrl( $address = '' ) {
		if ( ! empty( $address ) ) {
			//805 PEACHTREE ST NE UNIT 416 ATLANTA, GA 30308
			//805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308';

//1325 Peachtree St NE Apt 202, Atlanta GA 30309-3249
//			1325+Peachtree+St+NE+Apt+202-Atlanta-GA-30309
			$res     = explode( ',', $address );
			$res_str = '';
			for ( $i = 0; $i < count( $res ); $i ++ ) {
				if ( $i == 0 ) {
					$res_str .= str_replace( ' ', '+', $res[ $i ] );
				} else {
					$res_str .= str_replace( ' ', '-', $res[ $i ] );
				}
			}

			return $res_str;
		} else {
			return false;
		}
	}

	public static function crawlingData( $address ) {
		// do something to $content
		// always return
//		$content = 'https://www.bhhs.com/home-value';
//		$content = 'https://bhhs.findbuyers.com/address/805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308';
		$curl = curl_init();
//		$proxy = '45.32.106.145:3128';
//		curl_setopt($curl, CURLOPT_PROXY, $proxy);
		curl_setopt( $curl, CURLOPT_URL, $address );
//		curl_setopt( $curl, CURLOPT_FAILONERROR, true );
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		$result = curl_exec( $curl );
		curl_close( $curl );

		return $result;

	}

	// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

	public static function callAPI( $method, $url, $data = false, $raw_body = '' ) {
		$curl = curl_init();
		switch ( $method ) {
			case "POST":
				curl_setopt( $curl, CURLOPT_POST, 1 );

				if ( $data ) {
					$raw_body = json_encode( $raw_body );
					curl_setopt( $curl, CURLOPT_POSTFIELDS, $raw_body );
					$url = sprintf( "%s?%s", $url, http_build_query( $data ) );
					curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
				}
				break;
			case "PUT":
				curl_setopt( $curl, CURLOPT_PUT, 1 );
				break;
			default:
				if ( $data ) {
					$url = sprintf( "%s?%s", $url, http_build_query( $data ) );
				}
		}

		// Optional Authentication:
		curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $curl, CURLOPT_USERPWD, "username:password" );

		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

		$result = curl_exec( $curl );

		curl_close( $curl );

		return $result;
	}


	//example using with wp http
	public function call_remote_api( $url, $method, $access_token, $params = [] ) {
		$http     = new \WP_Http();
		$default  = [ 'access_token' => $access_token ];
		$params   = array_merge( $params, $default );
		$response = $http->request( $url, array( 'method' => $method, 'body' => $params ) );

		return $response;
	}

}