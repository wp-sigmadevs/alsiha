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
	Abstracts\CustomizerBase,
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
			'panel'       => 'alsiha_general_settings',
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
		$this->sections['alsiha_typography_base'] = [
			'title'    => esc_html__( 'Base Fonts', 'alsiha' ),
			'panel'    => 'alsiha_typography_settings',
			'priority' => 10,
		];

		$this->sections['alsiha_typography_nav'] = [
			'title'    => esc_html__( 'Menu Font', 'alsiha' ),
			'panel'    => 'alsiha_typography_settings',
			'priority' => 20,
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
		$this->controls['alsiha_section_body_font'] = [
			'section'  => 'alsiha_typography_base',
			'label'    => esc_html__( 'Body Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 10,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_body_font'] = [
			'section'   => 'alsiha_typography_base',
			'type'      => 'typography',
			'priority'  => 10,
			'transport' => 'refresh',
			'default'   => [
				'font-family'    => 'Inter',
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'choices'   => [
				'fonts' => [
					'google' => $this->googleFontsList(),
				],
			],
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--alsiha-body-font',
					'choice'   => 'font-family',
				],
				[
					'element'  => 'body, button, input, select, textarea',
					'property' => '--alsiha-body-font-size',
					'choice'   => 'font-size',
				],
				[
					'element'  => 'body, button, input, select, textarea',
					'property' => '--alsiha-body-line-height',
					'choice'   => 'line-height',
				],
				[
					'element'  => 'body, button, input, select, textarea',
					'property' => 'letter-spacing',
					'choice'   => 'letter-spacing',
				],
				[
					'element'  => 'body, button, input, select, textarea',
					'property' => 'text-transform',
					'choice'   => 'text-transform',
				],
			],
		];

		$this->controls['alsiha_section_heading_font'] = [
			'section'  => 'alsiha_typography_base',
			'label'    => esc_html__( 'Heading Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 10,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_heading_font'] = [
			'section'   => 'alsiha_typography_base',
			'type'      => 'typography',
			'priority'  => 10,
			'transport' => 'refresh',
			'default'   => [
				'font-family'    => 'Inter',
				'variant'        => '600',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			],
			'choices'   => [
				'fonts' => [
					'google' => $this->googleFontsList(),
				],
			],
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--alsiha-heading-font',
					'choice'   => 'font-family',
				],
				[
					'element'  => 'h1, h2, h3, h4, h5, h6',
					'property' => '--alsiha-body-font-size',
					'choice'   => 'font-size',
				],
				[
					'element'  => 'h1, h2, h3, h4, h5, h6',
					'property' => '--alsiha-heading-line-height',
					'choice'   => 'line-height',
				],
				[
					'element'  => 'h1, h2, h3, h4, h5, h6',
					'property' => 'letter-spacing',
					'choice'   => 'letter-spacing',
				],
				[
					'element'  => 'h1, h2, h3, h4, h5, h6',
					'property' => 'text-transform',
					'choice'   => 'text-transform',
				],
			],
		];

		$this->controls['alsiha_section_menu_font'] = [
			'section'  => 'alsiha_typography_nav',
			'label'    => esc_html__( 'Navigation Menu Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 10,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_nav_font'] = [
			'section'   => 'alsiha_typography_nav',
			'type'      => 'typography',
			'priority'  => 10,
			'default'   => [
				'font-family'    => 'Inter',
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'uppercase',
			],
			'choices'   => [
				'fonts' => [
					'google' => $this->googleFontsList(),
				],
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => '#main-menu li a',
				],
			],
		];

		$this->controls['alsiha_section_social_menu_font'] = [
			'section'  => 'alsiha_typography_nav',
			'label'    => esc_html__( 'Menu Social Icons Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 15,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_icon_nav_font'] = [
			'section'   => 'alsiha_typography_nav',
			'type'      => 'typography',
			'priority'  => 16,
			'default'   => [
				'font-size'   => '1.4rem',
				'line-height' => '1.5',
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element' => '#icon-menu > li a',
				],
			],
		];

		$this->controls['alsiha_section_h1_font'] = [
			'section'  => 'alsiha_typography_base',
			'label'    => esc_html__( 'H1 Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 20,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_h1_font'] = [
			'section'   => 'alsiha_typography_base',
			'type'      => 'typography',
			'priority'  => 21,
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

		$this->controls['alsiha_section_h2_font'] = [
			'section'  => 'alsiha_typography_base',
			'label'    => esc_html__( 'H2 Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 22,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_h2_font'] = [
			'section'   => 'alsiha_typography_base',
			'type'      => 'typography',
			'priority'  => 23,
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

		$this->controls['alsiha_section_h3_font'] = [
			'section'  => 'alsiha_typography_base',
			'label'    => esc_html__( 'H3 Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 24,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_h3_font'] = [
			'section'   => 'alsiha_typography_base',
			'type'      => 'typography',
			'priority'  => 25,
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

		$this->controls['alsiha_section_h4_font'] = [
			'section'  => 'alsiha_typography_base',
			'label'    => esc_html__( 'H4 Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 26,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_h4_font'] = [
			'section'   => 'alsiha_typography_base',
			'type'      => 'typography',
			'priority'  => 27,
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

		$this->controls['alsiha_section_h5_font'] = [
			'section'  => 'alsiha_typography_base',
			'label'    => esc_html__( 'H5 Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 28,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_h5_font'] = [
			'section'   => 'alsiha_typography_base',
			'type'      => 'typography',
			'priority'  => 29,
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

		$this->controls['alsiha_section_h6_font'] = [
			'section'  => 'alsiha_typography_base',
			'label'    => esc_html__( 'H6 Font', 'alsiha' ),
			'type'     => 'generic',
			'priority' => 30,
			'choices'  => [
				'element' => 'div',
			],
		];

		$this->controls['alsiha_h6_font'] = [
			'section'   => 'alsiha_typography_base',
			'type'      => 'typography',
			'priority'  => 31,
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

	/**
	 * Retrieve the list of Google Fonts.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function googleFontsList() {
		return apply_filters(
			'sd/sigma/customizer/google_fonts_list',
			[
				'Anton',
				'Arimo',
				'Baloo',
				'Besley',
				'Cambay',
				'Crimson Text',
				'Dancing Script',
				'Fraunces',
				'Great Vibes',
				'Hind',
				'Inter',
				'Italianno',
				'Josefin Sans',
				'Lato',
				'Libre Baskerville',
				'Lobster',
				'Merriweather',
				'Montserrat',
				'Noto Sans',
				'Old Standard TT',
				'Open Sans',
				'Oswald',
				'Outfit',
				'Oxygen',
				'Pacifico',
				'Playfair Display',
				'Poppins',
				'Quicksand',
				'Radley',
				'Raleway',
				'Roboto',
				'Sacramento',
				'Source Sans Pro',
				'Tangerine',
				'Tinos',
				'Unbounded',
			]
		);
	}
}
