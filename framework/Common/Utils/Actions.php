<?php
/**
 * Utility Class: Actions.
 *
 * List of all functions hooked in action hooks.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Utils;

use WP_Query;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Utils Class: Actions.
 *
 * @since 1.0.0
 */
class Actions {
	/**
	 * Adds page attributes support to the 'post' post-type.
	 *
	 * This static method adds support for page attributes
	 * to the 'post' post type in WordPress.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function pageAttributes(): void {
		add_post_type_support( 'post', 'page-attributes' );
	}

	/**
	 * Content width in pixels, based on the theme's design and stylesheet.
	 *
	 * @global int $content_width
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function themeContentWidth(): void {
		$GLOBALS['content_width'] = apply_filters( 'sigmadevs/sigma/content_width', 960 );
	}

	/**
	 * Add a ping-back url auto-discovery header for single posts, pages, or attachments.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function pingbackHeader(): void {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

	/**
	 * Insert social meta-tags in the head for improved sharing
	 * on social media platforms.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function socialMetaTags(): void {
		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		if ( ! is_singular( 'post' ) ) {
			return;
		}

		$title        = get_the_title();
		$link         = get_the_permalink() . '?v=' . time();
		$attachmentId = get_post_thumbnail_id( $post->ID );

		echo '<meta property="og:url" content="' . esc_url( $link ) . '" />';
		echo '<meta property="og:type" content="article" />';
		echo '<meta property="og:title" content="' . esc_html( $title ) . '" />';

		if ( ! empty( $post->post_content ) ) {
			echo '<meta property="og:description" content="' . wp_kses(
				wp_trim_words(
					$post->post_content,
					150
				),
				'allow_content'
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
	 * @return void
	 * @since  1.0.0
	 */
	public static function markupValidator(): void {
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
	 * @since  1.0.0
	 */
	public static function hex2rgb( $hex ): string {
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

		return "$r, $g, $b";
	}

	/**
	 * Set a temporary custom query for the main WordPress loop.
	 *
	 * @param WP_Query $query The custom query object to set temporarily.
	 *
	 * @return WP_Query
	 * @since  1.0.0
	 */
	public static function setTempQuery( $query ): WP_Query {
		global $wp_query;

		$temp     = $wp_query;
		$wp_query = $query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

		return $temp;
	}

	/**
	 * Reset the main WordPress loop to the previous query after a temporary switch.
	 *
	 * @param WP_Query $temp The temporary main query object.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function resetTempQuery( $temp ): void {
		global $wp_query;

		$wp_query = $temp; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

		wp_reset_postdata();
	}

	/**
	 * Adds an empty placeholder div for handheld menu masking.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function handheldMenuMask(): void {
		?>
		<div id="alsiha-menu-mask" class="alsiha-menu-mask"></div>
		<!-- <?php echo esc_attr__( 'Empty placeholder for handheld Menu masking.', 'alsiha' ); ?> -->
		<?php
	}

	/**
	 * Adds a scroll to top button.
	 *
	 * @return string|false|null
	 * @since  1.0.0
	 */
	public static function scrollToTopButton(): string|false|null {
		if ( false === sd_alsiha()->getOption( 'alsiha_enable_totop' ) ) {
			return null;
		}

		ob_start();
		?>
		<div class="alsiha-scroll-to-top">
			<svg class="scroll-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
				<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
			</svg>
		</div><!-- .alsiha-scroll-to-top -->
		<?php
		echo wp_kses( ob_get_clean(), 'allow_content' );

		return false;
	}

	/**
	 * Adds header codes.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function headerCodes(): void {
		$header_code = sd_alsiha()->getOption( 'alsiha_header_code' );

		if ( ! empty( $header_code ) ) {
			echo $header_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Adds footer codes.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function footerCodes(): void {
		$footer_code = sd_alsiha()->getOption( 'alsiha_footer_code' );

		if ( ! empty( $footer_code ) ) {
			echo $footer_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Adds a page loading animation.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function sitePreLoader(): void {
		if ( false === sd_alsiha()->getOption( 'alsiha_enable_pageloader' ) ) {
			return;
		}
		?>
		<div class="alsiha-site-preloader">
			<div class="site-preloader-inner">
				<div class="loader">
					<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 189.34 211.01"><defs><style>.cls-1{fill:#daa756;fill-rule:evenodd;}</style></defs><path class="cls-1" d="M1,141a77.22,77.22,0,0,0,9.36-.35c2.74-.31,3.45-1.51,4.09-3.9a47,47,0,0,0,1-6.57s6.11-.43,8.91-.79c3.34-.44,4.11-.75,4.7-5,.34-2.39.64-4.83,1.07-7.71-3.16.09-6,.22-10.89.29-3.55,0-4.63,1.8-4.65,4.92,0,2.54-.05,4.16-.09,6.24-5.55,0-7.08,0-10.37.17-2.65.09-3.95,1.45-4,4a24.87,24.87,0,0,0,.12,3.34C.52,138.21,1,141,1,141Z"/><path class="cls-1" d="M175.4,158.6c12.46-17.53,17.68-36.34,11-56.95-3.56-11-10.11-20.85-16.58-30.75-5.43-8.3-10.93-16.64-15.32-25.37-4.9-9.72-3-19.08,4.58-27.38a11.56,11.56,0,0,0,1.19-1.89l-.94-.76a18.64,18.64,0,0,0-1.47,1.32c-3.31,3.6-6.8,7.09-9.82,10.87a23.54,23.54,0,0,0-5.61,13.78c-.43,9.16,3.76,17.11,8.71,24.84,5.67,8.85,11.82,17.47,17.38,26.37,12.87,20.59,15.14,41.62,3.85,63.08-5.31,10.08-12.48,19.07-20.71,27.46-2,2-2.71,3.86-.07,6,4.86,4,4.81,4,.59,8.6L151,199.12c-3.14,3.34-3,4,.86,7a50,50,0,0,1,4.61,4.84c2.35-2.52,5.19-5.31,7.61-8.35.63-.79.37-2.55-.22-3.54s-2.09-1.92-3.31-2.72c-2-1.33-2.49-2.63-.58-4.34a54.69,54.69,0,0,0,3.84-4.08c2.78-3.08,2.66-3.91-.83-6.57-1.31-1-2.59-2-4-3.2,1.05-1.18,1.91-2.1,2.72-3.06C166.3,169.65,171.3,164.37,175.4,158.6Z"/><path class="cls-1" d="M140.28,18.74c3.17,1.68,2.7,3.67,1.12,5.88-.8,1.13-1.63,2.24-2.76,3.78,1.17-.13,1.7,0,1.86-.22,3.77-4.12,7.69-8.14,11.15-12.44,1.87-2.33.89-4.7-2-6.23-3.11-1.64-2.83-3.6-1-5.82.76-.93,1.37-2,2-2.94L149.42,0c-3.59,4-7.27,7.91-10.72,12C136.54,14.54,137,17,140.28,18.74Z"/><path class="cls-1" d="M92.35,173.34c-1.65,0-3.3,0-4.77,0-.31-1-.6-1.88-.9-2.81,6.3-.38,12.2-6.57,12.2-6.57s7.08.83,9.2,1.19c.9.15,1.82.23,2.74.3,1.08.07,2.15.11,3.21.1h0c16.19-.28,26-.49,39.27-12,11.95-10.35,12.41-32.51,5.75-46.84-3.57-7.67-8.94-14.15-14.26-20.68A200.8,200.8,0,0,1,132,69.16c-4.28-6.57-4.12-13.61-.14-20.46a8.49,8.49,0,0,0,.55-1.51l-.69-.45c-.27.37-.58.72-.81,1.11-1.73,3-3.6,5.9-5.13,9a18.7,18.7,0,0,0-2.06,10.65c.76,6.73,4.38,12.09,8.47,17.2,4.69,5.86,9.66,11.5,14.29,17.4,10.69,13.66,15.35,40.33,5,49.14-7.16,6.08-15.93,8.79-23.94,9.9a15.55,15.55,0,0,0,3.17-4.16,35.1,35.1,0,0,0,1.92-6.41c.34-1.49.71-4,1.12-6,.23-1.13.51-2.24.83-3.34,1.44-4.95,4.22-7,9.45-7,.68,0,1.35,0,2-.06,0-.22.1-1,.1-1l-1.73-.18c-3.25-.35-6.49-.74-9.74-.95a39,39,0,0,0-15.09,1.62c-7.44,2.51-12.22,7.74-15.64,14.38-2.18,4.23-4.18,8.56-6.56,12.68-1.3,2.25-2.84,4.41-5.12,4.85-3.21.62-6.65-1.43-8.09-3.78-2.48-4.05-2-8.32,1.3-12.69a4.81,4.81,0,0,0-.83-.19c-6.88,1.26-10.66,11.36-6.36,17.29a14.22,14.22,0,0,0,1.56,1.8c-.15,4.22-2.2,7.45-4.38,8.57-4.29,2.2-8.8,3.12-13.09-.33-.16.5-.29.7-.24.79,3.72,6.4,10.18,9.09,17.35,7.12,3.94-1.09,7.8-2.47,11.76-3.49,3.69-.94,7.45-1.23,11.15.26-6.31.6-11.76,3.51-17.45,5.82a87.53,87.53,0,0,1-12,4.09c-3.86,1-7.79.69-10.56-1.85a71.67,71.67,0,0,1-10.44-11.17c-11-14.32-5.68-29.78,8.5-43.24,6.12-5.82,12.81-11.43,19-17.21,5.43-5,10.13-10.28,10.29-16.53.08-3.52-1.7-6.69-4.71-9.6-2.78-2.7-6-5.22-9.1-7.81a14.71,14.71,0,0,0-1.39-.95l-1,.47a8.32,8.32,0,0,0,1.06,1.34c7,6,8.33,12.4,2.82,18.81-5,5.75-11,11.19-16.93,16.61-3.82,3.48-7.66,7-11.06,10.55h0c-5.3,4.56-7.67,6.47-17.09,12.66C19.53,151.29,11.07,157.71,11,172.66c0,5.32,0,10.64-.39,15.93s-2.51,9.65-8,11.74c-.86.32-1.51.67-2.53,1.08.21.42.72,1.57.93,2l54.25-17.77c2.24,2.27,4.3,4.14,6,5.7,1.47,1.29,5.2,4.83,9.29,6.6a12.15,12.15,0,0,0,5.13.73,9.25,9.25,0,0,0,2.45-.28c6.68-2.4,21.93-8.76,22.57-9,4-1.27,11.49-2.55,16.61,1.56l.26-.69s-9.86-9.11-14.63-13.07A15.8,15.8,0,0,0,92.35,173.34Zm35.76-36a101.14,101.14,0,0,1-3.62,12.36c-3.6,11.73-14.6,10.43-18.18,10C111.63,140.86,122.88,138.59,128.11,137.38ZM27,193.23c.63-7.71,1.17-14,1.66-20.35.37-4.78.3-9.64,1.14-14.35a19.33,19.33,0,0,1,9.56-12.91c-3.89,11.51.88,22.25,10,33.45,1.69,2.07,3.34,3.92,4.92,5.57C50.15,185.94,29.88,192.42,27,193.23Z"/></svg>
					<span class="logo" data-content="AL-SIHA">AL-SIHA</span>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Meta tags for social sharing.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function og_metatags_for_sharing() {
		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		if ( ! is_single() ) {
			return;
		}

		echo '<meta property="og:url" content="' . esc_url( get_the_permalink() ) . '" />';
		echo '<meta property="og:type" content="article" />';
		echo '<meta property="og:title" content="' . esc_html( $post->post_title ) . '" />';
		echo '<meta property="og:description" content="' . wp_kses_post( wp_trim_words( $post->post_content, 150 ) ) . '" />';

		$attachment = get_the_post_thumbnail_url();

		if ( ! empty( $attachment ) ) {
			echo '<meta property="og:image" content="' . esc_url( $attachment ) . '" />';
		}

		echo '<meta property="og:site_name" content="' . esc_html( get_bloginfo( 'name' ) ) . '" />';
		echo '<meta name="twitter:card" content="summary" />';
	}
}
