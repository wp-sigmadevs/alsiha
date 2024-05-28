<?php
/**
 * Functions Class: Helpers.
 *
 * List of all helper functions.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Functions;

use WP_Term;
use WP_Error;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Functions Class: Helpers.
 *
 * @since 1.0.0
 */
class Helpers {
	/**
	 * Gets Ajax URL.
	 *
	 * @static
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function ajaxUrl() {
		return admin_url( 'admin-ajax.php' );
	}

	/**
	 * Nonce Text.
	 *
	 * @static
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function nonceText() {
		return 'sd_alsiha_nonce_secret';
	}

	/**
	 * Nonce ID.
	 *
	 * @static
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function nonceId() {
		return 'sd_alsiha_nonce';
	}

	/**
	 * Check if the AJAX call is valid.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function verifyAjaxCall() {
		// Verifies the Ajax request.
		if ( ! check_ajax_referer( self::nonceText(), self::nonceId(), false ) ) {
			wp_send_json(
				[
					'error'        => true,
					'errorMessage' => esc_html__( 'Security Check Failed. Access Denied!', 'alsiha' ),
				]
			);
		}
	}

	/**
	 * Renders a view file.
	 *
	 * @param string $viewName The name of the view file.
	 * @param array  $args Arguments to pass to the view file.
	 *
	 * @return WP_Error|void
	 * @since  1.0.0
	 */
	public static function renderView( $viewName, $args = [] ) {
		$file       = str_replace( '.', '/', $viewName );
		$file       = ltrim( $file, '/' );
		$pluginPath = sd_alsiha()->getThemePath();
		$viewsPath  = sd_alsiha()->getData()['views_folder'];
		$viewFile   = trailingslashit( $pluginPath . '/' . $viewsPath ) . $file . '.php';

		if ( ! file_exists( $viewFile ) ) {
			return new WP_Error(
				'brock',
				/* translators: View file name. */
				sprintf( esc_html__( '%s file not found', 'alsiha' ), $viewFile )
			);
		}

		load_template( $viewFile, true, $args );
	}

