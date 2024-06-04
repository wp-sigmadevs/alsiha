<?php
/**
 * Customizer Class: Typography.
 *
 * This Class registers Customizer Typography Panel.
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
 * Customizer Class: Typography.
 *
 * @since 1.0.0
 */
class Typography extends CustomizerBase {
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
		$this->panelID   = 'alsiha_typography_settings';
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
			'title'       => esc_html__( 'Typography', 'alsiha' ),
			'description' => esc_html__( 'Typography settings', 'alsiha' ),
			'panel'       => 'alsiha_texts_colors_settings',
			'priority'    => 10,
		];
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections['alsiha_typography_body'] = [
			'title'       => esc_html__( 'Body', 'alsiha' ),
			'description' => esc_html__( 'Specify the body typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 10,
		];

		$this->sections['alsiha_typography_nav'] = [
			'title'       => esc_html__( 'Menu', 'alsiha' ),
			'description' => esc_html__( 'Specify the Navigation Menu typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 20,
		];

		$this->sections['alsiha_typography_h1'] = [
			'title'       => esc_html__( 'Heading 1', 'alsiha' ),
			'description' => esc_html__( 'Specify h1 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 30,
		];

		$this->sections['alsiha_typography_h2'] = [
			'title'       => esc_html__( 'Heading 2', 'alsiha' ),
			'description' => esc_html__( 'Specify h2 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 40,
		];

		$this->sections['alsiha_typography_h3'] = [
			'title'       => esc_html__( 'Heading 3', 'alsiha' ),
			'description' => esc_html__( 'Specify h3 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 50,
		];

		$this->sections['alsiha_typography_h4'] = [
			'title'       => esc_html__( 'Heading 4', 'alsiha' ),
			'description' => esc_html__( 'Specify h4 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 60,
		];

		$this->sections['alsiha_typography_h5'] = [
			'title'       => esc_html__( 'Heading 5', 'alsiha' ),
			'description' => esc_html__( 'Specify h5 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 70,
		];

		$this->sections['alsiha_typography_h6'] = [
			'title'       => esc_html__( 'Heading 6', 'alsiha' ),
			'description' => esc_html__( 'Specify h6 typography.', 'alsiha' ),
			'panel'       => 'alsiha_typography_settings',
			'priority'    => 80,
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
		$this->controls['alsiha_body_font'] = [
			'section'   => 'alsiha_typography_body',
			'label'     => esc_html__( 'Body Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 10,
			'transport' => 'auto',
			'default'   => [
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'output'    => [
				[
					'element' => 'body, button, input, select, textarea',
				],
			],
		];

		$this->controls['alsiha_nav_font'] = [
			'section'   => 'alsiha_typography_nav',
			'label'     => esc_html__( 'Menu Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 15,
			'default'   => [
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'uppercase',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => '#main-menu li a',
				],
			],
		];

		$this->controls['alsiha_icon_nav_font'] = [
			'section'   => 'alsiha_typography_nav',
			'label'     => esc_html__( 'Icon Menu Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 16,
			'default'   => [
				'font-size'      => '1.4rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'capitalize',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => '#icon-menu > li a',
				],
			],
		];

		$this->controls['alsiha_h1_font'] = [
			'section'   => 'alsiha_typography_h1',
			'label'     => esc_html__( 'Heading-1 Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 20,
			'default'   => [
				'font-size'      => '4rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => 'h1, .h1',
				],
			],
		];

		$this->controls['alsiha_h2_font'] = [
			'section'   => 'alsiha_typography_h2',
			'label'     => esc_html__( 'Heading-2 Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 25,
			'default'   => [
				'font-size'      => '3.2rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => 'h2, .h2',
				],
			],
		];

		$this->controls['alsiha_h3_font'] = [
			'section'   => 'alsiha_typography_h3',
			'label'     => esc_html__( 'Heading-3 Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 30,
			'default'   => [
				'font-size'      => '2.8rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => 'h3, .h3',
				],
			],
		];

		$this->controls['alsiha_h4_font'] = [
			'section'   => 'alsiha_typography_h4',
			'label'     => esc_html__( 'Heading-4 Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 35,
			'default'   => [
				'font-size'      => '2.4rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => 'h4, .h4',
				],
			],
		];

		$this->controls['alsiha_h5_font'] = [
			'section'   => 'alsiha_typography_h5',
			'label'     => esc_html__( 'Heading-5 Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 40,
			'default'   => [
				'font-size'      => '2rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => 'h5, .h5',
				],
			],
		];

		$this->controls['alsiha_h6_font'] = [
			'section'   => 'alsiha_typography_h6',
			'label'     => esc_html__( 'Heading-6 Typography', 'alsiha' ),
			'type'      => 'typography',
			'priority'  => 45,
			'default'   => [
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => 'h6, .h6',
				],
			],
		];

		return $this->controls;
	}
}
