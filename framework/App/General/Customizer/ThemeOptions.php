<?php
/**
 * Customizer Class: ThemeOptions.
 *
 * This Class registers Customizer Primary Theme Options Panel.
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
 * Customizer Class: ThemeOptions.
 *
 * @since 1.0.0
 */
class ThemeOptions extends CustomizerBase {
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
		$this->panelID   = $this->primaryPanel;
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
			'title'       => sd_alsiha()->getData()['name'] . esc_html__( ' Settings', 'alsiha' ),
			'description' => sd_alsiha()->getData()['name'] . esc_html__( ' options & settings', 'alsiha' ),
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
		$this->sections['alsiha_social_media'] = [
			'title'       => esc_html__( 'Social Media', 'alsiha' ),
			'description' => esc_html__( 'Please add your social media profile information', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 20,
		];

		$this->sections['alsiha_integrations'] = [
			'title'       => esc_html__( 'Integrations', 'alsiha' ),
			'description' => esc_html__( 'Integrations settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 25,
		];

		$this->sections['alsiha_extra_settings'] = [
			'title'       => esc_html__( 'Extra', 'alsiha' ),
			'description' => esc_html__( 'Extra settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 30,
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
		$this->controls['alsiha_social_media_profiles'] = [
			'section'      => 'alsiha_social_media',
			'label'        => esc_html__( 'Social Media Information', 'alsiha' ),
			'type'         => 'repeater',
			'priority'     => 10,
			'row_label'    => [
				'type'  => 'text',
				'value' => esc_html__( 'Social Profile', 'alsiha' ),
			],
			'button_label' => esc_html__( 'Add More', 'alsiha' ),
			'fields'       => [
				'type_image'  => [
					'type'        => 'text',
					'label'       => esc_html__( 'Icon Class', 'alsiha' ),
					'description' => esc_html__( 'Please enter Font Awesome or other icon class', 'alsiha' ),
				],
				'profile_url' => [
					'type'        => 'link',
					'label'       => esc_html__( 'Profile Link', 'alsiha' ),
					'description' => esc_html__( 'Please enter the social media profile link', 'alsiha' ),
				],
			],
		];

		$this->controls['alsiha_header_code'] = [
			'section'     => 'alsiha_integrations',
			'label'       => esc_html__( 'Header Code', 'alsiha' ),
			'description' => esc_html__( 'Please enter the header code (Wrap this code with &lt;script&gt; tag).', 'alsiha' ),
			'type'        => 'code',
			'priority'    => 10,
			'choices'     => [
				'language' => 'html',
			],
		];

		$this->controls['alsiha_footer_code'] = [
			'section'     => 'alsiha_integrations',
			'label'       => esc_html__( 'Footer Code', 'alsiha' ),
			'description' => esc_html__( 'Please enter the footer code (Wrap this code with &lt;script&gt; tag).', 'alsiha' ),
			'type'        => 'code',
			'priority'    => 15,
			'choices'     => [
				'language' => 'html',
			],
		];

		$this->controls['alsiha_enable_totop'] = [
			'section'     => 'alsiha_extra_settings',
			'label'       => esc_html__( 'Enable Scroll To-Top Button?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable scroll to top button.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		];

		$this->controls['alsiha_enable_pageloader'] = [
			'section'     => 'alsiha_extra_settings',
			'label'       => esc_html__( 'Enable Page Loader?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable page loader animation.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 15,
			'default'     => 1,
		];

		return $this->controls;
	}
}
