<?php
/**
 * Elementor Add-on Class: ShowcaseSlider
 *
 * This class registers and renders Elementor Showcase Slider Widget.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Elementor\Widgets;

use Exception;
use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Abstracts\ElementorBase,
	Elementor\Render\Render,
	Elementor\Helpers\WidgetControls
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Widget Class: ShowcaseSlider
 *
 * @since 1.0.0
 */
class ShowcaseSlider extends ElementorBase {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Construct function
	 *
	 * @param array $data default array.
	 * @param mixed $args default arg.
	 *
	 * @throws Exception If arguments are missing when initializing a full widget
	 *  instance.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function __construct( $data = [], $args = null ) {
		$this->title = esc_html__( 'Showcase Slider', 'alsiha' );
		$this->name  = 'sigma-showcase-slider';

		parent::__construct( $data, $args );
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends(): array {
		if ( ! $this->isEditMode() ) {
			return [];
		}

		return [
			'elementor-icons-shared-0',
			'elementor-icons-fa-solid',
		];
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_script_depends(): array {
		return [
			'imagesloaded',
			'swiper',
		];
	}

	/**
	 * Widget Field
	 *
	 * @return array
	 */
	public function widgetFields() {
		return array_merge(
			WidgetControls::showcaseSliderControls( $this ),
		);
	}

	/**
	 * Render Function
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Render initialization.
		$this->renderStart();

		// Call the template rendering method.
		echo wp_kses( Render::instance()->showcaseSliderView( $settings, $this->get_unique_name() ), 'allow_content' );

		// Ending the render.
		$this->renderEnd();
	}
}
