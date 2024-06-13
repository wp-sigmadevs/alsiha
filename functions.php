<?php
/**
 * Theme Engine Room.
 * This theme uses OOP logic instead of procedural coding.
 * All functions, hooks, and actions are properly organized inside related folders and files.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

declare( strict_types=1 );

use SigmaDevs\Sigma\Bootstrap;
use SigmaDevs\Sigma\Common\Functions;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Load PSR4 autoloader.
 *
 * @since 1.0.0
 */
$autoloader = require get_parent_theme_file_path( 'vendor/autoload.php' );

if ( ! class_exists( 'SigmaDevs\Sigma\\Bootstrap' ) ) {
	wp_die( esc_html__( 'Al-Siha is unable to find the Bootstrap class.', 'alsiha' ) );
}

/**
 * Bootstrap the theme.
 *
 * @param object $autoloader Autoloader Object.
 *
 * @since 1.0.0
 */
add_action(
	'after_setup_theme',
	static function () use ( $autoloader ) {
		$app = new Bootstrap();

		// Register all the services.
		$app->registerServices( $autoloader );
	}
);

/**
 * Create a function for external uses.
 *
 * @return Functions
 * @since 1.0.0
 */
function sd_alsiha() {
	return new Functions();
}
