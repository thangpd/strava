<?php

namespace Elhelper\widgets\userProfile;

use Elhelper\Elhelper_Plugin;
use Elhelper\modules\productStravaModule\controller\ChallengeController;
use Elhelper\modules\productStravaModule\db\ChallengeDb;
use Elhelper\modules\productStravaModule\model\ChallengeModel;
use MailPoet\WP\DateTime;
use Elhelper\mail\Template;

class UserProfile extends \Elementor\Widget_Base {

	/**
	 * @param array $data
	 * @param array|null $args
	 */
	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'userprofile', [
			'js'      => true,
			'js_dep'  => [
				'elementor-frontend-modules',
			],
			'css_dep' => [
				'font-awesome-all',
				'font-awesome',
				'fontawesome-pro-5',
				'slimselect',
				'bootstrap'
			],
		] );
	}

	public static function renderProductChallenge( $challenge ) {
		$user_id    = $challenge->user_id;
		$product_id = $challenge->product_id;
		$product    = wc_get_product( $product_id );

		$product_title = $product->get_title();


		$challengeModel   = new ChallengeModel( $challenge );
		$distance_already = $challengeModel->getDistanceAlreadyRun();

//		$amount_distance = get_field( 'distance', $product_id );
		$amount_distance = $challenge->amount_distance;
		if ( $distance_already < $amount_distance ) {
			$distance_left         = $amount_distance - $distance_already;
			$percent_distance_left = round( $distance_already / $amount_distance * 100, 0 );
			$distance_active       = round( $percent_distance_left / 10, 0 );

		} else {
			$distance_left         = 0;
			$percent_distance_left = 100;
			$distance_active       = 10;
		}


// get_field products:
		/*
		 * distance
		 * start_date
		 * end_date
		 * thumbail_challenge
		 * amount_day
		 * */
		$start_date = $challenge->created_at;

//		$amount_date = get_field( 'amount_date', $product_id );
		$amount_date = $challenge->amount_date;
		$now         = new \DateTime( 'now' );

		$date_left         = 0;
		$date_left_percent = 0;
		if ( ! empty( $start_date ) && ! empty( $amount_date ) ) {
			$start_date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $start_date );
			$end_date   = clone( $start_date );
			$end_date->modify( '+' . $amount_date . 'days' );
			//end date

			$datediff_left = $now->diff( $end_date );
			if ( $datediff_left->days > 0 ) {
				$date_left         = $datediff_left->days;
				$f                 = $date_left / $amount_date;
				$date_left_percent = round( $f * 100, 0 );
				$date_active       = round( $date_left_percent / 10, 0 );
			} else {
				$date_left         = 0;
				$date_left_percent = 100;
				$date_active       = 10;
			}

		} else {
			$start_date = new \DateTime( 'now' );
			$end_date   = new \DateTime( 'now' );
		}


		$start_date_html = $start_date->format( 'd/m/Y' );
		$end_date_html   = $end_date->format( 'd/m/Y' );

		//Thumbnail challenge
		$thumbail_challenge = get_field( 'thumbail_challenge', $product_id );
		if ( $challenge->status == 1 ) {
			$label_tag_finished_failed = ' <div class="strava-challenges__status-image">
                                    <span>Đã hoàn thành</span>
                                </div>';
		} else {
			$label_tag_finished_failed = '';
		}

		$html = <<<HTML
		<div class="strava-challenges__item">
                        <div class="strava-challenges__inner">
                                <div class="row">
                                    <div class="col-md-12 col-lg-3">
                                        <!-- banner -->
                                    <div class="strava-challenges__head">
                                        <div class="strava-challenges__banner">
                                            <img src="{$thumbail_challenge['url']}" alt="banner">
                                        </div>
                                        <div class="strava-challenges__head-info">
                                            <h2 class="d-block d-lg-none">{$product_title}</h2>
                                            <span class="distance-date d-block d-lg-none">{$amount_distance} km - {$amount_date} ngày</span>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-12 col-lg-9">
                                        <div class="strava-challenges__content">
                                            <h2 class="d-none d-lg-block">
												<a href="#">
													{$product_title}
												</a>
											</h2>
                                            <span class="distance-date d-none d-lg-block">{$amount_distance} km - {$amount_date} ngày</span>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3>Ngày bắt đầu</h3>
                                                    <span class="date">{$start_date_html}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3>Ngày kết thúc</h3>
                                                    <span class="date">{$end_date_html}</span>
                                                </div>
                                            </div>

                                            <div class="row align-items-end align-items-lg-center">
                                                <div class="col-3 pr-0">
                                                    <h3 class="label">Độ dài</h3>
                                                    <span class="percent">{$percent_distance_left}%</span>
                                                </div>
                                                <div class="col-9">
                                                    <div class="line" data-active="{$distance_active}">
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                    </div>
                                                    <div class="d-none d-lg-block distance-left">
                                                        <b>{$distance_already} km</b>
                                                        <span>Còn lại <b>{$distance_left}km</b></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row  align-items-end align-items-lg-center">
                                                <div class="col-3 pr-0">
                                                    <h3 class="label">Thời gian</h3>
                                                    <span class="percent">{$date_left_percent}%</span>
                                                </div>
                                                <div class="col-9">
                                                    <div class="line" data-active="${date_active}">
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                        <div class="rectangle"></div>
                                                    </div>
                                                    <div class="d-none d-lg-block distance-left">
                                                        <b>{$amount_date} ngày</b>
                                                        <span>Còn lại <b>{$date_left} ngày</b></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
								<div class="strava-challenges__status">
                               {$label_tag_finished_failed}
                            	</div>
                            </div>
                        </div>

