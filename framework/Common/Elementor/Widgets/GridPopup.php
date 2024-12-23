<?php
/**
 * Elementor Add-on Class: GridPopup
 *
 * This class registers and renders Grid with Image Popup Widget.
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
 * Widget Class: GridPopup
 *
 * @since 1.0.0
 */
class GridPopup extends ElementorBase {
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
		$this->title = esc_html__( 'Grid Popup', 'alsiha' );
		$this->name  = 'sigma-grid-popup';

		parent::__construct( $data, $args );
	}

	/**
	 * Widget Field
	 *
	 * @return array
	 */
	public function widgetFields() {
		return array_merge(
			WidgetControls::gridPopupControls( $this ),
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
		echo wp_kses( Render::instance()->gridPopupView( $settings, $this->get_unique_name(), 'sigma-portfolio-grid' ), 'allow_content' );

		// Ending the render.
		$this->renderEnd();
	}
}
