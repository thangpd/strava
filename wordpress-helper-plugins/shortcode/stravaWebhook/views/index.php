<?php

use Spatie\Async\Pool;

$mypool = Pool::create();

echo 'this is webhook';
define( 'OA_SECRET_KEY', "MdAsoWetdBd3xyUA5wzu" );
$transient = get_transient( 'debug_receive_hook' );
if ( ! empty( $transient ) ) {
	print_r( $transient );
} else {

}

$json    = file_get_contents( "php://input" );
$headers = getallheaders();
$data    = json_decode( $json, false, 512, JSON_BIGINT_AS_STRING );

if ( ! empty( $headers ) && ! empty( $data ) ) {
	set_transient( 'debug_receive_hook', $data );
}

function setInterval( $f, $milliseconds ) {
	$seconds = (int) $milliseconds / 1000;
	while ( true ) {
		$f();
		sleep( $seconds );
	}
}

function search( $user_id ) {
	$waiting = get_transient( 'waiting2' );

	if ( ! $waiting ) {
		$users = [
			$user_id
		];
		set_transient( 'waiting2', $users );

		return null;
	} else {
		array_push( $waiting, $user_id );
		delete_transient( 'waiting2' );
		set_transient( 'waiting2', $waiting );
	}

	$not_me_l = array_diff( $waiting, array( $user_id ) );

	if ( count( $not_me_l ) > 0 ) {
		return $not_me_l[ array_rand( $not_me_l ) ];
	} else {
		return null;
	}
}

function check_connect( $user_id ) {
	$connected = get_transient( 'connected' );

	if ( $connected ) {
		$target = null;
		foreach ( $connected as $cn ) {
			if ( $cn['from'] == $user_id ) {
				return $cn['to'];
			}
		}

		return $target;
	}

	return false;
}

function make_connect( $user_id, $target_id ) {
	removeWaiting( $user_id, $target_id );

	$connected = get_transient( 'connected' );

	if ( ! $connected ) {
		$couple = [
			array(
				'from' => $user_id,
				'to'   => $target_id
			),
			array(
				'from' => $target_id,
				'to'   => $user_id
			)
		];
		set_transient( 'connected', $couple );
	} else {
		array_push( $connected,
			array(
				'from' => $user_id,
				'to'   => $target_id
			),
			array(
				'from' => $target_id,
				'to'   => $user_id
			)
		);
		delete_transient( 'connected' );
		set_transient( 'connected', $connected );
	}
}

function removeConection( $user_id ) {
	$connected = get_transient( 'connected' );
	$array     = [];
	$target    = null;

	if ( $connected ) {
		foreach ( $connected as $cn ) {
			if ( $cn['from'] === $user_id ) {
				$target = $cn['to'];
			}
			if ( $cn['from'] === $user_id || $cn['to'] === $user_id ) {
				array_push( $array, $cn );
			}
		}

		$refresh_connected = array_diff( $connected, $array );
		delete_transient( 'connected' );
		set_transient( 'connected', $refresh_connected );

		return $target;
	}

	return false;
}

function removeWaiting( ...$users_id ) {
	$waiting2        = get_transient( 'waiting2' );
	$refresh_waiting = array_diff( $waiting2, $users_id );
	delete_transient( 'waiting2' );
	set_transient( 'waiting2', $refresh_waiting );
}

