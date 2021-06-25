<?php
/**
 * Date: 12/1/20
 * Time: 5:34 PM
 */
define( 'EL_HELPER', 'EL_HELPER' );
define( 'WP_HELPER_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_HELPER_INC_URI', plugins_url( '', __FILE__ ) );
define( 'EL_HELPER_DEBUG', 'PROD' );

return [
	'enqueue_scripts' => [
		'script'      => [
			'wp_register_script' => [
				// 'slimselect-js'                     => [
				// 	plugins_url( '/assets/lib/slimselect/slimselect.min.js', __FILE__ ),
				// 	array( 'jquery' ),
				// ],
				'jquery-md5-js'                     => [
					plugins_url( '/assets/lib/jquery-lib/jquery.md5.js', __FILE__ ),
					array( 'jquery' ),
				],
				'html5lightbox'                     => [
					plugins_url( '/assets/lib/html5lightbox/html5lightbox.js', __FILE__ ),
					[ 'jquery' ]
				],
				'bootstrap-js'                      => [
					plugins_url( '/assets/lib/bootstrap/js/bootstrap.js', __FILE__ ),
					array(
						'jquery'
					)
				],
				'jquery-validate'                   => [
					'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js',
					array( 'jquery' )
				],
				'jquery-validate-additional-method' => [
					'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js',
					array(
						'jquery',
						'jquery-validate'
					)
				]
			],
			'wp_enqueue_script'  => [
				'elhelper-script' => [
					'src'              => plugins_url( '/assets/js/el-helper-plugin.js', __FILE__ ),
					'dep'              => array( 'jquery' ),
					'ver'              => '',
					'in_footer'        => '',
					'locallize_script' => [
						'ajax_object' => [
							'ajax_url' => admin_url( 'admin-ajax.php' ),
							'we_value' => 1234
						]
					],
				],
			],
		],
		'style'       => [
			'wp_enqueue_style'  => [
				'elhelper-style' => [
					'src'   => plugins_url( '/assets/css/el-helper-style.css', __FILE__ ),
					'dep'   => '',
					'ver'   => '',
					'media' => '',
				],

			],
			'wp_register_style' => [
				'slimselect'        => [
					'src'   => plugins_url( '/assets/lib/slimselect/slimselect.min.css', __FILE__ ),
					'dep'   => '',
					'ver'   => '',
					'media' => '',

				],
				'bootstrap'         => [
					'src'   => plugins_url( '/assets/lib/bootstrap/css/bootstrap.css', __FILE__ ),
					'dep'   => '',
					'ver'   => '',
					'media' => '',

				],
				'font-awesome-all'  => [
					'src'   => plugins_url( '/assets/lib/fontawesome/css/all.css', __FILE__ ),
					'dep'   => '',
					'ver'   => '',
					'media' => '',

				],
				'font-awesome'      => [
					'src'   => plugins_url( '/assets/lib/fontawesome/css/fontawesome.css', __FILE__ ),
					'dep'   => 'font-awesome-all',
					'ver'   => '',
					'media' => '',
				],
				'fontawesome-pro-5' => [
					'src'   => plugins_url( '/assets/lib/fontawesome-5-pro/css/all.css', __FILE__ ),
					'dep'   => '',
					'ver'   => '',
					'media' => '',
				]
			],
		],
		'default_arr' => [
			'item_script' => [
				'src'       => '',
				'dep'       => '',
				'ver'       => '',
				'in_footer' => '',
			],
			'item_style'  => [
				'src'   => '',
				'dep'   => '',
				'ver'   => '',
				'media' => '',
			]
		],

	]
];