<?php
/**
 * General Class: Panels.
 *
 * This Class registers Customizer Panels.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General\Customizer;

use Kirki;
use SigmaDevs\Sigma\Common\Traits\Singleton;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * General Class: Panels.
 *
 * @since 1.0.0
 */
class Panels {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Customizer Panels.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public array $panels = [];

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
		$this
			->setPanels()
			->addPanels();
	}

	/**
	 * Setting up panels.
	 *
	 * @return Panels
	 * @since  1.0.0
	 */
	private function setPanels(): Panels {
		$this->panels['alsiha_settings'] = [
			'priority'    => 10,
			'title'       => esc_html__( 'Theme Options', 'alsiha' ),
			'description' => esc_html__( 'Theme options & settings', 'alsiha' ),
		];

		$this->panels['alsiha_general_settings'] = [
			'priority'    => 10,
			'title'       => esc_html__( 'General', 'alsiha' ),
			'description' => esc_html__( 'General settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		];

		$this->panels['header_settings'] = [
			'priority'    => 11,
			'title'       => esc_html__( 'Header', 'alsiha' ),
			'description' => esc_html__( 'Logo and page-title settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		];

		$this->panels['alsiha_footer_settings'] = [
			'priority'    => 12,
			'title'       => esc_html__( 'Footer', 'alsiha' ),
			'description' => esc_html__( 'Footer settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		];

		$this->panels['alsiha_texts_colors_settings'] = [
			'priority'    => 13,
			'title'       => esc_html__( 'Texts & Colors', 'alsiha' ),
			'description' => esc_html__( 'Typography & Color settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		];

		$this->panels['alsiha_typography_settings'] = [
			'priority'    => 10,
			'title'       => esc_html__( 'Typography', 'alsiha' ),
			'description' => esc_html__( 'Typography settings', 'alsiha' ),
			'panel'       => 'alsiha_texts_colors_settings',
		];

		$this->panels['alsiha_page_settings'] = [
			'priority'    => 14,
			'title'       => esc_html__( 'Page', 'alsiha' ),
			'description' => esc_html__( 'Page settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		];

		$this->panels['alsiha_blog_settings'] = [
			'priority'    => 15,
			'title'       => esc_html__( 'Blog', 'alsiha' ),
			'description' => esc_html__( 'Archives and single post settings', 'alsiha' ),
			'panel'       => 'alsiha_settings',
		];

		return $this;
	}

	/**
	 * Adding panels with the help of Kirki.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function addPanels() {
		if ( empty( $this->panels ) ) {
			return;
		}

		foreach ( $this->panels as $panel_id => $panel_args ) {
			Kirki::add_panel( $panel_id, $panel_args );
		}
	}
}
