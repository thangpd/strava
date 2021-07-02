<?php

namespace Elhelper\mail;

class Template {

	public static function action_sendmail( $product_id, $user_id, $template_number ) {
		$template_email = Template::getDataEmailTemplate( $product_id, $user_id, $template_number );
		$userObj        = get_user_by( 'id', $user_id );
		$useremail      = $userObj->data->user_email;
		if ( ! empty( $useremail ) ) {
			self::send_mail( $useremail, 'The Mount begins', $template_email );
		}
	}

	public static function getDataEmailTemplate( $user_id, $product_id, $template_number ) {
		switch ( $template_number ) {
			case 0:
				$image_template_cover  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/CoverEverFinal.png';
				$image_template_footer = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/E.Footer.png';
				$line                  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/images/line.png';
				$product               = wc_get_product( $product_id );
				if ( ! empty( $product ) ) {
					$product_title = $product->get_title();
					$product_link  = $product->get_permalink();
				} else {
					$product_title = 'Product Empty';
					$product_link  = '#';
				}
				$title        = '';
				$template_dir = Template::get_template_dir( 0 );
				$included     = require $template_dir;

				return $included;
				break;
		}
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
		$headers = 'From: ' . $email_to . "\r\n" .
		           'Reply-To: ' . 'finishing@inspiretrails.life' . "\r\n";

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