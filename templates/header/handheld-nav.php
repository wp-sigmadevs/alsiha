<?php
/**
 * Displays the handheld navigation.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<nav id="alsiha-mobile-menu" class="alsiha-menu d-block d-sm-block d-md-block d-lg-none">
	<button class="alsiha-menu-close"><?php echo esc_html__( '&larr; Back', 'alsiha' ); ?></button>
	<?php
	if ( has_nav_menu( 'handheld_nav' ) ) {
		$navMenuArgs = [
			'theme_location'  => 'handheld_nav',
			'menu'            => 'handheld_nav',
			'container'       => 'div',
			'container_class' => 'nav-wrapper',
			'menu_class'      => 'alsiha-menu-items',
			'menu_id'         => 'handheld-menu',
		];

		// Primary menu.
		sd_alsiha()->navMenu( $navMenuArgs );
	}
	?>
	<div class="mobile-menu-footer">
		<div class="header-socials">
			<?php
			$showSocials = sd_alsiha()->getOption( 'alsiha_nav_socials' );

			if ( $showSocials ) {
				echo do_shortcode( '[alsiha_social_icons]' );
			}
			?>
		</div>
	</div>
</nav>
