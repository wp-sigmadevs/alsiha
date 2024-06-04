<?php
/**
 * Abstract Class: Base.
 *
 * The Base class which can be extended by other classes to load in default methods.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Abstracts;

use SigmaDevs\Sigma\Config\Theme;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Abstract Class: Base.
 *
 * @since 1.0.0
 */
abstract class Base {
	/**
	 * Data from the theme config class.
	 *
	 * @var object
	 * @since 1.0.0
	 */
	protected $theme;

	/**
	 * Base Constructor.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->theme = new Theme();
	}
}
