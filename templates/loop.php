<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts.
 *
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$i = 0;

/* Start the Loop */
while ( have_posts() ) {
	the_post();

	$i++;
	$class = 0 === $i % 2 ? 'even' : 'odd';

	if ( is_search() ) {

		// Search template partial.
		sd_alsiha()->templates()->get( 'content/content', 'search' );

	} else {
		/**
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called views/content/content-___.php (where ___ is the Post Format name)
		 * and that will be used instead.
		 */
		echo '<div class="posts-wrapper ' . esc_attr( $class ) . '-entries">';
		sd_alsiha()->templates()->get( 'content/content', get_post_format() );
		echo '</div>';
	}
}
