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
	Abstracts\CustomizerBase,
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
		$this->panelID    = 'header_settings';
		$this->sectionIDs = [
			'title_tagline'  => 'title_tagline',
			'header_image'   => 'header_image',
			'header_styles'  => 'alsiha_header_styles',
			'header_top_bar' => 'alsiha_header_top_bar',
		];
		$this->panelArgs  = $this->setPanelArgs();
		$this->sections   = $this->setSections();
		$this->controls   = $this->setControls();

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
			'title'       => esc_html__( 'Header', 'alsiha' ),
			'description' => esc_html__( 'Logo and page-title settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 11,
		];
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections[ $this->sectionIDs['header_styles'] ] = [
			'title'    => esc_html__( 'Header Styles', 'alsiha' ),
			'panel'    => $this->panelID,
			'priority' => 10,
		];

		$this->sections[ $this->sectionIDs['header_top_bar'] ] = [
			'title'    => esc_html__( 'Header Top Bar', 'alsiha' ),
			'panel'    => $this->panelID,
			'priority' => 11,
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
		$this
			->addTitleTaglineControls()
			->addHeaderImageControls()
			->addHeaderStyleControls()
			->addHeaderTopBarControls();

		return $this->controls;
	}

	/**
	 * Controls for Title, Tagline.
	 *
	 * @return Header
	 * @since  1.0.0
	 */
	private function addTitleTaglineControls(): Header {
		$this->addHeading(
			'alsiha_title_tagline_heading',
			$this->sectionIDs['title_tagline'],
			esc_html__( 'Logo, Site Title, Tagline & Icon', 'alsiha' ),
			esc_html__( 'Personalize your site by customizing the logo, site title, and site icon for brand recognition.', 'alsiha' ),
		);

		return $this;
	}

	/**
	 * Controls for Header Image.
	 *
	 * @return Header
	 * @since  1.0.0
	 */
	private function addHeaderImageControls(): Header {
		$this->addHeading(
			'alsiha_header_image_heading',
			$this->sectionIDs['header_image'],
			esc_html__( 'Header Background & Text', 'alsiha' ),
			esc_html__( 'Customize your header background, color, and text to match your site\'s style.', 'alsiha' ),
		);

		$this->controls['alsiha_header_bg_color'] = [
			'section'     => $this->sectionIDs['header_image'],
			'label'       => esc_html__( 'Header Background Color', 'alsiha' ),
			'description' => esc_html__( 'Please choose the header background color', 'alsiha' ),
			'type'        => 'color',
			'priority'    => 30,
			'choices'     => [
				'alpha' => true,
			],
			'default'     => '#ffffff',
			'output'      => [
				[
					'element'  => 'header .header-area',
					'property' => 'background-color',
				],
			],
			'transport'   => 'auto',
		];

		return $this;
	}

	/**
	 * Controls for Header Styles.
	 *
	 * @return Header
	 * @since  1.0.0
	 */
	private function addHeaderStyleControls(): Header {
		$this->addHeading(
			'alsiha_header_styles_heading',
			$this->sectionIDs['header_styles'],
			esc_html__( 'Header Style Settings', 'alsiha' ),
			esc_html__( 'Customize the header with options for logo padding and others.', 'alsiha' ),
		);

		$this->controls['alsiha_logo_padding'] = [
			'section'     => $this->sectionIDs['header_styles'],
			'label'       => esc_html__( 'Logo Padding', 'alsiha' ),
			'description' => esc_html__( 'Logo top/bottom padding. Default: 0.1rem.', 'alsiha' ),
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
			'section'     => $this->sectionIDs['header_styles'],
			'label'       => esc_html__( '100% Header?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable 100% header width, regardless of container.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 25,
			'default'     => 0,
		];

		$this->controls['alsiha_enable_sticky_header'] = [
			'section'     => $this->sectionIDs['header_styles'],
			'label'       => esc_html__( 'Enable Sticky Header?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable sticky header.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 30,
			'default'     => 1,
		];

		return $this;
	}

	/**
	 * Controls for Header Top Bar.
	 *
	 * @return Header
	 * @since  1.0.0
	 */
	private function addHeaderTopBarControls(): Header {
		$this->addHeading(
			'alsiha_header_top_bar_heading',
			$this->sectionIDs['header_top_bar'],
			esc_html__( 'Header Top Bar Settings', 'alsiha' ),
			esc_html__( 'Configure the top bar\'s design and text options to enhance your site\'s header.', 'alsiha' ),
		);

		$this->controls['alsiha_header_socials'] = [
			'section'     => $this->sectionIDs['header_top_bar'],
			'label'       => esc_html__( 'Enable Header Social Icons?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable header social icons.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		];

		$this->controls['alsiha_header_page_title'] = [
			'section'     => $this->sectionIDs['header_top_bar'],
			'label'       => esc_html__( 'Top bar page title', 'alsiha' ),
			'description' => esc_html__( 'Please enter header top bar page title.', 'alsiha' ),
			'type'        => 'textarea',
			'priority'    => 10,
		];

		$this->controls['alsiha_header_page_selector'] = [
			'section'     => $this->sectionIDs['header_top_bar'],
			'label'       => esc_html__( 'Select Top Bar Page', 'alsiha' ),
			'description' => esc_html__( 'Please select header top bar page.', 'alsiha' ),
			'type'        => 'dropdown-pages',
			'priority'    => 10,
		];

		$this->controls['alsiha_header_phone'] = [
			'section'     => $this->sectionIDs['header_top_bar'],
			'label'       => esc_html__( 'Top Bar Phone Text', 'alsiha' ),
			'description' => esc_html__( 'Enter header top bar phone text.', 'alsiha' ),
			'type'        => 'text',
			'priority'    => 10,
		];

		$this->controls['alsiha_header_phone_url'] = [
			'section'     => $this->sectionIDs['header_top_bar'],
			'label'       => esc_html__( 'Top Bar Phone URL', 'alsiha' ),
			'description' => esc_html__( 'Enter header top bar phone URL.', 'alsiha' ),
			'type'        => 'text',
			'priority'    => 11,
		];

		return $this;
	}
}
