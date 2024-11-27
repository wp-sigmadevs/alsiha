<?php
/**
 * Config Class: Debloater.
 *
 * This class to optimize and debloat WordPress by disabling unnecessary
 * features and scripts.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Config;

use SigmaDevs\Sigma\Common\Traits\Singleton;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Config Class: Debloater.
 *
 * @since 1.0.0
 */
class Debloater {
	/**
	 * Singleton trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Initialize the debloating methods.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function debloat(): void {
		$debloats = [
			'disableEmojis'           => sd_alsiha()->getOption( 'alsiha_disable_emojis' ) ?? false,
			'removeEmbedScripts'      => sd_alsiha()->getOption( 'alsiha_remove_embed_scripts' ) ?? false,
			'removeJQueryMigrate'     => sd_alsiha()->getOption( 'alsiha_remove_jquery_migrate' ) ?? false,
			'disableAdminBar'         => sd_alsiha()->getOption( 'alsiha_disable_admin_bar' ) ?? false,
			'removeDashicons'         => sd_alsiha()->getOption( 'alsiha_remove_dashicons' ) ?? false,
			'removeGeneratorMeta'     => sd_alsiha()->getOption( 'alsiha_remove_generator_meta' ) ?? false,
			'removeRSDLink'           => sd_alsiha()->getOption( 'alsiha_remove_rsd_link' ) ?? false,
			'removeWLWManifestLink'   => sd_alsiha()->getOption( 'alsiha_remove_wlw_manifest_link' ) ?? false,
			'removeShortlink'         => sd_alsiha()->getOption( 'alsiha_remove_shortlink' ) ?? false,
			'disableWPEmbeds'         => sd_alsiha()->getOption( 'alsiha_disable_wp_embeds' ) ?? false,
			'disableSelfPingbacks'    => sd_alsiha()->getOption( 'alsiha_disable_self_pingbacks' ) ?? false,
			'removeRestApiLinks'      => sd_alsiha()->getOption( 'alsiha_remove_rest_api_links' ) ?? false,
			'disableRestApiForGuests' => sd_alsiha()->getOption( 'alsiha_disable_rest_api_for_guests' ) ?? false,
			'disableXMLRPC'           => sd_alsiha()->getOption( 'alsiha_disable_xml_rpc' ) ?? false,
			'disableRssFeeds'         => sd_alsiha()->getOption( 'alsiha_disable_rss_feeds' ) ?? false,
			'disableHeartbeatApi'     => sd_alsiha()->getOption( 'alsiha_disable_heartbeat' ) ?? false,
			'removeQueryStrings'      => sd_alsiha()->getOption( 'alsiha_remove_query_strings' ) ?? false,
			'disableGutenbergEditor'  => sd_alsiha()->getOption( 'alsiha_disable_gutenberg' ) ?? false,
			'limitPostRevisions'      => sd_alsiha()->getOption( 'alsiha_limit_revisions' ) ?? false,
		];

		foreach ( $debloats as $debloat => $enabled ) {
			if ( $enabled && method_exists( $this, $debloat ) ) {
				$this->$debloat();
			}
		}
	}

	/**
	 * Disable WordPress emojis.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableEmojis(): void {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
	}

	/**
	 * Remove embed scripts.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeEmbedScripts(): void {
		add_action(
			'wp_footer',
			function () {
				wp_dequeue_script( 'wp-embed' );
			}
		);
	}

	/**
	 * Remove jQuery migrate script.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeJQueryMigrate(): void {
		add_action(
			'wp_default_scripts',
			function ( $scripts ) {
				if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
					$script = $scripts->registered['jquery'];
					if ( $script->deps ) {
						$script->deps = array_diff( $script->deps, [ 'jquery-migrate' ] );
					}
				}
			}
		);
	}

	/**
	 * Disable the admin bar.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableAdminBar(): void {
		add_filter( 'show_admin_bar', '__return_false' );
	}

	/**
	 * Remove Dashicons from the frontend.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeDashicons(): void {
		add_action(
			'wp_enqueue_scripts',
			function () {
				if ( ! is_admin() ) {
					wp_deregister_style( 'dashicons' );
				}
			}
		);
	}

	/**
	 * Remove WordPress generator meta tag.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeGeneratorMeta(): void {
		remove_action( 'wp_head', 'wp_generator' );
	}

	/**
	 * Remove RSD link.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeRSDLink(): void {
		remove_action( 'wp_head', 'rsd_link' );
	}

	/**
	 * Remove the Windows Live Writer manifest link.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeWLWManifestLink(): void {
		remove_action( 'wp_head', 'wlwmanifest_link' );
	}

	/**
	 * Remove WordPress shortlink.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeShortlink(): void {
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	}

	/**
	 * Disable WP embeds.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableWPEmbeds(): void {
		add_action(
			'init',
			function () {
				remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
				remove_action( 'wp_head', 'wp_oembed_add_host_js' );
				add_filter( 'embed_oembed_discover', '__return_false' );
				add_filter(
					'tiny_mce_plugins',
					function ( $plugins ) {
						return array_diff( $plugins, [ 'wpembed' ] );
					}
				);
				add_filter(
					'rewrite_rules_array',
					function ( $rules ) {
						foreach ( $rules as $rule => $rewrite ) {
							if ( false !== strpos( $rewrite, 'embed=true' ) ) {
								unset( $rules[ $rule ] );
							}
						}
						return $rules;
					}
				);
			},
			9999
		);
	}

	/**
	 * Disable self pingbacks.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableSelfPingbacks(): void {
		add_action(
			'pre_ping',
			function ( &$links ) {
				foreach ( $links as $l => $link ) {
					if ( 0 === strpos( $link, home_url() ) ) {
						unset( $links[ $l ] );
					}
				}
			}
		);
	}

	/**
	 * Remove REST API links.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeRestApiLinks(): void {
		remove_action( 'wp_head', 'rest_output_link_wp_head' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	}

	/**
	 * Disable REST API for guests.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableRestApiForGuests(): void {
		add_filter(
			'rest_endpoints',
			function ( $endpoints ) {
				if ( ! is_user_logged_in() ) {
					$restricted_endpoints = [
						'/wp/v2/users',
						'/wp/v2/users/(?P<id>[\d]+)',
					];
					foreach ( $restricted_endpoints as $endpoint ) {
						if ( isset( $endpoints[ $endpoint ] ) ) {
							unset( $endpoints[ $endpoint ] );
						}
					}
				}
				return $endpoints;
			}
		);
	}

	/**
	 * Disable XML-RPC.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableXMLRPC(): void {
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

	/**
	 * Disable RSS feeds.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableRssFeeds(): void {
		add_action(
			'do_feed',
			function () {
				$homepage_url = get_bloginfo( 'url' );

				wp_die(
					sprintf(
					/* translators: %s: Home page URL */
						esc_html__( 'No feed available, please visit our %s!', 'alsiha' ),
						'<a href="' . esc_url( $homepage_url ) . '">' . esc_html__( 'homepage', 'alsiha' ) . '</a>'
					)
				);
			},
			1
		);
		add_action( 'do_feed_rdf', 'disable_rss_feeds', 1 );
		add_action( 'do_feed_rss', 'disable_rss_feeds', 1 );
		add_action( 'do_feed_rss2', 'disable_rss_feeds', 1 );
		add_action( 'do_feed_atom', 'disable_rss_feeds', 1 );
	}

	/**
	 * Disable Heartbeat API.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableHeartbeatApi(): void {
		add_action(
			'init',
			function () {
				if ( ! is_admin() ) {
					wp_deregister_script( 'heartbeat' );
				}
			},
			1
		);
	}

	/**
	 * Remove query strings from static resources.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function removeQueryStrings(): void {
		add_action(
			'init',
			function () {
				if ( ! is_admin() ) {
					$remove_query_strings = function ( $src ) {
						if ( is_string( $src ) ) {
							$output = preg_split( '/(&ver|\?ver)/', $src );
							return $output[0];
						}
						return $src;
					};

					add_filter( 'script_loader_src', $remove_query_strings, 15 );
					add_filter( 'style_loader_src', $remove_query_strings, 15 );
				}
			}
		);
	}

	/**
	 * Disable Gutenberg editor and enable Classic Editor.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function disableGutenbergEditor(): void {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_dequeue_style( 'wp-block-library' );
				wp_dequeue_style( 'wp-block-library-theme' );
				wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS.
			},
			100
		);

		add_filter( 'use_block_editor_for_post', '__return_false', 10 );
		add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
		add_filter( 'use_block_editor_for_page', '__return_false', 10 );
		add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
		add_filter( 'use_widgets_block_editor', '__return_false' );

		// Enqueue the Classic Editor styles.
		add_action(
			'admin_enqueue_scripts',
			function () {
				wp_enqueue_style( 'classic-editor', includes_url( '/css/editor.min.css' ), [], '1.0' );
			}
		);

		// Replace Gutenberg with Classic Editor.
		add_action(
			'admin_init',
			function () {
				remove_action( 'admin_notices', [ 'Gutenberg_Admin', 'admin_notices' ] );
				remove_action( 'wp_enqueue_scripts', [ 'Gutenberg_Frontend', 'enqueue_block_assets' ] );
			}
		);
	}

	/**
	 * Limit the number of post-revisions.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function limitPostRevisions(): void {
		if ( ! defined( 'WP_POST_REVISIONS' ) ) {
			define( 'WP_POST_REVISIONS', 3 );
		}
	}

	/**
	 * Disable RSS feeds and display a message.
	 *
	 * @return void
  	 * @since  1.0.0
	 */
	public function disable_rss_feeds() {
		wp_die(
			esc_html__( 'RSS feeds are disabled on this site. Please visit the homepage for updates.', 'alsiha' ),
			esc_html__( 'No RSS Feeds', 'alsiha' ),
			[ 'response' => 403 ]
		);
	}
}
