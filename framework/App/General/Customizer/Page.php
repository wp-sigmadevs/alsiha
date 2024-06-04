<?php
/**
 * Customizer Class: Page.
 *
 * This Class registers Customizer Page Panel.
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
 * Customizer Class: Page.
 *
 * @since 1.0.0
 */
class Page extends CustomizerBase {
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
		$this->panelID   = 'alsiha_page_settings';
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
			'title'       => esc_html__( 'Page', 'alsiha' ),
			'description' => esc_html__( 'Page settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 14,
		];
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections['alsiha_pagetitle'] = [
			'title'       => esc_html__( 'Page Title Banner', 'alsiha' ),
			'description' => esc_html__( 'Page title banner settings', 'alsiha' ),
			'panel'       => $this->panelID,
			'priority'    => 10,
		];

		$this->sections['alsiha_breadcrumbs'] = [
			'title'       => esc_html__( 'Breadcrumbs', 'alsiha' ),
			'description' => esc_html__( 'Breadcrumbs settings', 'alsiha' ),
			'panel'       => $this->panelID,
			'priority'    => 15,
		];

		$this->sections['alsiha_page_styles'] = [
			'title'       => esc_html__( 'Page Styles', 'alsiha' ),
			'description' => esc_html__( 'Page style settings', 'alsiha' ),
			'panel'       => $this->panelID,
			'priority'    => 20,
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
		$this->controls['alsiha_pagetitle_banner_bg'] = [
			'section'     => 'alsiha_pagetitle',
			'label'       => esc_html__( 'Page title Banner Background', 'alsiha' ),
			'description' => esc_html__( 'Please upload page title banner image. Recommended image size is 1920x1080 px.', 'alsiha' ),
			'type'        => 'background',
			'priority'    => 10,
			'default'     => [
				'background-image'      => '',
				'background-repeat'     => 'no-repeat',
				'background-position'   => 'left top',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => '#page-title',
				],
			],
		];

		$this->controls['alsiha_pagetitle_padding'] = [
			'section'     => 'alsiha_pagetitle',
			'label'       => esc_html__( 'Page Title Banner Padding', 'alsiha' ),
			'description' => esc_html__( 'Page title banner top/bottom padding. Default: 8rem.', 'alsiha' ),
			'type'        => 'dimensions',
			'priority'    => 15,
			'default'     => [
				'padding-top'    => '8rem',
				'padding-bottom' => '8rem',
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
					'element' => '#page-title',
				],
			],
		];

		$this->controls['alsiha_pagetitle_blog'] = [
			'section'     => 'alsiha_pagetitle',
			'label'       => esc_html__( 'Page title Text for Blog', 'alsiha' ),
			'description' => esc_html__( 'Please enter the page title text for blog.', 'alsiha' ),
			'type'        => 'text',
			'priority'    => 25,
			'transport'   => 'auto',
			'default'     => esc_html__( 'blog', 'alsiha' ),
		];

		$this->controls['alsiha_enable_breadcrumbs'] = [
			'section'     => 'alsiha_breadcrumbs',
			'label'       => esc_html__( 'Enable Breadcrumbs?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable breadcrumbs.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 0,
		];

		$this->controls['alsiha_page_padding'] = [
			'section'     => 'alsiha_page_styles',
			'label'       => esc_html__( 'Page Padding', 'alsiha' ),
			'description' => esc_html__( 'Page top/bottom padding. Default: 8rem.', 'alsiha' ),
			'type'        => 'dimensions',
			'priority'    => 10,
			'default'     => [
				'padding-top'    => '8rem',
				'padding-bottom' => '8rem',
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
					'element' => 'body:not(.woocommerce-page.archive) #wrapper.inner-page-content',
				],
			],
		];

		return $this->controls;
	}
}
