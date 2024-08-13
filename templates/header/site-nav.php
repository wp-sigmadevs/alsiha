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
<div class="handheld-nav-trigger d-md-flex d-lg-none justify-content-end align-items-center width-100">
	<div id="alsiha-menu-trigger" class="mobile-nav alsiha-menu-trigger d-block d-sm-block d-md-block d-lg-none text-right">
		<div class="primary-nav">
			<button id="alsiha-trigger-button" class="primary-nav-details">
				<svg class="mobile-icon" width="34" height="19" viewBox="0 0 34 19" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M1.61863 0C1.11894 0 0.713867 0.405076 0.713867 0.904762C0.713867 1.40445 1.11894 1.80952 1.61863 1.80952H32.3805C32.8802 1.80952 33.2853 1.40445 33.2853 0.904762C33.2853 0.405076 32.8802 0 32.3805 0H1.61863ZM1.61863 17.1905C1.11894 17.1905 0.713867 17.5956 0.713867 18.0952C0.713867 18.5949 1.11894 19 1.61863 19H32.3805C32.8802 19 33.2853 18.5949 33.2853 18.0952C33.2853 17.5956 32.8802 17.1905 32.3805 17.1905H1.61863ZM0.713867 9.95238C0.713867 9.45269 1.11894 9.04762 1.61863 9.04762H19.7139C20.2136 9.04762 20.6186 9.45269 20.6186 9.95238C20.6186 10.4521 20.2136 10.8571 19.7139 10.8571H1.61863C1.11894 10.8571 0.713867 10.4521 0.713867 9.95238ZM24.2377 9.04762C23.738 9.04762 23.3329 9.45269 23.3329 9.95238C23.3329 10.4521 23.738 10.8571 24.2377 10.8571H26.952C27.4517 10.8571 27.8567 10.4521 27.8567 9.95238C27.8567 9.45269 27.4516 9.04762 26.952 9.04762H24.2377Z" fill="currentColor"></path>
				</svg>
			</button>
		</div><!-- #primary-nav -->
	</div><!-- #mfit-menu-trigger -->
</div><!-- .handheld-nav-trigger -->
