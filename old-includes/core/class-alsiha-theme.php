<?php
/**
 * The main theme initialization class.
 * We're using this one to instantiate other classes
 * and access the main theme objects.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Main Theme Class.
 */
final class Alsiha_Theme {

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
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Alsiha_Theme
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Method to register the services and functions.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register_services() {
		$this->base = Alsiha_Base::get_instance();
		$this->functions()->services();
	}

	/**
	 * Store all the classes.
	 *
	 * @access private
	 * @return array
	 *
	 * @since 1.0.0
	 */
	private function get_classes() {
		$classes = array(
			Alsiha_Admin::class,
			Alsiha_Customizer::class,
			Alsiha_ACF::class,
			Alsiha_Setup::class,
			Alsiha_Widgets::class,
			Alsiha_Post_Types::class,
			Alsiha_Menus::class,
			Alsiha_Public_Enqueue::class,
			Alsiha_CSS_Variables::class,
			Alsiha_Shortcodes::class,
		);

		if ( Alsiha_Helpers::has_woocommerce() ) {
			$classes[] = Alsiha_Woocommerce::class;
			$classes[] = Alsiha_Ajax::class;
		}

		if ( Alsiha_Helpers::has_jetpack() ) {
			$classes[] = Alsiha_Jetpack::class;
		}

		return $classes;
	}

	/**
	 * Store all the files.
	 *
	 * @access private
	 * @return array
	 *
	 * @since 1.0.0
	 */
	private function get_files() {
		$files = array(
			$this->base->get_framework_directory() . 'functions/theme-functions',
			$this->base->get_framework_directory() . 'functions/template-functions',
		);

		return $files;
	}

	/**
	 * Method to register the functions.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function functions() {
		foreach ( $this->get_files() as $file ) {
			$this->base::require_file( "$file.php" );
		}

		return $this;
	}

	/**
	 * Method to register the services.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function services() {
		foreach ( $this->get_classes() as $service ) {
			$this->base::require_service( $service );
		}

		return $this;
	}
}
