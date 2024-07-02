<?php
/**
 * Customizer Class: Misc.
 *
 * This Class registers miscellaneous section.
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
 * Customizer Class: Misc.
 *
 * @since 1.0.0
 */
class Misc extends CustomizerBase {
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
		$this->panelID    = 'alsiha_general_settings';
		$this->sectionIDs = [
			'misc' => 'alsiha_misc_settings',
		];
		$this->sections   = $this->setSections();
		$this->controls   = $this->setControls();

		$this->init();
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections[ $this->sectionIDs['misc'] ] = [
			'title'    => esc_html__( 'Misc', 'alsiha' ),
			'panel'    => $this->panelID,
			'priority' => 12,
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
		$this->addHeading(
			'alsiha_color_heading',
			$this->sectionIDs['misc'],
			esc_html__( 'Miscellaneous Settings', 'alsiha' ),
		);

		$this->controls['alsiha_enable_totop'] = [
			'section'     => $this->sectionIDs['misc'],
			'label'       => esc_html__( 'Enable Scroll To-Top Button?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable scroll to top button.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		];

		$this->controls['alsiha_enable_pageloader'] = [
			'section'     => $this->sectionIDs['misc'],
			'label'       => esc_html__( 'Enable Page Loader?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable page loader animation.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 15,
			'default'     => 1,
		];

		return $this->controls;
	}
}
