<?php
/**
 * Template used to display post content.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

use SigmaDevs\Sigma\Common\Functions\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

// Determine the appropriate thumbnail size.
$thumbnailSize = is_single() ? 'full' : 'alsiha-featured-image';
$postThumbnail = Helpers::getThePostThumbnail( $thumbnailSize );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-half pb-half post-item' ); ?>>
	<header class="entry-header pos-r">
		<?php
		// The Post Thumbnail.
		echo wp_kses( $postThumbnail, 'allow_image' );

		if ( 'post' === get_post_type() ) {
			?>
			<div class="entry-meta">
				<div class="post-meta-container">
					<?php
					// Post date/time meta.
					sd_alsiha()->postedOn();
					?>
				</div>
				<div class="post-title-container">
					<?php
					if ( is_single() ) {
						the_title( '<h1 class="entry-title">', '</h1>' );
					}
					?>
				</div>
			</div><!-- .entry-meta-->
			<?php
		}
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="post-content">
			<?php
			if ( is_single() ) {
				// Post content.
				the_content();

				/**
				 * This section is for pagination purpose for a long large
				 * post that is separated using next page tags.
				 */
				wp_link_pages(
					[
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'alsiha' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'alsiha' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					]
				);
			} else {
				the_title(
					sprintf(
						'<h2 class="entry-title"><a href="%s" rel="bookmark">',
						esc_url( get_permalink() )
					),
					'</a></h2>'
				);
				?>
				<div class="entry-summary">
					<?php
					the_excerpt();
					?>
				</div>
				<footer class="entry-footer">
					<div class="more-link">
						<a href="<?php the_permalink(); ?>" class="sigma-btn primary"><?php echo esc_html__( 'Continue Reading', 'alsiha' ); ?></a>
					</div>
				</footer><!-- .entry-footer -->
				<?php
			}
			?>
		</div><!-- .post-content -->
	</div><!-- .entry-content -->

	<?php
	if ( is_single() && 'post' === get_post_type() ) {
		?>
		<footer class="entry-footer">'
			<?php
			 $categories_list = get_the_category_list( ', ' );

			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<div class="category-links">' . esc_html__( 'Posted in %1$s', 'alsiha' ) . '</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'alsiha' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<div class="tags-links">' . esc_html__( 'Tagged %1$s', 'alsiha' ) . '</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</footer><!-- .entry-footer -->
		<?php
	}
	?>
</article><!-- #post-<?php the_ID(); ?> -->
