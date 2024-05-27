<?php
/**
 * Customizer Controls Class.
 * This Class registers Customizer Controls.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Controls Class.
 *
 * @since v1.0
 */
class Alsiha_Customizer_Controls {

	/**
	 * Kirki Configuration ID.
	 *
	 * @access public
	 * @var string
	 * @since  1.0.0
	 */
	public $config_id;

	/**
	 * Customizer Controls.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $controls = array();

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
	 * @return Alsiha_Customizer_Controls
	 * @since  1.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Customizer panels.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->config_id = 'alsiha_theme';
		$this->header()->footer()->typography()->colors()->page()
		->blog()->socials()->integrations()->extras()->add_controls();
	}

	/**
	 * Adding controls with the help of Kirki.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function add_controls() {
		if ( empty( $this->controls ) ) {
			return;
		}

		foreach ( $this->controls as $control ) {
			Kirki::add_field( $this->config_id, $control );
		}
	}

	/**
	 * Header controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function header() {
		$this->controls[] = array(
			'settings'    => 'alsiha_logo_padding',
			'label'       => esc_html__( 'Logo Padding', 'alsiha' ),
			'description' => esc_html__( 'Logo top/bottom padding. Default: 0.1rem.', 'alsiha' ),
			'section'     => 'alsiha_header_styles',
			'type'        => 'dimensions',
			'priority'    => 20,
			'default'     => array(
				'padding-top'    => '0.1rem',
				'padding-bottom' => '0.1rem',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'alsiha' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'alsiha' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '.site-branding .logo',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_enable_100_header',
			'label'       => esc_html__( '100% Header?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable 100% header width, regardless of container.', 'alsiha' ),
			'section'     => 'alsiha_header_styles',
			'type'        => 'toggle',
			'priority'    => 25,
			'default'     => 0,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_header_bg_color',
			'label'       => esc_html__( 'Header Background Color', 'alsiha' ),
			'description' => esc_html__( 'Please choose the header background color', 'alsiha' ),
			'section'     => 'header_image',
			'type'        => 'color',
			'priority'    => 30,
			'choices'     => array(
				'alpha' => true,
			),
			'default'     => '#fff',
			'output'      => array(
				array(
					'element'  => 'header .header-area',
					'property' => 'background-color',
				),
			),
			'transport'   => 'auto',
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_enable_sticky_header',
			'label'       => esc_html__( 'Enable Sticky Header?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable sticky header.', 'alsiha' ),
			'section'     => 'alsiha_sticky_header',
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_header_socials',
			'label'       => esc_html__( 'Enable Header Social Icons?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable header social icons.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_header_page_title',
			'label'       => esc_html__( 'Top bar page title', 'alsiha' ),
			'description' => esc_html__( 'Please enter header top bar page title.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'textarea',
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_header_page_selector',
			'label'       => esc_html__( 'Select Top Bar Page', 'alsiha' ),
			'description' => esc_html__( 'Please select header top bar page.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'dropdown-pages',
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_header_phone',
			'label'       => esc_html__( 'Top Bar Phone Text', 'alsiha' ),
			'description' => esc_html__( 'Enter header top bar phone text.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'text',
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_header_phone_url',
			'label'       => esc_html__( 'Top Bar Phone URL', 'alsiha' ),
			'description' => esc_html__( 'Enter header top bar phone URL.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'text',
			'priority'    => 11,
		);

		return $this;
	}

	/**
	 * Footer controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function footer() {
		$this->controls[] = array(
			'type'        => 'image',
			'settings'    => 'alsiha_footer_logo',
			'label'       => esc_html__( 'Footer Top Logo', 'alsiha' ),
			'description' => esc_html__( 'Please upload footer top logo (SVG preferred)', 'alsiha' ),
			'section'     => 'alsiha_footer_styles',
			'priority'    => 11,
			'transport'   => 'auto',
		);

		$this->controls[] = array(
			'type'        => 'color',
			'settings'    => 'alsiha_footer_bgc',
			'label'       => esc_html__( 'Footer background', 'alsiha' ),
			'description' => esc_html__( 'Please choose the footer background color', 'alsiha' ),
			'section'     => 'alsiha_footer_styles',
			'priority'    => 12,
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => '#colophon',
					'property' => 'background-color',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_footer_padding',
			'label'       => esc_html__( 'Footer Padding', 'alsiha' ),
			'description' => esc_html__( 'Footer top/bottom padding. Default: 7rem.', 'alsiha' ),
			'section'     => 'alsiha_footer_styles',
			'type'        => 'dimensions',
			'priority'    => 15,
			'default'     => array(
				'padding-top'    => '7rem',
				'padding-bottom' => '7rem',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'alsiha' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'alsiha' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#colophon',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_enable_100_footer',
			'label'       => esc_html__( '100% Footer?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable 100% footer width, regardless of container.', 'alsiha' ),
			'section'     => 'alsiha_footer_styles',
			'type'        => 'toggle',
			'priority'    => 20,
			'default'     => 0,
		);

		$this->controls[] = array(
			'type'        => 'editor',
			'settings'    => 'alsiha_footer_copyright_text',
			'label'       => esc_html__( 'Footer Copyright Text', 'alsiha' ),
			'description' => esc_html__( 'Please enter footer copyright text.', 'alsiha' ),
			'section'     => 'alsiha_footer_copyright',
			'priority'    => 10,
		);

		return $this;
	}

	/**
	 * Typography controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function typography() {
		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_body_font',
			'label'     => esc_html__( 'Body Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_body',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 10,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'body, button, input, select, textarea',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_nav_font',
			'label'     => esc_html__( 'Menu Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_nav',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'uppercase',
			),
			'priority'  => 15,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => '#main-menu li a',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_icon_nav_font',
			'label'     => esc_html__( 'Icon Menu Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_nav',
			'default'   => array(
				'font-size'      => '1.4rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'capitalize',
			),
			'priority'  => 16,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => '#icon-menu > li a',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_h1_font',
			'label'     => esc_html__( 'Heading-1 Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_h1',
			'default'   => array(
				'font-size'      => '4rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 20,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h1, .h1',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_h2_font',
			'label'     => esc_html__( 'Heading-2 Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_h2',
			'default'   => array(
				'font-size'      => '3.2rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 25,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h2, .h2',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_h3_font',
			'label'     => esc_html__( 'Heading-3 Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_h3',
			'default'   => array(
				'font-size'      => '2.8rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 30,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h3, .h3',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_h4_font',
			'label'     => esc_html__( 'Heading-4 Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_h4',
			'default'   => array(
				'font-size'      => '2.4rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 35,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h4, .h4',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_h5_font',
			'label'     => esc_html__( 'Heading-5 Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_h5',
			'default'   => array(
				'font-size'      => '2rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 40,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h5, .h5',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'alsiha_h6_font',
			'label'     => esc_html__( 'Heading-6 Typography', 'alsiha' ),
			'section'   => 'alsiha_typography_h6',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 45,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h6, .h6',
				),
			),
		);

		return $this;
	}

	/**
	 * Color controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function colors() {
		$this->controls[] = array(
			'settings'  => 'alsiha_text_color',
			'label'     => esc_html__( 'Text Color', 'alsiha' ),
			'section'   => 'alsiha_color_settings',
			'type'      => 'color',
			'priority'  => 10,
			'default'   => '#242545',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'alsiha_primary_color',
			'label'     => esc_html__( 'Primary Color', 'alsiha' ),
			'section'   => 'alsiha_color_settings',
			'type'      => 'color',
			'priority'  => 15,
			'default'   => '#738ff4',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'alsiha_secondary_color',
			'label'     => esc_html__( 'Secondary Color', 'alsiha' ),
			'section'   => 'alsiha_color_settings',
			'type'      => 'color',
			'priority'  => 20,
			'default'   => '#fc346c',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'alsiha_tertiary_color',
			'label'     => esc_html__( 'Tertiary Color', 'alsiha' ),
			'section'   => 'alsiha_color_settings',
			'type'      => 'color',
			'priority'  => 25,
			'default'   => '#fccc6c',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'alsiha_offset_color',
			'label'     => esc_html__( 'Offset Color', 'alsiha' ),
			'section'   => 'alsiha_color_settings',
			'type'      => 'color',
			'priority'  => 30,
			'default'   => '#EFF5FC',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'alsiha_border_color',
			'label'     => esc_html__( 'Border Color', 'alsiha' ),
			'section'   => 'alsiha_color_settings',
			'type'      => 'color',
			'priority'  => 35,
			'default'   => '#DDDDDD',
			'transport' => 'postMessage',
		);

		return $this;
	}

	/**
	 * Page controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function page() {
		$this->controls[] = array(
			'type'         => 'repeater',
			'settings'     => 'alsiha_home_top_slider',
			'label'        => esc_html__( 'Showcase Slider', 'alsiha' ),
			'section'      => 'alsiha_showcase_slider',
			'priority'     => 10,
			'row_label'    => array(
				'type'  => 'text',
				'value' => esc_html__( 'Slides', 'alsiha' ),
			),
			'button_label' => esc_html__( 'Add More', 'alsiha' ),
			'fields'       => array(
				'slide_image'  => array(
					'type'        => 'image',
					'label'       => esc_html__( 'Upload Slide Image', 'alsiha' ),
					'description' => esc_html__( 'Please upload slide image. Recommended image size is 1920x1080 px.', 'alsiha' ),
				),
				// 'promo_title' => array(
				// 	'type'        => 'text',
				// 	'label'       => esc_html__( 'Promo Text', 'alsiha' ),
				// 	'description' => esc_html__( 'Please enter the slide promo text', 'alsiha' ),
				// ),
				'title' => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Slide Title', 'alsiha' ),
					'description' => esc_html__( 'Please enter the slide title text', 'alsiha' ),
				),
				'subtitle' => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Slide Description', 'alsiha' ),
					'description' => esc_html__( 'Please enter the slide description text', 'alsiha' ),
				),
				'link' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Slide URL', 'alsiha' ),
					'description' => esc_html__( 'Please enter the slide link', 'alsiha' ),
				),
			),
		);

		$this->controls[] = array(
			'type'        => 'background',
			'settings'    => 'alsiha_pagetitle_banner_bg',
			'label'       => esc_html__( 'Page title Banner Background', 'alsiha' ),
			'description' => esc_html__( 'Please upload page title banner image. Recommended image size is 1920x1080 px.', 'alsiha' ),
			'section'     => 'alsiha_pagetitle',
			'priority'    => 10,
			'default'     => array(
				'background-image'      => '',
				'background-repeat'     => 'no-repeat',
				'background-position'   => 'left top',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#page-title',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_pagetitle_padding',
			'label'       => esc_html__( 'Page Title Banner Padding', 'alsiha' ),
			'description' => esc_html__( 'Page title banner top/bottom padding. Default: 8rem.', 'alsiha' ),
			'section'     => 'alsiha_pagetitle',
			'type'        => 'dimensions',
			'priority'    => 15,
			'default'     => array(
				'padding-top'    => '8rem',
				'padding-bottom' => '8rem',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'alsiha' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'alsiha' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#page-title',
				),
			),
		);

		$this->controls[] = array(
			'type'        => 'text',
			'settings'    => 'alsiha_pagetitle_blog',
			'label'       => esc_html__( 'Page title Text for Blog', 'alsiha' ),
			'description' => esc_html__( 'Please enter the page title text for blog.', 'alsiha' ),
			'section'     => 'alsiha_pagetitle',
			'priority'    => 25,
			'transport'   => 'auto',
			'default'     => esc_html__( 'blog', 'alsiha' ),
		);

		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'alsiha_enable_breadcrumbs',
			'label'       => esc_html__( 'Enable Breadcrumbs?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable breadcrumbs.', 'alsiha' ),
			'section'     => 'alsiha_breadcrumbs',
			'default'     => 0,
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_page_padding',
			'label'       => esc_html__( 'Page Padding', 'alsiha' ),
			'description' => esc_html__( 'Page top/bottom padding. Default: 8rem.', 'alsiha' ),
			'section'     => 'alsiha_page_styles',
			'type'        => 'dimensions',
			'priority'    => 10,
			'default'     => array(
				'padding-top'    => '8rem',
				'padding-bottom' => '8rem',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'alsiha' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'alsiha' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => 'body:not(.woocommerce-page.archive) #wrapper.inner-page-content',
				),
			),
		);

		return $this;
	}

	/**
	 * Blog controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function blog() {
		$this->controls[] = array(
			'settings'    => 'alsiha_archive_description',
			'label'       => esc_html__( 'Archive Description', 'alsiha' ),
			'description' => esc_html__( 'Please enter archive description.', 'alsiha' ),
			'section'     => 'alsiha_archive_settings',
			'type'        => 'textarea',
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_archive_pagination',
			'label'       => esc_html__( 'Pagination Type', 'alsiha' ),
			'description' => esc_html__( 'Please select the pagination type for archive pages', 'alsiha' ),
			'choices'     => array(
				'classic'  => esc_html__( 'Classic Pagination', 'alsiha' ),
				'numbered' => esc_html__( 'Numbered Pagination', 'alsiha' ),
			),
			'type'        => 'select',
			'section'     => 'alsiha_archive_settings',
			'priority'    => 11,
			'default'     => 'classic',
		);

		// $this->controls[] = array(
		// 	'settings'    => 'alsiha_single_pagination',
		// 	'label'       => esc_html__( 'Enable Single Post Navigation?', 'alsiha' ),
		// 	'description' => esc_html__( 'Enable/disable single post navigation', 'alsiha' ),
		// 	'type'        => 'toggle',
		// 	'section'     => 'alsiha_single_settings',
		// 	'priority'    => 10,
		// 	'default'     => 0,
		// );

		return $this;
	}

	/**
	 * Social Media controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function socials() {
		$this->controls[] = array(
			'type'         => 'repeater',
			'settings'     => 'alsiha_social_media_profiles',
			'label'        => esc_html__( 'Social Media Information', 'alsiha' ),
			'section'      => 'alsiha_social_media',
			'priority'     => 10,
			'row_label'    => array(
				'type'  => 'text',
				'value' => esc_html__( 'Social Profile', 'alsiha' ),
			),
			'button_label' => esc_html__( 'Add More', 'alsiha' ),
			'fields'       => array(
				'type_image'  => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Icon Class', 'alsiha' ),
					'description' => esc_html__( 'Please enter Font Awesome or other icon class', 'alsiha' ),
				),
				'profile_url' => array(
					'type'        => 'link',
					'label'       => esc_html__( 'Profile Link', 'alsiha' ),
					'description' => esc_html__( 'Please enter the social media profile link', 'alsiha' ),
				),
			),
		);

		return $this;
	}

	/**
	 * Integration controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function integrations() {
		$this->controls[] = array(
			'settings'    => 'alsiha_header_code',
			'label'       => esc_html__( 'Header Code', 'alsiha' ),
			'description' => esc_html__( 'Please enter the header code (Wrap this code with &lt;script&gt; tag).', 'alsiha' ),
			'type'        => 'code',
			'section'     => 'alsiha_integrations',
			'choices'     => array(
				'language' => 'html',
			),
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'alsiha_footer_code',
			'label'       => esc_html__( 'Footer Code', 'alsiha' ),
			'description' => esc_html__( 'Please enter the footer code (Wrap this code with &lt;script&gt; tag).', 'alsiha' ),
			'type'        => 'code',
			'section'     => 'alsiha_integrations',
			'choices'     => array(
				'language' => 'html',
			),
			'priority'    => 15,
		);

		return $this;
	}

	/**
	 * Extra controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function extras() {
		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'alsiha_enable_totop',
			'label'       => esc_html__( 'Enable Scroll To-Top Button?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable scroll to top button.', 'alsiha' ),
			'section'     => 'alsiha_extra_settings',
			'default'     => 1,
			'priority'    => 10,
		);

		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'alsiha_enable_pageloader',
			'label'       => esc_html__( 'Enable Page Loader?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable page loader animation.', 'alsiha' ),
			'section'     => 'alsiha_extra_settings',
			'default'     => 1,
			'priority'    => 15,
		);

		return $this;
	}
}
