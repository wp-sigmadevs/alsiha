<?php
/**
 * Customizer Panels Class.
 * This Class registers Customizer Panels.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Panels Class.
 *
 * @since v1.0
 */
class Alsiha_Customizer_Panels {

	/**
	 * Customizer Panels.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $panels = array();

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
	 * @return Alsiha_Customizer_Panels
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
		$this->set_panels()->add_panels();
	}

	/**
	 * Setting up panels.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function set_panels() {
		$this->panels['alsiha_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'Theme Options', 'alsiha' ),
			'description' => esc_html__( 'Theme options & settings', 'alsiha' ),
		);

		$this->panels['alsiha_general_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'General', 'alsiha' ),
			'description' => esc_html__( 'General settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		);

		$this->panels['header_settings'] = array(
			'priority'    => 11,
			'title'       => esc_html__( 'Header', 'alsiha' ),
			'description' => esc_html__( 'Logo and page-title settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		);

		$this->panels['alsiha_footer_settings'] = array(
			'priority'    => 12,
			'title'       => esc_html__( 'Footer', 'alsiha' ),
			'description' => esc_html__( 'Footer settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		);

		$this->panels['alsiha_texts_colors_settings'] = array(
			'priority'    => 13,
			'title'       => esc_html__( 'Texts & Colors', 'alsiha' ),
			'description' => esc_html__( 'Typography & Color settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		);

		$this->panels['alsiha_typography_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'Typography', 'alsiha' ),
			'description' => esc_html__( 'Typography settings', 'alsiha' ),
			'panel'       => 'alsiha_texts_colors_settings',
		);

		$this->panels['alsiha_page_settings'] = array(
			'priority'    => 14,
			'title'       => esc_html__( 'Page', 'alsiha' ),
			'description' => esc_html__( 'Page settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		);

		$this->panels['alsiha_blog_settings'] = array(
			'priority'    => 15,
			'title'       => esc_html__( 'Blog', 'alsiha' ),
			'description' => esc_html__( 'Archives and single post settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
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
	private function add_panels() {
		if ( empty( $this->panels ) ) {
			return;
		}

		foreach ( $this->panels as $panel_id => $panel_args ) {
			Kirki::add_panel( $panel_id, $panel_args );
		}
	}
}
