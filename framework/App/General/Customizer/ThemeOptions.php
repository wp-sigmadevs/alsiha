<?php
/**
 * Customizer Class: ThemeOptions.
 *
 * This Class registers Customizer Primary Theme Options Panel.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General\Customizer;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Abstracts\CustomizerBase
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Class: ThemeOptions.
 *
 * @since 1.0.0
 */
class ThemeOptions extends CustomizerBase {
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
		$this->panelID   = $this->primaryPanel;
		$this->panelArgs = $this->setPrimaryPanelArgs();

		$this->init();
	}

	/**
	 * Set the primary panel args.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setPrimaryPanelArgs(): array {
		return [
			'priority'    => 10,
			'title'       => sd_alsiha()->getData()['name'] . esc_html__( ' Settings', 'alsiha' ),
			'description' => sd_alsiha()->getData()['name'] . esc_html__( ' options & settings', 'alsiha' ),
		];
	}
}
