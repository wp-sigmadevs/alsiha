<?php
/**
 * Page Template: Left Sidebar
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
			<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">
				<aside id="secondary" class="widget-area">
					<?php
					get_sidebar();
					?>
				</aside><!-- #secondary -->
			</div>

			<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
				<main id="primary" class="site-main" role="main">
					<?php
					while ( have_posts() ) {
						the_post();

						/**
						 * Template partial for page.
						 */
						sd_alsiha()->templates()->get( 'content/content', 'page' );

						/**
						 * If comments are open, or we have at least one comment,
						 * load up the comment template.
						 */
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					}
					?>
				</main><!-- #primary -->
			</div>
		</div>
	</div>
</div><!-- #content -->

<?php
get_footer();
