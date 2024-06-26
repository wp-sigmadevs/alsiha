<?php
/**
 * The Public Enqueue class.
 * We're using this one to register public scripts by extending
 * the main Alsiha_Enqueue Class.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Public Enqueue class.
 *
 * @since 1.0.0
 */
class Alsiha_Public_Enqueue extends Alsiha_Enqueue {

	/**
	 * Base Class.
	 *
	 * @access private
	 * @var object
	 * @since 1.0.0
	 */
	private $base;

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
	 * @return Alsiha_Public_Enqueue
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
	 * Registering Scripts.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->base = Alsiha_Base::get_instance();

		// Enqueuing scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Method to enqueue scripts in the frontend.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @return void
	 */
	public function enqueue() {

		// Building up styles & scripts list.
		$this->scripts_list();

		if ( empty( $this->scripts_list() ) ) {
			return;
		}

		// Registering & Enqueuing scripts.
		$this
			->register_scripts()
			->enqueue_scripts()
			->localize( $this->localize_args() );
	}

	/**
	 * Method to build up scripts & styles list.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @return mixed
	 */
	private function scripts_list() {
		$this->get_styles()->get_scripts();

		return $this->enqueues;
	}

	/**
	 * Method to build up styles list.
	 *
	 * @since  1.0.0
	 * @access Private
	 * @static
	 *
	 * @return Object
	 */
	private function get_styles() {
		$styles = array();

		// Google Fonts.
		$styles[] = array(
			'handle'    => 'alsiha-google-fonts',
			'asset_uri' => esc_url( apply_filters( 'alsiha_default_google_fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap' ) ),
			'version'   => null,
		);

		// FontAwesome 5 CSS.
		$styles[] = array(
			'handle'    => 'fontawesome',
			'asset_uri' => $this->base->get_css_uri() . 'fontawesome.min.css',
			'version'   => '5.15.2',
		);

		// Bootstrap CSS.
		$styles[] = array(
			'handle'    => 'bootstrap',
			'asset_uri' => $this->base->get_css_uri() . 'bootstrap.min.css',
			'version'   => '4.6.0',
		);

		// Tooltip CSS.
		$styles[] = array(
			'handle'    => 'jquery-tipsy',
			'asset_uri' => $this->base->get_css_uri() . 'tipsy.min.css',
			'version'   => '1.0.0',
		);

		// Swiper CSS.
		if ( is_front_page() || is_product() ) {
			$styles[] = array(
				'handle'    => 'swiper',
				'asset_uri' => $this->base->get_css_uri() . 'swiper.min.css',
				'version'   => '6.4.11',
			);
		}

		// iziModal CSS.
		if ( is_product() ) {
			$styles[] = array(
				'handle'    => 'izimodal',
				'asset_uri' => $this->base->get_css_uri() . 'iziModal.min.css',
				'version'   => '1.6.0',
			);
		}

		// Main Stylesheet.
		$styles[] = array(
			'handle'    => 'alsiha-stylesheet',
			'asset_uri' => get_stylesheet_uri(),
			'version'   => $this->base->get_theme_version(),
		);

		$this->enqueues['style'] = apply_filters( 'alsiha_frontend_styles', $styles, 10, 1 );

		return $this;
	}

	/**
	 * Method to build up scripts list.
	 *
	 * @since  1.0.0
	 * @access Private
	 * @static
	 *
	 * @return Object
	 */
	private function get_scripts() {
		$scripts = array();

		// Modernizr JS.
		$scripts[] = array(
			'handle'         => 'modernizr',
			'asset_uri'      => $this->base->get_js_uri() . 'modernizr.min.js',
			'dependency'     => array( 'jquery' ),
			'version'        => '1.7.10',
			'load_in_footer' => false,
		);

		// IE Polyfill.
		global $is_IE;
		if ( $is_IE ) {
			$scripts[] = array(
				'handle'         => 'ie11-polyfill-css-variables',
				'asset_uri'      => $this->base->get_js_uri() . 'ie11-polyfill.min.js',
				'dependency'     => array(),
				'version'        => '3.14.1',
				'load_in_footer' => false,
			);
		}

		// Superfish JS.
		$scripts[] = array(
			'handle'     => 'superfish',
			'asset_uri'  => $this->base->get_js_uri() . 'superfish.min.js',
			'dependency' => array( 'jquery' ),
			'version'    => '1.7.10',
		);

		// Headroom JS.
		$scripts[] = array(
			'handle'     => 'headroom',
			'asset_uri'  => $this->base->get_js_uri() . 'headroom.min.js',
			'dependency' => array( 'jquery' ),
			'version'    => '0.12',
		);

		// Handheld Menu JS.
		$scripts[] = array(
			'handle'     => 'alsiha-handheld-menu',
			'asset_uri'  => $this->base->get_js_uri() . 'handheld-menu.js',
			'dependency' => array( 'jquery' ),
			'version'    => '1.0',
		);

		// Swiper JS.
		if ( is_front_page() || is_product() ) {
			$scripts[] = array(
				'handle'     => 'swiper',
				'asset_uri'  => $this->base->get_js_uri() . 'swiper.min.js',
				'dependency' => array( 'jquery' ),
				'version'    => '6.4.11',
			);
		}

		// IziModal JS.
		if ( is_product() ) {
			$scripts[] = array(
				'handle'     => 'izimodal',
				'asset_uri'  => $this->base->get_js_uri() . 'iziModal.min.js',
				'dependency' => array( 'jquery' ),
				'version'    => '1.6.0',
			);
		}

		if ( Alsiha_Helpers::inside_shop() || Alsiha_Helpers::inside_product_cat() || Alsiha_Helpers::inside_top_product_cat() || Alsiha_Helpers::inside_product_attribute() ) {
			// Sticky Sidebar JS.
			$scripts[] = array(
				'handle'     => 'jquery-sticky-sidebar',
				'asset_uri'  => $this->base->get_js_uri() . 'sticky-sidebar.min.js',
				'dependency' => array( 'jquery' ),
				'version'    => '3.3.1',
			);
		}

		// Tooltip JS.
		$scripts[] = array(
			'handle'     => 'jquery-tipsy',
			'asset_uri'  => $this->base->get_js_uri() . 'tipsy.min.js',
			'dependency' => array( 'jquery' ),
			'version'    => '1.0.0',
		);

		// Comment Reply.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			$scripts[] = array(
				'handle' => 'comment-reply',
			);
		}

		// Main Frontend JS.
		$scripts[] = array(
			'handle'     => 'alsiha-frontend-script',
			'asset_uri'  => $this->base->get_js_uri() . 'frontend.js',
			'dependency' => array( 'jquery' ),
			'version'    => $this->base->get_theme_version(),
		);

		$this->enqueues['script'] = apply_filters( 'alsiha_frontend_scripts', $scripts, 10, 1 );

		return $this;
	}

	/**
	 * Localize data.
	 *
	 * @return array
	 */
	private function localize_args() {
		return array(
			'handle'    => 'alsiha-frontend-script',
			'js_object' => 'alsihaSettings',
			'vars'      => array(
				'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
			),
		);
	}
}
