<?php
/**
 * CSS Variables Class.
 * This Class assigns CSS custom properties.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * SS Variables Class.
 *
 * @since v1.0.0
 */
class Alsiha_CSS_Variables {

	/**
	 * Variables to include.
	 *
	 * @access private
	 * @var array
	 * @since 1.0.0
	 */
	private $variables = array();

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
	 * @return Alsiha_Color_Patterns
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Colors.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->colors();

		if ( empty( $this->variables ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'print' ) );
	}

	/**
	 * Add inline style for variables.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function print() {
		$theme_vars  = '';
		$theme_vars .= '
			:root {
				--alsiha-text-color: ' . $this->variables['colors']['text'] . ';
				--alsiha-primary-color: ' . $this->variables['colors']['primary'] . ';
				--alsiha-secondary-color: ' . $this->variables['colors']['secondary'] . ';
				--alsiha-tertiary-color: ' . $this->variables['colors']['tertiary'] . ';
				--alsiha-offset-color: ' . $this->variables['colors']['offset'] . ';
				--alsiha-border-color: ' . $this->variables['colors']['border'] . ';
		}';

		wp_add_inline_style( 'alsiha-stylesheet', $theme_vars );
	}


	/**
	 * Colors.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function colors() {
		$this->variables['colors']['text']      = get_theme_mod( 'alsiha_text_color', '#242545' );
		$this->variables['colors']['primary']   = get_theme_mod( 'alsiha_primary_color', '#F93001' );
		$this->variables['colors']['secondary'] = get_theme_mod( 'alsiha_secondary_color', '#404040' );
		$this->variables['colors']['tertiary']  = get_theme_mod( 'alsiha_tertiary_color', '#bfbfbf' );
		$this->variables['colors']['offset']    = get_theme_mod( 'alsiha_offset_color', '#EFF5FC' );
		$this->variables['colors']['border']    = get_theme_mod( 'alsiha_border_color', '#DDDDDD' );

		return $this;
	}
}
