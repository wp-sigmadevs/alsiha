<?php
/**
 * Template used to display post content.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

use SigmaDevs\Sigma\Common\Utils\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

// Determine the appropriate thumbnail size.
$thumbnailSize = is_single() ? 'full' : 'alsiha-featured-image';
$postThumbnail = Helpers::getThePostThumbnail( $thumbnailSize );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-half pb-half post-item' ); ?>>
	<header class="entry-header relative-content">
		<?php
		if ( 'post' === get_post_type() ) {
			?>
			<div class="post-meta-container">
				<div class="entry-categories">
					<?php
					// Post categories.
					sd_alsiha()->postedIn();
					?>
				</div>
				<div class="entry-title">
					<?php
					if ( is_single() ) {
						the_title( '<h2>', '</h2>' );
					} else {
						the_title(
							sprintf(
								'<h2><a href="%s" rel="bookmark">',
								esc_url( get_permalink() )
							),
							'</a></h2>'
						);
					}
					?>
				</div>
				<div class="entry-meta">
					<?php
					// Post date/time meta.
					sd_alsiha()->postedOn();
					?>
				</div>
			</div><!-- .entry-meta-->
			<?php
		}

		// The Post Thumbnail.
		echo wp_kses( $postThumbnail, 'allow_image' );
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
				?>
				<div class="entry-summary">
					<?php
					the_content();
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
		<footer class="entry-footer">
			<?php
			$tags_list = get_the_tag_list( '<ul><li>', '</li><li>', '</li></ul>' );

			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<div class="tags-links">%1$s</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			<div class="post-share">
				<?php
				$post_url   = get_permalink();
				$post_title = get_the_title();
				$post_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				?>

				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( $post_url ); ?>">
					<span class="share-box"><i class="fab fa-facebook-f"></i></span>
				</a>

				<a target="_blank" href="https://twitter.com/intent/tweet?text=Check out this article: <?php echo esc_html( $post_title ); ?> - <?php echo esc_url( $post_url ); ?>">
					<span class="share-box"><i class="fab fa-x-twitter"></i></span>
				</a>

				<a target="_blank" href="https://wa.me/?text=<?php echo 'Check out this article: ' . esc_html( $post_title ) . ' - ' . esc_url( $post_url ); ?>">
					<span class="share-box"><i class="fab fa-whatsapp"></i></span>
				</a>

				<?php if ( $post_image ) : ?>
					<a target="_blank" data-pin-do="skipLink" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url( $post_url ); ?>&amp;media=<?php echo esc_url( $post_image ); ?>&amp;description=<?php echo esc_html( $post_title ); ?>">
						<span class="share-box"><i class="fab fa-pinterest-p"></i></span>
					</a>
				<?php endif; ?>
			</div>

		</footer><!-- .entry-footer -->
		<?php
	}
	?>
</article><!-- #post-<?php the_ID(); ?> -->
