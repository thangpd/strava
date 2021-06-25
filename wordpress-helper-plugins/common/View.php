<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/3/21
 * Time: 5:45 PM
 */

namespace Elhelper\common;


class View {

	private $_view;
	private $_context;

	public function __construct( $context ) {
		$this->_context = $context;
		if ( method_exists( $this->_context, 'enqueue_scripts_general' ) ) {
			$this->_context->enqueue_scripts_general();
		}
	}


	/**
	 * https://packagist.org/packages/typisttech/wp-kses-view
	 * Render WPKsesView
	 * echo Views template with context
	 * @return string
	 *
	 */
	public function render( $template, $params = [], $allowed_html = [] ) {
		$template = $this->_context->getViewPath() . $template;
		if ( ! empty( $allowed_html ) ) {
			$allowed_html = ! empty( $allowed_html ) ? $allowed_html : wp_kses_allowed_html( 'post' );
			$this->_view  = new \TypistTech\WPKsesView\View( $template, $allowed_html );

			return $this->_view->toHtml( (object) $params );
		} else {
			return $this->toHtml( $template, (object) $params );
		}

	}


	/**
	 * render normal, No escape html
	 * @return string
	 */
	public function toHtml( $template, $context ) {
		ob_start();
		// phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.IncludingFile
		include $template;

		return ob_get_clean();
	}


}