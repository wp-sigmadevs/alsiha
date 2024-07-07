<?php
/**
 * General Class: PageTemplates.
 *
 * This class loads the required theme page templates.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Models\PageTemplates as PageTemplatesBase,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * General Class: PageTemplates.
 *
 * @since 1.0.0
 */
class PageTemplates {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * The array of page templates.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private array $pageTemplates = [];

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
		$this->pageTemplates = $this->getPageTemplates();

		if ( empty( $this->pageTemplates ) ) {
			return;
		}

		add_action( 'init', [ $this, 'registerPageTemplates' ] );
	}

	/**
	 * Accumulates theme page templates.
	 *
	 * @return array
	 */
	private function getPageTemplates(): array {
		return apply_filters(
			'sigmadevs/sigma/theme/page_templates',
			[
				'alsiha.php'        => esc_html__( 'Template: Al-Siha', 'alsiha' ),
				'left-sidebar.php'  => esc_html__( 'Template: Left Sidebar', 'alsiha' ),
				'right-sidebar.php' => esc_html__( 'Template: Right Sidebar', 'alsiha' ),
			]
		);
	}

	/**
	 * Registers page templates.
	 *
	 * @return PageTemplatesBase
	 * @since  1.0.0
	 */
	public function registerPageTemplates(): PageTemplatesBase {
		return new PageTemplatesBase( $this->pageTemplates );
	}
}
