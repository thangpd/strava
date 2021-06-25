<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/3/21
 * Time: 5:41 PM
 */

namespace Elhelper\common;


abstract class Shortcode extends Base {

	private $_view;

	public function __construct() {
		add_shortcode( $this->get_name(), [ $this, 'render_shortcode' ] );
		//enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	abstract protected function get_name();

	abstract function render_shortcode( $attr = [], $content = '' );

	public function enqueue_scripts() {

	}

	/**
	 * https://packagist.org/packages/typisttech/wp-kses-view
	 * Render WPKsesView
	 * return Views template with context
	 *
	 *
	 */
	public function render( $template, $params = [], $allowed_html = [] ) {

		if ( ! empty( $allowed_html ) ) {
			$allowed_html = ! empty( $allowed_html ) ? $allowed_html : wp_kses_allowed_html( 'post' );
			$this->_view  = new \TypistTech\WPKsesView\View( $template, $allowed_html );

			echo $this->_view->toHtml( (object) $params );
		} else {
			echo $this->toHtml( $template, (object) $params );
		}

	}


	/**
	 * render normal, No escape html
	 */
	public function toHtml( $template, $context ) {
		ob_start();

		// phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.IncludingFile
		include $template;

		return ob_get_clean();
	}

}