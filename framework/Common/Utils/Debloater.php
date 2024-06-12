<?php
/**
 * Utility Class: Debloater.
 *
 * This class to optimize and debloat WordPress by disabling unnecessary
 * features and scripts.
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
 * Utility Class: Debloater.
 *
 * @since 1.0.0
 */
class Debloater {
	/**
	 * Constructor to initialize the debloating methods.
	 *
	 * @param array $config Configuration array to enable/disable specific debloat methods.
	 */
	public function __construct( $config = [] ) {
		$defaults = [
			'disable_emojis'              => true,
			'remove_embed_scripts'        => true,
			'remove_jquery_migrate'       => true,
			'disable_admin_bar'           => false,
			'remove_dashicons'            => false,
			'remove_generator_meta'       => true,
			'remove_rsd_link'             => true,
			'remove_wlw_manifest_link'    => true,
			'remove_shortlink'            => true,
			'disable_wp_embeds'           => true,
			'disable_self_pingbacks'      => true,
			'remove_rest_api_links'       => true,
			'disable_rest_api_for_guests' => false,
			'disable_xml_rpc'             => true,
			'disable_rss_feeds'           => false,
			'disable_heartbeat'           => false,
			'dequeue_block_library_css'   => true,
			'remove_query_strings'        => true,
			'disable_gutenberg_css'       => true,
			'disable_gutenberg_editor'    => true,
		];

		$config = array_merge( $defaults, $config );

		foreach ( $config as $method => $enabled ) {
			if ( $enabled && method_exists( $this, $method ) ) {
				$this->$method();
			}
		}
	}

	/**
	 * Disable WordPress emojis.
	 *
	 * @return Debloater
	 */
	public function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		return $this;
	}

	/**
	 * Remove embed scripts.
	 *
	 * @return Debloater
	 */
	public function remove_embed_scripts() {
		add_action(
			'wp_footer',
			function () {
				wp_dequeue_script( 'wp-embed' );
			}
		);
		return $this;
	}

	/**
	 * Remove jQuery migrate script.
	 *
	 * @return Debloater
	 */
	public function remove_jquery_migrate() {
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
		return $this;
	}

	/**
	 * Disable the admin bar.
	 *
	 * @return Debloater
	 */
	public function disable_admin_bar() {
		add_filter( 'show_admin_bar', '__return_false' );
		return $this;
	}

	/**
	 * Remove Dashicons from the frontend.
	 *
	 * @return Debloater
	 */
	public function remove_dashicons() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				if ( ! is_admin() ) {
					wp_deregister_style( 'dashicons' );
				}
			}
		);
		return $this;
	}

	/**
	 * Remove WordPress generator meta tag.
	 *
	 * @return Debloater
	 */
	public function remove_generator_meta() {
		remove_action( 'wp_head', 'wp_generator' );
		return $this;
	}

	/**
	 * Remove RSD link.
	 *
	 * @return Debloater
	 */
	public function remove_rsd_link() {
		remove_action( 'wp_head', 'rsd_link' );
		return $this;
	}

	/**
	 * Remove Windows Live Writer manifest link.
	 *
	 * @return Debloater
	 */
	public function remove_wlw_manifest_link() {
		remove_action( 'wp_head', 'wlwmanifest_link' );
		return $this;
	}

	/**
	 * Remove WordPress shortlink.
	 *
	 * @return Debloater
	 */
	public function remove_shortlink() {
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		return $this;
	}

	/**
	 * Disable WP embeds.
	 *
	 * @return Debloater
	 */
	public function disable_wp_embeds() {
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
		return $this;
	}

	/**
	 * Disable self pingbacks.
	 *
	 * @return Debloater
	 */
	public function disable_self_pingbacks() {
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
		return $this;
	}

	/**
	 * Remove REST API links.
	 *
	 * @return Debloater
	 */
	public function remove_rest_api_links() {
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
		remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
		return $this;
	}

	/**
	 * Disable REST API for guests.
	 *
	 * @return Debloater
	 */
	public function disable_rest_api_for_guests() {
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
		return $this;
	}

	/**
	 * Disable XML-RPC.
	 *
	 * @return Debloater
	 */
	public function disable_xml_rpc() {
		add_filter( 'xmlrpc_enabled', '__return_false' );
		return $this;
	}

	/**
	 * Disable RSS feeds.
	 *
	 * @return Debloater
	 */
	public function disable_rss_feeds() {
		add_action(
			'do_feed',
			function () {
				wp_die( __( 'No feed available, please visit our <a href="' . get_bloginfo( 'url' ) . '">homepage</a>!' ) );
			},
			1
		);
		add_action( 'do_feed_rdf', 'disable_rss_feeds', 1 );
		add_action( 'do_feed_rss', 'disable_rss_feeds', 1 );
		add_action( 'do_feed_rss2', 'disable_rss_feeds', 1 );
		add_action( 'do_feed_atom', 'disable_rss_feeds', 1 );
		return $this;
	}

	/**
	 * Disable Heartbeat API.
	 *
	 * @return Debloater
	 */
	public function disable_heartbeat() {
		add_action(
			'init',
			function () {
				wp_deregister_script( 'heartbeat' );
			},
			1
		);
		return $this;
	}

	/**
	 * Dequeue Block Library CSS.
	 *
	 * @return Debloater
	 */
	public function dequeue_block_library_css() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_dequeue_style( 'wp-block-library' );
				wp_dequeue_style( 'wp-block-library-theme' );
				wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
			},
			100
		);
		return $this;
	}

	/**
	 * Remove query strings from static resources.
	 *
	 * @return Debloater
	 */
	public function remove_query_strings() {
		add_action(
			'init',
			function () {
				if ( ! is_admin() ) {
					add_filter(
						'script_loader_src',
						function ( $src ) {
							$output = preg_split( '/(&ver|\?ver)/', $src );
							return $output[0];
						},
						15
					);
					add_filter(
						'style_loader_src',
						function ( $src ) {
							$output = preg_split( '/(&ver|\?ver)/', $src );
							return $output[0];
						},
						15
					);
				}
			}
		);
		return $this;
	}

	/**
	 * Disable Gutenberg CSS.
	 *
	 * @return Debloater
	 */
	public function disable_gutenberg_css() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_dequeue_style( 'wp-block-library' );
				wp_dequeue_style( 'wp-block-library-theme' );
				wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
			},
			100
		);
		return $this;
	}

	/**
	 * Disable Gutenberg editor and enable Classic Editor.
	 *
	 * @return Debloater
	 */
	public function disable_gutenberg_editor() {
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

		return $this;
	}
}
