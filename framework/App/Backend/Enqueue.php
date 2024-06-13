<?php
/**
 * Backend Class: Enqueue
 *
 * This class enqueues required styles & scripts in the admin pages.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\Backend;

use SigmaDevs\Sigma\Common\{
	Utils\Helpers,
	Traits\Singleton,
	Abstracts\Enqueue as EnqueueBase,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Backend Class: Enqueue
 *
 * @since 1.0.0
 */
class Enqueue extends EnqueueBase {
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
	 * This backend class is only being instantiated in the backend
	 * as requested in the Bootstrap class.
	 *
	 * @see Requester::isAdminBackend()
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		global $pagenow;

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

		if ( 'themes.php' === $pagenow && 'alsiha' === $page ) {
			$this->assets();

			// Bail if no assets.
			if ( empty( $this->assets() ) ) {
				return;
			}

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
		}
	}

	/**
	 * Accumulate the admin style list.
	 *
	 * @return Enqueue
	 * @since  1.0.0
	 */
	protected function getStyles(): Enqueue {
		$styles = [];

		$styles[] = [
			'handle' => 'thickbox',
		];

		$styles[] = [
			'handle'    => 'alsiha-admin-styles',
			'asset_uri' => sd_alsiha()->getAssetsUri( 'backend/backend', 'css', $this->suffix . '.css' ),
			'version'   => $this->theme->version(),
		];

		$this->enqueues['style'] = apply_filters( 'sigmadevs/sigma/admin/styles', $styles, 10, 1 );

		return $this;
	}

	/**
	 * Accumulate the admin script list.
	 *
	 * @return Enqueue
	 * @since  1.0.0
	 */
	protected function getScripts(): Enqueue {
		$scripts = [];

		$scripts[] = [
			'handle'     => 'alsiha-admin-script',
			'asset_uri'  => sd_alsiha()->getAssetsUri( 'backend/backend', 'js', $this->suffix . '.js' ),
			'dependency' => [ 'jquery' ],
			'in_footer'  => true,
			'version'    => $this->theme->version(),
		];

		$this->enqueues['script'] = apply_filters( 'sigmadevs/sigma/admin/scripts', $scripts, 10, 1 );

		return $this;
	}

	/**
	 * Enqueue the admin scripts.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function enqueue(): void {
		$this
			->registerScripts()
			->enqueueScripts()
			->localize( $this->localizeData() );
	}

	/**
	 * Admin Localized data.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function localizeData(): array {
		return [
			'handle' => 'alsiha-admin-script',
			'object' => 'alsihaAdminParams',
			'data'   => [
				'ajaxUrl'          => esc_url( Helpers::ajaxUrl() ),
				'homeUrl'          => esc_url( home_url( '/' ) ),
				'restApiUrl'       => esc_url_raw( rest_url() ),
				'restNonce'        => wp_create_nonce( 'wp_rest' ),
				Helpers::nonceId() => wp_create_nonce( Helpers::nonceText() ),
			],
		];
	}
}
