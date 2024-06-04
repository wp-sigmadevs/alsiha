<?php
/**
 * Customizer Class: Header.
 *
 * This Class registers Customizer Header Panel.
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
 * Customizer Class: Header.
 *
 * @since 1.0.0
 */
class Header extends CustomizerBase {
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
		$this->panelID   = 'header_settings';
		$this->panelArgs = $this->setPanelArgs();
		$this->sections  = $this->setSections();
		$this->controls  = $this->setControls();

		$this->init();
	}

	/**
	 * Get the panel args.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setPanelArgs(): array {
		return [
			'priority'    => 11,
			'title'       => esc_html__( 'Header', 'alsiha' ),
			'description' => esc_html__( 'Logo and page-title settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
		];
	}

	/**
	 * Get the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections['alsiha_header_styles'] = [
			'title'       => esc_html__( 'Header Styles', 'alsiha' ),
			'description' => esc_html__( 'Header Style settings', 'alsiha' ),
			'panel'       => 'header_settings',
			'priority'    => 10,
		];

		$this->sections['alsiha_header_topbar'] = [
			'title'       => esc_html__( 'Header Top Bar', 'alsiha' ),
			'description' => esc_html__( 'Header top bar settings', 'alsiha' ),
			'panel'       => 'header_settings',
			'priority'    => 11,
		];

		$this->sections['alsiha_sticky_header'] = [
			'title'       => esc_html__( 'Sticky Header', 'alsiha' ),
			'description' => esc_html__( 'Sticky header settings', 'alsiha' ),
			'panel'       => 'header_settings',
			'priority'    => 15,
		];

		return $this->sections;
	}

	/**
	 * Get the controls.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setControls(): array {
		$this->controls['alsiha_logo_padding'] = [
			'label'       => esc_html__( 'Logo Padding', 'alsiha' ),
			'description' => esc_html__( 'Logo top/bottom padding. Default: 0.1rem.', 'alsiha' ),
			'section'     => 'alsiha_header_styles',
			'type'        => 'dimensions',
			'priority'    => 20,
			'default'     => [
				'padding-top'    => '0.1rem',
				'padding-bottom' => '0.1rem',
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
					'element' => '.site-branding .logo',
				],
			],
		];

		$this->controls['alsiha_enable_100_header'] = [
			'label'       => esc_html__( '100% Header?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable 100% header width, regardless of container.', 'alsiha' ),
			'section'     => 'alsiha_header_styles',
			'type'        => 'toggle',
			'priority'    => 25,
			'default'     => 0,
		];

		$this->controls['alsiha_header_bg_color'] = [
			'label'       => esc_html__( 'Header Background Color', 'alsiha' ),
			'description' => esc_html__( 'Please choose the header background color', 'alsiha' ),
			'section'     => 'header_image',
			'type'        => 'color',
			'priority'    => 30,
			'choices'     => [
				'alpha' => true,
			],
			'default'     => '#fff',
			'output'      => [
				[
					'element'  => 'header .header-area',
					'property' => 'background-color',
				],
			],
			'transport'   => 'auto',
		];

		$this->controls['alsiha_enable_sticky_header'] = [
			'label'       => esc_html__( 'Enable Sticky Header?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable sticky header.', 'alsiha' ),
			'section'     => 'alsiha_sticky_header',
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		];

		$this->controls['alsiha_header_socials'] = [
			'label'       => esc_html__( 'Enable Header Social Icons?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable header social icons.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		];

		$this->controls['alsiha_header_page_title'] = [
			'label'       => esc_html__( 'Top bar page title', 'alsiha' ),
			'description' => esc_html__( 'Please enter header top bar page title.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'textarea',
			'priority'    => 10,
		];

		$this->controls['alsiha_header_page_selector'] = [
			'label'       => esc_html__( 'Select Top Bar Page', 'alsiha' ),
			'description' => esc_html__( 'Please select header top bar page.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'dropdown-pages',
			'priority'    => 10,
		];

		$this->controls['alsiha_header_phone'] = [
			'label'       => esc_html__( 'Top Bar Phone Text', 'alsiha' ),
			'description' => esc_html__( 'Enter header top bar phone text.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'text',
			'priority'    => 10,
		];

		$this->controls['alsiha_header_phone_url'] = [
			'label'       => esc_html__( 'Top Bar Phone URL', 'alsiha' ),
			'description' => esc_html__( 'Enter header top bar phone URL.', 'alsiha' ),
			'section'     => 'alsiha_header_topbar',
			'type'        => 'text',
			'priority'    => 11,
		];

		return $this->controls;
	}
}
