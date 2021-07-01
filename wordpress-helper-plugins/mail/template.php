<?php 
namespace Elhelper\Mail;

class Template {
    
    /**
     * @param string template name 
     * @param 
     */
    public static function get_template_dir( $template_name = '' ) {
        if( $template_name != '' ) {
            switch ($template_name) {
                case 'begin':
                    return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'begin.php';
                    break;

                case 'days-left-to-finish':
                    return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'begin.php';
                    break;

                case 'reach-25':
                    return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'begin.php';
                    break;

                case 'reach-50':
                    return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'begin.php';
                    break;
                case 'reach-75':
                    return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'begin.php';
                    break;
                case 'reach-100':
                    return WP_HELPER_PATH . 'mail' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'begin.php';
                    break;
                default:
                    return 'default';
                    break;
            } 
        }
        return false;
    }

    public static function send_mail( $email, $subject, $message ) {
        $to = "$email";
        $subject = "$subject";
        $headers =  'From: '. $email . "\r\n" .
                    'Reply-To: ' . $email . "\r\n";

        $send = wp_mail($to, $subject, $message, $headers);
       
        return $send;
    }

    public function action_send_mail( $template, $product_id, $email = '') {
        $args = array(
			'post_type' 		=> 'product',
			'posts_per_page' 	=> 1,
			'post__in'			=> array( $product_id )
		);

		$product = new \WP_Query( $args );
        		
		if ( $product->have_posts() ) {
            while ( $product->have_posts() ) : $product->the_post();
                $title = the_title();
            endwhile;
        }

        wp_reset_postdata();
        
        $email_template = self::get_template_dir($template);
        ob_start();
            require $email_template;
        $message = ob_get_clean();

        $result = self::send_mail( $email, 'test subject', $message  );

        return $result;
    }
}