if ( 0 < strlen( $json ) && isset( $headers["X-Zevent-Signature"] ) ) :
	if ( $data ) :
		// Calculate the MAC value from received data
		$mac_1 = "mac=" . hash( "sha256", $data->app_id . $json . $data->timestamp . OA_SECRET_KEY );
		$mac_2 = $headers["X-Zevent-Signature"];

		if ( 0 === strcmp( $mac_1, $mac_2 ) ) :
			$event_type     = $data->event_name;
			$transient_at   = 'kQjKReIRaX-qf5LhXfoT5hAjLM60YffLqR0zGx71ccJpYJPikEka6v2W22lisQOAnByF7ud-mokrj14PyyYtRPEKUHpcoEKJZxPBOScAWs2QspzYp8A2QBo_2KdwZuu_nzyoIPsSg63mucLjiQZRR_BbOdYPizGCvTPy1uQSzGwxp4iGqQFL3PxlPIJoZTjKk_PqKSQft2IjrdSNpAZQ0P7hSdpGpzHGl999PfJIscoZj4jlaCp_JQUkEMBQbeTrkiyPMztsY6UzpGvHpfJ8UVBP1ac0dhfbDJS52Vz4ZuoQ7W';
			$transient_oaId = 2378013480520699910;
			if ( ! empty( $transient_oaId ) && ! empty( $transient_at ) ) {
				$strava        = new \Elhelper\model\TechvsiStravaModel();
				$res_message = $data->message->text;

				// delete_transient('waiting2');
				// delete_transient('connected');

				// return;

				if ( check_connect( $data->sender->id ) ) {
					if ( strtolower( $res_message ) == 'bye' ) {
						$type    = 'text';
						$partner = removeConection( $data->sender->id );
						if ( $partner ) {
							$message = 'End.';
							$strava->sendMessageToListRecipient( $data->sender->id, $message, 'text' );
							$strava->sendMessageToListRecipient( $partner, $message, 'text' );
						}
					}


					// $strava->sendMessageToListRecipient( check_connect($data->sender->id) , $event_type, 'text');

					// return;

					switch ( $event_type ) {
						case 'user_send_text':
							$strava->sendMessageToListRecipient( check_connect( $data->sender->id ), $res_message, 'text' );
							break;
						case 'user_send_sticker':
							$res   = $strava->uploadWith( 'image', $data->message->attachments[0]->payload->url );
							$image = $res['data']['attachment_id'];
							$strava->sendMessageToListRecipient( check_connect( $data->sender->id ), 'dsadsa', 'media', array(
								'image' => $image
							) );
							break;
						case 'user_send_gif':
							$res   = $strava->uploadWith( 'gif', $data->message->attachments[0]->payload->url );
							$image = $res['data']['attachment_id'];
							$strava->sendMessageToListRecipient( check_connect( $data->sender->id ), 'dsadsa', 'media', array(
								'image' => $image
							) );
							break;
					}

					return;
				}

				switch ( strtolower( $res_message ) ) {
					case 'say hi':
						$type    = 'text';
						$message = 'Vui lòng chờ đợi..';

						$mypool
							->add( function () use ( $data, $strava, $res_message ) {
								// $target = null;
								// $count = 0;

								// while($target == null) {
								// 	$count++;
								$target = search( $data->sender->id );

								if ( $target !== null ) {
									make_connect( $data->sender->id, $target );

									return $target;
								}

								// if($count > 5) {
								// 	$target = 'No one';
								// 	// 	$waiting2 = get_transient('waiting2');
								// 	// 	$refresh_waiting = array_diff($waiting2, array($data->sender->id));
								// 	// 	delete_transient('waiting2');
								// 	// 	set_transient('waiting2', $refresh_waiting);
								// }

								// 	sleep(1);
								// }			

								return false;
							} )
							->then( function ( $partner ) use ( $data, $strava ) {
								// if($count > 10) {
								// 	$target = 'No one';
								// 	$waiting2 = get_transient('waiting2');
								// 	$refresh_waiting = array_diff($waiting2, array($data->sender->id));
								// 	delete_transient('waiting2');
								// 	set_transient('waiting2', $refresh_waiting);
								// }

								// sleep(1);

								if ( $partner ) {
									$message = "Đã ghép nối!";
									$strava->sendMessageToListRecipient( $data->sender->id, $message, 'text' );
									$strava->sendMessageToListRecipient( $partner, $message, 'text' );
								}
							} )
							->catch( function ( $exception ) {
								// When an exception is thrown from within a process, it's caught and passed here.
							} )
							->timeout( function () {
								// Ohh No! A process took too long to finish. Let's do something
							} );

						$mypool->wait();

						break;
					case '#datmon':
						$type    = 'media';
						$message = 'Vui lòng chọn món';
						$buttons = [
							array(
								'value'  => '#canhchua',
								'action' => 'query_show',
								'label'  => 'Canh chua'
							),
							// array(
							// 	'value' => '#suonheo',
							// 	'action' => 'query_show',
							// 	'label' => 'Sườn heo'
							// ),
							array(
								'value'  => '#caloc',
								'action' => 'sms',
								'sms'    => 'This is text SMS',
								'label'  => 'SMS Cá lóc'
							),
							array(
								'value'  => '#xemthem',
								'action' => 'query_hide',
								'label'  => 'Thêm món'
							)
						];
						$res     = $strava->uploadWith( 'image', 'https://motogo.vn/wp-content/uploads/2019/11/mon-ngon-da-nang-min.jpg' );
						$image   = $res['data']['attachment_id'];
						break;
					case '#canhchua':
						$type    = 'media';
						$message = 'Bạn chọn canh chua';
						// $res = $strava->uploadWith( 'image', plugin_dir_path( __DIR__  ) . 'assets\qr_stravacode.jpg' );
						$res   = $strava->uploadWith( 'image', 'https://icdn.dantri.com.vn/2018/5/22/photo-11-15269813002722095304393.jpg' );
						$image = $res['data']['attachment_id'];
						break;
					case '#xemthem':
						$message = 'Chọn món thêm';
						$buttons = [
							array(
								'value'  => '#suonheo',
								'action' => 'query_show',
								'label'  => 'Sườn heo'
							)
						];
						break;
					// default : 
					// 	$type = 'list';
					// 	$elements = [
					// 		array(
					// 			'action' => 'query_show',
					// 			'value' => '#canhchua',
					// 			'title' => 'Canh chua',
					// 			'description' => 'test test',
					// 			'thumb' => 'https://motogo.vn/wp-content/uploads/2019/11/mon-ngon-da-nang-min.jpg'
					// 		),
					// 		array(
					// 			'action' => 'query_show',
					// 			'value' => '#canhchua',
					// 			'title' => 'Canh chua',
					// 			'description' => 'test test',
					// 			'thumb' => 'https://img.icons8.com/bubbles/2x/google-logo.png'
					// 		),
					// 		array(
					// 			'action' => 'query_show',
					// 			'value' => '#canhchua',
					// 			'title' => 'Canh chua',
					// 			'description' => 'test test',
					// 			'thumb' => 'https://img.icons8.com/bubbles/2x/google-logo.png'
					// 		),
					// 		array(
					// 			'action' => 'query_show',
					// 			'value' => '#canhchua',
					// 			'title' => 'Canh chua',
					// 			'description' => 'test test',
					// 			'thumb' => 'https://img.icons8.com/bubbles/2x/google-logo.png'
					// 		),
					// 		array(
					// 			'action' => 'query_show',
					// 			'value' => '#canhchua',
					// 			'title' => 'Canh chua',
					// 			'description' => 'test test',
					// 			'thumb' => 'https://img.icons8.com/bubbles/2x/google-logo.png'
					// 		)
					// 	];
					// 	break;
				}

				if ( ! empty( $type ) ) {
					$image   = ! empty( $image ) ? $image : null;
					$buttons = ! empty( $buttons ) ? $buttons : [];
					$strava->sendMessageToListRecipient( $data->sender->id, $message, $type, array(
						'elements' => $elements,
						'buttons'  => $buttons,
						'image'    => $image
					) );
				}
			}
		endif;
	endif;
endif;








