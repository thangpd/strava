<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/25/21
 * Time: 11:01 AM
 */

namespace Elhelper\common;


class SingleController extends Singleton {
	public $view_path = '';

	/**
	 * Always return string path for template_include hook.
	 */
	public function render( $path ) {
		static::enqueue_scripts_general();

		return static::$_instance->getViewPath() . $path;
	}

	public static function enqueue_scripts_general() {

	}

	public function templateInclude( $template ) {
		return $template;
	}

	public function getViewPath() {
		try {
			$reflection = new \ReflectionClass( static::instance() );
		} catch ( \ReflectionException $e ) {
			throw new \Exception( $e->getMessage() );
		}

		return plugin_dir_path( $reflection->getFileName() ) . 'views' . DIRECTORY_SEPARATOR;
	}

}