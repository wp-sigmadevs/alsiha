<?php
/**
 * Template used to display post content.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-half pb-half post-item' ); ?>>
	<header class="entry-header pos-r">
		<?php
		// The Post Thumbnail.
		if ( is_single() ) {
			alsiha_the_post_thumbnail( 'full' );
		} else {
			alsiha_the_post_thumbnail( 'alsiha-featured-image' );
		}

		if ( 'post' === get_post_type() ) {
			?>
			<div class="entry-meta">
				<div class="meta-container">
					<?php
					alsiha_posted_on();

					if ( is_single() ) {
						the_title( '<h1 class="entry-title">', '</h1>' );
					}
					?>
				</div>
			</div>
			<?php
		}

		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="post-content">
			<?php
			if ( ! is_single() ) {
				the_title(
					sprintf(
						'<h2 class="entry-title"><a href="%s" rel="bookmark">',
						esc_url( get_permalink() )
					),
					'</a></h2>'
				);
			}

			if ( is_single() ) {
				the_content();

				// This section is for pagination purpose for a long large post that is separated using nextpage tags.
				wp_link_pages(
					array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'alsiha' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'alsiha' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);

			} else {
				echo '<div class="entry-summary">';
				the_excerpt();
				echo '</div>';

				?>
				<footer class="entry-footer">
					<div class="more-link">
						<a href="<?php the_permalink(); ?>" class="alsiha-btn primary"><?php echo esc_html__( 'Details', 'alsiha' ); ?></a>
					</div>
				</footer>
				<?php
			}
			?>
		</div><!-- .post-content -->
	</div><!-- .entry-content -->

	<?php
	if ( is_single() ) {
		echo '<footer class="entry-footer">';

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'alsiha' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<div class="cat-links">' . esc_html__( 'Posted in %1$s', 'alsiha' ) . '</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'alsiha' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<div class="tags-links">' . esc_html__( 'Tagged %1$s', 'alsiha' ) . '</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		echo '</footer><!-- .entry-footer -->';
	}
	?>
</article><!-- #post-<?php the_ID(); ?> -->
