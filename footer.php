<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #page div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Al-Siha
 * @since   1.0.0
 */

use SigmaDevs\Sigma\Common\Functions\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$disable_footer = get_field( 'alsiha_meta_disable_footer_widgets' );
$footer_bg      = get_theme_mod( 'alsiha_footer_bg', false );
?>
		</div><!-- #wrapper -->

		<footer id="colophon" class="site-footer <?php echo ! $disable_footer ? esc_attr( ' has-widgets ' ) : esc_attr( 'no-widgets' ); ?>" role="contentinfo">
			<?php
			if ( ! $disable_footer ) {
				/**
				 * Footer Widgets.
				 */
				sd_alsiha()->getTemplatePart( 'views/footer/footer-widgets' );
			}
			?>

			<div class="footer-copyright">
				<div class="<?php echo esc_attr( Helpers::getFooterContainerClass() ); ?>">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<div class="site-info text-center">
								<?php
								$footer_copyright = get_theme_mod( 'alsiha_footer_copyright_text', '' );

								echo wp_kses_post( wpautop( wp_specialchars_decode( $footer_copyright ) ) );
								?>
							</div><!-- .site-info -->
						</div>
					</div>
				</div>
			</div><!-- .footer-copyright -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<!-- Modal structure -->
	<div id="alsiha-modal"><div class="modal-content"></div></div>

	<!-- Mobile Bottom Bar -->
	<div class="mobile-bar d-block d-lg-none">
		<?php
		sd_alsiha()->getTemplatePart( 'views/footer/mobile-bar' );
		?>
	</div>

	<!-- Search modal -->
	<div id="mobile-search">
		<?php
		/**
		 * Site Search.
		 */
		sd_alsiha()->getTemplatePart( 'views/header/site-search' );
		?>
		<div class="close-btn">
			<i class="fa fa-times"></i>
		</div>
	</div>
	<div class="mobile-search-overlay"></div>

	<?php wp_footer(); ?>
</body>
</html>
