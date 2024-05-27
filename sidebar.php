<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( is_single() && is_active_sidebar( 'alsiha-sidebar-blog' ) ) {
	dynamic_sidebar( 'alsiha-sidebar-blog' );
} elseif ( Alsiha_Helpers::has_woocommerce() && is_active_sidebar( 'alsiha-sidebar-caregory' ) && Alsiha_Helpers::inside_top_product_cat() ) {
	dynamic_sidebar( 'alsiha-sidebar-caregory' );
} elseif ( Alsiha_Helpers::has_woocommerce() && is_active_sidebar( 'alsiha-sidebar-products' ) && Alsiha_Helpers::inside_product_cat() ) {
	dynamic_sidebar( 'alsiha-sidebar-products' );
} elseif ( Alsiha_Helpers::has_woocommerce() && is_active_sidebar( 'alsiha-sidebar-products' ) && Alsiha_Helpers::inside_product_attribute() ) {
	dynamic_sidebar( 'alsiha-sidebar-products' );
} elseif ( Alsiha_Helpers::has_woocommerce() && is_active_sidebar( 'alsiha-sidebar-products' ) && Alsiha_Helpers::inside_woocommerce() ) {
	dynamic_sidebar( 'alsiha-sidebar-products' );
} elseif ( is_home() && is_active_sidebar( 'alsiha-sidebar-blog' ) ) {
	dynamic_sidebar( 'alsiha-sidebar-blog' );
} elseif ( is_archive() && is_active_sidebar( 'alsiha-sidebar-blog' ) ) {
	dynamic_sidebar( 'alsiha-sidebar-blog' );
} else {
	dynamic_sidebar( 'alsiha-sidebar-general' );
}
