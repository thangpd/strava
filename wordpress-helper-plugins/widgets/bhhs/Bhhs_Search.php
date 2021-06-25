<?php
/**
 * Date: 7/29/20
 * Time: 3:25 PM
 */

namespace Elhelper\widgets\bhhs;


class Bhhs_Search extends \Elementor\Widget_Base {
	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );
		wp_register_script( 'bhhs-search-elhelper', plugins_url( '/assets/bhhs-search/js/bhhs-search.js', __FILE__ ), [
			'elementor-frontend',
			'jquery',
//			'html5lightbox'
		], '1.0.0', true );
		wp_register_style( 'bhhs-search-elhelper-style',
			plugins_url( '/assets/bhhs-search/css/bhhs-search.css', __FILE__ ), [ 'bootstrap' ], false
		);
	}

	public function get_name() {
		return 'bhhs_search';
	}

	public function get_script_depends() {
		return [
			'bhhs-search-elhelper'
		];
	}

	public function get_style_depends() {
		return [ 'bhhs-search-elhelper-style' ];
	}


	/**
	 * Get widget title.
	 *
	 * Retrieve Category Carousel widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Elhelper Post Mansory', 'elhelper' );
	}

	public function get_icon() {
		return 'fa fa-book';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Category Carousel widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Register Category Carousel widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'url',
			[
				'label'       => __( 'Nothing to do with this', 'elhelper' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'url',
				'placeholder' => __( 'https://your-link.com ', 'elhelper' ),
			]
		);

		$this->end_controls_section();

	}


	/**
	 * Render Category Carousel widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$html = <<<HTML
		<div class="dev-test">
		ok
</div>
HTML;

		echo $html;

	}


}

