<?php
/**
 * Compatibility Class: Jetpack.
 *
 * This class is responsible for Jetpack compatibility.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace SigmaDevs\Sigma\Compatibility;

use SigmaDevs\Sigma\Common\{Traits\Singleton, Utils\Helpers};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Compatibility Class: Jetpack.
 */
class Jetpack {
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
		if ( ! Helpers::hasJetpack() ) {
			return;
		}

		// Setup Jetpack.
		$this->themeSupport();
	}

	/**
	 * Setup Jetpack.
	 *
	 * See: https://jetpack.com/support/infinite-scroll/
	 * See: https://jetpack.com/support/responsive-videos/
	 * See: https://jetpack.com/support/content-options/
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function themeSupport(): void {
		// Add theme support for Infinite Scroll.
		add_theme_support(
			'infinite-scroll',
			[
				'container'      => 'posts-container',
				'render'         => [ $this, 'infiniteScrollRender' ],
				'posts_per_page' => get_option( 'posts_per_page' ),
				'wrapper'        => false,
				'footer'         => false,
			]
		);

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );

		// Add theme support for Content Options.
		add_theme_support(
			'jetpack-content-options',
			[
				'post-details'    => [
					'stylesheet' => 'alsiha-style',
					'date'       => '.posted-on',
					'categories' => '.cat-links',
					'tags'       => '.tags-links',
					'author'     => '.byline',
					'comment'    => '.comments-link',
				],
				'featured-images' => [
					'archive' => true,
					'post'    => true,
					'page'    => true,
				],
			]
		);
	}

	/**
	 * Custom render function for Infinite Scroll.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function infiniteScrollRender(): void {
		while ( have_posts() ) {
			the_post();

			if ( is_search() ) {
				sd_alsiha()->templates()->get( 'content/content', 'search' );
			} else {
				sd_alsiha()->templates()->get( 'content/content', get_post_type() );
			}
		}
	}
}
