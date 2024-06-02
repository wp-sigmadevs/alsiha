<?php
/**
 * The template for displaying the header.
 *
 * This is the template that displays all the <head> section and site header
 * and starts <div id="wrapper">
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

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11"/>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<!--[if lte IE 9]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please upgrade your browser to improve your experience.</p>
	<![endif]-->

	<div id="page" class="<?php echo esc_attr( Helpers::getPageClasses() ); ?>">
		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php echo esc_html__( 'Skip to content', 'alsiha' ); ?></a><!-- .skip-link-->

		<header id="masthead" class="<?php echo esc_attr( Helpers::getHeaderClasses() ); ?>"<?php sd_alsiha()->headerImage(); ?>>
			<div class="header-area<?php echo true === get_theme_mod( 'alsiha_enable_sticky_header', true ) ? esc_attr( ' intelligent-header' ) : ''; ?>">
				<div class="top-bar">
					<div class="<?php echo esc_attr( Helpers::getHeaderContainerClass() ); ?>">
						<div class="row">
							<div class="col-12">
								<?php
								/**
								 * Header Top Bar template.
								 */
								sd_alsiha()->templates()->get( 'header/top', 'bar' );
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="primary-header">
					<div class="<?php echo esc_attr( Helpers::getHeaderContainerClass() ); ?>">
						<div class="row align-items-center">
							<div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-2">
								<?php
								/**
								 * Site Branding.
								 */
								sd_alsiha()->getTemplatePart( 'views/header/site-branding' );
								?>
							</div>

							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-7 d-none d-lg-block">
								<?php
								/**
								 * Site Search.
								 */
								sd_alsiha()->getTemplatePart( 'views/header/site-search' );
								?>
							</div>

							<div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
								<?php
								/**
								 * Action Buttons.
								 */
								sd_alsiha()->getTemplatePart( 'views/header/action-buttons' );
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="secondary-header">
					<div class="<?php echo esc_attr( Helpers::getHeaderContainerClass() ); ?>">
						<div class="row align-items-center">
							<div class="col-12 col-sm-12 col-md-12">
								<?php
								/**
								 * Site Nav.
								 */
								sd_alsiha()->getTemplatePart( 'views/header/site-nav' );
								?>
							</div>

							<div class="col-12 col-sm-12 col-md-12">
								<?php
								/**
								 * Icon Nav.
								 */
								sd_alsiha()->getTemplatePart( 'views/header/nav-icon' );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="fixed-header-space"></div><!-- <?php echo esc_attr__( 'Empty placeholder for header height.', 'alsiha' ); ?> -->

			<?php
			if ( has_nav_menu( 'handheld_nav' ) ) {
				/**
				 * Handheld Navigation.
				 */
				sd_alsiha()->getTemplatePart( 'views/header/handheld-nav' );
			}

			if ( ! is_front_page() ) {
				if ( ! get_field( 'alsiha_meta_disable_page_title' ) ) {
					/**
					 * Page Title.
					 */
					sd_alsiha()->getTemplatePart( 'views/header/page-title' );
				}
			} else {
				sd_alsiha()->getTemplatePart( 'views/content/content-slider' );
			}
			?>
		</header><!-- #masthead -->

		<div id="wrapper" class="site-content<?php echo is_front_page() ? esc_attr( ' front-page-content' ) : esc_attr( ' inner-page-content' ); ?>" tabindex="-1">
