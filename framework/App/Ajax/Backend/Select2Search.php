<?php
/**
 * Ajax Class: Select2Search
 *
 * This class builds query for select2 search.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\App\Ajax\Backend;

use SigmaDevs\Sigma\Common\{
	Utils\Helpers,
	Traits\Singleton,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Ajax Class: Select2Search
 *
 * @since 1.0.0
 */
class Select2Search {
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
	 * This backend Ajax class is always being instantiated as requested in the
	 * Bootstrap class.
	 *
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		add_action( 'wp_ajax_sd_sigma_select2_object_search', [ $this, 'search_response' ] );
		add_action( 'wp_ajax_sd_sigma_select2_get_title', [ $this, 'title_response' ] );
	}

	/**
	 * Ajax search response.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function search_response() {
		// Verifying AJAX call.
		Helpers::verifyAjaxCall();

		$queryPerPage = 15;
		$postType     = 'post';
		$sourceName   = 'post_type';
		$paged        = absint( $_POST['page'] ?? 1 ); // phpcs:ignore WordPress.Security.NonceVerification.Missing

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( ! empty( $_POST['post_type'] ) ) {
			$postType = sanitize_text_field( wp_unslash( $_POST['post_type'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( ! empty( $_POST['source_name'] ) ) {
			$sourceName = sanitize_text_field( wp_unslash( $_POST['source_name'] ) );  // phpcs:ignore WordPress.Security.NonceVerification.Missing
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$search  = ! empty( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
		$results = [];

		switch ( $sourceName ) {
			case 'taxonomy':
				$args = [
					'hide_empty' => false,
					'orderby'    => 'name',
					'order'      => 'ASC',
					'search'     => $search,
					'number'     => '5',
				];

				if ( 'all' !== $postType ) {
					$args['taxonomy'] = $postType;
				}

				$postList = wp_list_pluck( get_terms( $args ), 'name', 'term_id' );
				break;

			case 'user':
				$users = [];

				foreach ( get_users( [ 'search' => "*{$search}*" ] ) as $user ) {
					$userId           = $user->ID;
					$userName         = $user->display_name;
					$users[ $userId ] = $userName;
				}

				$postList = $users;
				break;

			default:
				$postList = $this->getQueryData( $postType, $queryPerPage, $search, $paged );
		}

		$pagination = true;

		if ( count( $postList ) < $queryPerPage ) {
			$pagination = false;
		}

		if ( ! empty( $postList ) ) {
			foreach ( $postList as $key => $item ) {
				$results[] = [
					'text' => $item,
					'id'   => $key,
				];
			}
		}

		wp_send_json(
			[
				'results'    => $results,
				'pagination' => [ 'more' => $pagination ],
			]
		);
	}

	/**
	 * Ajax title response.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function title_response() {
		// Verifying AJAX call and user role.
		Helpers::verifyAjaxCall();

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( empty( $_POST['id'] ) ) {
			wp_send_json_error( [] );
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$ids = array_filter( array_map( 'intval', wp_unslash( $_POST['id'] ) ) );

		if ( empty( $ids ) ) {
			wp_send_json_error( [] );
		}

		$sourceName = ! empty( $_POST['source_name'] ) ? sanitize_text_field( wp_unslash( $_POST['source_name'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$postType   = ! empty( $_POST['post_type'] ) ? sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

		switch ( $sourceName ) {
			case 'taxonomy':
				$args = [
					'hide_empty' => false,
					'orderby'    => 'name',
					'order'      => 'ASC',
					'include'    => implode( ',', $ids ),
				];

				if ( 'all' !== $postType ) {
					$args['taxonomy'] = $postType;
				}

				$response = wp_list_pluck( get_terms( $args ), 'name', 'term_id' );
				break;

			case 'user':
				$users = [];

				foreach ( get_users( [ 'include' => $ids ] ) as $user ) {
					$userId           = $user->ID;
					$userName         = $user->display_name . '-' . $user->ID;
					$users[ $userId ] = $userName;
				}

				$response = $users;
				break;

			default:
				$postInfo = get_posts(
					[
						'post_type' => $postType,
						'include'   => implode( ',', $ids ),
					]
				);
				$response = wp_list_pluck( $postInfo, 'post_title', 'ID' );
		}

		if ( ! empty( $response ) ) {
			wp_send_json_success( [ 'results' => $response ] );
		} else {
			wp_send_json_error( [] );
		}
	}

	/**
	 * Retrieves a list of published posts.
	 *
	 * @param string $postType Post type to filter by.
	 * @param int    $limit     The number of posts to retrieve.
	 * @param string $search    A search term to filter by post title.
	 * @param int    $paged     The page number for pagination.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function getQueryData( $postType = 'any', $limit = 10, $search = '', $paged = 1 ) {
		global $wpdb;

		$where = '';
		$data  = [];

		// Set up LIMIT and OFFSET.
		if ( -1 === $limit ) {
			$limit = '';
		} elseif ( 0 === $limit ) {
			$limit = 'LIMIT 0,1';
		} else {
			$offset = $paged > 1 ? ( $paged - 1 ) * $limit : 0;
			$limit  = $wpdb->prepare( 'LIMIT %d, %d', $offset, $limit );
		}

		// Handle post type filter.
		if ( 'any' === $postType ) {
			$inSearchPostTypes = get_post_types( [ 'exclude_from_search' => false ] );

			if ( empty( $inSearchPostTypes ) ) {
				$where .= ' AND 1=0 ';
			} else {
				$inSearchPostTypes = implode( "', '", array_map( 'esc_sql', $inSearchPostTypes ) );
				$where            .= " AND {$wpdb->posts}.post_type IN ('$inSearchPostTypes')";
			}
		} elseif ( ! empty( $postType ) ) {
			$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_type = %s", $postType );
		}

		// Handle search filter.
		if ( ! empty( $search ) ) {
			$search = '%' . $wpdb->esc_like( $search ) . '%';
			$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_title LIKE %s", $search );
		}

		// Complete query.
		$query   = "SELECT post_title, ID FROM {$wpdb->posts} WHERE post_status = 'publish' {$where} {$limit}";
		$results = $wpdb->get_results( $query ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.NoCaching

		// Process results.
		if ( ! empty( $results ) ) {
			foreach ( $results as $row ) {
				$data[ $row->ID ] = $row->post_title . ' (ID#' . $row->ID . ')';
			}
		}

		return $data;
	}
}
