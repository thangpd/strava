<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/12/21
 * Time: 4:12 PM
 */

namespace Elhelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


use Elhelper\admin\modules\pages\coolSettings\CoolSettingAdminPage;
use Elhelper\admin\modules\pages\stravaApiSettingPages\StravaApiSettingPage;
use Elhelper\admin\modules\pages\stravaApiSettingPages\stravaChat\StravaChat;
use Elhelper\admin\modules\pages\stravaApiSettingPages\stravaChatBotManager\StravaChatBotManager;
use Elhelper\admin\modules\settings\ExampleSettingPage\ExampleSettingPage;
use Elhelper\modules\stravaApiModule\models\StravaApiModel;
use Elhelper\modules\stravaApiModule\StravaApiController;
use Elhelper\shortcode\testShortcode\TestShortcode;
use Elhelper\shortcode\stravaApi\StravaApiShortcode;
use Elhelper\shortcode\stravaGetAccessToken\StravaGetATShortcode;
use Elhelper\shortcode\stravaWebhook\StravaWebhookShortcode;
use Elhelper\widgets\connectStravaBtn\ConnectStravaBtn;

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
class Elhelper_Plugin {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';
	/**
	 * declare enqueue wpackio scripts/styles
	 */
	public static $enqueue;
	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elhelper_Plugin The single instance of the class.
	 */
	private static $_instance = null;
	/**
	 * Controllers of all modules;
	 */
	private $controllers;

	/**
	 * Include general config
	 */
	private $config;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct( $config = [] ) {
		$this->config = $config;
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'init', function () {
			return load_plugin_textdomain( 'elhelper' );
		} );
		//https://wpack.io/guides/using-wpackio-enqueue/#why-call-it-early
		self::$enqueue = new \WPackio\Enqueue( 'wordpressHelperPlugins', 'dist', '1.0.0', 'plugin', __FILE__ );

	}

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elhelper_Plugin An instance of the class.
	 */
	public static function instance( $config = [] ) {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $config );
		}

		return self::$_instance;

	}

	/**
	 * rewrite activation
	 */
	public function elhelper_rewrite_activation() {
		$this->add_rewrite_rules();
		flush_rewrite_rules( true );
	}

	/**
	 * Add Rewrite Rule
	 */
	public function add_rewrite_rules() {
//		add_rewrite_rule( '^welcome$', 'index.php?p=36', 'top' );
		add_rewrite_rule( '^' . StravaApiModel::EL_API_CAT_RULE . '/([^/]*)/?', 'index.php?' . StravaApiModel::EL_STRAVA_SLUG . '=$matches[1]', 'top' );

		//testing so flush after refresh everytime
		flush_rewrite_rules( true );
	}

	/**
	 * Initialize the plugin
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			// Add Plugin actions
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
			add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

		}

		//enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script' ] );
		add_filter( 'template_include', [ $this, 'summit_template_include' ], 10 );

		//wp-admin
		if ( is_admin() ) {
			//Demo ad menu strava api. Doing nothing.
			new CoolSettingAdminPage();

			//register page
			new StravaApiSettingPage();

			//Example Setting Page
			new ExampleSettingPage();


			//strava chat
			new StravaChat();

			//strava chat bot manager page
			new StravaChatBotManager();

		}

		//init register custom post type;
		$this->init_cpt();

		//shortcode
		$this->init_shortcode();
		//controller
		$this->init_controller();

		//Add custom_rewrite_tag
		$this->add_rewrite_tags();


		//testing only. Comment after test rewrite rule.
		$this->add_rewrite_rules();

		/*		add_action( 'parse_request', function($query){
		echo '<pre>';
		print_r($query);
		echo '</pre>';
		die;
		} );*/

	}

	/**
	 * Init Custom Post Type
	 * @return void
	 */
	public function init_cpt() {

	}

	/**
	 * Init Shortcode
	 * @return void
	 */
	public function init_shortcode() {

		new TestShortcode();
		new StravaGetATShortcode();
		new StravaApiShortcode();
		new StravaWebhookShortcode();
	}

	/**
	 * Init Controller
	 * @return void
	 */
	public function init_controller() {
		$this->controllers = [
			StravaApiController::instance(),
		];
	}

	/**
	 * Add custom rewrite tags
	 */
	public function add_rewrite_tags() {
		add_rewrite_tag( '%' . StravaApiModel::EL_STRAVA_SLUG . '%', '([^&]+)' );
	}


	/**
	 * Template include
	 */
	public function summit_template_include( $template ) {
		foreach ( $this->controllers as $controller ) {
			$template = $controller->templateInclude( $template );
		}

		return $template;

	}

	/**
	 * @param $hook
	 */
	function enqueue_script( $hook ) {

		$config = self::getConfig();
		if ( ! empty( $config['enqueue_scripts'] ) ) {
			foreach ( $config['enqueue_scripts']['script'] as $key => $item ) {
				$this->enqueue_script_helper( $key, $item );
			}
			foreach ( $config['enqueue_scripts']['style'] as $key => $item ) {
				$this->enqueue_style_helper( $key, $item );
			}
		}

		self::$_instance->wpackio_enqueue( 'testapp', 'main', [] );

	}

	/**
	 * Get $config
	 */
	public function getConfig() {
		return self::$_instance->config;
	}

	/**
	 * Enqueue script and style from array list $this->config  config.php
	 */
	public function enqueue_script_helper( $callable, $arr_list ) {
		foreach ( $arr_list as $key => $item ) {
			$item = array_merge( self::getConfig()['enqueue_scripts']['default_arr']['item_script'], $item );
			call_user_func( $callable, $key, $item['src'], $item['dep'], $item['ver'], $item['in_footer'] );
			if ( isset( $item['locallize_script'] ) ) {
				foreach ( $item['locallize_script'] as $lo_key => $lo_item ) {
					if ( is_array( $lo_item ) ) {
						wp_localize_script( $key, $lo_key, $lo_item );
					}
				}
			}
		}
	}

	/**
	 * Enqueue script and style from array list $this->config config.php
	 */
	public function enqueue_style_helper( $callable, $arr_list ) {
		foreach ( $arr_list as $key => $item ) {
			$item = array_merge( self::getConfig()['enqueue_scripts']['default_arr']['item_style'], $item );
			call_user_func( $callable, $key, $item['src'], $item['dep'], $item['ver'], $item['media'] );
		}
	}

	/**
	 * https://wpack.io/apis/php-api/
	 * Wpackio enqueue
	 * $params
	 * Normalizes the configuration array of assets.
	 *
	 * Here are the supported keys:
	 * `js` (`boolean`) True if we are to include javascripts.
	 * `css` (`boolean`) True if we are to include stylesheets.
	 * `js_dep` (`array`) Additional dependencies for the javascript assets.
	 * `css_dep` (`array`) Additional dependencies for the stylesheet assets.
	 * `in_footer` (`boolean`) Whether to print the assets in footer (for js only).
	 * `media` (`string`) Media attribute for stylesheets (defaults `'all'`).
	 *
	 * @param array $config Configuration array.
	 *
	 * @return array Normalized configuration with all the mentioned keys.
	 */
	public function wpackio_enqueue( $app, $entry, $config = [] ) {
		//wpackio
		return self::$enqueue->enqueue( $app, $entry, $config );
	}


	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ConnectStravaBtn() );


	}

	/**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_controls() {

		// Include Control files
		require_once( __DIR__ . '/controls/test-control.php' );

		// Register control
//		\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Elementor_Test_Control() );

	}


}
