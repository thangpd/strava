<?php
/**
 * Date: 2/18/21
 * Time: 10:25 AM
 */


if ( ! function_exists( 'write_log' ) ) {
	function write_log( $log ) {
		$upload_dir   = wp_upload_dir();
		$log_filename = $upload_dir['basedir'] . "/log";
		if ( ! file_exists( $log_filename ) ) {
			// create directory/folder uploads.
			$res = mkdir( $log_filename, 0777, true );
		}
		$log_file_data = $log_filename . '/log_' . date( 'd-M-Y' ) . '.log';
		// if you don't add `FILE_APPEND`, the file will be erased each time you add a log
		ob_start();
		var_dump( $log . "|| time: " . date( 'd-m-Y H:m:s', time() ) );
		$log = ob_get_clean();
		file_put_contents( $log_file_data, $log . "\n", FILE_APPEND );
	}
}



