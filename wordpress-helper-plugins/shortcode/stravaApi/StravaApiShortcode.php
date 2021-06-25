<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/17/21
 * Time: 1:29 PM
 */

namespace Elhelper\shortcode\stravaApi;

use Elhelper\common\Shortcode;
use Elhelper\Elhelper_Plugin;

class StravaApiShortcode extends Shortcode {
	function render_shortcode( $attr = [], $content = '' ) {
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'stravaApiShortcode', [ 'css_dep' => [ 'bootstrap' ] ] );
		$template_path             = plugin_dir_path( __FILE__ ) . 'views/index.php';
		$allowedHtmltags           = wp_kses_allowed_html( 'post' );
		$allowedHtmltags['input']  = array(
			'name'        => true,
			'class'       => true,
			'id'          => true,
			'placeholder' => true,
			'title'       => true,
			'value'       => true,
			'type'        => true
		);
		$allowedHtmltags['iframe'] = array(
			'name'   => true,
			'class'  => true,
			'id'     => true,
			'title'  => true,
			'src'    => true,
			'height' => true,
			'width'  => true
		);
		$allowedHtmltags['form']   = [ 'method' => 'true', 'class' => true, 'action' => true ];

		return $this->render( $template_path, [ 'context' => 'test' ], $allowedHtmltags );
	}

	protected function get_name() {
		// TODO: Implement get_name() method.
		return 'stravaapi_shortcode';
	}

}