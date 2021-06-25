<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/17/21
 * Time: 1:29 PM
 */

namespace Elhelper\shortcode\stravaGetAccessToken;

use Elhelper\common\Shortcode;
use Elhelper\Elhelper_Plugin;

class StravaGetATShortcode extends Shortcode {
	function render_shortcode( $attr = [], $content = '' ) {
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'stravaApiGetAccessShortcode' );
		$template_path = plugin_dir_path( __FILE__ ) . 'views/index.php';

		return $this->render( $template_path, [ 'context' => 'test' ] );
	}

	protected function get_name() {
		// TODO: Implement get_name() method.
		return 'stravagetat_shortcode';
	}

}