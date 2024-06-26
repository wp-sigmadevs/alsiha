<?php
/**
 * Config Class: I18n.
 *
 * Internationalization and localization definitions.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Config;

use SigmaDevs\Sigma\Common\
{
	Abstracts\Base,
	Traits\Singleton,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Config Class: I18n.
 *
 * @since 1.0.0
 */
final class I18n extends Base {
	/**
	 * Singleton trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Load the theme text domain for translation.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function load(): void {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Easy Docs, use a find and replace
		 * to change 'alsiha' to the name of your theme in all the
		 * template files.
		 */
		load_theme_textdomain( $this->theme->textDomain(), $this->theme->languagePath() );
	}
}
