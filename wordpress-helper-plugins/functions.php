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


function inspire_rewrite_activation() {
	inspire_inspire_challenge();
	inspire_history_challenge_athlete();
	inspire_history_athlete();
}

function inspire_inspire_challenge() {
	global $wpdb;
	$table_name      = \Elhelper\modules\productStravaModule\db\ChallengeDb::get_table();
	$charset_collate = $wpdb->get_charset_collate();
	$sql             = "CREATE TABLE `{$table_name}` (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            product_id int(11),
            user_id tinyint(1),
            history_id int(11),
            status tinyint,
            amount_date int(10),
            amount_distance int(10),
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (id)
            ) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
	if ( ! empty( $wpdb->last_error ) ) {
		throw new \Exception( $wpdb->last_error );
	}
}

function inspire_history_challenge_athlete() {
	global $wpdb;
	$table_name      = \Elhelper\modules\stravaApiModule\db\HistoryChallengeAthleteDb::get_table();
	$charset_collate = $wpdb->get_charset_collate();
	$sql             = "CREATE TABLE `{$table_name}` (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            athlete_id int,
            type char(20),
            activity_id_strava int,
            distance float,
            moving_time int,
			created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            ) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
	if ( ! empty( $wpdb->last_error ) ) {
		throw new \Exception( $wpdb->last_error );
	}
}

function inspire_history_athlete() {
	global $wpdb;
	$table_name      = \Elhelper\modules\userStravaModule\db\AthleteDb::get_table();
	$charset_collate = $wpdb->get_charset_collate();
	$sql             = "CREATE TABLE `{$table_name}` (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            product_id int(11),
            activity_id tinyint(1),
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (id)
            ) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
	if ( ! empty( $wpdb->last_error ) ) {
		throw new \Exception( $wpdb->last_error );
	}
}


function inspire_uninstall_hook() {
	inspire_drop_history_challenge_athlete();
	inspire_drop_history_athlete();
	inspire_drop_challenge();
}

function inspire_drop_history_challenge_athlete() {
	global $wpdb;
	$table_name = \Elhelper\modules\stravaApiModule\db\HistoryChallengeAthleteDb::get_table();
	$sql        = "DROP TABLE IF EXISTS `$table_name`;";
	$wpdb->query( $sql );
	if ( ! empty( $wpdb->last_error ) ) {
		throw new \Exception( $wpdb->last_error );
	}
}

function inspire_drop_history_athlete() {
	global $wpdb;
	$table_name = \Elhelper\modules\userStravaModule\db\AthleteDb::get_table();
	$sql        = "DROP TABLE IF EXISTS `$table_name`;";
	$wpdb->query( $sql );
	if ( ! empty( $wpdb->last_error ) ) {
		throw new \Exception( $wpdb->last_error );
	}
}

function inspire_drop_challenge() {
	global $wpdb;
	$table_name = \Elhelper\modules\productStravaModule\db\ChallengeDb::get_table();
	$sql        = "DROP TABLE IF EXISTS `$table_name`;";
	$wpdb->query( $sql );
	if ( ! empty( $wpdb->last_error ) ) {
		throw new \Exception( $wpdb->last_error );
	}
}


// Custom field
if ( function_exists( 'acf_add_local_field_group' ) ):

	acf_add_local_field_group( array(
		'key'                   => 'group_60dbff2342e90',
		'title'                 => 'Setting Product Detail',
		'fields'                => array(
			array(
				'key'               => 'field_60dc2688cda7e',
				'label'             => 'Khoảng cách (km)',
				'name'              => 'distance',
				'type'              => 'number',
				'instructions'      => 'Độ dài thử thách.',
				'required'          => 1,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'min'               => '',
				'max'               => '',
				'step'              => '',
			),
			array(
				'key'               => 'field_60dc29c029bda',
				'label'             => 'Ngày bắt đầu',
				'name'              => 'start_date',
				'type'              => 'date_picker',
				'instructions'      => 'Chọn ngày bắt đầu',
				'required'          => 1,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'display_format'    => 'd/m/Y',
				'return_format'     => 'd/m/Y',
				'first_day'         => 1,
			),
			array(
				'key'               => 'field_60dc2a0229bdb',
				'label'             => 'Ngày kết thúc',
				'name'              => 'end_date',
				'type'              => 'date_picker',
				'instructions'      => 'Chọn ngày kết thúc.',
				'required'          => 1,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'display_format'    => 'd/m/Y',
				'return_format'     => 'd/m/Y',
				'first_day'         => 1,
			),
			array(
				'key'               => 'field_60dc7a1ed31af',
				'label'             => 'Thời gian chạy (ngày)',
				'name'              => 'amount_day',
				'type'              => 'number',
				'instructions'      => 'Nhập thời gian của thử thách trong bao lâu. Đơn vị ngày.',
				'required'          => 1,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'min'               => '',
				'max'               => '',
				'step'              => '',
			),
			array(
				'key'               => 'field_60dc4123a90eb',
				'label'             => 'Thumbail Thử thách',
				'name'              => 'thumbail_challenge',
				'type'              => 'image',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'return_format'     => 'array',
				'preview_size'      => 'large',
				'library'           => 'all',
				'min_width'         => '',
				'min_height'        => '',
				'min_size'          => '',
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'product',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	) );

endif;


