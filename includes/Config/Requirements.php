<?php
/**
 * Config Class: Requirements.
 *
 * Check if any requirements are needed to run this theme.
 *
 * @package SigmaDevs\AlSiha
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\AlSiha\Config;

use SigmaDevs\AlSiha\Common\{
	Utils\Notice,
	Utils\Errors,
	Abstracts\Base,
	Traits\Singleton
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Config Class: Requirements.
 *
 * @since 1.0.0
 */
final class Requirements extends Base {
	/**
	 * Singleton trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Specifications for the requirements.
	 *
	 * @return array Used to specify the requirements.
	 * @since 1.0.0
	 */
	public function specifications() {
		return apply_filters(
			'sd/alsiha/theme_requirements',
			[
				'php' => $this->theme->requiredPhp(),
				'wp'  => $this->theme->requiredWp(),
			]
		);
	}

	/**
	 * Theme requirements checker
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function check() {
		foreach ( $this->versionCompare() as $compatCheck ) {
			if ( version_compare(
				$compatCheck['compare'],
				$compatCheck['current'],
				'>='
			) ) {
				$error = Errors::errorMessage(
					$compatCheck['title'],
					$compatCheck['message'],
					__FILE__
				);

				// Through error & kill theme.
				$this->throughError( $error );
			}
		}
	}

	/**
	 * Compares PHP & WP versions and kills theme if it's not compatible
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function versionCompare() {
		return [
			// PHP version check.
			[
				'current' => phpversion(),
				'compare' => $this->specifications()['php'],
				'title'   => esc_html__( 'Invalid PHP version', 'alsiha' ),
				'message' => sprintf(
					/* translators: 1. Required php version, 2. Current php version */
					esc_html__( 'You must be using PHP %1$1s or greater. You are currently using PHP %2$2s.', 'alsiha' ),
					$this->theme->requiredPhp(),
					phpversion()
				),
			],
			// WP version check.
			[
				'current' => get_bloginfo( 'version' ),
				'compare' => $this->specifications()['wp'],
				'title'   => esc_html__( 'Invalid WordPress version', 'alsiha' ),
				'message' => sprintf(
					/* translators: 2. Required WordPress version, 2. Current WordPress version */
					esc_html__( 'You must be using WordPress %1$s or greater. You are currently using WordPress %2$s.', 'alsiha' ),
					$this->theme->requiredWp(),
					get_bloginfo( 'version' )
				),
			],
		];
	}

	/**
	 * Gives an admin notice and deactivates theme.
	 *
	 * @param string $error Error message.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function throughError( $error ) {
		// Gives an error notice.
		Notice::trigger( $error, 'error' );

		// Disables some actions.
		Errors::disableActions();
	}
}
