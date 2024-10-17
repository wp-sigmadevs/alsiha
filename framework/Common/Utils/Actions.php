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
	 * @return void
	 * @since  1.0.0
	 */
	public static function scrollToTopButton(): void {
		if ( false === sd_alsiha()->getOption( 'alsiha_enable_totop' ) ) {
			return;
		}

		echo '<div class="alsiha-scroll-to-top"><i class="fa fa-angle-up"></i><i class="fa fa-angle-double-up"></i></div>';
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
					<img src="/wp-content/uploads/2024/07/cropped-favicon.png" alt="Al-Siha Logo">
					<span class="logo" data-content="AL-SIHA">AL-SIHA</span>
				</div>
			</div>
		</div>
		<?php
	}
}
