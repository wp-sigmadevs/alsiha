<?php
/**
 * Customizer Sections Class.
 * This Class registers Customizer Sections.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Sections Class.
 *
 * @since v1.0
 */
class Alsiha_Customizer_Sections {

	/**
	 * Customizer Sections.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $sections = array();

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 * @since  1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Alsiha_Customizer_Sections
	 * @since  1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Customizer sections.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->set_sections()->add_sections();
	}

	/**
	 * Setting up sections.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function set_sections() {
		$this->sections['alsiha_header_styles'] = array(
			'title'       => esc_html__( 'Header Styles', 'alsiha' ),
			'description' => esc_html__( 'Header Style settings', 'alsiha' ),
			'panel'       => 'header_settings',
			'priority'    => 10,
		);

		$this->sections['alsiha_header_topbar'] = array(
			'title'       => esc_html__( 'Header Top Bar', 'alsiha' ),
			'description' => esc_html__( 'Header top bar settings', 'alsiha' ),
			'panel'       => 'header_settings',
			'priority'    => 11,
		);

		$this->sections['alsiha_sticky_header'] = array(
			'title'       => esc_html__( 'Sticky Header', 'alsiha' ),
			'description' => esc_html__( 'Sticky header settings', 'alsiha' ),
			'panel'       => 'header_settings',
			'priority'    => 15,
		);

		$this->sections['alsiha_footer_styles'] = array(
			'title'       => esc_html__( 'Footer Styles', 'alsiha' ),
			'description' => esc_html__( 'footer style settings', 'alsiha' ),
			'panel'       => 'alsiha_footer_settings',
			'priority'    => 10,
		);

		$this->sections['alsiha_footer_copyright'] = array(
			'title'       => esc_html__( 'Footer Copyright', 'alsiha' ),
			'description' => esc_html__( 'footer copyright settings', 'alsiha' ),
			'panel'       => 'alsiha_footer_settings',
			'priority'    => 15,
		);

		$this->sections['alsiha_footer_copyright'] = array(
			'title'       => esc_html__( 'Footer Copyright', 'alsiha' ),
			'description' => esc_html__( 'footer copyright settings', 'alsiha' ),
			'panel'       => 'alsiha_footer_settings',
			'priority'    => 15,
		);

		$this->sections['alsiha_typography_body'] = array(
			'title'       => esc_html__( 'Body', 'alsiha' ),
			'description' => esc_html__( 'Specify the body typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 10,
		);

		$this->sections['alsiha_typography_nav'] = array(
			'title'       => esc_html__( 'Menu', 'alsiha' ),
			'description' => esc_html__( 'Specify the Navigation Menu typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 20,
		);

		$this->sections['alsiha_typography_h1'] = array(
			'title'       => esc_html__( 'Heading 1', 'alsiha' ),
			'description' => esc_html__( 'Specify h1 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 30,
		);

		$this->sections['alsiha_typography_h2'] = array(
			'title'       => esc_html__( 'Heading 2', 'alsiha' ),
			'description' => esc_html__( 'Specify h2 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 40,
		);

		$this->sections['alsiha_typography_h3'] = array(
			'title'       => esc_html__( 'Heading 3', 'alsiha' ),
			'description' => esc_html__( 'Specify h3 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 50,
		);

		$this->sections['alsiha_typography_h4'] = array(
			'title'       => esc_html__( 'Heading 4', 'alsiha' ),
			'description' => esc_html__( 'Specify h4 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 60,
		);

		$this->sections['alsiha_typography_h5'] = array(
			'title'       => esc_html__( 'Heading 5', 'alsiha' ),
			'description' => esc_html__( 'Specify h5 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 70,
		);

		$this->sections['alsiha_typography_h6'] = array(
			'title'       => esc_html__( 'Heading 6', 'alsiha' ),
			'description' => esc_html__( 'Specify h6 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 80,
		);

		$this->sections['alsiha_color_settings'] = array(
			'title'       => esc_html__( 'Colors', 'alsiha' ),
			'description' => esc_html__( 'Color scheme settings', 'alsiha' ),
			'panel'       => 'alsiha_texts_colors_settings',
			'priority'    => 10,
		);

		$this->sections['alsiha_showcase_slider'] = array(
			'title'       => esc_html__( 'Homepage Showcase Slider', 'alsiha' ),
			'description' => esc_html__( 'Homepage showcase slider settings', 'alsiha' ),
			'panel'       => 'alsiha_page_settings',
			'priority'    => 5,
		);

		$this->sections['alsiha_pagetitle'] = array(
			'title'       => esc_html__( 'Page Title Banner', 'alsiha' ),
			'description' => esc_html__( 'Page title banner settings', 'alsiha' ),
			'panel'       => 'alsiha_page_settings',
			'priority'    => 10,
		);

		$this->sections['alsiha_breadcrumbs'] = array(
			'title'       => esc_html__( 'Breadcrumbs', 'alsiha' ),
			'description' => esc_html__( 'Breadcrumbs settings', 'alsiha' ),
			'panel'       => 'alsiha_page_settings',
			'priority'    => 15,
		);

		$this->sections['alsiha_page_styles'] = array(
			'title'       => esc_html__( 'Page Styles', 'alsiha' ),
			'description' => esc_html__( 'Page style settings', 'alsiha' ),
			'panel'       => 'alsiha_page_settings',
			'priority'    => 20,
		);

		$this->sections['alsiha_archive_settings'] = array(
			'title'       => esc_html__( 'Archives', 'alsiha' ),
			'description' => esc_html__( 'Archive settings', 'alsiha' ),
			'panel'       => 'alsiha_blog_settings',
			'priority'    => 10,
		);

		// $this->sections['alsiha_single_settings'] = array(
		// 	'title'       => esc_html__( 'Single Post', 'alsiha' ),
		// 	'description' => esc_html__( 'Single post settings', 'alsiha' ),
		// 	'panel'       => 'alsiha_blog_settings',
		// 	'priority'    => 15,
		// );

		$this->sections['alsiha_social_media'] = array(
			'title'       => esc_html__( 'Social Media', 'alsiha' ),
			'description' => esc_html__( 'Please add your social media profile information', 'alsiha' ),
			'panel'       => 'alsiha_settings',
			'priority'    => 20,
		);

		$this->sections['alsiha_integrations'] = array(
			'title'       => esc_html__( 'Integrations', 'alsiha' ),
			'description' => esc_html__( 'Integrations settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
			'priority'    => 25,
		);

		$this->sections['alsiha_extra_settings'] = array(
			'title'       => esc_html__( 'Extra', 'alsiha' ),
			'description' => esc_html__( 'Extra settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
			'priority'    => 30,
		);

		return $this;
	}

	/**
	 * Adding panels with the help of Kirki.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function add_sections() {
		if ( empty( $this->sections ) ) {
			return;
		}

		foreach ( $this->sections as $section_id => $section_args ) {
			Kirki::add_section( $section_id, $section_args );
		}
	}
}
