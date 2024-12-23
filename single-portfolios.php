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
		<div class="container-fluid">
			<div class="row">
				<main id="primary" class="site-main">
					<div id="portfolio-container">
						<?php
						while ( have_posts() ) {
							the_post();
							echo '<div class="portfolio-item">';

							/**
							 * The content.
							 */
							the_content();
							echo '</div>';
						}
						?>
					</div>
				</main><!-- #primary -->
			</div>
		</div>
	</div><!-- #content -->

<?php
get_footer();
