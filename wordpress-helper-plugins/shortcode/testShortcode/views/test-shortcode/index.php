<?php
/**
 * Date: 2/3/21
 * Time: 5:28 PM
 */

echo '<pre>';
print_r( get_transient( 'receive_webhook_header' ) );
print_r( get_transient( 'receive_webhook_body' ) );
echo '</pre>';


echo '<pre>';
print_r( $context->context );
echo '</pre>';
?>
