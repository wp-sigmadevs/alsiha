<?php
/**
 * Customizer Class: Appearance.
 *
 * This Class registers Customizer Appearance & Color Panel.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General\Customizer;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Abstracts\CustomizerBase,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Class: Appearance.
 *
 * @since 1.0.0
 */
class Appearance extends CustomizerBase {
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
		$this->panelID   = 'alsiha_texts_colors_settings';
		$this->panelArgs = $this->setPanelArgs();
		$this->sections  = $this->setSections();
		$this->controls  = $this->setControls();

		$this->init();
	}

	/**
	 * Set the panel args.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setPanelArgs(): array {
		return [
			'title'       => esc_html__( 'Appearance', 'alsiha' ),
			'description' => esc_html__( 'Typography & Color settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 13,
		];
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections['alsiha_color_settings'] = [
			'title'       => esc_html__( 'Colors', 'alsiha' ),
			'description' => esc_html__( 'Color scheme settings', 'alsiha' ),
			'panel'       => $this->panelID,
			'priority'    => 10,
		];

		return $this->sections;
	}

	/**
	 * Set the controls.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setControls(): array {
		$this->controls['alsiha_text_color'] = [
			'section'   => 'alsiha_color_settings',
			'label'     => esc_html__( 'Text Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 10,
			'default'   => '#242545',
			'transport' => 'postMessage',
		];

		$this->controls['alsiha_primary_color'] = [
			'section'   => 'alsiha_color_settings',
			'label'     => esc_html__( 'Primary Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 15,
			'default'   => '#738ff4',
			'transport' => 'postMessage',
		];

		$this->controls['alsiha_secondary_color'] = [
			'section'   => 'alsiha_color_settings',
			'label'     => esc_html__( 'Secondary Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 20,
			'default'   => '#fc346c',
			'transport' => 'postMessage',
		];

		$this->controls['alsiha_tertiary_color'] = [
			'section'   => 'alsiha_color_settings',
			'label'     => esc_html__( 'Tertiary Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 25,
			'default'   => '#fccc6c',
			'transport' => 'postMessage',
		];

		$this->controls['alsiha_offset_color'] = [
			'section'   => 'alsiha_color_settings',
			'label'     => esc_html__( 'Offset Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 30,
			'default'   => '#EFF5FC',
			'transport' => 'postMessage',
		];

		$this->controls['alsiha_border_color'] = [
			'section'   => 'alsiha_color_settings',
			'label'     => esc_html__( 'Border Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 35,
			'default'   => '#DDDDDD',
			'transport' => 'postMessage',
		];

		return $this->controls;
	}
}
