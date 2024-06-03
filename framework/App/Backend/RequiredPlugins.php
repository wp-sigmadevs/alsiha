<?php
/**
 * Backend Class: RequiredPlugins
 *
 * This class uses TGMPA to install the required plugins.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\Backend;

use TGM_Plugin_Activation;
use SigmaDevs\Sigma\Common\Traits\Singleton;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Backend Class: RequiredPlugins
 *
 * @since 1.0.0
 */
class RequiredPlugins {
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
	 * @return void
	 * @since  1.0.0
	 *
	 * @see Bootstrap::registerServices
	 * @see Requester::isAdminBackend()
	 */
	public function register() {
		$this->includeTGMPA();

		// Required and recommended plugins.
		add_action( 'tgmpa_register', [ $this, 'registerPlugins' ] );

		// Custom button for TGMPA notice.
		add_filter( 'tgmpa_notice_action_links', [ $this, 'customButton' ] );
	}

	/**
	 * Include TGMPA file.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function includeTGMPA() {
		include_once sd_alsiha()->getThemePath() . '/lib/class-tgm-plugin-activation.php';
	}


	/**
	 * Register all plugins with TGMPA.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function registerPlugins() {
		$plugins = $this->get_theme_plugins();
		$config  = $this->plugins_config();

		tgmpa( $plugins, $config );
	}

	/**
	 * List of recommended plugins.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function get_theme_plugins() {
		$plugins = [
			[
				'name'     => esc_html__( 'Advanced Custom Fields', 'alsiha' ),
				'slug'     => 'advanced-custom-fields',
				'required' => true,
			],
			[
				'name'     => esc_html__( 'Kirki Customizer Framework', 'alsiha' ),
				'slug'     => 'kirki',
				'required' => true,
			],
			[
				'name'     => esc_html__( 'Classic Editor', 'alsiha' ),
				'slug'     => 'classic-editor',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'Classic Widgets', 'alsiha' ),
				'slug'     => 'classic-widgets',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'Elementor Page Builder', 'alsiha' ),
				'slug'     => 'elementor',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'Forminator - Form Builder', 'alsiha' ),
				'slug'     => 'forminator',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'WooCommerce', 'alsiha' ),
				'slug'     => 'woocommerce',
				'required' => true,
			],
			[
				'name'     => esc_html__( 'WooCommerce Filters', 'alsiha' ),
				'slug'     => 'woocommerce-ajax-filters',
				'required' => true,
			],
			[
				'name'     => esc_html__( 'Anywhere Elementor', 'alsiha' ),
				'slug'     => 'anywhere-elementor',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'Yoast SEO', 'alsiha' ),
				'slug'     => 'wordpress-seo',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'Smush - Optimize Image', 'alsiha' ),
				'slug'     => 'wp-smushit',
				'required' => false,
			],
		];

		return apply_filters( 'sigmadevs/sigma/required_plugins/list', $plugins );
	}

	/**
	 * TGMPA configuration.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function plugins_config() {
		$config = [
			'domain'       => 'alsiha',
			'id'           => 'alsiha_tgmpa',
			'default_path' => '',
			'parent_slug'  => 'themes.php',
			'menu'         => 'alsiha-plugins',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'is_automatic' => true,
			'message'      => '',
			'strings'      => [
				'page_title'                      => __( 'Install Recommended Plugins', 'alsiha' ),
				'menu_title'                      => __( 'Install Plugins', 'alsiha' ),
				/* translators: %s: plugin name. */
				'installing'                      => __( 'Installing Plugin: %s', 'alsiha' ),
				/* translators: %s: plugin name. */
				'updating'                        => __( 'Updating Plugin: %s', 'alsiha' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'alsiha' ),
				'notice_can_install_required'     =>
				/* translators: 1: plugin name(s). */
					_n_noop(
						'Al-Siha Theme requires the following plugin: %1$s.',
						'Al-Siha Theme requires the following plugins: %1$s.',
						'alsiha'
					),
				'notice_can_install_recommended'  =>
				/* translators: 1: plugin name(s). */
					_n_noop(
						'Al-Siha Theme recommends the following plugin: %1$s.',
						'Al-Siha Theme recommends the following plugins: %1$s.',
						'alsiha'
					),
				'notice_ask_to_update'            =>
				/* translators: 1: plugin name(s). */
					_n_noop(
						'The following plugin needs to be updated to its latest version to ensure maximum compatibility with Alsiha Theme: %1$s.',
						'The following plugins need to be updated to their latest version to ensure maximum compatibility with Alsiha Theme: %1$s.',
						'alsiha'
					),
				'notice_ask_to_update_maybe'      =>
				/* translators: 1: plugin name(s). */
					_n_noop(
						'There is an update available for: %1$s.',
						'There are updates available for the following plugins: %1$s.',
						'alsiha'
					),
				'notice_can_activate_required'    =>
				/* translators: 1: plugin name(s). */
					_n_noop(
						'The following required plugin is currently inactive: %1$s.',
						'The following required plugins are currently inactive: %1$s.',
						'alsiha'
					),
				'notice_can_activate_recommended' =>
				/* translators: 1: plugin name(s). */
					_n_noop(
						'The following recommended plugin is currently inactive: %1$s.',
						'The following recommended plugins are currently inactive: %1$s.',
						'alsiha'
					),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'alsiha'
				),
				'update_link'                     => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'alsiha'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'alsiha'
				),
				'return'                          => __( 'Return to Plugins Installer', 'alsiha' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'alsiha' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'alsiha' ),
				/* translators: 1: plugin name. */
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'alsiha' ),
				/* translators: 1: plugin name. */
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'alsiha' ),
				/* translators: 1: dashboard link. */
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'alsiha' ),
				'dismiss'                         => __( 'Dismiss this notice', 'alsiha' ),
				'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'alsiha' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'alsiha' ),

				'nag_type'                        => '',
			],
		];

		return apply_filters( 'sigmadevs/sigma/required_plugins/config', $config );
	}

	/**
	 * Custom button for TGMPA notice.
	 *
	 * @return array The action link(s) for a required plugin.
	 * @since  1.0.0
	 */
	public function customButton() {
		$link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:15px;margin-bottom:0;" href="' . esc_url( TGM_Plugin_Activation::$instance->get_tgmpa_url() ) . '">' . esc_attr__( 'Manage Plugins', 'alsiha' ) . '</a>';

		return [
			'install' => $link_template,
		];
	}
}
