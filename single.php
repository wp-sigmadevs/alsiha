<?php
/**
 * The template for displaying all single posts.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

get_header(); ?>

<div id="content" class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12">
				<main id="primary" class="site-main">
					<div id="post-container">
						<?php
						while ( have_posts() ) {
							the_post();
							echo '<div class="row">';
							echo '<div class="col-12 col-lg-12">';

							/**
							 * The content template partial.
							 */
							sd_alsiha()->templates()->get( 'content/content', get_post_format() );
							echo '</div>';
							echo '</div>';

							/**
							 * If comments are open, or we have at least one comment, load up the comment template.
							 */
							if ( comments_open() || get_comments_number() ) {
								echo '<div class="row">';
									echo '<div class="col-12">';
										comments_template();
									echo '</div>';
								echo '</div>';
							}
						}
						?>
					</div>
				</main><!-- #primary -->
			</div>
		</div>
	</div>
</div><!-- #content -->

<?php
get_footer();
