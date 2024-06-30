<?php
/**
 * Abstract Class: CustomizerBase.
 *
 * The Base class which can be extended by other classes to customizer elements.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Abstracts;

use Kirki;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Abstract Class: CustomizerBase.
 *
 * @since 1.0.0
 */
abstract class CustomizerBase {
	/**
	 * Control default value.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected static array $defaultValues = [];

	/**
	 * Customizer primary Panel name.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected string $primaryPanel = 'alsiha_settings';

	/**
	 * Customizer Panel name.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected string $panelID;

	/**
	 * Customizer Section names.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected array $sectionIDs = [];

	/**
	 * Customizer Panel arguments.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected array $panelArgs;

	/**
	 * Customizer Sections.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected array $sections = [];

	/**
	 * Customizer Controls.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected array $controls = [];

	/**
	 * Registers the panel.
	 *
	 * @return void
	 */
	abstract public function register(): void;

	/**
	 * Initialize the panel, sections, and controls.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function init(): void {
		$this->storeDefaults();

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->addPanel();
		$this->addSections();
		$this->addControls();
	}

	/**
	 * Add the panel.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function addPanel(): void {
		if ( empty( $this->panelID ) || empty( $this->panelArgs ) ) {
			return;
		}

		Kirki::add_panel( $this->panelID, $this->panelArgs );
	}

	/**
	 * Add sections.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function addSections(): void {
		if ( empty( $this->sections ) ) {
			return;
		}

		foreach ( $this->sections as $sectionID => $sectionArgs ) {
			$sectionArgs['panel'] = $this->panelID;

			Kirki::add_section( $sectionID, $sectionArgs );
		}
	}

	/**
	 * Add controls.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function addControls(): void {
		if ( empty( $this->controls ) ) {
			return;
		}

		foreach ( $this->controls as $controlID => $controlArgs ) {
			Kirki::add_field(
				sd_alsiha()->getData()['theme_config_id'],
				array_merge( [ 'settings' => $controlID ], $controlArgs )
			);
		}
	}

	/**
	 * Store the default values of the controls.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function storeDefaults(): void {
		if ( empty( $this->controls ) ) {
			return;
		}

		foreach ( $this->controls as $id => $control ) {
			self::$defaultValues[ $id ] = $control['default'] ?? '';
		}
	}

	/**
	 * Retrieve the default values.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public static function getDefaultValues(): array {
		return self::$defaultValues;
	}

	/**
	 * Adds a section title.
	 *
	 * @param string $section   Section ID.
	 * @param string $label     Control label.
	 * @param int    $priority  Control priority.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	protected function addSectionTitle( string $section, string $label, int $priority = 10 ): array {
		return [
			'label'    => $label,
			'priority' => $priority,
			'section'  => $section,
			'type'     => 'generic',
			'choices'  => [
				'element' => 'div',
			],
		];
	}
}
