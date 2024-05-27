<?php
/**
 * Functions Class: Actions.
 *
 * List of all functions hooked in action hooks.
 *
 * @package SigmaDevs\AlSiha
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\AlSiha\Common\Functions;

// Do not allow directly accessing this file.
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Functions Class: Actions.
 *
 * @since 1.0.0
 */
class Actions {
	/**
	 * Adds page attributes support to the 'post' post type.
	 *
	 * This static method adds support for page attributes
	 * to the 'post' post type in WordPress.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function pageAttributes() {
		add_post_type_support( 'post', 'page-attributes' );
	}

	/**
	 * Content width in pixels, based on the theme's design and stylesheet.
	 *
	 * @global int $content_width
	 * @return void
	 * @since 1.0.0
	 */
	public static function themeContentWidth() {
		$GLOBALS['content_width'] = apply_filters( 'sd/alsiha/content_width', 960 );
	}

	/**
	 * Add a ping-back url auto-discovery header for
	 * single posts, pages, or attachments.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function pingbackHeader() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

	/**
	 * Insert social meta tags in the head for improved sharing
	 * on social media platforms.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function socialMetaTags() {
		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		if ( ! is_singular( 'post' ) ) {
			return;
		}

		$title         = get_the_title();
		$link          = get_the_permalink() . '?v=' . time();
		$attachmentId  = get_post_thumbnail_id( $post->ID );

		echo '<meta property="og:url" content="' . esc_url( $link ) . '" />';
		echo '<meta property="og:type" content="article" />';
		echo '<meta property="og:title" content="' . esc_html( $title ) . '" />';

		if ( ! empty( $post->post_content ) ) {
			echo '<meta property="og:description" content="' . wp_kses(
				wp_trim_words(
					$post->post_content,
					150
				),
				'alltext_allow'
			) . '" />';
		}

		if ( ! empty( $attachmentId ) ) {
			$thumbnail = wp_get_attachment_image_src( $attachmentId, 'full' );

			if ( ! empty( $thumbnail ) ) {
				$thumbnail[0] .= '?v=' . time();
				echo '<meta property="og:image" content="' . esc_url( $thumbnail[0] ) . '" />';
			}
		}

		echo '<meta property="og:site_name" content="' . esc_html( get_bloginfo( 'name' ) ) . '" />';
		echo '<meta name="twitter:card" content="summary" />';
		echo '<meta property="og:updated_time" content="' . esc_html( time() ) . '" />';
	}

	/**
	 * Perform markup validation on output buffers.
	 *
	 * @returns void
	 * @since 1.0.0
	 */
	public static function markupValidator() {
		// Filter 1: Remove unnecessary type attribute from script tags.
		ob_start(
			function ( $buffer ) {
				return str_replace( [ '<script type="text/javascript">', "<script type='text/javascript'>" ], '<script>', $buffer );
			}
		);

		// Filter 2: Simplify script tag with src attribute.
		ob_start(
			function ( $buffer ) {
				return str_replace( [ "<script type='text/javascript' src" ], '<script src', $buffer );
			}
		);

		// Filter 3: Remove type attribute from style tags.
		ob_start(
			function ( $buffer ) {
				return str_replace( [ ' type="text/css"', " type='text/css'", ' type="text/css"' ], '', $buffer );
			}
		);

		// Filter 4: Simplify iframe tag attributes.
		ob_start(
			function ( $buffer ) {
				return str_replace( [ '<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"' ], '<iframe', $buffer );
			}
		);

		// Filter 5: Remove aria-required attribute.
		ob_start(
			function ( $buffer ) {
				return str_replace( [ 'aria-required="true"' ], '', $buffer );
			}
		);
	}

	/**
	 * Convert a hexadecimal color code to its RGB equivalent.
	 *
	 * @param string $hex The hexadecimal color code to convert.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public static function hex2rgb( $hex ) {
		$hex = str_replace( '#', '', $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		$rgb = "$r, $g, $b";

		return $rgb;
	}

	/**
	 * Set a temporary custom query for the main WordPress loop.
	 *
	 * @param WP_Query $query The custom query object to set temporarily.
	 *
	 * @return WP_Query
	 * @since 1.0.0
	 */
	public static function setTempQuery( $query ) {
		global $wp_query;

		$temp     = $wp_query;
		$wp_query = $query;

		return $temp;
	}

	/**
	 * Reset the main WordPress loop to the previous query
	 * after a temporary switch.
	 *
	 * @param WP_Query $temp The temporary main query object.
	 *
	 * @returns void
	 * @since 1.0.0
	 */
	public static function resetTempQuery( $temp ) {
		global $wp_query;

		$wp_query = $temp;

		wp_reset_postdata();
	}
}
