<?php 
namespace Elhelper\Mail;

class Template {
    
    /**
     * @param string template name 
     * @param 
     */
    public static function get_template_mail( $template_name = '' ) {
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

    public function action_send_mail( $template, $product) {
        $user = wp_get_current_user();

        if($user && isset($user->user_login) && 'username_to_check' == $user->user_login) {
        
            echo self::get_template_mail('begin');

        }
    }
}