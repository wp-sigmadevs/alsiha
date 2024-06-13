<?php
/**
 * Abstract Class: Widget
 *
 * This Widget class which can be extended by other classes to add and register widgets.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Abstracts;

use WP_Widget;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Abstract Class: Widget
 *
 * @since 1.0.0
 */
abstract class Widgets extends WP_Widget {
	/**
	 * Widget name.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected string $widgetName;

	/**
	 * Registers the shortcode.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		add_action( 'widgets_init', [ $this, 'addWidgets' ] );
	}

	/**
	 * Adds widget.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function addWidgets(): void {
		register_widget( $this->widgetName );
	}
}
