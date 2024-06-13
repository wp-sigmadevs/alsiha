<?php
/**
 * Shortcode Class: SocialProfiles
 *
 * This class registers and renders social profiles shortcode.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Integrations\Shortcodes;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Abstracts\Shortcode,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Shortcode Class: SocialProfiles
 *
 * @since 1.0.0
 */
class SocialProfiles extends Shortcode {
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
	 * This integration class is only being instantiated
	 * as requested in the Bootstrap class.
	 *
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		$this->shortcodeTag = 'alsiha_social_icons';

		parent::register();
	}

	/**
	 * Shortcode callback.
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function shortcodeCallback( array $atts ): string {
		shortcode_atts(
			[],
			$atts
		);

		$result = '';

		ob_start();

		$social_icons = sd_alsiha()->getOption( 'alsiha_social_media_profiles' );

		if ( empty( $social_icons ) ) {
			return $result;
		}
		?>
		<div class="social-icon-wrapper">
			<ul class="mb-0 list-inline">
				<?php
				foreach ( $social_icons as $social ) {
					echo '<li class="list-inline-item"><a href="' . esc_url( $social['profile_url'] ) . '" target="_blank"><i class="' . esc_attr( $social['type_image'] ) . '"></i></a></li>';
				}
				?>
			</ul>
		</div>
		<?php
		$result .= ob_get_clean();

		return $result;
	}
}
