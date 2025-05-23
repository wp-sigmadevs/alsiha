<?php
/**
 * The template for displaying search results pages.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

get_header();
?>

<div id="content" class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8">
				<main id="primary" class="site-main">
					<div id="posts-container" class="row">
						<?php
						if ( have_posts() ) {
							/**
							 * The Loop template partial.
							 */
							sd_alsiha()->templates()->get( 'loop' );
						} else {
							/**
							 * Template partial for no content.
							 */
							sd_alsiha()->templates()->get( 'content/content', 'none' );
						}
						?>
					</div>

					<div class="nav-container">
						<?php
						/**
						 * Posts Pagination.
						 */
						sd_alsiha()->numberedPagination();
						?>
					</div>
				</main><!-- #primary -->
			</div>
		</div>
	</div>
</div><!-- #content -->

<?php
get_footer();
