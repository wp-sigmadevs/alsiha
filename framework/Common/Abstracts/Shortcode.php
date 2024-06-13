<?php
/**
 * Abstract Class: Shortcode
 *
 * This Shortcode class which can be extended by other classes to add and register shortcodes.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Abstracts;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Abstract Class: Shortcode
 *
 * @since 1.0.0
 */
abstract class Shortcode {
	/**
	 * Shortcode name tag.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected string $shortcodeTag = '';

	/**
	 * Registers the shortcode.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		add_action( 'init', [ $this, 'addShortcode' ] );
	}

	/**
	 * Adds shortcode.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function addShortcode(): void {
		add_shortcode( $this->shortcodeTag, [ $this, 'shortcodeCallback' ] );
	}

	/**
	 * Shortcode callback.
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	abstract public function shortcodeCallback( array $atts );
}
