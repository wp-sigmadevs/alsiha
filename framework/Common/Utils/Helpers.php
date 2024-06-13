<?php
/**
 * Utility Class: Helpers.
 *
 * List of all helper functions.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Utils;

use WP_Term;
use WP_Error;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Utils Class: Helpers.
 *
 * @since 1.0.0
 */
class Helpers {
	/**
	 * Gets Ajax URL.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function ajaxUrl(): string {
		return admin_url( 'admin-ajax.php' );
	}

	/**
	 * Nonce Text.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function nonceText(): string {
		return 'sd_alsiha_nonce_secret';
	}

	/**
	 * Nonce ID.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function nonceId(): string {
		return 'sd_alsiha_nonce';
	}

	/**
	 * Check if the AJAX call is valid.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function verifyAjaxCall(): void {
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
	 * @param array $args Custom menu args.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public static function navMenuArgs( array $args = [] ): array {
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

		$defaults = apply_filters( 'sigmadevs/sigma/nav_menu/defaults', $defaults, $args );

		return wp_parse_args( $args, $defaults );
	}

	/**
	 * Beautify string.
	 *
	 * @param string $string String to beautify.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function beautify( $string ): string {
		return ucwords( str_replace( '_', ' ', $string ) );
	}

	/**
	 * Uglify string.
	 *
	 * @param string $string String to uglify.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function uglify( $string ): string {
		return strtolower( str_replace( ' ', '_', $string ) );
	}

	/**
	 * Pluralize string.
	 *
	 * @param string $string String to Pluralize.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function pluralize( $string ): string {
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
	 * Check if the WooCommerce plugin is active.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public static function hasWooCommerce(): bool {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Check if the Jetpack plugin is active.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public static function hasJetpack(): bool {
		return class_exists( 'Jetpack' );
	}

	/**
	 * Check if the current context is within a Tribe Events Calendar event.
	 *
	 * @param int|false $id The event ID to check.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public static function tribeIsEvent( $id = false ): bool {
		if ( function_exists( 'tribe_is_event' ) ) {
			return false === $id ? \tribe_is_event() : \tribe_is_event( $id );
		}

		return false;
	}

	/**
	 * Check if the current context is within the WooCommerce pages.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public static function isWooCommerce(): bool {
		return function_exists( 'is_woocommerce' ) && is_woocommerce();
	}

	/**
	 * Check if the current context is within the WooCommerce shop page.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public static function isShop(): bool {
		return function_exists( 'is_shop' ) && is_shop();
	}

	/**
	 * Query if inside WooCommerce category Page.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public static function isProductCategory(): bool {
		return function_exists( 'is_product_category' ) && is_product_category();
	}

	/**
	 * Query if inside WooCommerce single product Page.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public static function isProduct(): bool {
		return function_exists( 'is_product' ) && is_product();
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
	 * @since  1.0.0
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
	 * @since  1.0.0
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
	 * @since  1.0.0
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


	/**
	 * Display a "New" badge for posts published within the last week.
	 *
	 * @param int $id The post-ID.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function newBadge( $id ): void {
		$now           = time();
		$publishedDate = get_post_time( 'U', false, $id );

		if ( $publishedDate && ( $now - $publishedDate ) < 604800 ) { ?>
			<span class="alsiha-badge-new">
				<?php
				esc_html_e( 'New', 'alsiha' );
				?>
			</span>
			<?php
		}
	}

	/**
	 * Filter and sanitize content using various
	 * WordPress text processing functions.
	 *
	 * @param string $content The content to be filtered and sanitized.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function filterContent( $content ): string {
		// Filter and sanitize content.
		$content = wptexturize( $content );
		$content = convert_smilies( $content );
		$content = convert_chars( $content );
		$content = wpautop( $content );
		$content = shortcode_unautop( $content );

		// Filter shortcodes.
		$pattern = '/\[(.+?)\]/';
		$content = preg_replace( $pattern, '', $content );

		// Filter tags.
		return wp_strip_all_tags( $content );
	}

	/**
	 * Prints HTML with meta-information for the categories, tags, and comments.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function entryFooter(): void {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$categoriesList = get_the_category_list( esc_html__( ', ', 'alsiha' ) );
			if ( $categoriesList ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'alsiha' ) . '</span>', $categoriesList ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			$tagsList = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'alsiha' ) );

			if ( $tagsList ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'alsiha' ) . '</span>', $tagsList ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'alsiha' ),
						[
							'span' => [
								'class' => [],
							],
						]
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
				/* Translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'alsiha' ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}

	/**
	 * Post thumbnail HTML.
	 *
	 * @param string $size Image size.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function getThePostThumbnail( $size = 'full' ): string {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return '';
		}

		ob_start();

		if ( is_singular() ) {
			?>
			<figure class="post-thumbnail">
				<?php the_post_thumbnail( $size ); ?>
			</figure><!-- .post-thumbnail -->
			<?php
		} else {
			?>
			<figure class="post-thumbnail">
				<a class="wp-post-image" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail(
						$size,
						[
							'alt' => the_title_attribute(
								[
									'echo' => false,
								]
							),
						]
					);
					?>
				</a>
			</figure>
			<?php
		}

		return ob_get_clean();
	}

	/**
	 * Get the page classes.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function getPageClasses(): string {
		$classes = [ 'site' ];

		return implode( ' ', $classes );
	}

	/**
	 * Get the image markup.
	 *
	 * @param string   $size image size.
	 * @param int|null $id post id.
	 * @param string   $class image CSS class.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function getImageMarkup( $size = 'full', int $id = null, $class = '' ): string {
		if ( ! $id ) {
			return '';
		}

		$altText = trim( wp_strip_all_tags( get_post_meta( absint( $id ), '_wp_attachment_image_alt', true ) ) );

		return wp_get_attachment_image(
			absint( $id ),
			esc_attr( $size ),
			false,
			[
				'class' => esc_attr( $class ),
				'alt'   => esc_attr( $altText ),
			]
		);
	}

	/**
	 * Get product thumbnail.
	 *
	 * @param object $product The product object.
	 * @param string $thumb_size Thumbnail size.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function getProductThumbnail( $product, $thumb_size = 'woocommerce_thumbnail' ): string {
		$thumbnail = $product->get_image( $thumb_size, [], false );

		if ( ! $thumbnail ) {
			$thumbnail = wc_placeholder_img( $thumb_size );
		}

		return $thumbnail;
	}

	/**
	 * Get the header classes.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function getHeaderClasses(): string {
		$classes   = [ 'site-header' ];
		$classes[] = is_front_page() ? 'front-header' : 'inner-header';
		$classes[] = has_custom_logo() ? 'has-logo' : 'no-logo';
		$classes[] = has_nav_menu( 'primary_nav' ) ? 'has-menu' : 'no-menu';
		$classes[] = has_custom_header() ? 'background-image-center' : 'no-header-image';

		return implode( ' ', $classes );
	}

	/**
	 * Get the header container class.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function getHeaderContainerClass(): string {
		$classes   = [];
		$classes[] = true === sd_alsiha()->getOption( 'alsiha_enable_100_header' ) ? 'container-fluid' : 'container';

		return implode( ' ', $classes );
	}

	/**
	 * Get the footer container class.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function getFooterContainerClass(): string {
		$classes   = [];
		$classes[] = true === get_theme_mod( 'alsiha_enable_100_footer', false ) ? esc_attr( 'container-fluid' ) : esc_attr( 'container' );

		return implode( ' ', $classes );
	}

	/**
	 * Renders the page title.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function thePageTitle(): void {
		if ( is_front_page() && is_home() ) {
			return;
		}

		if ( is_home() ) {
			$title = get_theme_mod( 'alsiha_pagetitle_blog', esc_html__( 'Blog', 'alsiha' ) );
		} elseif ( is_archive() ) {
			$title = get_the_archive_title();
		} elseif ( is_search() ) {
			$title = esc_html__( 'Search results for', 'alsiha' ) . ' "' . get_search_query() . '"';
		} elseif ( is_404() ) {
			$title = esc_html__( 'Page Not Found', 'alsiha' );
		} else {
			global $post;

			$title = get_the_title( $post->ID );
		}

		echo wp_kses( $title, 'allow_title' );
	}

	/**
	 * Sanitizes hex colors.
	 *
	 * @param string $color The color code.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public static function sanitizeHex( $color ): string {
		if ( '' === $color ) {
			return '';
		}

		// Make sure the color starts with a hash.
		$color = '#' . ltrim( $color, '#' );

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		return '';
	}
}
