<?php
/**
 * Displays the footer widgets.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

use SigmaDevs\Sigma\Common\Functions\Helpers;

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
			<div class="footer-top-logo col-12">
				<?php
				if ( ! empty( $footerLogo ) ) {
					echo '<div class="footer-logo-inner text-center">';
						$attachmentID = attachment_url_to_postid( $footerLogo );

						echo wp_kses(
							Helpers::getImageMarkup(
								'full',
								$attachmentID,
								'footer-logo'
							),
							'allow_image'
						);
					echo '</div>';
				}
				?>
			</div>
		</div>
		<div class="row">
			<div id="footer-top-col-1" class="footer-top-column mb-half col-12 col-sm-12 col-md-12 col-lg-6">
				<?php
				if ( is_active_sidebar( 'alsiha-footer-top-col-1' ) ) {
					dynamic_sidebar( 'alsiha-footer-top-col-1' );
				}
				?>
			</div>
			<div id="footer-top-col-2" class="footer-top-column mb-half col-12 col-sm-12 col-md-12 col-lg-6">
				<?php
				if ( is_active_sidebar( 'alsiha-footer-top-col-2' ) ) {
					dynamic_sidebar( 'alsiha-footer-top-col-2' );
				}
				?>
			</div>
		</div>
		<div class="row">
			<?php
			for ( $footerCol = 1; $footerCol <= 4; $footerCol++ ) {
				echo '<div id="footer-bottom-col-' . esc_attr( $footerCol ) . '" class="footer-column mb-half col-12 col-sm-12 col-md-6 col-lg-3">';
				if ( is_active_sidebar( 'alsiha-footer-bottom-col-' . esc_attr( $footerCol ) ) ) {
					dynamic_sidebar( 'alsiha-footer-bottom-col-' . esc_attr( $footerCol ) );
				}
				echo '</div>';
			}
			?>
		</div>
	</div>
</div><!-- .footer-widget-area -->
