<?php
/**
 * Customizer Class: Colors.
 *
 * This Class registers Customizer Color Panel.
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
class Colors extends CustomizerBase {
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
			'theme_colors' => 'alsiha_color_settings',
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
		$this->sections[ $this->sectionIDs['theme_colors'] ] = [
			'title'       => esc_html__( 'Colors', 'alsiha' ),
			'description' => esc_html__( 'Theme Colors', 'alsiha' ),
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
			'section'   => $this->sectionIDs['theme_colors'],
			'label'     => esc_html__( 'Text Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 10,
			'default'   => '#242545',
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--alsiha-text-color',
					'choice'   => 'color',
				],
			],
		];

		$this->controls['alsiha_heading_color'] = [
			'section'   => $this->sectionIDs['theme_colors'],
			'label'     => esc_html__( 'Headings (H1~H6) Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 11,
			'default'   => '#242545',
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--alsiha-headings-color',
					'choice'   => 'color',
				],
			],
		];

		$this->controls['alsiha_primary_color'] = [
			'section'   => $this->sectionIDs['theme_colors'],
			'label'     => esc_html__( 'Primary Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 15,
			'default'   => '#738ff4',
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--alsiha-primary-color',
					'choice'   => 'color',
				],
			],
		];

		$this->controls['alsiha_secondary_color'] = [
			'section'   => $this->sectionIDs['theme_colors'],
			'label'     => esc_html__( 'Secondary Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 20,
			'default'   => '#fc346c',
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--alsiha-secondary-color',
					'choice'   => 'color',
				],
			],
		];

		$this->controls['alsiha_offset_color'] = [
			'section'   => $this->sectionIDs['theme_colors'],
			'label'     => esc_html__( 'Offset Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 30,
			'default'   => '#EFF5FC',
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--alsiha-offset-color',
					'choice'   => 'color',
				],
			],
		];

		$this->controls['alsiha_border_color'] = [
			'section'   => $this->sectionIDs['theme_colors'],
			'label'     => esc_html__( 'Border Color', 'alsiha' ),
			'type'      => 'color',
			'priority'  => 35,
			'default'   => '#DDDDDD',
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--alsiha-border-color',
					'choice'   => 'color',
				],
			],
		];

		return $this->controls;
	}
}
