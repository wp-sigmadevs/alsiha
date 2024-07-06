<?php
/**
 * Displays the site navigation.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="navigation-wrapper d-none d-sm-none d-md-none d-lg-block">
	<nav id="main-nav">
		<?php
		if ( has_nav_menu( 'primary_nav' ) ) {
			$navMenuArgs = [
				'theme_location' => 'primary_nav',
				'menu'           => 'primary_nav',
			];

			// Primary menu.
			sd_alsiha()->navMenu( $navMenuArgs );
		}
		?>
	</nav><!-- #main-nav -->
</div><!-- .navigation-wrapper -->
