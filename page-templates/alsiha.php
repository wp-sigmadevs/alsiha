<?php
/**
 * Page Template: Al-Siha
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
	<main id="primary" class="site-main" role="main">
		<?php
		while ( have_posts() ) {
			the_post();

			/**
			 * Template partial for page.
			 */
			sd_alsiha()->templates()->get( 'content/content', 'page' );
		}
		?>
	</main><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
