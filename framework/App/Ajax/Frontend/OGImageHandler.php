<?php
/**
 * Ajax Class: OG_Image_Handler
 *
 * This class handles Open Graph Image requests.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\Ajax\Frontend;

use SigmaDevs\Sigma\Common\{
	Utils\Helpers,
	Traits\Singleton,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Ajax Class: OG_Image_Handler
 *
 * @since 1.0.0
 */
class OGImageHandler {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Transient prefix.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $transientPrefix = 'sd_temp_og_image_';

	/**
	 * Registers the class.
	 *
	 * This frontend Ajax class is always being instantiated as requested in the
	 * Bootstrap class.
	 *
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		add_action( 'wp_ajax_set_temp_og_image', [ $this, 'response' ] );
		add_action( 'wp_ajax_nopriv_set_temp_og_image', [ $this, 'response' ] );
	}

	/**
	 * Handles the AJAX request to set a temporary OG image.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function response() {
		// Verifying AJAX call and user role.
		Helpers::verifyAjaxCall();

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( empty( $_REQUEST['page_id'] ) || empty( $_REQUEST['image_src'] ) ) {
			wp_send_json_error( 'Missing data' );
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$page_id = absint( $_REQUEST['page_id'] );

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$image_src = esc_url_raw( wp_unslash( $_REQUEST['image_src'] ) );

		if ( ! $page_id || ! filter_var( $image_src, FILTER_VALIDATE_URL ) ) {
			wp_send_json_error( 'Invalid input' );
		}

		$transient_key = $this->transientPrefix . $page_id;

		set_transient( $transient_key, $image_src, 5 * MINUTE_IN_SECONDS );

		wp_send_json_success( 'Temporary OG image set' );
	}
}
