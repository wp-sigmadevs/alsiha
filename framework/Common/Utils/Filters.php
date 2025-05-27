<?php
/**
 * Utility Class: Filters.
 *
 * List of all functions hooked in filter hooks.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Utils;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Utils Class: Filters.
 *
 * @since 1.0.0
 */
class Filters {
	/**
	 * Define allowed HTML tags and attributes for different contexts.
	 *
	 * This method returns an array of allowed HTML tags and attributes
	 * based on the specified context.
	 *
	 * @param array  $tags    An array of allowed HTML tags attributes.
	 * @param string $context The context for which the allowed HTML is defined.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public static function allowedHtml( $tags, $context ): array {
		$commonTags = [
			'a'      => [
				'class'  => [],
				'href'   => [],
				'rel'    => [],
				'title'  => [],
				'target' => [],
			],
			'img'    => [
				'alt'    => [],
				'class'  => [],
				'height' => [],
				'src'    => [],
				'srcset' => [],
				'width'  => [],
			],
			'b'      => [],
			'span'   => [
				'class' => [],
				'title' => [],
				'style' => [],
			],
			'strong' => [],
		];

		switch ( $context ) {
			case 'allow_link':
				return $commonTags;

			case 'allow_title':
				unset( $commonTags['img'] );

				return array_merge(
					$commonTags,
					[
						'h1'  => [
							'class' => [],
							'id'    => [],
						],
						'h2'  => [
							'class' => [],
							'id'    => [],
						],
						'h3'  => [
							'class' => [],
							'id'    => [],
						],
						'h4'  => [
							'class' => [],
							'id'    => [],
						],
						'h5'  => [
							'class' => [],
							'id'    => [],
						],
						'h6'  => [
							'class' => [],
							'id'    => [],
						],
						'div' => [
							'class' => [],
							'id'    => [],
						],
						'p'   => [],
					]
				);

			case 'allow_image':
				return array_merge(
					$commonTags,
					[
						'figure'     => [
							'class' => [],
							'id'    => [],
						],
						'figcaption' => [
							'class' => [],
						],
					]
				);

			case 'allow_notice':
				unset( $commonTags['a'], $commonTags['img'] );

				return array_merge(
					$commonTags,
					[
						'h3'    => [
							'class' => [],
							'id'    => [],
						],
						'div'   => [
							'class' => [],
							'id'    => [],
						],
						'i'     => [],
						'em'    => [],
						'small' => [],
						'hr'    => [],
						'p'     => [],
					]
				);

			case 'allow_content':
				return array_merge(
					$commonTags,
					[
						'abbr'       => [
							'title' => [],
						],
						'br'         => [],
						'sub'        => [],
						'blockquote' => [
							'cite' => [],
						],
						'cite'       => [
							'title' => [],
						],
						'code'       => [],
						'del'        => [
							'datetime' => [],
							'title'    => [],
						],
						'dd'         => [],
						'div'        => [
							'class'             => [],
							'title'             => [],
							'style'             => [],
							'id'                => [],
							'data-bg-image'     => [],
							'data-settings'     => [],
							'data-id'           => [],
							'data-element_type' => [],
						],
						'dl'         => [],
						'dt'         => [],
						'em'         => [],
						'h1'         => [
							'class' => [],
							'title' => [],
							'style' => [],
							'id' 	=> [],
						],
						'h2'         => [
							'class' => [],
							'title' => [],
							'style' => [],
							'id' 	=> [],
						],
						'h3'         => [
							'class' => [],
							'title' => [],
							'style' => [],
							'id' 	=> [],
						],
						'h4'         => [
							'class' => [],
							'title' => [],
							'style' => [],
							'id' 	=> [],
						],
						'h5'         => [
							'class' => [],
							'title' => [],
							'style' => [],
							'id' 	=> [],
						],
						'h6'         => [
							'class' => [],
							'title' => [],
							'style' => [],
							'id' 	=> [],
						],
						'hr'         => [],
						'i'          => [
							'class' => [],
						],
						'li'         => [
							'class' => [],
						],
						'ol'         => [
							'class' => [],
						],
						'ul'         => [
							'class' => [],
						],
						'p'          => [
							'class' => [],
						],
						'q'          => [
							'cite'  => [],
							'title' => [],
						],
						'strike'     => [],
						'a'          => [
							'href'                              => [],
							'class'                             => [],
							'id'                                => [],
							'target'                            => [],
							'data-elementor-open-lightbox'      => [],
							'data-elementor-lightbox-title'     => [],
							'data-e-action-hash'                => [],
							'data-elementor-lightbox-slideshow' => [],
						],
						'svg'        => [
							'class'   => [],
							'width'   => [],
							'height'  => [],
							'viewbox' => [],
						],
						'path'       => [
							'd'     => [],
							'style' => [],
						],
					]
				);

			default:
				return $tags;
		}
	}

	/**
	 * Generate the archive title based on the current archive context.
	 *
	 * @param string $title The original archive title.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function archiveTitle( $title ): string {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		}

		return $title;
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public static function bodyClasses( $classes ): array {
		// Adds `singular` to singular pages, and `hfeed` to all other pages.
		$classes[] = is_singular() ? 'singular' : 'hfeed';

		// Adds a class to blogs with more than 1 published author.
		$classes[] = is_multi_author() ? 'group-blog' : '';

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'alsiha-sidebar-general' )
			 || ! is_active_sidebar( 'alsiha-sidebar-blog' )
			 || ! is_active_sidebar( 'alsiha-sidebar-shop' ) ) {
			$classes[] = 'no-sidebar';
		}

		// Adds a class when Woocommerce is detected.
		$classes[] = Helpers::hasWooCommerce() ? 'woocommerce-active' : '';

		// Adds a class based on the 'view' parameter in the URL.
		$classes[] = isset( $_GET['view'] ) && 'list' === sanitize_text_field( wp_unslash( $_GET['view'] ) ) ? 'product-list-view' : 'product-grid-view'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		// Add browser-specific classes based on global variables.
		// https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans.
		$browsers  = [ 'iphone', 'chrome', 'safari', 'NS4', 'opera', 'macIE', 'winIE', 'gecko', 'lynx', 'IE', 'edge' ];
		$classes[] = join(
			' ',
			array_filter(
				$browsers,
				function ( $browser ) {
					return '' . $GLOBALS[ 'is_' . $browser ];
				}
			)
		);

		return $classes;
	}

	/**
	 * Adds a title to posts and pages that are missing titles.
	 *
	 * @param string $title The title.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function emptyPostTitle( $title ): string {
		return '' === $title ? esc_html_x( 'Untitled', 'Added to posts and pages that are missing titles', 'alsiha' ) : $title;
	}

	/**
	 * Custom notice for featured image.
	 *
	 * @param string $html Featured image HTML.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function featuredImageNotice( $html ): string {
		if ( 'post' === get_post_type() ) {
			$html .= '<p><b><u>Note:</u></b> Recommended image size for blog post is <b>800x533</b> px or greater (maintaining same aspect ratio).</p>';
		}

		if ( 'product' === get_post_type() ) {
			$html .= '<p><b><u>Note:</u></b> Recommended image size for product is <b>1000x1000</b> px or greater (maintaining same aspect ratio).</p>';
		}

		return $html;
	}

	/**
	 * Customize excerpt more.
	 *
	 * @param string $content The excerpt.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function customizeExcerpt( $content ) {
		if ( ! ( is_home() || is_archive() ) ) {
			return $content;
		}

		$limit       = 100;
		$allowedTags = '<p><a><strong><em><ul><ol><li><blockquote><b><i><u><h1><h2><h3><h4><h5><h6><span><br><div>';
		$content     = strip_tags( $content, $allowedTags );
		$words       = preg_split( '/\s+/', $content );

		if ( count( $words ) > $limit ) {
			$content  = implode( ' ', array_slice( $words, 0, $limit ) );
			$content .= '...';
		}

		return wpautop( $content );
	}

	/**
	 * OpenGraph image override.
	 *
	 * @param string $image OpenGraph image.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function opengraphImageOverride( $image ) {
		if ( ! is_singular() ) {
			return $image;
		}

		$page_id    = get_the_ID();
		$temp_image = get_transient( 'sd_temp_og_image_' . $page_id );

		if ( $temp_image ) {
			$attachment_id = attachment_url_to_postid( $temp_image );

			if ( $attachment_id ) {
				$cropped = wp_get_attachment_image_src( $attachment_id, 'alsiha-og-image' );

				if ( $cropped ) {
					return esc_url( $cropped[0] . '?fbrefresh=' . time() );
				}
			}

			return esc_url( $temp_image . '?fbrefresh=' . time() );
		}

		return $image . '?v=' . time();
	}
}
