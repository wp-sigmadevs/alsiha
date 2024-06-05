<?php
/**
 * Displays the top bar.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$tbPhone     = sd_alsiha()->getOption( 'alsiha_header_phone' );
$tbPhoneUrl  = sd_alsiha()->getOption( 'alsiha_header_phone_url' );
$tbPageTitle = sd_alsiha()->getOption( 'alsiha_header_page_title' );
$tbPage      = sd_alsiha()->getOption( 'alsiha_header_page_selector' );
$socials     = sd_alsiha()->getOption( 'alsiha_header_socials' );
?>

<div class="top-bar-wrapper">
	<div class="row align-items-center">
		<div class="col col-sm-4 col-md-4 col-lg-4 col-xl-4 d-none d-sm-block">
			<div class="header-socials">
				<?php
				if ( $socials ) {
					echo do_shortcode( '[alsiha_social_icons]' );
				}
				?>
			</div>
		</div>
		<div class="col-9 col-sm-6 col-md-4 col-lg-4 col-xl-4">
			<div class="top-bar-middle text-left text-sm-center">
				<div class="page-selector">
					<a class="color-text alsiha-text" href="<?php echo esc_url( get_permalink( $tbPage ) ); ?>"><?php echo wp_kses( $tbPageTitle, 'allow_title' ); ?></a>
				</div>
			</div>
		</div>
		<div class="col-3 col-sm-2 col-md-4 col-lg-4 col-xl-4">
			<div class="top-bar-right d-flex mb-0 align-items-center justify-content-end justify-content-md-end">
				<a class="d-flex header-phone alsiha-text" href="tel:<?php echo esc_attr( $tbPhoneUrl ); ?>">
					<span class="d-none d-lg-inline"><?php echo esc_html( $tbPhone ); ?></span>
					<i class="fas fa-phone-alt d-block d-lg-none"></i>
				</a>
			</div>
		</div>
	</div>
</div><!-- .top-bar-wrapper -->
