<?php
/**
 * Customizer Class: ThemeOptions.
 *
 * This Class registers Customizer Primary Theme Options Panel.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General\Customizer;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Abstracts\CustomizerBase,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Class: ThemeOptions.
 *
 * @since 1.0.0
 */
class ThemeOptions extends CustomizerBase {
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
	 * This general class is always being instantiated as requested in the
	 * Bootstrap class.
	 *
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		$this->panelID   = $this->primaryPanel;
		$this->panelArgs = $this->setPanelArgs();
		$this->sections  = $this->setSections();
		$this->controls  = $this->setControls();

		$this->init();
	}

	/**
	 * Set the panel args.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setPanelArgs(): array {
		return [
			'title'       => sd_alsiha()->getData()['name'] . esc_html__( ' Settings', 'alsiha' ),
			'description' => sd_alsiha()->getData()['name'] . esc_html__( ' options & settings', 'alsiha' ),
			'priority'    => 10,
		];
	}

	/**
	 * Set the sections.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setSections(): array {
		$this->sections['alsiha_social_media'] = [
			'title'       => esc_html__( 'Social Media', 'alsiha' ),
			'description' => esc_html__( 'Please add your social media profile information', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 20,
		];

		$this->sections['alsiha_integrations'] = [
			'title'       => esc_html__( 'Integrations', 'alsiha' ),
			'description' => esc_html__( 'Integrations settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 25,
		];

		$this->sections['alsiha_extra_settings'] = [
			'title'       => esc_html__( 'Extra', 'alsiha' ),
			'description' => esc_html__( 'Extra settings', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 30,
		];

		$this->sections['alsiha_optimization_settings'] = [
			'title'       => esc_html__( 'Optimizations', 'alsiha' ),
			'description' => esc_html__( 'Settings to optimize site performance', 'alsiha' ),
			'panel'       => $this->primaryPanel,
			'priority'    => 35,
		];

		return $this->sections;
	}

	/**
	 * Set the controls.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function setControls(): array {
		$this->controls['alsiha_social_media_profiles'] = [
			'section'      => 'alsiha_social_media',
			'label'        => esc_html__( 'Social Media Information', 'alsiha' ),
			'type'         => 'repeater',
			'priority'     => 10,
			'row_label'    => [
				'type'  => 'text',
				'value' => esc_html__( 'Social Profile', 'alsiha' ),
			],
			'button_label' => esc_html__( 'Add More', 'alsiha' ),
			'fields'       => [
				'type_image'  => [
					'type'        => 'text',
					'label'       => esc_html__( 'Icon Class', 'alsiha' ),
					'description' => esc_html__( 'Please enter Font Awesome or other icon class', 'alsiha' ),
				],
				'profile_url' => [
					'type'        => 'link',
					'label'       => esc_html__( 'Profile Link', 'alsiha' ),
					'description' => esc_html__( 'Please enter the social media profile link', 'alsiha' ),
				],
			],
		];

		$this->controls['alsiha_header_code'] = [
			'section'     => 'alsiha_integrations',
			'label'       => esc_html__( 'Header Code', 'alsiha' ),
			'description' => esc_html__( 'Please enter the header code (Wrap this code with &lt;script&gt; tag).', 'alsiha' ),
			'type'        => 'code',
			'priority'    => 10,
			'choices'     => [
				'language' => 'html',
			],
		];

		$this->controls['alsiha_footer_code'] = [
			'section'     => 'alsiha_integrations',
			'label'       => esc_html__( 'Footer Code', 'alsiha' ),
			'description' => esc_html__( 'Please enter the footer code (Wrap this code with &lt;script&gt; tag).', 'alsiha' ),
			'type'        => 'code',
			'priority'    => 15,
			'choices'     => [
				'language' => 'html',
			],
		];

		$this->controls['alsiha_enable_totop'] = [
			'section'     => 'alsiha_extra_settings',
			'label'       => esc_html__( 'Enable Scroll To-Top Button?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable scroll to top button.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		];

		$this->controls['alsiha_enable_pageloader'] = [
			'section'     => 'alsiha_extra_settings',
			'label'       => esc_html__( 'Enable Page Loader?', 'alsiha' ),
			'description' => esc_html__( 'Enable/disable page loader animation.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 15,
			'default'     => 1,
		];

		$this->controls['alsiha_disable_emojis'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable Emojis?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable WordPress emojis.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_embed_scripts'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove Embed Scripts?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove embed scripts.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 11,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_jquery_migrate'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove jQuery migrate?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove jQuery migrate scripts.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 12,
			'default'     => 0,
		];

		$this->controls['alsiha_disable_admin_bar'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable admin bar?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable the admin bar.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 13,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_dashicons'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove Dashicons?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove Dashicons from the frontend.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 14,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_generator_meta'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove WordPress generator?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove WordPress generator meta tag.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 15,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_rsd_link'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove RSD link?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove EditURI/RSD (Really Simple Discovery) link.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 16,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_wlw_manifest_link'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove WLWriter manifest link?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove Windows Live Writer manifest link.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 17,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_shortlink'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove WordPress shortlink?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove WordPress shortlink.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 18,
			'default'     => 0,
		];

		$this->controls['alsiha_disable_wp_embeds'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable WP embeds?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable WP embeds.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 19,
			'default'     => 0,
		];

		$this->controls['alsiha_disable_self_pingbacks'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable self pingbacks?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable self pingbacks.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 20,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_rest_api_links'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove REST API links?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove REST API links.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 21,
			'default'     => 0,
		];

		$this->controls['alsiha_disable_rest_api_for_guests'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable REST API for guests?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable REST API for guests.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 22,
			'default'     => 0,
		];

		$this->controls['alsiha_disable_xml_rpc'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable XML-RPC?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable XML-RPC.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 23,
			'default'     => 0,
		];

		$this->controls['alsiha_disable_rss_feeds'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable RSS feeds?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable RSS feeds.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 24,
			'default'     => 0,
		];

		$this->controls['alsiha_disable_heartbeat'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable Heartbeat API?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable Heartbeat API.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 25,
			'default'     => 0,
		];

		$this->controls['alsiha_dequeue_block_library_css'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Dequeue Block Library CSS?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to dequeue Block Library CSS.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 26,
			'default'     => 0,
		];

		$this->controls['alsiha_remove_query_strings'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Remove query strings?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to remove query strings from static resources.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 27,
			'default'     => 0,
		];

		$this->controls['alsiha_disable_gutenberg'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Disable Gutenberg editor?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to disable Gutenberg editor and enable Classic Editor.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 28,
			'default'     => 0,
		];

		$this->controls['alsiha_limit_revisions'] = [
			'section'     => 'alsiha_optimization_settings',
			'label'       => esc_html__( 'Limit Post Revisions?', 'alsiha' ),
			'description' => esc_html__( 'Switch on to limit post revisions to only 3.', 'alsiha' ),
			'type'        => 'toggle',
			'priority'    => 29,
			'default'     => 0,
		];

		return $this->controls;
	}
}
