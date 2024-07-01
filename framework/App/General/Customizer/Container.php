<?php
/**
 * Customizer Class: Container.
 *
 * This Class registers Customizer Container Section.
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
 * Customizer Class: Container.
 *
 * @since 1.0.0
 */
class Container extends CustomizerBase {
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
		$this->panelID    = 'alsiha_general_settings';
		$this->sectionIDs = [
			'container' => 'alsiha_container_settings',
		];
		$this->sections   = $this->setSections();
		$this->controls   = $this->setControls();

		$this->init();
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections[ $this->sectionIDs['container'] ] = [
			'title'       => esc_html__( 'Containers', 'alsiha' ),
			'description' => esc_html__( 'Theme Container Widths', 'alsiha' ),
			'panel'       => $this->panelID,
			'priority'    => 10,
			'tabs'        => [
				'general' => [
					'label' => esc_html__( 'General', 'alsiha' ),
				],
				'design'  => [
					'label' => esc_html__( 'Design', 'alsiha' ),
				],
			],
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
		new \Kirki\Pro\Field\Headline(
			[
				'settings'    => 'kirki_pro_headline',
				'label'       => esc_html__( 'Content', 'alsiha' ),
				'description' => esc_html__( 'Headlines can include descriptions as well.', 'alsiha' ),
				'section'     => $this->sectionIDs['container'],
				'tooltip'     => 'Headlines also work with tooltips.',
				'tab'         => 'general',
			]
		);

		$this->controls['alsiha_container_xxl'] = [
			'section'     => $this->sectionIDs['container'],
			'label'       => esc_html__( 'Container Width (px) for Large Screens', 'alsiha' ),
			'description' => esc_html__( 'For large screens (≥ 1600px)', 'alsiha' ),
			'type'        => 'kirki-input-slider',
			'priority'    => 10,
			'default'     => 1400,
			'choices'     => [
				'min'  => 500,
				'max'  => 2000,
				'step' => 10,
			],
			'transport'   => 'postMessage',
			'tab'         => 'general',
			'output'      => [
				[
					'element'  => ':root',
					'property' => '--alsiha-container-xxl',
				],
			],
		];

		$this->controls['alsiha_container_xl'] = [
			'section'     => $this->sectionIDs['container'],
			'label'       => esc_html__( 'Container Width (px) for Desktops', 'alsiha' ),
			'description' => esc_html__( 'For desktops (≥ 1200px)', 'alsiha' ),
			'type'        => 'kirki-input-slider',
			'priority'    => 10,
			'default'     => 1140,
			'choices'     => [
				'min'  => 500,
				'max'  => 2000,
				'step' => 10,
			],
			'transport'   => 'postMessage',
			'tab'         => 'general',
			'output'      => [
				[
					'element'  => ':root',
					'property' => '--alsiha-container-xl',
				],
			],
		];

		$this->controls['alsiha_container_lg'] = [
			'section'     => $this->sectionIDs['container'],
			'label'       => esc_html__( 'Container Width (px) for Tablets', 'alsiha' ),
			'description' => esc_html__( 'For tablets (≥ 1024px)', 'alsiha' ),
			'type'        => 'kirki-input-slider',
			'priority'    => 10,
			'default'     => 960,
			'choices'     => [
				'min'  => 500,
				'max'  => 2000,
				'step' => 10,
			],
			'transport'   => 'postMessage',
			'tab'         => 'general',
			'output'      => [
				[
					'element'  => ':root',
					'property' => '--alsiha-container-lg',
				],
			],
		];

		$this->controls['alsiha_container_md'] = [
			'section'     => $this->sectionIDs['container'],
			'label'       => esc_html__( 'Container Width (px) for Small Tablets', 'alsiha' ),
			'description' => esc_html__( 'For small tablets (≥ 768px)', 'alsiha' ),
			'type'        => 'kirki-input-slider',
			'priority'    => 10,
			'default'     => 720,
			'choices'     => [
				'min'  => 500,
				'max'  => 2000,
				'step' => 10,
			],
			'transport'   => 'postMessage',
			'tab'         => 'general',
			'output'      => [
				[
					'element'  => ':root',
					'property' => '--alsiha-container-md',
				],
			],
		];

		$this->controls['alsiha_container_sm'] = [
			'section'     => $this->sectionIDs['container'],
			'label'       => esc_html__( 'Container Width (px) for Mobile Devices', 'alsiha' ),
			'description' => esc_html__( 'For mobile devices (≥ 576px)', 'alsiha' ),
			'type'        => 'kirki-input-slider',
			'priority'    => 10,
			'default'     => 540,
			'choices'     => [
				'min'  => 500,
				'max'  => 2000,
				'step' => 10,
			],
			'transport'   => 'postMessage',
			'tab'         => 'general',
			'output'      => [
				[
					'element'  => ':root',
					'property' => '--alsiha-container-sm',
				],
			],
		];

		$this->controls['alsiha_container_padding'] = [
			'section'     => $this->sectionIDs['container'],
			'label'       => esc_html__( 'Container Width (px) for Mobile Devices', 'alsiha' ),
			'description' => esc_html__( 'For mobile devices (≥ 576px)', 'alsiha' ),
			'type'        => 'kirki-padding',
			'priority'    => 10,
			'default'     => [
				'top'    => 2,
				'bottom' => 2,
			],
			'transport'   => 'postMessage',
			'tab'         => 'design',
			'choices'     => [
				'unit' => 'rem',
			],
			'output'      => [
				[
					'element'  => ':root',
					'property' => '--alsiha-container-sm',
				],
			],
		];

		return $this->controls;
	}
}
