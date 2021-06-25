<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 6/25/21
 * Time: 3:39 PM
 */

namespace Elhelper\modules\userStravaModule\model;


use Elhelper\common\Model;

class UserStravaRenderModel extends Model {

	public function __construct() {

	}

	public static function renderUserProfile( UserStravaAthleteModel $userAthlete ) {


		$html           = <<<HTML
		

HTML;
		$container_item = '<table class="table">
								  <thead>
								    <tr>
								      <th scope="col">#</th>
								      <th scope="col">ID</th>
								      <th scope="col">username</th>
								      <th scope="col">Avatar</th>
								    </tr>
								  </thead>
								  %1$s
								</table>';
		$item_template  = '<tbody>
								    <tr>
								      <th scope="row">%1$s</th>
								      <td>%2$s</td>
								      <td>%3$s</td>
								      <td><img src="%4$s" alt=""></td>
								    </tr>
								  </tbody>';

		$items      = '';
		$userObject = $userAthlete->getAthleteObject();
		if ( ! empty( $userObject ) ) {
			$items .= sprintf( $item_template, 1, $userObject->id, $userObject->username, $userObject->profile_medium );
			$html  = sprintf( $container_item, $items );
		}
		return $html;
	}

	public static function renderUserActivities( $user_id ) {
		$userStravaController = new \Elhelper\modules\userStravaModule\controller\UserStravaController( $user_id );
		$getinfoAthlete       = $userStravaController->getListActivities();
		$html                 = '';
		$container_item       = '<table class="table">
								  <thead>
								    <tr>
								      <th scope="col">#</th>
								      <th scope="col">Tên Hoạt Động</th>
								      <th scope="col">Khoảng cách</th>
								      <th scope="col">Loại</th>
								    </tr>
								  </thead>
								  %1$s
								</table>';
		$item_template        = '<tbody>
								    <tr>
								      <th scope="row">%1$s</th>
								      <td>%2$s meters</td>
								      <td>%3$s</td>
								      <td>%4$s</td>
								    </tr>
								  </tbody>';

		$items = '';
		if ( ! empty( $getinfoAthlete ) ) {
			foreach ( $getinfoAthlete as $index => $value ) {
				$items .= sprintf( $item_template, $index, $value->name, $value->distance, $value->type );
			}
			$html = sprintf( $container_item, $items );
		}

		return $html;
	}


}