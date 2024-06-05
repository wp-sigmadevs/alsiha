<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

use SigmaDevs\Sigma\Common\Functions\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$sidebar = 'alsiha-sidebar-general';

if ( is_active_sidebar( 'alsiha-sidebar-blog' ) && ( is_single() || is_home() || is_archive() ) ) {
	$sidebar = 'alsiha-sidebar-blog';
} elseif ( Helpers::hasWooCommerce() && Helpers::isWooCommerce() && is_active_sidebar( 'alsiha-sidebar-products' ) ) {
	$sidebar = 'alsiha-sidebar-products';
}

/**
 * Display dynamic sidebar.
 */
dynamic_sidebar( $sidebar );
