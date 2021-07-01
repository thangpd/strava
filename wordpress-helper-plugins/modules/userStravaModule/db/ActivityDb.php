<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 4/29/21
 * Time: 9:19 AM
 */

namespace Elhelper\modules\userStravaModule\db;

use Elhelper\inc\DB;

class ActivityDb extends DB {

	static $primary_key = 'inspire_athlete';

	public function __construct() {
	}




	/**
	 * Singletons should not be restorable from strings.
	 */
	public function __wakeup() {
		throw new \Exception( "Cannot unserialize a singleton." );
	}

	/**
	 * Singletons should not be cloneable.
	 */
	protected function __clone() {
	}


}