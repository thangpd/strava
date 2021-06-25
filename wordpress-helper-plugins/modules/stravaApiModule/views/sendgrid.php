<?php
/**
 * Date: 3/4/21
 * Time: 2:26 PM
 */


$email = new \SendGrid\Mail\Mail();
$email->setFrom("testthang@gomsu.fun", "Thomas SendGrid");
$email->setSubject("Sending with SendGrid is Fun");
$email->addTo("thang.pham@techvsi.com", "Thomas test");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
	"text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$getenv   = getenv( 'SENDGRID_API_KEY' );
/*echo '<pre>';
print_r($getenv);
echo '</pre>';
echo '<pre>';
print_r($_ENV);
echo '</pre>';
var_dump(getenv('path')); // bool(false)
var_dump(getenv('Path')); // bool(false)
var_dump(getenv('PATH')); // string(13) "/usr/bin:/bin"
die;*/
//$sendgrid = new \SendGrid( '' );
//try {
//	$response = $sendgrid->send($email);
//	print $response->statusCode() . "\n";
//	print_r($response->headers());
//	print $response->body() . "\n";
//} catch (Exception $e) {
//	echo 'Caught exception: '. $e->getMessage() ."\n";
//}