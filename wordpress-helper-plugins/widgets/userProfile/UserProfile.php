<?php

namespace Elhelper\widgets\userProfile;

use Elhelper\Elhelper_Plugin;

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
<<<<<<< HEAD:wordpress-helper-plugins/widgets/userProfile/userProfile.php
		
		if ( class_exists('WooCommerce') ) {
			$args = array(
				'post_type'				=> 'shop_order'
				,'post_status'       	=>  array( 'wc-processing', 'wc-completed' )
				,'ignore_sticky_posts'	=> 1
				,'posts_per_page' 		=> 4
				,'orderby' 				=> 'date'
				,'order' 				=> 'desc'
				,''
			);
=======
>>>>>>> a4b439ebfc90bbf91fe31dcbc0c2f3824fe2c0b9:wordpress-helper-plugins/widgets/userProfile/UserProfile.php


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
