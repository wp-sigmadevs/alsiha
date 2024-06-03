<?php
/**
 * General Class: Customizer.
 *
 * This Class uses Kirki framework to register Customizer controls.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General;

use Kirki;
use SigmaDevs\Sigma\Common\
{
	Abstracts\Base,
	Traits\Singleton
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * General Class: Customizer.
 *
 * @since 1.0.0
 */
class Customizer extends Base {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Kirki Configuration ID.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public string $configId;

	/**
	 * Registers the class.
	 *
	 * This general class is always being instantiated as requested in the
	 * Bootstrap class.
	 *
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->configId = 'alsiha_theme';

		// Initialization.
		$this->initCustomizer();
	}

	/**
	 * Customizer init.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function initCustomizer(): void {
		// Setup kirki.
		add_action( 'init', [ $this, 'setup' ] );

		// Modifying existing controls.
		add_action( 'customize_register', [ $this, 'modifyControls' ] );

		// Disable kirki Custom Loader.
		// add_filter( 'kirki/config', [ $this, 'disableLoader' ] );

		// Selective refresh JS.
		add_action( 'customize_preview_init', [ $this, 'selectiveRefresh' ] );

		// Customizer CSS.
		// add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueueStyles' ] );
	}

	/**
	 * Setup Kirki.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function setup(): void {
		$args = [
			'capability'  => 'edit_theme_options',
			'option_type' => 'theme_mod',
		];

		Kirki::add_config( $this->configId, $args );
	}

	/**
	 * Modifying existing controls.
	 *
	 * @param object $wpCustomize An instance of the WP_Customize_Manager class.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function modifyControls( $wpCustomize ): void {
		// Moving background color setting alongside background image.
		$wpCustomize->get_control( 'background_color' )->section  = 'background_image';
		$wpCustomize->get_control( 'background_color' )->priority = 20;

		$wpCustomize->get_control( 'header_textcolor' )->section  = 'header_image';
		$wpCustomize->get_control( 'header_textcolor' )->priority = 11;

		// Changing some default titles.
		$wpCustomize->get_section( 'background_image' )->title = esc_html__( 'Site Background', 'alsiha' );
		$wpCustomize->get_section( 'title_tagline' )->title    = esc_html__( 'Logo / Title / Favicon', 'alsiha' );
		$wpCustomize->get_section( 'title_tagline' )->priority = 8;
		$wpCustomize->get_section( 'header_image' )->title     = esc_html__( 'Header Background', 'alsiha' );
		$wpCustomize->get_section( 'header_image' )->priority  = 10;

		// Moving some general section.
		$wpCustomize->get_section( 'static_front_page' )->panel = 'alsiha_general_settings';
		$wpCustomize->get_section( 'title_tagline' )->panel     = 'header_settings';
		$wpCustomize->get_section( 'background_image' )->panel  = 'alsiha_general_settings';
		$wpCustomize->get_section( 'header_image' )->panel      = 'header_settings';

		// Moving control description.
		$wpCustomize->get_control( 'custom_logo' )->description = esc_html__( 'Recommended image size is 180x180 px.', 'alsiha' );

		// Selective refresh.
		$wpCustomize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wpCustomize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wpCustomize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		$wpCustomize->selective_refresh->add_partial(
			'blogname',
			[
				'selector'        => 'header .site-title',
				'render_callback' => function () {
					bloginfo( 'name' );
				},
			]
		);

		$wpCustomize->selective_refresh->add_partial(
			'blogdescription',
			[
				'selector'        => 'header .site-description',
				'render_callback' => function () {
					bloginfo( 'description' );
				},
			]
		);
	}

	/**
	 * JS for Live Preview.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function selectiveRefresh(): void {
		wp_enqueue_script(
			'alsiha-customize-preview',
			sd_alsiha()->getAssetsUri( 'customizer/customize-preview', 'js', '.js' ),
			[ 'customize-preview', 'jquery' ],
			sd_alsiha()->getVersion(),
			true
		);
	}
}
