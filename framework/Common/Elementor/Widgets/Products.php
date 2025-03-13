<?php
/**
 * Elementor Add-on Class: Products
 *
 * This class registers and renders products with external links.
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
 * Widget Class: Products
 *
 * @since 1.0.0
 */
class Products extends ElementorBase {
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
		$this->title = esc_html__( 'Products', 'alsiha' );
		$this->name  = 'sigma-products-grid';

		parent::__construct( $data, $args );
	}

	/**
	 * Widget Field
	 *
	 * @return array
	 */
	public function widgetFields() {
		return array_merge(
			WidgetControls::productsControls( $this ),
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
		echo wp_kses( Render::instance()->productsView( $settings, $this->get_unique_name() ), 'allow_content' );

		// Ending the render.
		$this->renderEnd();
	}
}
