<?php
/**
 * Admin Class.
 * This Class uses TGMPA class to install recommended plugins.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Main Admin Class.
 *
 * @since v1.0
 */
class Alsiha_Admin {

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 * @since  1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Alsiha_Admin
	 * @since  1.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initializing Recommended Plugins.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {

		// Requiring the TGMPA Class.
		include_once 'class-tgm-plugin-activation.php';

		// Required and recommended plugins.
		add_action( 'tgmpa_register', array( $this, 'register_plugins' ) );

		// Custom button for TGMPA notice.
		add_filter( 'tgmpa_notice_action_links', array( $this, 'edit_tgmpa_notice_action_links' ) );
	}

	/**
	 * Register all plugins with TGMPA.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register_plugins() {

		// Plugin list.
		$plugins = $this->get_theme_plugins();

		// Plugin Configuration.
		$config = $this->plugins_config();

		tgmpa( $plugins, $config );
	}

	/**
	 * List of recommended plugins.
	 *
	 * @access private
	 * @return array
	 *
	 * @since 1.0.0
	 */
	private function get_theme_plugins() {
		$plugins = array(
			array(
				'name'     => esc_html__( 'Advanced Custom Fields', 'alsiha' ),
				'slug'     => 'advanced-custom-fields',
				'required' => true,
			),

			array(
				'name'     => esc_html__( 'Classic Editor', 'alsiha' ),
				'slug'     => 'classic-editor',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'Classic Widgets', 'alsiha' ),
				'slug'     => 'classic-widgets',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'Elementor Page Builder', 'alsiha' ),
				'slug'     => 'elementor',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'Forminator - Form Builder', 'alsiha' ),
				'slug'     => 'forminator',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'WooCommerce', 'alsiha' ),
				'slug'     => 'woocommerce',
				'required' => true,
			),

			array(
				'name'     => esc_html__( 'WooCommerce Filters', 'alsiha' ),
				'slug'     => 'woocommerce-ajax-filters',
				'required' => true,
			),

			array(
				'name'     => esc_html__( 'WooCommerce Wishlist', 'alsiha' ),
				'slug'     => 'yith-woocommerce-wishlist',
				'required' => true,
			),

			array(
				'name'     => esc_html__( 'Anywhere Elementor', 'alsiha' ),
				'slug'     => 'anywhere-elementor',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'Yoast SEO', 'alsiha' ),
				'slug'     => 'wordpress-seo',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'Smush - Optimize Image', 'alsiha' ),
				'slug'     => 'wp-smushit',
				'required' => false,
			),
		);

		return $plugins;
	}

	/**
	 * TGMPA configuration.
	 *
	 * @access private
	 * @return array
	 *
	 * @since 1.0.0
	 */
	private function plugins_config() {

		// Change this to your theme text domain.
		$theme_text_domain = 'alsiha';

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       => $theme_text_domain,
			'id'           => 'alsiha_tgmpa',
			'default_path' => '',
			'parent_slug'  => 'themes.php',
			'menu'         => 'alsiha-plugins',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'is_automatic' => true,
			'message'      => '',
			'strings'      => array(
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

				'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			),
		);

		return $config;
	}

	/**
	 * Custom button for TGMPA notice.
	 *
	 * @access public
	 * @param  array $action_links The action link(s) for a required plugin.
	 * @return array The action link(s) for a required plugin.
	 * @since  1.0.0
	 */
	public function edit_tgmpa_notice_action_links( $action_links ) {

		$link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:15px;margin-bottom:0;" href="' . esc_url( TGM_Plugin_Activation::$instance->get_tgmpa_url() ) . '">' . esc_attr__( 'Manage Plugins', 'alsiha' ) . '</a>';
		$action_links  = array(
			'install' => $link_template,
		);

		return $action_links;
	}
}
