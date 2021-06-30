<?php

namespace Elhelper\widgets\userProfile;

use Elhelper\Elhelper_Plugin;
use MailPoet\WP\DateTime;

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

	public static function renderProductChallenge( $product_id, $user_id ) {
		$userAthlete = new \Elhelper\modules\userStravaModule\model\UserStravaAthleteModel( $user_id );

		$distance_already = $userAthlete->getDistanceOfProduct( $product_id );
		if ( ! empty( $distance_already ) ) {
			$distance_already *= 0.001;
		} else {
			$distance_already = 0;
		}
// get_field products:
		/*
		 * distance
		 * start_date
		 * end_date
		 * thumbail_challenge
		 * */
		$distnace_product = get_field( 'distance', $product_id );
		$start_date       = get_field( 'start_date', $product_id );
		$end_date         = get_field( 'end_date', $product_id );
		$now              = new \DateTime( 'now' );


		if ( ! empty( $start_date ) ) {
			$start_date = \DateTime::createFromFormat( 'd/m/Y', $start_date );
		}
		if ( ! empty( $end_date ) ) {
			//end date
			$end_date = \DateTime::createFromFormat( 'd/m/Y', $end_date );
//			$end_datetime = $end_date->modify( 'tomorrow' );
//			$end_date      = $end_date->setTimestamp( $end_datetime->getTimestamp() - 1 );
		}
		$datediff          = $end_date->diff( $start_date );
		$date_range        = $datediff->days;
		$datediff_left     = $now->diff( $end_date );
		$date_left         = $datediff_left->days;
		$f                 = $date_left / $date_range;
		$date_left_percent = round( $f * 100, 0 );

		$thumbail_challenge = get_field( 'thumbail_challenge', $product_id );


		$distance_already_OfProduct = isset( $distance_already ) && ! empty( $distance_already ) ? $distance_already . 'km' : '0 km';

		$distance_left         = $distnace_product - $distance_already;
		$percent_distance_left = round( $distance_already / $distance_left * 100, 0 );


		$html = <<<HTML
                                <div class="row">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="banner"></div>
                                    </div>
                                    <div class="col-md-8 col-lg-9">
                                        <div class="content">
                                            <h2>Chinh phục Everest</h2>
                                            <span class="distance-date">{$distnace_product} km - {$date_range} ngày</span>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3>Ngày bắt đầu</h3>
                                                    <span class="date">{$start_date->format( 'd/m/Y' )}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3>Ngày kết thúc</h3>
                                                    <span class="date">{$end_date->format( 'd/m/Y' )}</span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 pr-0">
                                                    <h3 class="label">Độ dài</h3>
                                                    <span class="percent">{$percent_distance_left}%</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="line" data-active="0">
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
                                                    <div class="distance-left">
                                                        <b>{$distance_already_OfProduct}</b>
                                                        <span>Còn lại <b>{$distance_left}km</b></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 pr-0">
                                                    <h3 class="label">Thời gian</h3>
                                                    <span class="percent">{$date_left_percent}%</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="line" data-active="7">
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
                                                    <div class="distance-left">
                                                        <b>{$date_range} ngày</b>
                                                        <span>Còn lại <b>{$date_left} ngày</b></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

HTML;


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
