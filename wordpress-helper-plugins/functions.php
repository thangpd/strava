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

if ( ! function_exists( 'phpJson_decode' ) ) {
	function phpJson_decode( $string ) {
		$custom = $string ? json_decode( str_replace( '\\', '', $string ), true ) : '';

		return $custom;
	}
}


add_shortcode( 'my_purchased_products', 'bbloomer_products_bought_by_user_id' );

function inspire_doshortcode_product_lists( $product_ids ) {
	$product_ids_str = implode( ",", $product_ids );

	// PASS PRODUCT IDS TO PRODUCTS SHORTCODE
	return do_shortcode( "[products ids='$product_ids_str']" );
}

function bbloomer_products_bought_by_user_id( $user_id ) {

	// GET CURR USER
	$user_obj = get_user_by( 'id', $user_id );
	if ( 0 == $user_obj->ID ) {
		return;
	}
	$product_ids = inspire_get_list_purchased_product_by_user_object( $user_obj );

	return $product_ids;
}

function inspire_get_list_purchased_product_by_user_object( WP_User $user_obj ) {

	// GET USER ORDERS (COMPLETED + PROCESSING)
	$customer_orders = get_posts( array(
		'numberposts' => - 1,
		'meta_key'    => '_customer_user',
		'meta_value'  => $user_obj->ID,
		'post_type'   => wc_get_order_types(),
		'post_status' => array_keys( wc_get_is_paid_statuses() ),
	) );

	// LOOP THROUGH ORDERS AND GET PRODUCT IDS
	if ( ! $customer_orders ) {
		return;
	}
	$product_ids = array();
	foreach ( $customer_orders as $customer_order ) {
		$order = wc_get_order( $customer_order->ID );
		$items = $order->get_items();
		foreach ( $items as $item ) {
			$product_id    = $item->get_product_id();
			$product_ids[] = $product_id;
		}
	}
	$product_ids = array_unique( $product_ids );

	return $product_ids;
}




