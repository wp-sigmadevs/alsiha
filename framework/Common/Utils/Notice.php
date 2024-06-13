<?php
/**
 * Utility Class: Notice.
 *
 * Gives an admin notice.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Utils;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Utility Class: Notice.
 *
 * @since 1.0.0
 */
class Notice {
	/**
	 * Notice message.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private static string $message;

	/**
	 * Type of notice.
	 *
	 * Possible values are error, warning, success, info.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private static string $type;

	/**
	 * The Close button.
	 * If true, the notice will include a close button.
	 *
	 * @var bool
	 * @since 1.0.0
	 */
	private static bool $close = false;

	/**
	 * Initialize the class.
	 *
	 * @param string  $message Notice message.
	 * @param string  $type Type of notice.
	 * @param boolean $close Close button.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function trigger( $message, $type, $close = false ): void {
		self::$message = $message;
		self::$type    = $type;
		self::$close   = $close;

		add_action( 'admin_notices', [ __CLASS__, 'notice' ] );
	}

	/**
	 * Admin notice.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function notice(): void {
		$hasClose = self::$close ? ' is-dismissible' : '';

		echo wp_kses(
			sprintf(
				'<div class="notice notice-' . self::$type . esc_attr( $hasClose ) . '">%s</div>',
				self::$message
			),
			'allow_notice'
		);
	}
}
