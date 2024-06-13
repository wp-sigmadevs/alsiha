<?php
/**
 * Customizer Class: Blog.
 *
 * This Class registers Customizer Blog Panel.
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
 * Customizer Class: Blog.
 *
 * @since 1.0.0
 */
class Blog extends CustomizerBase {
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
		$this->panelID   = 'alsiha_blog_settings';
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
			'title'       => esc_html__( 'Blog', 'alsiha' ),
			'description' => esc_html__( 'Archives and single post settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 15,
		];
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections['alsiha_archive_settings'] = [
			'title'       => esc_html__( 'Archives', 'alsiha' ),
			'description' => esc_html__( 'Archive settings', 'alsiha' ),
			'panel'       => $this->panelID,
			'priority'    => 10,
		];

		 $this->sections['alsiha_single_settings'] = [
			 'title'       => esc_html__( 'Single Post', 'alsiha' ),
			 'description' => esc_html__( 'Single post settings', 'alsiha' ),
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
		$this->controls['alsiha_archive_description'] = [
			'section'     => 'alsiha_archive_settings',
			'label'       => esc_html__( 'Archive Description', 'alsiha' ),
			'description' => esc_html__( 'Please enter archive description.', 'alsiha' ),
			'type'        => 'textarea',
			'priority'    => 10,
		];

		$this->controls['alsiha_archive_pagination'] = [
			'section'     => 'alsiha_archive_settings',
			'label'       => esc_html__( 'Pagination Type', 'alsiha' ),
			'description' => esc_html__( 'Please select the pagination type for archive pages', 'alsiha' ),
			'type'        => 'select',
			'priority'    => 11,
			'choices'     => [
				'classic'  => esc_html__( 'Classic Pagination', 'alsiha' ),
				'numbered' => esc_html__( 'Numbered Pagination', 'alsiha' ),
			],
			'default'     => 'classic',
		];

		 $this->controls['alsiha_single_pagination'] = [
			 'section'     => 'alsiha_single_settings',
			 'label'       => esc_html__( 'Enable Single Post Navigation?', 'alsiha' ),
			 'description' => esc_html__( 'Enable/disable single post navigation', 'alsiha' ),
			 'type'        => 'toggle',
			 'priority'    => 10,
			 'default'     => 0,
		 ];

		 return $this->controls;
	}
}
