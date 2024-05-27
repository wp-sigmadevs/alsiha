<?php
/**
 * The Widget class.
 * We're using this one to register various widget locations.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Widgets class.
 *
 * @since 1.0.0
 */
class Alsiha_Widgets {

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 *
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Alsiha_Widgets
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Widgets.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'widgets_init', array( $this, 'locations' ) );
	}

	/**
	 * Widgets Locations.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function locations() {
		$this->sidebar();
		$this->footer();
	}

	/**
	 * Widgets: Sidebar.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function sidebar() {
		self::register_widget_area(
			array(
				'name'        => esc_html__( 'Sidebar (General)', 'alsiha' ),
				'id'          => esc_attr( 'alsiha-sidebar-general' ),
				'description' => esc_html__( 'This sidebar will show everywhere the sidebar is enabled, both Posts and Pages.', 'alsiha' ),
			)
		);

		// self::register_widget_area(
		// 	array(
		// 		'name'        => esc_html__( 'Sidebar (Blog)', 'alsiha' ),
		// 		'id'          => esc_attr( 'alsiha-sidebar-blog' ),
		// 		'description' => esc_html__( 'This sidebar will show in Blog (Posts) page.', 'alsiha' ),
		// 	)
		// );

		if ( Alsiha_Helpers::has_woocommerce() ) {
			self::register_widget_area(
				array(
					'name'        => esc_html__( 'Sidebar (Product Categories)', 'alsiha' ),
					'id'          => esc_attr( 'alsiha-sidebar-caregory' ),
					'description' => esc_html__( 'This sidebar will show in product categories pages.', 'alsiha' ),
				)
			);

			self::register_widget_area(
				array(
					'name'        => esc_html__( 'Sidebar (Products)', 'alsiha' ),
					'id'          => esc_attr( 'alsiha-sidebar-products' ),
					'description' => esc_html__( 'This sidebar will show in products pages.', 'alsiha' ),
				)
			);
		}
	}

	/**
	 * Widgets: Footer.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function footer() {
		self::register_widget_area(
			array(
				'name'        => esc_html__( 'Footer Top Column 1', 'alsiha' ),
				'id'          => esc_attr( 'alsiha-footer-top-col-1' ),
				'description' => esc_html__( 'The widget area for the footer top column-1.', 'alsiha' ),
				'before_widget' => '<aside id="%1$s" class="%2$s footer-widget">',
				'after_widget'  => '</aside>',
			)
		);

		self::register_widget_area(
			array(
				'name'        => esc_html__( 'Footer Top Column 2', 'alsiha' ),
				'id'          => esc_attr( 'alsiha-footer-top-col-2' ),
				'description' => esc_html__( 'The widget area for the footer top column.', 'alsiha' ),
				'before_widget' => '<aside id="%1$s" class="%2$s footer-widget">',
				'after_widget'  => '</aside>',
			)
		);

		for ( $footer_col = 1; $footer_col <= 4; $footer_col++ ) {
			self::register_widget_area(
				array(
					'name'          => esc_html__( 'Footer Bottom Column', 'alsiha' ) . ' - ' . esc_attr( $footer_col ),
					'id'            => esc_attr( 'alsiha-footer-bottom-col-' ) . esc_attr( $footer_col ),
					'description'   => esc_html__( 'The widget area for the footer bottom column', 'alsiha' ) . ' - ' . esc_attr( $footer_col ),
					'before_widget' => '<aside id="%1$s" class="%2$s footer-widget">',
					'after_widget'  => '</aside>',
				)
			);
		}
	}

	/**
	 * Method to expedite the widget area registration process.
	 *
	 * @access public
	 * @param array $args Widget arguments.
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	public static function register_widget_area( array $args ) {

		$defaults = array(
			'before_widget' => '<section id="%1$s" class="%2$s sidebar-widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title widgettitle">',
			'after_title'   => '</h4>',
		);

		$defaults = apply_filters( 'alsiha_widget_area_defaults', $defaults, $args );

		$args = wp_parse_args( $args, $defaults );

		return register_sidebar( $args );
	}
}
