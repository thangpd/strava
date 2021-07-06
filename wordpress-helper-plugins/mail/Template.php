<?php

namespace Elhelper\mail;

class Template {

	public static function action_sendmail( $product_id, $user_id, $template_number, $title ) {
		$template_email = Template::getDataEmailTemplate( $product_id, $user_id, $template_number );
		$userObj        = get_user_by( 'id', $user_id );
		$useremail      = $userObj->data->user_email;
		if ( ! empty( $useremail ) ) {
			$res = self::send_mail( $useremail, $title, $template_email );
			write_log( json_encode( $res ) . __FILE__ . __LINE__ );
		}
	}

	public static function getDataEmailTemplate( $product_id, $user_id, $template_number ) {
		switch ( $template_number ) {
			case 0:
				$header  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/header.png';
				$footer  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/footer.png';
				$line    = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/images/line.png';
				$product = wc_get_product( $product_id );
				if ( ! empty( $product ) ) {
					$product_title = $product->get_title();
					$product_link  = $product->get_permalink();
				} else {
					$product_title = 'Product Empty';
					$product_link  = '#';
				}
				$title        = '';
				$template_dir = Template::get_template_dir( 0 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 1:
				$image_template_cover = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/25percent/CoverEver25.png';
				$footer               = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/E.Footer.png';
				$line                 = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/images/line.png';
				$product              = wc_get_product( $product_id );
				$userModel            = get_user_by( 'id', $user_id );
				$username             = $userModel->data->user_nicename;
				$sidebar_image        = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/25percent/sherpa.png';

				if ( ! empty( $product ) ) {
					$product_title = $product->get_title();
					$product_link  = $product->get_permalink();
				} else {
					$product_title = 'Product Empty';
					$product_link  = '#';
				}
				$title        = '';
				$template_dir = Template::get_template_dir( 1 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 2:
				$header  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/50percent/header.png';
				$footer  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/E.Footer.png';
				$line    = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/images/line.png';
				$product = wc_get_product( $product_id );
				if ( ! empty( $product ) ) {
					$product_title = $product->get_title();
					$product_link  = $product->get_permalink();
				} else {
					$product_title = 'Product Empty';
					$product_link  = '#';
				}
				$userModel     = get_user_by( 'id', $user_id );
				$username      = $userModel->data->user_nicename;
				$sidebar_image = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/50percent/sidebar.png';
				$template_dir  = Template::get_template_dir( 2 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 3:
				$image_template_cover  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/75percent/header.png';
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

				$userModel     = get_user_by( 'id', $user_id );
				$username      = $userModel->data->user_nicename;
				$template_dir  = Template::get_template_dir( 3 );
				$sidebar_image = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/75percent/sidebar.png';

				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 4:
				$header  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/100percent/header.png';
				$footer  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/E.Footer.png';
				$line    = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/images/line.png';
				$product = wc_get_product( $product_id );
				if ( ! empty( $product ) ) {
					$product_title = $product->get_title();
					$product_link  = $product->get_permalink();
				} else {
					$product_title = 'Product Empty';
					$product_link  = '#';
				}
				$site_link=home_url();
				$body_1 = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/100percent/body_1.png';
				$body_2 = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/100percent/body_2.jpeg';

				$title        = '';
				$template_dir = Template::get_template_dir( 4 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			case 5:
				$header  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/CoverEverFinal.png';
				$footer= plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/begin/E.Footer.png';
				$line                  = plugin_dir_url( dirname( __FILE__ ) ) . '/mail/assets/images/line.png';
				$template_dir = Template::get_template_dir( 5 );
				ob_start();
				require $template_dir;
				$included = ob_get_clean();
				break;
			default:
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
		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		$send    = wp_mail( $to, $subject, $message, $headers );

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