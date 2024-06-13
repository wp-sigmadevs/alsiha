<?php
/**
 * Displays the page title.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

use SigmaDevs\Sigma\Common\Models\Breadcrumbs;
use SigmaDevs\Sigma\Common\Utils\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$archiveDescription = sd_alsiha()->getOption( 'alsiha_archive_description' );
$breadcrumbs        = new Breadcrumbs();
$enableBreadcrumbs  = sd_alsiha()->getOption( 'alsiha_enable_breadcrumbs' );
$breadcrumbsMeta    = sd_alsiha()->getField( 'alsiha_meta_disable_breadcrumbs' );

if ( ! $breadcrumbsMeta ) {
	?>
	<div id="page-title" class="page-title image-in-bg size-cover">
		<div class="breadcrumbs-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<?php
						if ( $enableBreadcrumbs ) {
							/**
							 * Breadcrumbs.
							 */
							if ( is_single() && ! is_product() ) {
								$breadcrumbs->getBreadcrumbs(
									[
										'delimiter'        => '/',
										'displayTerms'     => false,
										'catArchivePrefix' => false,
										'tagArchivePrefix' => false,
										'displayPostTypeArchive' => false,
									]
								);
							} else {
								$breadcrumbs->getBreadcrumbs(
									[
										'delimiter'        => '/',
										'displayTerms'     => true,
										'catArchivePrefix' => false,
										'tagArchivePrefix' => false,
										'displayPostTypeArchive' => false,
									]
								);
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .page-title -->
	<?php
}

if ( ! ( Helpers::isProduct() || is_single() ) ) {
	?>
	<div class="pagetitle-section">
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center">
					<h1 class="mb-0"><?php Helpers::thePageTitle(); ?></h1>
					<?php
					if ( is_home() && ! empty( $archiveDescription ) ) {
						?>
						<div class="archive-description mt-half row">
							<div class="col-12 col-sm-12 col-md-12 col-lg-8 offset-lg-2 text-justify">
								<?php
								echo wp_kses( apply_filters( 'the_content', $archiveDescription ), 'allow_content' );
								?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
