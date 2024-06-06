<?php
/**
 * Frontend Class: CSSVariables
 *
 * This class provides and assigns custom CSS variable dynamic values.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\Frontend;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Functions\Helpers,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Frontend Class: Enqueue
 *
 * @since 1.0.0
 */
class CSSVariables {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Variables to include.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private array $variables = [];

	/**
	 * Registers the class.
	 *
	 * This backend class is only being instantiated in the frontend
	 * as requested in the Bootstrap class.
	 *
	 * @return void
	 * @since  1.0.0
	 *
	 * @see Bootstrap::registerServices
	 * @see Requester::isFrontend()
	 */
	public function register(): void {
		$this->colors();

		if ( empty( $this->variables ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', [ $this, 'print' ] );
	}

	/**
	 * Add inline style for variables.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function print(): void {
		$themeVars  = '';
		$themeVars .= '
			:root {
				--alsiha-text-color: ' . $this->variables['colors']['text'] . ';
				--alsiha-primary-color: ' . $this->variables['colors']['primary'] . ';
				--alsiha-secondary-color: ' . $this->variables['colors']['secondary'] . ';
				--alsiha-tertiary-color: ' . $this->variables['colors']['tertiary'] . ';
				--alsiha-offset-color: ' . $this->variables['colors']['offset'] . ';
				--alsiha-border-color: ' . $this->variables['colors']['border'] . ';
		}';

		wp_add_inline_style( 'alsiha-frontend-styles', $themeVars );
	}


	/**
	 * Colors.
	 *
	 * @return CSSVariables
	 * @since  1.0.0
	 */
	private function colors(): CSSVariables {
		$this->variables['colors']['text']      = sd_alsiha()->getOption( 'alsiha_text_color' );
		$this->variables['colors']['primary']   = sd_alsiha()->getOption( 'alsiha_primary_color' );
		$this->variables['colors']['secondary'] = sd_alsiha()->getOption( 'alsiha_secondary_color' );
		$this->variables['colors']['tertiary']  = sd_alsiha()->getOption( 'alsiha_tertiary_color' );
		$this->variables['colors']['offset']    = sd_alsiha()->getOption( 'alsiha_offset_color' );
		$this->variables['colors']['border']    = sd_alsiha()->getOption( 'alsiha_border_color' );

		return $this;
	}
}
