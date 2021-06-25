<?php
/*
 Plugin Name: Strava Integrate Plugin
 Description: This plugin will be attached to woocommerce order flow. Once ordered confirmed, will call to Strava api. This plugin include dashboard for configuration for url api and debug.
 Author: wearesection
 Version: 1.0.0
 Author URI: https://wearesection.com/
 Text Domain: elhelper
 */

namespace Elhelper;
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/functions.php';
$config = require __DIR__ . '/config.php';
require_once __DIR__ . '/Elhelper_Plugin.php';
$instance = Elhelper_Plugin::instance( $config );


//Function rewrite when activation
register_activation_hook( __FILE__, [ $instance, 'elhelper_rewrite_activation' ] );

