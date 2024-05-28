<?php
/**
 * Functions Class: Functions.
 *
 * Main function class for external uses.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Functions;

use SigmaDevs\Sigma\Common\Abstracts\Base;
use SigmaDevs\Sigma\Common\Models\Templates;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Functions Class: Functions.
 *
 * @since 1.0.0
 */
class Functions extends Base {
	/**
	 * Get theme data by using sd_alsiha()->getData()
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getData() {
		return $this->theme->data();
	}

	/**
	 * Get theme version.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function getVersion() {
		return $this->theme->version();
	}

	/**
	 * Get template data.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function templatesPath() {
		return $this->theme->templatePath();
	}

	/**
	 * Get the template class.
	 *
	 * @return Templates
	 * @since 1.0.0
	 */
	public function templates() {
		return new Templates();
	}

	/**
	 * Get theme path.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function getThemePath() {
		return $this->theme->parentThemePath();
	}

	/**
	 * Get theme URI.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function getThemeUri() {
		return $this->theme->parentThemeUri();
	}

	/**
	 * Get assets URI.
	 *
	 * @param string $path Asset file path.
	 * @param string $type Asset type.
	 * @param string $suffix Asset suffix.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function getAssetsUri( $path = '', $type = 'css', $suffix = '.css' ) {
		$assetsUri = $this->theme->assetsUri();

		if ( empty( $path ) ) {
			return $assetsUri;
		}

		return $assetsUri . $type . '/' . $path . $suffix;
	}

	/**
	 * Display a "New" badge for posts published within the last week.
	 *
	 * @param int $id The post ID.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function newBadge( $id ) {
		$now           = time();
		$publishedDate = get_post_time();
		$diff          = $now - $publishedDate;

		if ( $diff < 604800 ) { ?>
			<span class="badge-new">
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
	 * @since 1.0.0
	 */
	public static function filterContent( $content ) {
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
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function postedOn() {
		$timeString = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$timeString = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$timeString = sprintf(
			$timeString,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$postedOn = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'alsiha' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $timeString . '</a>'
		);

		echo '<span class="posted-on">' . $postedOn . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Prints HTML with meta information for the current author.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function postedBy() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'alsiha' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function entryFooter() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categoriesList = get_the_category_list( esc_html__( ', ', 'alsiha' ) );
			if ( $categoriesList ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'alsiha' ) . '</span>', $categoriesList ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
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
					/* translators: %s: Name of current post. Only visible to screen readers */
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
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function postThumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) {
			?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->
			<?php
		} else {
			?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail(
				'post-thumbnail',
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
			<?php
		}
	}

	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function wpBodyOpen() {
		do_action( 'wp_body_open' );
	}

	/**
	 * Page Classes.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function pageClass() {
		$classes = [ 'site' ];

		echo esc_attr( implode( ' ', $classes ) );
	}
}
