<?php
/**
 * Compatibility Class: ACF.
 *
 * This class is responsible for Advanced Custom Fields compatibility.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace SigmaDevs\Sigma\Compatibility;

use SigmaDevs\Sigma\Common\Traits\Singleton;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Compatibility Class: ACF.
 */
class ACF {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Registers the class.
	 *
	 * This compatibility class is always being instantiated as requested in the
	 * Bootstrap class.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		if ( ! class_exists( 'ACF' ) ) {
			return;
		}

		// Add Options Page.
		$this->addThemeOptions();
	}

	/**
	 * Show theme options.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function addThemeOptions(): void {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		\acf_add_options_page(
			[
				'page_title' => __( 'Theme Options', 'alsiha' ),
				'menu_title' => __( 'Theme Options', 'alsiha' ),
				'menu_slug'  => 'alsiha-theme-options',
				'icon_url'   => 'dashicons-admin-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
			]
		);
	}
}
