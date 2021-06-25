<?php
/**
 * Date: 12/2/20
 * Time: 9:05 AM
 */

namespace Elhelper\common;


abstract class Controller {

	public function enqueue_scripts_general() {

	}

	public function getViewPath() {
		try {
			$reflection = new \ReflectionClass( $this );
		} catch ( \ReflectionException $e ) {
			throw ( new \Exception( $e->getMessage() ) );
		}

		return plugin_dir_path( $reflection->getFileName() ) . 'views' . DIRECTORY_SEPARATOR;
	}


}