	/**
	 * Get the arguments for configuring a navigation menu.
	 *
	 * @param array $args Custom args.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public static function navMenuArgs( $args = [] ) {
		$defaults = [
			'theme_location'  => '',
			'menu'            => '',
			'container'       => 'ul',
			'container_class' => 'main-menu',
			'container_id'    => '',
			'menu_class'      => 'sf-menu',
			'menu_id'         => 'main-menu',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => '',
		];

		$defaults = apply_filters( 'sigmadevs/sigma/nav_menu_defaults', $defaults, $args );

		return wp_parse_args( $args, $defaults );
	}

	/**
	 * Check if the WooCommerce plugin is active.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public static function hasWooCommerce() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Check if the Jetpack plugin is active.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public static function hasJetpack() {
		return class_exists( 'Jetpack' );
	}

	/**
	 * Check if the current context is within a Tribe Events Calendar event.
	 *
	 * @param int|false $id The event ID to check.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public static function insideTribeEvent( $id = false ) {
		if ( function_exists( 'tribe_is_event' ) ) {
			if ( false === $id ) {
				return (bool) tribe_is_event();
			} else {
				return (bool) tribe_is_event( $id );
			}
		}
		return false;
	}

	/**
	 * Check if the current context is within the WooCommerce pages.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public static function insideWooCommerce() {
		if ( function_exists( 'is_woocommerce' ) ) {
			return is_woocommerce();
		}

		return false;
	}

	/**
	 * Check if the current context is within the WooCommerce shop page.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public static function insideShop() {
		if ( function_exists( 'is_shop' ) ) {
			return is_shop();
		}

		return false;
	}

	/**
	 * Method to beautify string.
	 *
	 * @param string $string String to beautify.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function beautify( $string ) {
		return ucwords( str_replace( '_', ' ', $string ) );
	}

	/**
	 * Method to uglify string.
	 *
	 * @param string $string String to uglify.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function uglify( $string ) {
		return strtolower( str_replace( ' ', '_', $string ) );
	}

	/**
	 * Method to Pluralize string.
	 *
	 * @param string $string String to Pluralize.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function pluralize( $string ) {
		$last = $string[ strlen( $string ) - 1 ];

		if ( 'y' === $last ) {
			$cut = substr( $string, 0, -1 );
			// convert y to ies.
			$plural = $cut . 'ies';
		} elseif ( 's' === $last ) {
			return $string;
		} else {
			// just attach an s.
			$plural = $string . 's';
		}

		return $plural;
	}

	/**
	 * Retrieve the first matching term based on a given key and value,
	 * with caching support.
	 *
	 * This function is an enhancement of the WordPress native get_term_by()
	 * function, offering caching to improve performance.
	 *
	 * @param string     $field   The field to match.
	 * @param string|int $value   The value to search for.
	 * @param string     $taxonomy The taxonomy to which the term belongs.
	 * @param string     $output  The output type.
	 * @param string     $filter  How to sanitize the term fields.
	 *
	 * @return WP_Term|array|false|null
	 * @since 1.0.0
	 */
	public static function getTermBy( $field, $value, $taxonomy, $output = OBJECT, $filter = 'raw' ) {
		if ( 'id' == $field ) {
			return get_term_by( $field, $value, $taxonomy, $output, $filter );
		}

		$cacheKey = $field . '|' . $taxonomy . '|' . md5( $value );
		$termId   = wp_cache_get( $cacheKey, 'get_term_by' );

		if ( false === $termId ) {
			$term = get_term_by( $field, $value, $taxonomy );

			if ( $term && ! is_wp_error( $term ) ) {
				wp_cache_set( $cacheKey, $term->term_id, 'get_term_by' );
			} else {
				wp_cache_set( $cacheKey, 0, 'get_term_by' );
			}
		} else {
			$term = get_term( $termId, $taxonomy, $output, $filter );
		}

		if ( is_wp_error( $term ) ) {
			$term = false;
		}

		return $term;
	}

	/**
	 * Retrieve the permalink for a term with caching support.
	 *
	 * This function is designed to retrieve the permalink for a term based on
	 * its slug, with added caching support to improve performance.
	 *
	 * @param int|object|string $term     The term to retrieve the permalink for.
	 * @param string|null       $taxonomy The taxonomy to which the term belongs.
	 *
	 * @return string|false
	 * @since 1.0.0
	 */
	public static function getTermLink( $term, $taxonomy = null ) {
		if ( is_numeric( $term ) || is_object( $term ) ) {
			return get_term_link( $term, $taxonomy );
		}

		$termObject = self::getTermBy( 'slug', $term, $taxonomy );

		return get_term_link( $termObject );
	}

	/**
	 * Check if a term exists in a taxonomy with caching support.
	 *
	 * This function is an enhancement of the WordPress native term_exists()
	 * function, providing caching support to improve performance.
	 *
	 * @param string|int $term     The term name, slug, or ID.
	 * @param string     $taxonomy The taxonomy to check within.
	 * @param int|null   $parent   The parent term ID to check within.
	 *
	 * @return array|null|WP_Error
	 * @since 1.0.0
	 */
	public static function termExists( $term, $taxonomy = '', $parent = null ) {
		if ( null !== $parent ) {
			return term_exists( $term, $taxonomy, $parent );
		}

		if ( ! empty( $taxonomy ) ) {
			$cacheKey = $term . '|' . $taxonomy;
		} else {
			$cacheKey = $term;
		}

		$cacheValue = wp_cache_get( $cacheKey, 'term_exists' );

		if ( false === $cacheValue ) {
			$termExists = term_exists( $term, $taxonomy );
			wp_cache_set( $cacheKey, $termExists, 'term_exists' );
		} else {
			$termExists = $cacheValue;
		}

		if ( is_wp_error( $termExists ) ) {
			$termExists = null;
		}

		return $termExists;
	}
}
