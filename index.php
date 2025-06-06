<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$paginationType = sd_alsiha()->getOption( 'alsiha_archive_pagination' );

get_header();
?>

<div id="content" class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12">
				<main id="primary" class="site-main">
					<div id="articles-container" class="row">
						<div class="col-12 col-lg-12">
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
					</div>

					<div class="nav-container">
						<?php
						/**
						 * Posts Pagination.
						 */
						if ( 'classic' === $paginationType ) {
							sd_alsiha()->classicPagination();
						} else {
							sd_alsiha()->numberedPagination();
						}
						?>
					</div>
				</main><!-- #primary -->
			</div>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #content -->

<?php
get_footer();
