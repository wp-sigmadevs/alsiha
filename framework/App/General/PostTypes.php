<?php
/**
 * General Class: PostTypes.
 *
 * This class registers custom post types required for the Theme.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\General;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Models\CustomPostType,
	Models\CustomTaxonomy,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * General Class: PostTypes.
 *
 * @since 1.0.0
 */
class PostTypes {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Accumulates Custom Post Types.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public array $customPostTypes = [];

	/**
	 * Accumulates Custom Taxonomies.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public array $customTaxonomies = [];

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
		$this->definePostTypes();
		$this->defineTaxonomies();

		if ( ! empty( $this->customPostTypes ) ) {
			$this->registerCustomPostTypes();
		}

		if ( ! empty( $this->customTaxonomies ) ) {
			$this->registerCustomTaxonomies();
		}
	}

	/**
	 * Define Post Types.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function definePostTypes(): array {
		$this->customPostTypes = [
			[
				'name'   => esc_html__( 'Portfolios', 'alsiha' ),
				'slug'   => 'portfolios',
				'labels' => [
					'all_items' => esc_html__( 'All Portfolios', 'alsiha' ),
				],
				'args'   => [
					'menu_icon'          => 'dashicons-portfolio',
					'publicly_queryable' => false,
					'has_archive'        => false,
					'supports'           => [
						'title',
						'thumbnail',
						'editor',
					],
				],
			],
		];

		return $this->customPostTypes;
	}

	/**
	 * Define Taxonomies.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	private function defineTaxonomies(): array {
		$this->customTaxonomies = [
			[
				'name'     => esc_html__( ' Category', 'alsiha' ),
				'cpt_name' => [ 'portfolios' ],
				'slug'     => 'portfolio_category',
				'labels'   => [
					'menu_name' => esc_html__( 'Category', 'alsiha' ),
				],
				'args'     => [
					'hierarchical' => true,
				],
			],
		];

		return $this->customTaxonomies;
	}

	/**
	 * Loop through all the CPT definitions and build up CPT.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function registerCustomPostTypes(): void {
		foreach ( $this->customPostTypes as $postType ) {
			new CustomPostType(
				$postType['name'],
				$postType['slug'],
				! empty( $postType['labels'] ) ? $postType['labels'] : [],
				! empty( $postType['args'] ) ? $postType['args'] : []
			);
		}
	}

	/**
	 * Loop through all the Taxonomies definitions and build up Taxonomies.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function registerCustomTaxonomies(): void {
		foreach ( $this->customTaxonomies as $customTaxonomy ) {
			new CustomTaxonomy(
				$customTaxonomy['name'],
				$customTaxonomy['cpt_name'],
				$customTaxonomy['slug'],
				! empty( $customTaxonomy['labels'] ) ? $customTaxonomy['labels'] : [],
				! empty( $customTaxonomy['args'] ) ? $customTaxonomy['args'] : []
			);
		}
	}
}
