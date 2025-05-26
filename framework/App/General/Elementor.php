<?php
/**
 * General Class: ElementorInit.
 *
 * This class initializes Elementor add-ons.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General;

use Elementor\Plugin;
use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Elementor\Widgets\Products,
	Elementor\Widgets\GridPopup,
	Elementor\Widgets\Portfolios,
	Elementor\Widgets\ButtonPopup,
	Elementor\Widgets\ShowcaseSlider,
	Elementor\Widgets\GridPopupGallery,
	Elementor\Controls\Select2AjaxControl
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * General Class: ElementorInit.
 *
 * @since 1.0.0
 */
class Elementor {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

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
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'editorScripts' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'addCategory' ] );
		add_action( 'elementor/widgets/register', [ $this, 'initWidgets' ] );
		add_action( 'elementor/controls/register', [ $this, 'initControls' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'preview_styles' ] );
	}

	/**
	 * Enqueue Elementor Editor scripts.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function editorScripts() {
		wp_enqueue_style(
			'sigma-el-editor-style',
			sd_alsiha()->getAssetsUri( 'backend/elementor-editor', 'css', '.min.css' ),
			[],
			sd_alsiha()->getVersion()
		);
	}

	/**
	 * Register Custom Category.
	 *
	 * @param object $manager Categories Manager.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function addCategory( $manager ) {
		$categories['alsiha'] = [
			'title' => esc_html__( 'Al-Siha Theme', 'alsiha' ),
			'icon'  => 'fa fa-plug',
		];

		$existingCategories = $manager->get_categories();
		$categories         = array_merge(
			array_slice( $existingCategories, 0, 1 ),
			$categories,
			array_slice( $existingCategories, 1 )
		);

		$setCategory = function ( $categories ) use ( $manager ) {
			$manager->categories = $categories;
		};

		$setCategory->call( $manager, $categories );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @param object $manager Widgets Manager.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function initWidgets( $manager ) {
		$widgetList = [
			Products::class,
			GridPopup::class,
			Portfolios::class,
			ButtonPopup::class,
			ShowcaseSlider::class,
			GridPopupGallery::class,
		];

		foreach ( $widgetList as $element ) {
			$widget = new $element();

			if ( $widget && is_object( $widget ) ) {
				$manager->register( $widget );
			}
		}
	}

	/**
	 * Init Widgets
	 *
	 * Include controls files and register them
	 *
	 * @param object $manager Widgets Manager.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function initControls( $manager ) {
		$manager->register( new Select2AjaxControl() );
	}

	/**
	 * Elementor preview styles.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function preview_styles() {
		if ( Plugin::$instance->preview->is_preview_mode() ) {
			$custom_css = '
            .elementor-editor-active {
                .pswp {
                    display: none;
                }

                .elementor-invisible {
                    visibility: visible !important;
                }
            }
        ';
			wp_add_inline_style( 'elementor-frontend', $custom_css );
		}
	}
}
