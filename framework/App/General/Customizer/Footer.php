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
		$this->panelID    = 'alsiha_footer_settings';
		$this->sectionIDs = [
			'footer_styles'    => 'alsiha_footer_styles',
			'footer_copyright' => 'alsiha_footer_copyright',
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
		$this->sections[ $this->sectionIDs['footer_styles'] ] = [
			'title'    => esc_html__( 'Footer Styles', 'alsiha' ),
			'panel'    => $this->panelID,
			'priority' => 10,
		];

		$this->sections[ $this->sectionIDs['footer_copyright'] ] = [
			'title'    => esc_html__( 'Footer Copyright', 'alsiha' ),
			'panel'    => $this->panelID,
			'priority' => 15,
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
			->addFooterStyleControls()
			->addFooterCopyrightControls();

		return $this->controls;
	}

	/**
	 * Controls for Footer Styles.
	 *
	 * @return Footer
	 * @since  1.0.0
	 */
	private function addFooterStyleControls(): Footer {
		$this->addHeading(
			'alsiha_footer_style_heading',
			$this->sectionIDs['footer_styles'],
			esc_html__( 'Footer Styles', 'alsiha' ),
			esc_html__( 'Customize your footer background, color, and others to match your site\'s style.', 'alsiha' ),
		);

		$this->controls['alsiha_footer_logo'] = [
			'section'     => $this->sectionIDs['footer_styles'],
			'label'       => esc_html__( 'Footer Background Image', 'alsiha' ),
			'description' => esc_html__( 'Please upload footer background image', 'alsiha' ),
			'type'        => 'image',
			'priority'    => 11,
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => '#colophon',
					'property' => 'background-image',
				],
			],
		];

		$this->controls['alsiha_footer_bgc'] = [
			'section'     => $this->sectionIDs['footer_styles'],
			'label'       => esc_html__( 'Footer Background', 'alsiha' ),
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

		$this->controls['alsiha_footer_heading_color'] = [
			'section'     => $this->sectionIDs['footer_styles'],
			'label'       => esc_html__( 'Footer Heading Color', 'alsiha' ),
			'description' => esc_html__( 'Please choose the footer heading color', 'alsiha' ),
			'type'        => 'color',
			'priority'    => 12,
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => '#colophon .footer-widget h2',
					'property' => 'color',
				],
			],
		];

		$this->controls['alsiha_footer_text_color'] = [
			'section'     => $this->sectionIDs['footer_styles'],
			'label'       => esc_html__( 'Footer Text Color', 'alsiha' ),
			'description' => esc_html__( 'Please choose the footer text color', 'alsiha' ),
			'type'        => 'color',
			'priority'    => 12,
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => '#colophon .footer-widget p, #colophon .footer-widget ul, #colophon .footer-copyright p',
					'property' => 'color',
				],
			],
		];

		$this->controls['alsiha_footer_link_color'] = [
			'section'     => $this->sectionIDs['footer_styles'],
			'label'       => esc_html__( 'Footer Link Color', 'alsiha' ),
			'description' => esc_html__( 'Please choose the footer link color', 'alsiha' ),
			'type'        => 'color',
			'priority'    => 12,
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => '#colophon .footer-widget a, #colophon .footer-copyright a',
					'property' => 'color',
				],
			],
		];

		$this->controls['alsiha_footer_link_hover_color'] = [
			'section'     => $this->sectionIDs['footer_styles'],
			'label'       => esc_html__( 'Footer Link Hover Color', 'alsiha' ),
			'description' => esc_html__( 'Please choose the footer link hover color', 'alsiha' ),
			'type'        => 'color',
			'priority'    => 12,
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => '#colophon .footer-widget:not(.widget_nav_menu) a:hover, #colophon .footer-copyright a:hover',
					'property' => 'color',
				],
			],
		];

		$this->controls['alsiha_footer_padding'] = [
			'section'     => $this->sectionIDs['footer_styles'],
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
			'section'     => $this->sectionIDs['footer_styles'],
			'label'       => esc_html__( '100% Footer?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable 100% footer width, regardless of container.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 20,
			'default'     => 0,
		];

		return $this;
	}

	/**
	 * Controls for Footer Copyright.
	 *
	 * @return Footer
	 * @since  1.0.0
	 */
	private function addFooterCopyrightControls(): Footer {
		$this->addHeading(
			'alsiha_footer_copyright_heading',
			$this->sectionIDs['footer_copyright'],
			esc_html__( 'Footer Copyright', 'alsiha' ),
			esc_html__( 'Personalize your footer copyright text.', 'alsiha' ),
		);

		$this->controls['alsiha_footer_copyright_text'] = [
			'section'     => $this->sectionIDs['footer_copyright'],
			'label'       => esc_html__( 'Footer Copyright Text', 'alsiha' ),
			'description' => __( 'Please enter footer copyright text. <br />Use {year} placeholder for current year.', 'alsiha' ),
			'type'        => 'editor',
			'priority'    => 10,

		];

		return $this;
	}
}
