<?php
/**
 * Frontend Class: Enqueue
 *
 * This class enqueues required styles & scripts in the frontend.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\Frontend;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Functions\Helpers,
	Abstracts\Enqueue as EnqueueBase
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Frontend Class: Enqueue
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
	 * This backend class is only being instantiated in the frontend
	 * as requested in the Bootstrap class.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 * @see Bootstrap::registerServices
	 * @see Requester::isFrontend()
	 */
	public function register() {
		// Bail if no assets.
		if ( empty( $this->assets() ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	/**
	 * Method to accumulate styles list.
	 *
	 * @return Enqueue
	 * @since 1.0.0
	 */
	protected function getStyles() {
		$styles = [];

		$styles[] = [
			'handle'    => 'alsiha-frontend-styles',
			'asset_uri' => esc_url( $this->theme->assetsUri() . '/css/frontend' . $this->suffix . '.css' ),
			'version'   => $this->theme->version(),
		];

		$this->enqueues['style'] = apply_filters( 'signature_registered_frontend_styles', $styles, 10, 1 );

		return $this;
	}

	/**
	 * Method to accumulate scripts list.
	 *
	 * @return Enqueue
	 * @since 1.0.0
	 */
	protected function getScripts() {
		$scripts = [];

		$scripts[] = [
			'handle'     => 'alsiha-frontend-script',
			'asset_uri'  => esc_url( $this->theme->assetsUri() . '/js/frontend' . $this->suffix . '.js' ),
			'dependency' => [ 'jquery' ],
			'in_footer'  => true,
			'version'    => $this->theme->version(),
		];

		$this->enqueues['script'] = apply_filters( 'signature_registered_frontend_scripts', $scripts, 10, 1 );

		return $this;
	}

	/**
	 * Method to enqueue scripts.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function enqueue() {
		$this
			->registerScripts()
			->enqueueScripts()
			->localize( $this->localizeData() );
	}

	/**
	 * Localized data.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function localizeData() {
		return [
			'handle' => 'alsiha-frontend-script',
			'object' => 'signatureFrontendParams',
			'data'   => [
				'ajaxUrl' => esc_url( Helpers::ajaxUrl() ),
				'homeUrl' => esc_url( home_url( '/' ) ),
			],
		];
	}
}
