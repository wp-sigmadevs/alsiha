<?php
/**
 * Model Class: CustomPostType
 *
 * This class is responsible for creating a Custom Post Type.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace SigmaDevs\Sigma\Common\Models;

use WP_Post;
use SigmaDevs\Sigma\Common\Utils\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Model Class: CustomPostType
 *
 * @since 1.0.0
 */
class CustomPostType {
	/**
	 * Post-type name.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public string $postTypeName;

	/**
	 * Post-type slug.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public string $postTypeSlug;

	/**
	 * Post-type args.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public array $postTypeArgs;

	/**
	 * Post-type labels.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public array $postTypeLabels;

	/**
	 * Class Constructor.
	 *
	 * Registers a custom post-type.
	 *
	 * @param string $name Post-type name.
	 * @param string $slug Post-type slug.
	 * @param array  $labels Post-type labels.
	 * @param array  $args Post-type args.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function __construct( $name, $slug, $labels = [], $args = [] ) {
		$this->postTypeName   = Helpers::uglify( $name );
		$this->postTypeSlug   = $slug;
		$this->postTypeArgs   = $args;
		$this->postTypeLabels = $labels;

		// Register the post-type if the post-type does not already exist.
		if ( ! post_type_exists( $this->postTypeName ) ) {
			// Registering the Custom Post Type.
			add_action( 'init', [ $this, 'register' ] );

			// Custom messages.
			add_filter( 'post_updated_messages', [ $this, 'messages' ] );

			// Custom Title placeholders.
			add_filter( 'enter_title_here', [ $this, 'placeholders' ], 0, 2 );
		}
	}

	/**
	 * Register the post-type.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {

		// Capitalize the words and make it plural.
		$name   = Helpers::beautify( $this->postTypeName );
		$plural = Helpers::pluralize( $name );

		// Setting the default labels.
		$labels = array_merge(
			[
				'name'               => sprintf(
					/* translators: %s: post-type general name */
					esc_html_x( 'Name: %s', 'post-type general name', 'alsiha' ),
					$plural
				),
				'singular_name'      => sprintf(
					/* translators: %s: post-type singular name */
					esc_html_x( 'Name: %s', 'post-type singular name', 'alsiha' ),
					$name
				),
				/* translators: %s: post-type name */
				'add_new'            => sprintf( esc_html_x( 'Add New', '%s', 'alsiha' ), strtolower( $name ) ),
				/* translators: %s: post-type name */
				'add_new_item'       => sprintf( esc_html__( 'Add New %s', 'alsiha' ), $name ),
				/* translators: %s: post-type name */
				'edit_item'          => sprintf( esc_html__( 'Edit %s', 'alsiha' ), $name ),
				/* translators: %s: post-type name */
				'new_item'           => sprintf( esc_html__( 'New %s', 'alsiha' ), $name ),
				/* translators: %s: post-type plural name */
				'all_items'          => sprintf( esc_html__( 'All %s', 'alsiha' ), $plural ),
				/* translators: %s: post-type name */
				'view_item'          => sprintf( esc_html__( 'View %s', 'alsiha' ), $name ),
				/* translators: %s: post-type plural name */
				'search_items'       => sprintf( esc_html__( 'Search %s', 'alsiha' ), $plural ),
				/* translators: %s: post-type plural name */
				'not_found'          => sprintf( esc_html__( 'No %s found', 'alsiha' ), strtolower( $plural ) ),
				/* translators: %s: post-type plural name */
				'not_found_in_trash' => sprintf( esc_html__( 'No %s found in Trash', 'alsiha' ), strtolower( $plural ) ),
				/* translators: %s: post-type plural name */
				'parent_item_colon'  => sprintf( esc_html__( 'Parent %s: ', 'alsiha' ), $plural ),
				'menu_name'          => $name,
			],
			$this->postTypeLabels
		);

		// Setting the default arguments.
		$args = array_merge(
			[
				'label'              => $plural,
				'labels'             => $labels,
				'menu_icon'          => 'dashicons-admin-customizer',
				'public'             => true,
				'show_ui'            => true,
				'has_archive'        => true,
				'publicly_queryable' => true,
				'query_var'          => true,
				'rewrite'            => true,
				'capability-type'    => 'post',
				'hierarchical'       => true,
				'show_in_rest'       => true,
				'supports'           => [
					'title',
					'editor',
					'excerpt',
					'thumbnail',
				],
				'show_in_nav_menus'  => true,
				'menu_position'      => 30,
			],
			$this->postTypeArgs
		);

		// Register the post-type.
		register_post_type( $this->postTypeSlug, $args );
	}

	/**
	 * Show custom messages.
	 *
	 * @param array $messages Default messages.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function messages( array $messages ): array {
		$post           = get_post();
		$postType       = get_post_type( $post );
		$postTypeObject = get_post_type_object( $postType );
		$postTypeName   = Helpers::beautify( $this->postTypeSlug );

		$messages[ $this->postTypeSlug ] = [
			0  => '',
			1  => sprintf(
				/* translators: %s: post-type name */
				esc_html__( '%s updated.', 'alsiha' ),
				$postTypeName
			),
			2  => esc_html__( 'Custom field updated.', 'alsiha' ),
			3  => esc_html__( 'Custom field deleted.', 'alsiha' ),
			/* translators: %s: post-type name */
			4  => sprintf( esc_html__( '%s updated.', 'alsiha' ), $postTypeName ),
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			5  => isset( $_GET['revision'] ) ? sprintf(
				/* translators: %s: date and time of the revision */
				esc_html__( '%1$s restored to revision from %2$s', 'alsiha' ),
				$postTypeName,
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended
				wp_post_revision_title( (int) $_GET['revision'], false )
			) : false,
			/* translators: %s: post-type name */
			6  => sprintf( esc_html__( '%s published.', 'alsiha' ), $postTypeName ),
			/* translators: %s: post-type name */
			7  => sprintf( esc_html__( '%s saved.', 'alsiha' ), $postTypeName ),
			/* translators: %s: post-type name */
			8  => sprintf( esc_html__( '%s submitted.', 'alsiha' ), $postTypeName ),
			9  => sprintf(
			/* translators: Publish box date format. */
				__( '%1$s scheduled for: <strong>%2$s</strong>.', 'alsiha' ),
				$postTypeName,
				date_i18n( esc_html__( 'M j, Y @ G:i', 'alsiha' ), strtotime( $post->post_date ) )
			),
			/* translators: %s: post-type name */
			10 => sprintf( esc_html__( '%s draft updated.', 'alsiha' ), $postTypeName ),
		];

		if ( $postTypeObject->publicly_queryable && $this->postTypeSlug === $postType ) {
			$permalink = get_permalink( $post->ID );

			/* translators: %s: URL of View Post & Name of the Custom Post Type */
			$view_link                 = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), sprintf( esc_html__( 'View ', 'alsiha' ), $postTypeName ) );
			$messages[ $postType ][1] .= $view_link;
			$messages[ $postType ][6] .= $view_link;
			$messages[ $postType ][9] .= $view_link;

			/* translators: %s: URL of Preview Post & Name of the Custom Post Type */
			$preview_permalink          = add_query_arg( 'preview', 'true', $permalink );
			$preview_link               = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), sprintf( esc_html__( 'Preview ', 'alsiha' ), $postTypeName ) );
			$messages[ $postType ][8]  .= $preview_link;
			$messages[ $postType ][10] .= $preview_link;
		}

		return $messages;
	}

	/**
	 * Show custom title placeholders.
	 *
	 * @param string  $title Default title.
	 * @param WP_Post $post Post object.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function placeholders( $title, $post ): string {
		$postTypeName = $this->postTypeSlug;
		$name         = Helpers::beautify( $postTypeName );

		if ( $postTypeName === $post->post_type ) {
			/* translators: post-type name */
			$new_title = sprintf( esc_html__( 'Enter %s Title', 'alsiha' ), $name );

			return apply_filters( 'sd/sigma/admin/post_type_title', $new_title );
		}

		return $title;
	}
}
