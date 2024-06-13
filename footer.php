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

use SigmaDevs\Sigma\Common\Utils\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$disableFooter        = sd_alsiha()->getField( 'alsiha_meta_disable_footer_widgets' );
$footerBg             = sd_alsiha()->getOption( 'alsiha_footer_bg' );
$footerClass          = ! $disableFooter ? ' has-widgets ' : 'no-widgets';
$footerContainerClass = Helpers::getFooterContainerClass();
$footer_copyright     = sd_alsiha()->getOption( 'alsiha_footer_copyright_text' );
?>
		</div><!-- #wrapper -->

		<footer id="colophon" class="site-footer <?php echo esc_attr( $footerClass ); ?>" role="contentinfo">
			<?php
			if ( ! $disableFooter ) {
				/**
				 * Footer Widgets.
				 */
				sd_alsiha()->templates()->get( 'footer/footer', 'widgets' );
			}
			?>

			<div class="footer-copyright">
				<div class="<?php echo esc_attr( $footerContainerClass ); ?>">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<div class="site-info text-center">
								<?php
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

	<!-- Search modal -->
	<div id="mobile-search">
		<?php
		/**
		 * Site Search.
		 */
		sd_alsiha()->templates()->get( 'header/site', 'search' );
		?>
		<div class="close-btn">
			<i class="fa fa-times"></i>
		</div>
	</div>
	<div class="mobile-search-overlay"></div>

	<?php wp_footer(); ?>
</body>
</html>
