<?php
/**
 * Displays the footer widgets.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

use SigmaDevs\Sigma\Common\Utils\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$footerContainer = Helpers::getFooterContainerClass();
$footerLogo      = sd_alsiha()->getOption( 'alsiha_footer_logo' );
?>

<div class="footer-widget-area">
	<div class="<?php echo esc_attr( $footerContainer ); ?>">
		<div class="row">
			<div id="footer-bottom-col-1" class="footer-column mb-half col-12 col-sm-12 col-md-6 col-lg-3 col-xl-4">
				<?php
				if ( is_active_sidebar( 'alsiha-footer-col-1' ) ) {
					dynamic_sidebar( 'alsiha-footer-col-1' );
				}
				?>
			</div>
			<div id="footer-bottom-col-2" class="footer-column mb-half col-12 col-sm-12 col-md-6 col-lg-3">
				<?php
				if ( is_active_sidebar( 'alsiha-footer-col-2' ) ) {
					dynamic_sidebar( 'alsiha-footer-col-2' );
				}
				?>
			</div>
			<div id="footer-bottom-col-3" class="footer-column mb-half col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2">
				<?php
				if ( is_active_sidebar( 'alsiha-footer-col-3' ) ) {
					dynamic_sidebar( 'alsiha-footer-col-3' );
				}
				?>
			</div>
			<div id="footer-bottom-col-4" class="footer-column mb-half col-12 col-sm-12 col-md-6 col-lg-3">
				<?php
				if ( is_active_sidebar( 'alsiha-footer-col-4' ) ) {
					dynamic_sidebar( 'alsiha-footer-col-4' );
				}
				?>
			</div>
		</div>
	</div>
</div><!-- .footer-widget-area -->
