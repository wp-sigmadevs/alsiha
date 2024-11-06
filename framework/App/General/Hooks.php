<?php
/**
 * General Class: Hooks.
 *
 * This class initializes all the Action & Filter Hooks.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General;

use SigmaDevs\Sigma\Common\{
	Utils\Actions,
	Utils\Filters,
	Abstracts\Base,
	Traits\Singleton,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * General Class: Hooks.
 *
 * @since 1.0.0
 */
class Hooks extends Base {
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
	 * This general class is always being instantiated as requested in the
	 * Bootstrap class.
	 *
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		$this
			->actions()
			->filters();
	}

	/**
	 * List of action hooks
	 *
	 * @return Hooks
	 * @since  1.0.0
	 */
	public function actions(): Hooks {
		/**
		 * Backend Actions.
		 */
		// Adds page attributes support to the 'post' post-type.
		add_action( 'admin_init', [ Actions::class, 'pageAttributes' ] );

		/**
		 * Frontend Actions.
		 */
		// Set the content width for the theme.
		add_action( 'init', [ Actions::class, 'themeContentWidth' ], 0 );

		// Add ping back header to the frontend.
		add_action( 'wp_head', [ Actions::class, 'pingbackHeader' ] );

		// Add social meta tags to the frontend.
		add_action( 'wp_head', [ Actions::class, 'socialMetaTags' ] );

		// Redirect to markup validator if necessary.
		add_action( 'template_redirect', [ Actions::class, 'markupValidator' ] );

		// Adds an empty placeholder div for handheld menu masking.
		add_action( 'wp_footer', [ Actions::class, 'handheldMenuMask' ] );

		// Adds a scroll to top button.
		add_action( 'wp_footer', [ Actions::class, 'scrollToTopButton' ] );

		// Adds header codes.
		add_action( 'wp_head', [ Actions::class, 'headerCodes' ] );

		// Adds footer codes.
		add_action( 'wp_footer', [ Actions::class, 'footerCodes' ] );

		// Adds a page loading animation.
		add_action( 'wp_body_open', [ Actions::class, 'sitePreLoader' ] );

		return $this;
	}

	/**
	 * List of filter hooks
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function filters(): void {
		/**
		 * Backend Filters.
		 */
		// Custom notice for featured image.
		add_filter( 'admin_post_thumbnail_html', [ Filters::class, 'featuredImageNotice' ] );

		/**
		 * Front-end Filters.
		 */
		// Add custom allowed HTML tags for frontend.
		add_filter( 'wp_kses_allowed_html', [ Filters::class, 'allowedHtml' ], 10, 2 );

		// Customize the archive title.
		add_filter( 'get_the_archive_title', [ Filters::class, 'archiveTitle' ] );

		// Add custom body classes.
		add_filter( 'body_class', [ Filters::class, 'bodyClasses' ] );

		// Remove category title prefix.
		add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

		// Adds a title to posts and pages that are missing titles.
		add_filter( 'the_title', [ Filters::class, 'emptyPostTitle' ] );

		// Footer shortcode support.
		add_filter( 'widget_text', 'shortcode_unautop' );
		add_filter( 'widget_text', 'do_shortcode' );

		// Disable Elementor google fonts.
		add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
	}
}
