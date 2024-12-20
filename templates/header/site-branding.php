<?php
/**
 * Displays header site branding
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="site-branding">
	<div class="logo d-flex align-items-center">
		<?php
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$showH1Tag = [
				110,
				114,
				288,
			];

			echo in_array( get_the_ID(), $showH1Tag, true ) ? '<h1 class="visually-hidden">' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</h1>' : '';

			the_custom_logo();
		} else {
			?>
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?>
				</a>
			</div>
			<?php
			if ( '' !== get_bloginfo( 'description' ) ) {
				?>
				<p class="site-description"><?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?></p>
				<?php
			}
		}
		?>
	</div><!-- .logo -->
</div><!-- .site-branding -->
