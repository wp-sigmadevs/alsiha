<?php
/**
 * Customizer Class: Footer.
 *
 * This Class registers Customizer Footer Panel.
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
 * Customizer Class: Footer.
 *
 * @since 1.0.0
 */
class Footer extends CustomizerBase {
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
		$this->panelID   = 'alsiha_footer_settings';
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
			'title'       => esc_html__( 'Footer', 'alsiha' ),
			'description' => esc_html__( 'Footer settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 12,
		];
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections['alsiha_footer_styles'] = [
			'title'       => esc_html__( 'Footer Styles', 'alsiha' ),
			'description' => esc_html__( 'footer style settings', 'alsiha' ),
			'panel'       => $this->panelID,
			'priority'    => 10,
		];

		$this->sections['alsiha_footer_copyright'] = [
			'title'       => esc_html__( 'Footer Copyright', 'alsiha' ),
			'description' => esc_html__( 'footer copyright settings', 'alsiha' ),
			'panel'       => $this->panelID,
			'priority'    => 15,
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
		$this->controls['alsiha_footer_logo'] = [
			'section'     => 'alsiha_footer_styles',
			'label'       => esc_html__( 'Footer Top Logo', 'alsiha' ),
			'description' => esc_html__( 'Please upload footer top logo (SVG preferred)', 'alsiha' ),
			'type'        => 'image',
			'priority'    => 11,
			'transport'   => 'auto',
		];

		$this->controls['alsiha_footer_bgc'] = [
			'section'     => 'alsiha_footer_styles',
			'label'       => esc_html__( 'Footer background', 'alsiha' ),
			'description' => esc_html__( 'Please choose the footer background color', 'alsiha' ),
			'type'        => 'color',
			'priority'    => 12,
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => '#colophon',
					'property' => 'background-color',
				],
			],
		];

		$this->controls['alsiha_footer_padding'] = [
			'section'     => 'alsiha_footer_styles',
			'label'       => esc_html__( 'Footer Padding', 'alsiha' ),
			'description' => esc_html__( 'Footer top/bottom padding. Default: 7rem.', 'alsiha' ),
			'type'        => 'dimensions',
			'priority'    => 15,
			'default'     => [
				'padding-top'    => '7rem',
				'padding-bottom' => '7rem',
			],
			'choices'     => [
				'labels' => [
					'padding-top'    => esc_html__( 'Padding Top', 'alsiha' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'alsiha' ),
				],
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => '#colophon',
				],
			],
		];

		$this->controls['alsiha_enable_100_footer'] = [
			'section'     => 'alsiha_footer_styles',
			'label'       => esc_html__( '100% Footer?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable 100% footer width, regardless of container.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 20,
			'default'     => 0,
		];

		$this->controls['alsiha_footer_copyright_text'] = [
			'section'     => 'alsiha_footer_copyright',
			'label'       => esc_html__( 'Footer Copyright Text', 'alsiha' ),
			'description' => esc_html__( 'Please enter footer copyright text.', 'alsiha' ),
			'type'        => 'editor',
			'priority'    => 10,
		];

		return $this->controls;
	}
}
