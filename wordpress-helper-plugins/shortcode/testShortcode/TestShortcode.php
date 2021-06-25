<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/4/21
 * Time: 11:02 AM
 */

namespace Elhelper\shortcode\testShortcode;


use Elhelper\common\Shortcode;
use Elhelper\Elhelper_Plugin;

class TestShortcode extends Shortcode {


	public function render_shortcode( $attr = [], $content = '' ) {
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'test_shortcode' );
		$template_path = plugin_dir_path( __FILE__ ) . 'views/test-shortcode/index.php';

		return $this->render( $template_path, [ 'context' => 'test' ] );
	}

	protected function get_name() {
		// TODO: Implement get_name() method.
		return 'test_el_shortcode';
	}


}