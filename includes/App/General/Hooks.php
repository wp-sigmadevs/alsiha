<?php
/**
 * General Class: Hooks.
 *
 * This class initializes all the Action & Filter Hooks.
 *
 * @package SigmaDevs\AlSiha
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\AlSiha\App\General;

use SigmaDevs\AlSiha\Common\
{
	Abstracts\Base,
	Traits\Singleton,
	Functions\Actions,
	Functions\Filters
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
	 * Bootstrap class
	 *
	 * @return void
	 * @see Bootstrap::registerServices
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this
			->actions()
			->filters();
	}

	/**
	 * List of action hooks
	 *
	 * @return Hooks
	 */
	public function actions() {
		// Backend.
		add_action( 'admin_init', [ Actions::class, 'pageAttributes' ] );

		// Frontend.
		add_action( 'init', [ Actions::class, 'themeContentWidth' ], 0 );
		add_action( 'wp_head', [ Actions::class, 'pingbackHeader' ] );
		add_action( 'wp_head', [ Actions::class, 'socialMetaTags' ] );
		add_action( 'template_redirect', [ Actions::class, 'markupValidator' ] );

		return $this;
	}

	/**
	 * List of filter hooks
	 *
	 * @return void
	 */
	public function filters() {
		// Frontend.
		add_filter( 'wp_kses_allowed_html', [ Filters::class, 'allowedHtml' ], 10, 2 );
		add_filter( 'get_the_archive_title', [ Filters::class, 'archiveTitle' ] );
		add_filter( 'body_class', [ Filters::class, 'bodyClasses' ] );
	}
}
