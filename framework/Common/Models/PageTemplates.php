<?php
/**
 * Model Class: PageTemplates
 *
 * This class is responsible for loading frontend page templates.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace SigmaDevs\Sigma\Common\Models;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Class: PageTemplates
 *
 * @since 1.0.0
 */
class PageTemplates {

	/**
	 * The array of templates.
	 *
	 * @var array
	 * @since  1.0.0
	 */
	protected $templates = [];

	/**
	 * Class Constructor.
	 *
	 * Registers page templates.
	 *
	 * @param array $templates Page Templates to be included.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function __construct( $templates ) {
		$this->templates = $templates;

		// Adding page templates.
		add_filter( 'theme_page_templates', [ $this, 'addTemplate' ] );

		// Adding page templates to save post.
		add_filter( 'wp_insert_post_data', [ $this, 'registerTemplates' ] );

		// Adding page templates path.
		add_filter( 'template_include', [ $this, 'checkTemplate' ] );
	}

	/**
	 * Adds page templates.
	 *
	 * @param array $postTemplates Post Templates.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function addTemplate( $postTemplates ) {
		return array_merge( $postTemplates, $this->templates );
	}

	/**
	 * Adds templated to the pages cache.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function registerTemplates( $atts ) {
		// Creating the key used for the themes cache.
		$cacheKey = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieving the cache list.
		$templates = wp_get_theme()->get_page_templates();

		if ( empty( $templates ) ) {
			$templates = [];
		}

		// New cache, therefore remove the old one.
		wp_cache_delete( $cacheKey, 'themes' );

		// Adding templates to the list of templates.
		$templates = array_merge( $templates, $this->templates );

		// Adding the modified cache.
		wp_cache_add( $cacheKey, $templates, 'themes', 1800 );

		return $atts;
	}

	/**
	 * Checks if the template is assigned to the page
	 *
	 * @param array $template Template.
	 *
	 * @return string|array
	 * @since  1.0.0
	 */
	public function checkTemplate( $template ) {
		global $post;

		if ( ! $post ) {
			return $template;
		}

		// Return default template if no custom template defined.
		if ( ! isset(
			$this->templates[ get_post_meta(
				$post->ID,
				'_wp_page_template',
				true
			) ]
		) ) {
			return $template;
		}

		$file = sd_alsiha()->getData()['theme_path'] . '/page-templates/' . get_post_meta(
			$post->ID,
			'_wp_page_template',
			true
		);

		if ( file_exists( $file ) ) {
			return $file;
		}

		return $template;
	}
}
