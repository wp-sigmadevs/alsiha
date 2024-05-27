<?php
/**
 * Functions Class: Filters.
 *
 * List of all functions hooked in filter hooks.
 *
 * @package SigmaDevs\AlSiha
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\AlSiha\Common\Functions;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Functions Class: Filters.
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
	 * @since 1.0.0
	 */
	public static function allowedHtml( $tags, $context ) {
		switch ( $context ) {
			case 'allow_link':
				return [
					'a'   => [
						'class'  => [],
						'href'   => [],
						'rel'    => [],
						'title'  => [],
						'target' => [],
					],
					'img' => [
						'alt'    => [],
						'class'  => [],
						'height' => [],
						'src'    => [],
						'srcset' => [],
						'width'  => [],
					],
					'b'   => [],
				];

			case 'allow_title':
				return [
					'h1'     => [
						'class' => [],
						'id'    => [],
					],
					'h2'     => [
						'class' => [],
						'id'    => [],
					],
					'h3'     => [
						'class' => [],
						'id'    => [],
					],
					'h4'     => [
						'class' => [],
						'id'    => [],
					],
					'h5'     => [
						'class' => [],
						'id'    => [],
					],
					'h6'     => [
						'class' => [],
						'id'    => [],
					],
					'div'    => [
						'class' => [],
						'id'    => [],
					],
					'a'      => [
						'class'  => [],
						'href'   => [],
						'rel'    => [],
						'title'  => [],
						'target' => [],
					],
					'span'   => [
						'class' => [],
						'style' => [],
					],
					'b'      => [],
					'strong' => [],
					'p'      => [],
				];

			case 'allow_notice':
				return [
					'h3'     => [
						'class' => [],
						'id'    => [],
					],
					'div'    => [
						'class' => [],
						'id'    => [],
					],
					'b'      => [],
					'strong' => [],
					'i'      => [],
					'em'     => [],
					'small'  => [],
					'hr'     => [],
					'p'      => [],
				];

			case 'allow_content':
				return [
					'a'          => [
						'class'  => [],
						'href'   => [],
						'rel'    => [],
						'title'  => [],
						'target' => [],
					],
					'abbr'       => [
						'title' => [],
					],
					'b'          => [],
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
						'class' => [],
						'title' => [],
						'style' => [],
						'id' 	=> [],
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
					'img'        => [
						'alt'    => [],
						'class'  => [],
						'height' => [],
						'src'    => [],
						'srcset' => [],
						'width'  => [],
					],
					'li'         => [
						'class' => [],
					],
					'ol'         => [
						'class' => [],
					],
					'p'          => [
						'class' => [],
					],
					'q'          => [
						'cite'  => [],
						'title' => [],
					],
					'span'       => [
						'class' => [],
						'title' => [],
						'style' => [],
					],
					'strike'     => [],
					'strong'     => [],
					'ul'         => [
						'class' => [],
					],
				];

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
	 * @since 1.0.0
	 */
	public static function archiveTitle( $title ) {
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
	 * @since 1.0.0
	 */
	public static function bodyClasses( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'signature-sidebar-general' )
			 || ! is_active_sidebar( 'signature-sidebar-blog' )
			 || ! is_active_sidebar( 'signature-sidebar-shop' ) ) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}
}
