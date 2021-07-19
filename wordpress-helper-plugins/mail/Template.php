<?php

namespace Elhelper\mail;

use Elhelper\modules\productStravaModule\db\ChallengeDb;
use Elhelper\modules\productStravaModule\model\ChallengeModel;

class Template {

	public static function action_sendmail( $product_id, $user_id, $template_number ) {
//		$challenge = ChallengeModel::getChallengeByProductIdAndUserId( $product_id, $user_id );
		$userObj        = get_user_by( 'id', $user_id );
		$useremail      = $userObj->data->user_email;
		$product       = wc_get_product( $product_id );
		if ( ! empty( $product ) ) {
			$product_name = $product->get_title();
		} else {
			$product_name = 'Product Title Empty';
		}
		$title          = [
			'Chào mừng ' . $userObj->data->user_nicename . ' đến với Thử Thách ' . $product_name,
			'Reached 25% Milestone',
			'Reached 50% Milestone',
			'Reached 75% Milestone',
			'Reached 100% Milestone'
		];
		$template_email = Template::getDataEmailTemplate( $product_id, $user_id, $template_number );

		write_log( 'sent mail product_id' . $product_id . 'user' . $user_id . 'template.' . $template_number );

		if ( ! empty( $useremail ) ) {
			$subject = $title[ $template_number ];
			write_log( $subject );
			$res = self::send_mail( $useremail, $subject, $template_email );
			write_log( json_encode( $res ) . __FILE__ . __LINE__ );
		}
	}

	public static function getDataEmailTemplate( $product_id, $user_id, $template_number ) {
		$footer        = get_field( 'footer_image', $product_id );
		$facebook_link = get_field( 'footer_link_facebook', $product_id );
		$line          = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/images/line.png';
		$product       = wc_get_product( $product_id );
		if ( ! empty( $product ) ) {
			$product_title = $product->get_title();
		} else {
			$product_title = 'Product Title Empty';
		}
		$product_link = get_field( 'link_product_detail', $product_id );
		if ( ! empty( $product_link ) ) {
			$product_link = $product_link['url'];
		} else {
			$product_link = '#';
		}
		switch ( $template_number ) {
			case 0:
				//begin
//				$header               = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/header.png';
				$header               = get_field( 'begin_header_image', $product_id );
				$link_trang_trong_cay = get_field( 'begin_link_trang_trong_cay', $product_id );
				$template_dir         = Template::get_template_dir( 0 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 1:
				//25%
//				$header        = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/25percent/header.png';
				$header        = get_field( '25_header_image', $product_id );
				$userModel     = get_user_by( 'id', $user_id );
				$username      = $userModel->data->user_nicename;
				$sidebar_image = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/25percent/sherpa.png';

				$template_dir = Template::get_template_dir( 1 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 2:
				//50%
//				$header        = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/50percent/header.png';
				$header = get_field( '50_header_image', $product_id );
//				$sidebar_image = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/50percent/sidebar.png';
				$sidebar_image = get_field( '50_sidebar_image', $product_id );

				$userModel    = get_user_by( 'id', $user_id );
				$username     = $userModel->data->user_nicename;
				$template_dir = Template::get_template_dir( 2 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 3:
				//75%
//				$header        = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/75percent/header.png';
				$header = get_field( '75_header_image', $product_id );
//				$sidebar_image = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/75percent/sidebar.png';
				$sidebar_image = get_field( '75_sidebar_image', $product_id );
				$userModel     = get_user_by( 'id', $user_id );
				$username      = $userModel->data->user_nicename;
				$template_dir  = Template::get_template_dir( 3 );

				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 4:
				//100%
//				$header       = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/100percent/header.png';
				$header      = get_field( '100_header_image', $product_id );
				$header      = get_field( '100_header_image', $product_id );
				$site_link   = home_url();
				$medal       = get_field( '100_medal', $product_id );
				$certificate = get_field( '100_certificate', $product_id );
//				$body_2       = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/100percent/body_2.jpeg';
				$userModel    = get_user_by( 'id', $user_id );
				$username     = $userModel->data->user_nicename;
				$template_dir = Template::get_template_dir( 4 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 5:
				//3days before expired
				$header       = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/header.png';
				$template_dir = Template::get_template_dir( 5 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			default:
				$header  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/header.png';
				$line    = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/images/line.png';
				$product = wc_get_product( $product_id );
				if ( ! empty( $product ) ) {
					$product_title = $product->get_title();
				} else {
					$product_title = 'Product Empty';
				}
				$template_dir = Template::get_template_dir( 0 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
		}

		return $included;


	}

	/**
	 * @param string template name
	 * @param
	 * 0 begin
	 * 1 reach-25
	 * 2 reach-50
	 * 3 reach-75
	 * 4 reach-100
	 * 5 days-left-to-finish
	 *
	 */
	public static function get_template_dir( $template_num = 0 ) {
		switch ( $template_num ) {
			case 0:
				return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'begin.php';
				break;
			case 1:
				return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'reach-25.php';
				break;
			case 2:
				return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'reach-50.php';
				break;
			case 3:
				return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'reach-75.php';
				break;
			case 4:
				return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'reach-100.php';
				break;
			case 5:
				return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'days-left-to-finish.php';
				break;
			default:
				return false;
				break;
		}

	}

	public
	static function send_mail(
		$email_to, $subject, $message
	) {
		$to      = "$email_to";
		$subject = "$subject";
//		$headers = 'From: ' . $email_to . "\r\n" .
//		           'Reply-To: ' . 'finishing@inspiretrails.life' . "\r\n";
		$headers = 'Content-Type: text/html; charset=UTF-8';
		write_log( 'to: ' . $to . '//subject:' . $subject . '//message:' . $message . '//headers:' . $headers );
		$send = wp_mail( $to, $subject, $message, $headers );

		return $send;
	}

	public
	function action_send_mail(
		$template, $product_id, $email = ''
	) {
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => 1,
			'post__in'       => array( $product_id )
		);

		$product = new \WP_Query( $args );

		if ( $product->have_posts() ) {
			while ( $product->have_posts() ) : $product->the_post();
				$title = the_title();
			endwhile;
		}

		wp_reset_postdata();

		$email_template = self::get_template_dir( $template );
		ob_start();
		require $email_template;
		$message = ob_get_clean();

		$result = self::send_mail( $email, 'test subject', $message );

		return $result;
	}
}