HTML;


		return $html;

	}

	public static function renderAddNewChallenge() {
		$add_new_challenge = include __DIR__ . '/templates/add_more_challenge_template.php';

		return $add_new_challenge;
	}


	public static function renderListChallengeReport( $challenges ) {
		$html_template = '
						<div class="list-challenges">
						    <div class="container-fluid">
						        <div class="list-challenges__wrap mx-3">
						            <div class="row">
						                <div class="col-md-12">
						                    <h2 class="heading">Danh sách nhà chinh phục</h2>
						                    <span class="sub">(Xếp hạng dựa vào thời gian chinh phục)</span>
						                </div>
						            </div>
						
						            <div class="row">
						                <div class="col-md-12">
						<div class="table-tab">
						                        %1$s
						                    </div>
						                    </div>
						            </div>
						        </div>
						    </div>
						</div>';
		$html          = '';
		if ( ! empty( $challenges ) ) {
			foreach ( $challenges as $challenge ) {
				$html .= sprintf( $html_template, self::renderTableItemChallenge( $challenge ) );
			}

		}

		return $html;
	}

	public static function renderTableItemChallenge( $challenge ) {
		$product_id = $challenge->product_id;
		$product    = wc_get_product( $product_id );

		$product_title        = $product->get_title();
		$item_table_template  = '<div class="table-item">
<div class="row">
                                <div class="col-md-12">
                                    <h2>%2$s</h2>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">HẠNG</th>
                                    <th scope="col">TÊN NHÀ CHINH PHỤC</th>
                                    <th scope="col">TỐC ĐỘ <br>(avg Pace)</th>
                                    <th scope="col">TỔNG KM</th>
                                    <th scope="col">THỜI GIAN <br>CHINH PHỤC</th>
                                </tr>
                                </thead>
                                <tbody>
                                %1$s
                                </tbody>
                            </table>
                        </div>';
		$renderedFinisherHtml = '';
		$listsFinisher        = ChallengeModel::getListFinisherInfo( $challenge->product_id );
		if ( ! empty( $listsFinisher ) ) {
			$renderedFinisherHtml = self::renderListFinisherRowHtml( $listsFinisher );
		}
		$tables = sprintf( $item_table_template, $renderedFinisherHtml, $product_title );

		return $tables;

	}

	public static function renderListFinisherRowHtml( $listsFinisher ) {
		$html = '';
		foreach ( $listsFinisher as $index => $item ) {
			$html .= self::renderFinisherRow( $index + 1, $item );
		}

		return $html;
	}

	/**
	 * [user_name] => dinhthang
	 * [total_km] => 228.998
	 * [amount_time_finished] => 2
	 * [pace] => 27.068965517241
	 */
	public static function renderFinisherRow( $index, $item ) {
		$html = ' <tr>
                                    <th scope="row">%1$s</th>
                                    <td>%2$s</td>
                                    <td>%3$s</td>
                                    <td>%4$s km</td>
                                    <td>%5$s</td>
                                </tr>';
		$html = sprintf( $html, $index, $item['user_name'], $item['pace'], $item['total_km'], $item['amount_time_finished'] );

		return $html;
	}

	/**
	 * @return [type]
	 */
	public function get_name() {
		return 'user_profile';
	}

	/**
	 * @return [type]
	 */
	public function get_icon() {
		return 'fas fa-info-circle';
	}

	/**
	 * @return [type]
	 */
	public function get_title() {
		return __( 'User profile', 'elhelper' );
	}

	/**
	 * @return [type]
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * @return [type]
	 */
	public function render() {
		$settings = $this->get_settings_for_display();

		require WP_HELPER_PATH . 'mail/template.php';
		$get_dir_mail_template = new Template();

		// $get_dir_mail_template->action_send_mail('begin', 46, 'nguyenhuutien.it.3895@gmail.com');

		if ( class_exists( 'WooCommerce' ) ) {
			$args = array(
				'post_type'           => 'shop_order'
			,
				'post_status'         => array( 'wc-processing', 'wc-completed' )
			,
				'ignore_sticky_posts' => 1
			,
				'posts_per_page'      => 4
			,
				'orderby'             => 'date'
			,
				'order'               => 'desc'
			,
				''
			);
		}

		include __DIR__ . '/templates/challenge_section.php';
	}

	/**
	 * @return [type]
	 */
	protected function _register_controls() {
		$this->get_responsive_padding();
	}

	protected function get_responsive_padding() {
		$this->start_controls_section(
			'padding_box_timeline',
			[
				'label' => __( 'Padding Box Timeline', 'elhelper' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'padding_top',
			[
				'label'   => __( 'Padding Top', 'elhelper' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
			]
		);
		$this->add_control(
			'padding_bottom',
			[
				'label'   => __( 'Padding Bottom', 'elhelper' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
			]
		);
		$this->add_control(
			'responsive_padding',
			[
				'label'       => __( 'Responsive', 'elhelper' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 10,
				'placeholder' => __( 'Type your responsive', 'elhelper' ),
			]
		);
		$this->end_controls_section();
	}


}
