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

<div class="navigation-wrapper d-none d-lg-flex justify-content-end align-items-center width-100">
	<nav id="main-nav">
		<?php
		if ( has_nav_menu( 'primary_nav' ) ) {
			$navMenuArgs = [
				'theme_location' => 'primary_nav',
				'menu'           => 'primary_nav',
				'menu_class'     => 'sf-menu d-flex justify-content-end mb-0',
			];

			// Primary menu.
			sd_alsiha()->navMenu( $navMenuArgs );
		}
		?>
	</nav><!-- #main-nav -->
	<?php
	if ( sd_alsiha()->getOption( 'alsiha_nav_socials' ) ) {
		?>
		<div class="nav-socials-wrapper">
			<?php
			echo do_shortcode( '[alsiha_social_icons]' );
			?>
		</div>
		<?php
	}
	?>
</div><!-- .navigation-wrapper -->
