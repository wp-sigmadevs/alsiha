<?php
/**
 * Backward Compatibility Class.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Backward Compatibility Class.
 */
class Alsiha_Back_Compats {
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
	 * @return Alsiha_Back_Compats
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Compatibility Messages.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function actions() {
		add_action( 'after_switch_theme', [ $this, 'switch_theme' ] );
		add_action( 'admin_notices', [ $this, 'upgrade_notice' ] );
		add_action( 'load-customize.php', [ $this, 'disable_customizer' ] );
		add_action( 'template_redirect', [ $this, 'disable_preview' ] );
	}

	/**
	 * Prevent switching to Alsiha on old versions of WordPress.
	 *
	 * Switches to the default theme.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function switch_theme() {
		switch_theme( WP_DEFAULT_THEME );
		unset( $_GET['activated'] );
	}

	/**
	 * Adds a message for unsuccessful theme switch.
	 *
	 * Prints an update nag after an unsuccessful attempt to switch to
	 * Alsiha on WordPress versions prior to 5.0.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function upgrade_notice() {
		/* translators: %s: WordPress version. */
		$message = sprintf( esc_html__( 'ERROR: Al-Siha requires at least WordPress version 5.0. You are running version %s. Please upgrade and try again.', 'alsiha' ), $GLOBALS['wp_version'] );
		printf( '<div class="error"><p>%s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Prevents the Customizer from being loaded on WordPress
	 * versions prior to 5.0.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function disable_customizer() {
		wp_die(
			sprintf(
				/* translators: %s: WordPress version. */
				esc_html__( 'ERROR: Al-Siha requires at least WordPress version 5.0. You are running version %s. Please upgrade and try again.', 'alsiha' ),
				$GLOBALS['wp_version']
			),
			'',
			[
				'back_link' => true,
			]
		);
	}

	/**
	 * Prevents the Theme Preview from being loaded on WordPress
	 * versions prior to 5.0.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function disable_preview() {
		if ( isset( $_GET['preview'] ) ) {
			/* translators: %s: WordPress version. */
			wp_die( sprintf( esc_html__( 'ERROR: Al-Siha requires at least WordPress version 5.0. You are running version %s. Please upgrade and try again.', 'alsiha' ), $GLOBALS['wp_version'] ) );
		}
	}
}
