<?php
/**
 * Compatibility Class: WooCommerce.
 *
 * This class is responsible for WooCommerce compatibility.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace SigmaDevs\Sigma\Compatibility;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Functions\Helpers
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Compatibility Class: ACF.
 */
class WooCommerce {
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
		if ( ! Helpers::hasWooCommerce() ) {
			return;
		}

		// Setup Woocommerce.
		$this->themeSupport();
	}


	/**
	 * Setup Woocommerce.
	 *
	 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
	 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function themeSupport(): void {
		add_theme_support(
			'woocommerce',
			[
				'thumbnail_image_width' => 400,
				'single_image_width'    => 600,
				'product_grid'          => [
					'default_rows'    => 3,
					'min_rows'        => 1,
					'default_columns' => 3,
					'min_columns'     => 1,
					'max_columns'     => 6,
				],
			]
		);
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
}
