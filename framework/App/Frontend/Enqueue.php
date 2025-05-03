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
	Utils\Helpers,
	Traits\Singleton,
	Abstracts\Enqueue as EnqueueBase,
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
	 * @see Requester::isFrontend()
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		// Bail if no assets.
		if ( empty( $this->assets() ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	/**
	 * Accumulate the frontend style list.
	 *
	 * @return Enqueue
	 * @since  1.0.0
	 */
	protected function getStyles(): Enqueue {
		$styles      = [];
		$suffix      = $this->suffix . '.css';
		$debugSuffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '.css' : $this->suffix . '.css';

		$styles[] = [
			'handle' => 'elementor-icons-shared-0',
		];

		$styles[] = [
			'handle' => 'elementor-icons-fa-solid',
		];

		$styles[] = [
			'handle' => 'elementor-icons-fa-brands',
		];

		$styles[] = [
			'handle' => 'elementor-icons-fa-regular',
		];

		$styles[] = [
			'handle'    => 'jquery-tipsy',
			'asset_uri' => esc_url( sd_alsiha()->getAssetsUri( 'vendors/tipsy', 'css', $suffix ) ),
			'version'   => '1.0.0',
		];

		$styles[] = [
			'handle'    => 'swiper',
			'asset_uri' => esc_url( sd_alsiha()->getAssetsUri( 'vendors/swiper', 'css', $suffix ) ),
			'version'   => '6.4.11',
		];

		$styles[] = [
			'handle'    => 'alsiha-frontend-styles',
			'asset_uri' => esc_url( sd_alsiha()->getAssetsUri( 'frontend/frontend', 'css', $debugSuffix ) ),
			'version'   => $this->theme->version(),
		];

		$this->enqueues['style'] = apply_filters( 'sigmadevs/sigma/frontend/styles', $styles, 10, 1 );

		return $this;
	}

	/**
	 * Accumulate the frontend script list.
	 *
	 * @return Enqueue
	 * @since  1.0.0
	 */
	protected function getScripts(): Enqueue {
		$scripts    = [];
		$suffix     = $this->suffix . '.js';
		$swiperData = $this->getSwiperData();

		$scripts[] = [
			'handle'     => 'superfish',
			'asset_uri'  => esc_url( sd_alsiha()->getAssetsUri( 'vendors/superfish', 'js', $suffix ) ),
			'dependency' => [ 'jquery' ],
			'version'    => '1.7.10',
		];

		$scripts[] = [
			'handle'     => 'headroom',
			'asset_uri'  => esc_url( sd_alsiha()->getAssetsUri( 'vendors/headroom', 'js', $suffix ) ),
			'dependency' => [ 'jquery' ],
			'version'    => '0.12',
		];

		$scripts[] = [
			'handle'     => 'alsiha-handheld-menu',
			'asset_uri'  => esc_url( sd_alsiha()->getAssetsUri( 'vendors/handheld-menu', 'js', $suffix ) ),
			'dependency' => [ 'jquery' ],
			'version'    => '1.0',
		];

		$scripts[] = [
			'handle'     => 'swiper',
			'asset_uri'  => $swiperData['src'],
			'dependency' => [ 'jquery' ],
			'version'    => $swiperData['version'],
		];

		$scripts[] = [
			'handle'     => 'jquery-tipsy',
			'asset_uri'  => esc_url( sd_alsiha()->getAssetsUri( 'vendors/tipsy', 'js', $suffix ) ),
			'dependency' => [ 'jquery' ],
			'version'    => '1.0.0',
		];

		$scripts[] = [
			'handle'     => 'parallaxie',
			'asset_uri'  => esc_url( sd_alsiha()->getAssetsUri( 'vendors/parallaxie', 'js', $suffix ) ),
			'dependency' => [ 'jquery' ],
			'version'    => '0.5.0',
		];

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			$scripts[] = [
				'handle' => 'comment-reply',
			];
		}

		$scripts[] = [
			'handle'     => 'alsiha-frontend-script',
			'asset_uri'  => esc_url( sd_alsiha()->getAssetsUri( 'frontend/frontend', 'js', $suffix ) ),
			'dependency' => [ 'jquery' ],
			'in_footer'  => true,
			'version'    => $this->theme->version(),
		];

		$this->enqueues['script'] = apply_filters( 'sigmadevs/sigma/admin/scripts', $scripts, 10, 1 );

		return $this;
	}

	/**
	 * Enqueue the frontend scripts.
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
	 * Frontend Localized data.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function localizeData(): array {
		return [
			'handle' => 'alsiha-frontend-script',
			'object' => 'alsihaFrontendParams',
			'data'   => [
				'ajaxUrl'          => esc_url( Helpers::ajaxUrl() ),
				'homeUrl'          => esc_url( home_url( '/' ) ),
				Helpers::nonceId() => wp_create_nonce( Helpers::nonceText() ),
			],
		];
	}

	/**
	 * Get swiper JS asset data.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function getSwiperData() {
		$defaultSwiperPath = sd_alsiha()->getAssetsUri( 'vendors/swiper', 'js', $this->suffix . '.js' );
		$swiperVersion     = '8.4.5';

		if ( defined( 'ELEMENTOR_ASSETS_PATH' ) ) {
			$SwiperVersion8   = get_option( 'elementor_experiment-e_swiper_latest' );
			$isSwiper8Enabled = 'active' === $SwiperVersion8 || 'default' === $SwiperVersion8;

			if ( $isSwiper8Enabled ) {
				$elementorSwiperPath = 'lib/swiper/v8/swiper.min.js';
			} else {
				$elementorSwiperPath = 'lib/swiper/swiper.min.js';
				$swiperVersion       = '5.3.6';
			}

			$elementor_swiper_path = ELEMENTOR_ASSETS_PATH . $elementorSwiperPath;

			if ( file_exists( $elementor_swiper_path ) ) {
				$defaultSwiperPath = ELEMENTOR_ASSETS_URL . $elementorSwiperPath;
			}
		}

		return [
			'src'     => $defaultSwiperPath,
			'version' => $swiperVersion,
		];
	}
}
