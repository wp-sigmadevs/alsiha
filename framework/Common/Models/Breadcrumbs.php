<?php
/**
 * Model Class: Breadcrumbs
 *
 * This class renders the breadcrumbs for the theme.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Models;

use WP_Post;
use SigmaDevs\Sigma\Common\Utils\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Model Class: Breadcrumbs
 *
 * @since 1.0.0
 */
class Breadcrumbs {
	/**
	 * Current post object.
	 *
	 * @var WP_Post
	 * @since 1.0.0
	 */
	private WP_Post $post;

	/**
	 * Prefix for the breadcrumb.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private string $homePrefix;

	/**
	 * Separator between breadcrumbs list.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private string $delimiter;

	/**
	 * True if terms need to be displayed.
	 *
	 * @var bool
	 * @since 1.0.0
	 */
	private bool $displayTerms;

	/**
	 * Text for the "Home".
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private string $homeText;

	/**
	 * Prefix for category.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private string $catArchivePrefix;

	/**
	 * Prefix for terms.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private string $tagArchivePrefix;

	/**
	 * Prefix for search page.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private string $searchPrefix;

	/**
	 * Prefix for page 404.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private string $errorPrefix;

	/**
	 * True if Post type archive needs to be displayed.
	 *
	 * @var bool
	 * @since 1.0.0
	 */
	private bool $displayPostTypeArchive;

	/**
	 * Render markup.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private string $renderMarkup;

	/**
	 * Render breadcrumb markup.
	 *
	 * @param array $args Breadcrumb args.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function getBreadcrumbs( array $args ): void {
		// Initialize post object.
		$this->post = get_post( get_queried_object_id() );

		// Defaults.
		$defaults = [
			'homePrefix'             => '',
			'delimiter'              => '/',
			'displayPostTypeArchive' => true,
			'displayTerms'           => true,
			'homeText'               => sprintf( '<i class="fa fa-home"></i> <span>%s</span>', esc_attr__( 'Home', 'alsiha' ) ),
			'catArchivePrefix'       => esc_attr__( 'Category:&nbsp;', 'alsiha' ),
			'tagArchivePrefix'       => esc_attr__( 'Tag:&nbsp;', 'alsiha' ),
			'searchPrefix'           => esc_attr__( 'Search query for:&nbsp;', 'alsiha' ),
			'errorPrefix'            => esc_attr__( '404 - Page not found', 'alsiha' ),
		];

		$defaults = apply_filters( 'sigmadevs/sigma/breadcrumbs_defaults', $defaults );
		$args     = wp_parse_args( $args, $defaults );

		$this->homePrefix             = $args['homePrefix'];
		$this->delimiter              = $args['delimiter'];
		$this->displayPostTypeArchive = $args['displayPostTypeArchive'];
		$this->displayTerms           = $args['displayTerms'];
		$this->homeText               = $args['homeText'];
		$this->catArchivePrefix       = $args['catArchivePrefix'];
		$this->tagArchivePrefix       = $args['tagArchivePrefix'];
		$this->searchPrefix           = $args['searchPrefix'];
		$this->errorPrefix            = $args['errorPrefix'];

		// Check if the Yoast SEO options are activated.
		$options = get_option( 'wpseo_titles' );

		// Check if the Yoast Breadcrumbs is activated.
		if ( function_exists( 'yoast_breadcrumb' ) && $options && true === $options['breadcrumbs-enable'] ) {
			ob_start();
			yoast_breadcrumb();
			$this->renderMarkup = ob_get_clean();
		} else {
			// Theme Breadcrumbs.
			$this->startRender();
		}

		// Breadcrumb output.
		$this->breadcrumbsWrapper()->breadcrumbsOutput();
	}

	/**
	 * Start of Breadcrumbs Rendering.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function startRender(): void {
		// Breadcrumb prefix.
		$this->renderMarkup = $this->getBreadcrumbPrefix();

		// Home text.
		$this->renderMarkup .= $this->getBreadcrumbHome();

		// Woocommerce support.
		if ( Helpers::hasWooCommerce() && ( ( Helpers::isWooCommerce() && is_archive() && ! is_shop() ) || is_cart() || is_checkout() || is_account_page() ) ) {
			$this->renderMarkup .= $this->getWooCommercePage();
		}

		// Single Posts and Pages.
		if ( is_singular() ) {
			// If needed, display the archive breadcrumb.
			if ( isset( $this->post->post_type ) && get_post_type_archive_link( $this->post->post_type ) && $this->displayPostTypeArchive ) {
				$this->renderMarkup .= $this->getPostTypeArchive();
			}

			// Check for parents.
			if ( isset( $this->post->post_parent ) && 0 == $this->post->post_parent ) {
				$this->renderMarkup .= $this->getTerms();
			} else {
				$this->renderMarkup .= $this->getParents();
			}

			$this->renderMarkup .= $this->getBreadcrumbTrailMarkup();
		} else {
			// Breadcrumb for Blog.
			if ( is_home() && ! is_front_page() ) {
				$postsPage           = get_option( 'page_for_posts' );
				$postsPageTitle      = get_the_title( $postsPage );
				$this->renderMarkup .= $this->getBreadcrumbListItem( $postsPageTitle, '', false, false );
			} elseif ( ( is_tax() || is_tag() || is_category() || is_date() || is_author() ) && $this->displayPostTypeArchive && ! Helpers::isWooCommerce() ) {
				$this->renderMarkup .= $this->getPostTypeArchive();
			}

			// Custom post-types archives.
			if ( is_post_type_archive() ) {
				// Search in Custom Post Type Archive.
				if ( is_search() ) {
					$this->renderMarkup .= $this->getPostTypeArchive();
					$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( 'search' );
				} else {
					$this->renderMarkup .= $this->getPostTypeArchive( false );
				}
			} elseif ( is_tax() || is_tag() || is_category() ) {
				// Taxonomy Archives.
				if ( is_tag() ) {
					$this->renderMarkup .= $this->tagArchivePrefix;
				}

				// Category Archives.
				if ( is_category() ) {
					$this->renderMarkup .= $this->catArchivePrefix;
				}

				$this->renderMarkup .= $this->getTaxonomies();
				$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( 'term' );
			} elseif ( is_date() ) {
				// Date Archives.
				$year = esc_html( get_query_var( 'year' ) );

				if ( ! $year ) {
					$year = substr( esc_html( get_query_var( 'm' ) ), 0, 4 );
				}

				// Year Archives.
				if ( is_year() ) {
					$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( 'year' );
				} elseif ( is_month() ) {
					// Month Archives.
					$this->renderMarkup .= $this->getBreadcrumbListItem( $year, get_year_link( $year ) );
					$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( 'month' );
				} elseif ( is_day() ) {
					// Day Archives.
					global $wp_locale;

					$month = get_query_var( 'monthnum' );

					if ( ! $month ) {
						$month = substr( esc_html( get_query_var( 'm' ) ), 4, 2 );
					}

					$month_name          = $wp_locale->get_month( $month );
					$this->renderMarkup .= $this->getBreadcrumbListItem( $year, get_year_link( $year ) );
					$this->renderMarkup .= $this->getBreadcrumbListItem( $month_name, get_month_link( $year, $month ) );
					$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( 'day' );
				}
			} elseif ( is_author() ) {
				// Author Archives.
				$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( 'author' );
			} elseif ( is_search() ) {
				// Search Page.
				$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( 'search' );
			} elseif ( is_404() ) {
				// 404 Page.
				if ( Helpers::tribeIsEvent() || ( is_post_type_archive( 'tribe_events' ) || ( Helpers::tribeIsEvent() && is_archive() ) ) ) {
					$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( 'events' );
				} else {
					$this->renderMarkup .= $this->getBreadcrumbTrailMarkup( '404' );
				}
			}
		}
	}

	/**
	 * Breadcrumbs Wrapper.
	 *
	 * @return Breadcrumbs
	 * @since  1.0.0
	 */
	private function breadcrumbsWrapper(): Breadcrumbs {
		$this->renderMarkup = '<nav class="breadcrumb">' . $this->renderMarkup . '</nav><!-- .breadcrumb -->';

		return $this;
	}

	/**
	 * Breadcrumbs Output Markup.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function breadcrumbsOutput(): void {
		echo $this->renderMarkup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Breadcrumb prefix.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getBreadcrumbPrefix(): string {
		$prefix = '';

		if ( ! is_front_page() && $this->homePrefix ) {
			$prefix = '<span class="breadcrumb-prefix">' . $this->homePrefix . '</span>';
		}

		return $prefix;
	}

	/**
	 * Home Text.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getBreadcrumbHome(): string {
		return ( ! is_front_page() )
			? $this->getBreadcrumbListItem( $this->homeText, get_home_url() )
			: $this->getBreadcrumbListItem( 'Blog', '', true, true );
	}

	/**
	 * Render Terms.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getTerms(): string {
		$termsMarkup = '';

		if ( ! $this->displayTerms ) {
			return $termsMarkup;
		}

		// Post terms.
		if ( 'post' === $this->post->post_type ) {
			$taxonomy = 'category';
		} elseif ( 'product' === $this->post->post_type && Helpers::hasWooCommerce() && Helpers::isWooCommerce() ) {
			$taxonomy = 'product_cat';
		} elseif ( 'tribe_events' === $this->post->post_type ) {
			$taxonomy = 'tribe_events_cat';
		} else {
			return $termsMarkup;
		}

		$terms = wp_get_object_terms( $this->post->ID, $taxonomy );

		if ( empty( $terms ) ) {
			return $termsMarkup;
		}

		$termsById = [];

		foreach ( $terms as $term ) {
			$termsById[ $term->term_id ] = $term;
		}

		foreach ( $terms as $term ) {
			unset( $termsById[ $term->parent ] );
		}

		if ( 1 === count( $termsById ) ) {
			unset( $terms );
			$terms[0] = array_shift( $termsById );
		}

		if ( 1 === count( $terms ) ) {
			$termParent = $terms[0]->parent;

			if ( $termParent ) {
				$termTree   = get_ancestors( $terms[0]->term_id, $taxonomy );
				$termTree   = array_reverse( $termTree );
				$termTree[] = get_term( $terms[0]->term_id, $taxonomy );

				foreach ( $termTree as $term_id ) {
					$termObject   = get_term( $term_id, $taxonomy );
					$termsMarkup .= $this->getBreadcrumbListItem( $termObject->name, get_term_link( $termObject ) );
				}
			} else {
				$termsMarkup = $this->getBreadcrumbListItem( $terms[0]->name, get_term_link( $terms[0] ) );
			}
		} else {

			foreach ( $terms as $term ) {
				$termParents[] = $term->parent;
			}

			if ( 1 === count( array_unique( $termParents ) ) && $termParents[0] ) {
				$termTree = get_ancestors( $terms[0]->term_id, $taxonomy );
				$termTree = array_reverse( $termTree );

				foreach ( $termTree as $term_id ) {
					$termObject   = get_term( $term_id, $taxonomy );
					$termsMarkup .= $this->getBreadcrumbListItem( $termObject->name, get_term_link( $termObject ) );
				}
			}

			$termsMarkup .= $this->getBreadcrumbListItem( $terms[0]->name, get_term_link( $terms[0] ), false );
			array_shift( $terms );

			$maxIndex = count( $terms );
			$i        = 0;

			foreach ( $terms as $term ) {
				if ( ++$i == $maxIndex ) {
					$termsMarkup .= ', ' . $this->getBreadcrumbListItem( $term->name, get_term_link( $term ) );
				} else {
					$termsMarkup .= ', ' . $this->getBreadcrumbListItem( $term->name, get_term_link( $term ), false );
				}
			}
		}

		return $termsMarkup;
	}

	/**
	 * Render Parents.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getParents(): string {
		$parentsMarkup = '';
		$parentIDs     = array_reverse( get_post_ancestors( $this->post ) );

		foreach ( $parentIDs as $parentID ) {
			$parent = get_post( $parentID );

			if ( isset( $parent->post_title ) && isset( $parent->ID ) ) {
				$parentsMarkup .= $this->getBreadcrumbListItem( apply_filters( 'the_title', $parent->post_title ), get_permalink( $parent->ID ) );
			}
		}

		return $parentsMarkup;
	}

	/**
	 * Render Term parents.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getTaxonomies(): string {
		global $wp_query;

		$term        = $wp_query->get_queried_object();
		$termsMarkup = '';

		// Check for hierarchical taxonomy and parents.
		if ( 0 != $term->parent && is_taxonomy_hierarchical( $term->taxonomy ) ) {
			$termParents = get_ancestors( $term->term_id, $term->taxonomy );
			$termParents = array_reverse( $termParents );

			foreach ( $termParents as $termParent ) {
				$termObject   = get_term( $termParent, $term->taxonomy );
				$termsMarkup .= $this->getBreadcrumbListItem( $termObject->name, get_term_link( $termObject->term_id, $term->taxonomy ) );
			}
		}

		return $termsMarkup;
	}

	/**
	 * Render markup of a post-type archive.
	 *
	 * @param string $linked Check for links.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getPostTypeArchive( $linked = true ): string {
		global $wp_query;

		$link         = '';
		$archiveTitle = '';
		$delimiter    = false;

		$postType = $wp_query->query_vars['post_type'];

		if ( ! $postType ) {
			$postType = get_post_type();
		}

		$postTypeObject = get_post_type_object( $postType );

		// Check if we have a post-type object.
		if ( is_object( $postTypeObject ) ) {
			// Woocommerce: archive name should be the same as shop page name.
			if ( 'product' === $postType ) {
				return $this->getWooCommercePage( $linked );
			}

			// Use its name as fallback.
			$archiveTitle = $postTypeObject->name;

			// Default case. Check if the post-type has a non-empty label.
			if ( isset( $postTypeObject->label ) && '' !== $postTypeObject->label ) {
				if ( 'post' === $postTypeObject->name ) {
					$postsPage    = get_option( 'page_for_posts' );
					$archiveTitle = get_the_title( $postsPage );
				} else {
					$archiveTitle = $postTypeObject->label;
				}
			} elseif ( isset( $postTypeObject->labels->menu_name ) && '' !== $postTypeObject->labels->menu_name ) {
				// Alternatively, check for a non-empty menu name.
				$archiveTitle = $postTypeObject->labels->menu_name;
			}
		}

		// Check if the breadcrumb should be linked.
		if ( $linked ) {
			$link      = get_post_type_archive_link( $postType );
			$delimiter = true;
		}

		return $this->getBreadcrumbListItem( $archiveTitle, $link, $delimiter );
	}

	/**
	 * Render for Woocommerce.
	 *
	 * @param bool $linked Check for links.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getWooCommercePage( $linked = true ): string {
		$postType       = 'product';
		$postTypeObject = get_post_type_object( $postType );
		$shopPageMarkup = '';
		$link           = '';

		// Check if we are on a woocommerce page.
		if ( is_object( $postTypeObject ) && Helpers::hasWooCommerce() && ( Helpers::isWooCommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			$shopPageName = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

			if ( ! $shopPageName ) {
				$shopPageName = $postTypeObject->labels->name;
			}

			// Check if the breadcrumb should be linked.
			if ( $linked ) {
				$link = get_post_type_archive_link( $postType );
			}

			$delimiter = ! is_shop();

			if ( is_search() ) {
				$delimiter = true;
				$hasTrail  = false;
			}

			$shopPageMarkup = $this->getBreadcrumbListItem( $shopPageName, $link, $delimiter, $hasTrail );
		}

		return $shopPageMarkup;
	}

	/**
	 * Adds the markup of the breadcrumb trail.
	 *
	 * @param string $objectType ID of the current query object.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getBreadcrumbTrailMarkup( $objectType = '' ): string {
		global $wp_query, $wp_locale;

		switch ( $objectType ) {
			case 'term':
				$term  = $wp_query->get_queried_object();
				$title = $term->name;
				break;

			case 'year':
				$year = esc_html( get_query_var( 'year', 0 ) );

				if ( ! $year ) {
					$year = substr( esc_html( get_query_var( 'm' ) ), 0, 4 );
				}

				$title = esc_html__( 'Year: ', 'alsiha' ) . $year;
				break;

			case 'month':
				$monthNum = get_query_var( 'monthnum', 0 );

				if ( ! $monthNum ) {
					$monthNum = substr( esc_html( get_query_var( 'm' ) ), 4, 2 );
				}

				$title = esc_html__( 'Month: ', 'alsiha' ) . $wp_locale->get_month( $monthNum );
				break;

			case 'day':
				$day = get_query_var( 'day' );

				if ( ! $day ) {
					$day = substr( esc_html( get_query_var( 'm' ) ), 6, 2 );
				}

				$title = esc_html__( 'Day: ', 'alsiha' ) . $day;
				break;

			case 'author':
				$user = $wp_query->get_queried_object();

				if ( ! $user ) {
					$user = get_user_by( 'ID', $wp_query->query_vars['author'] );
				}

				$title = esc_html__( 'Articles Posted by&nbsp;', 'alsiha' ) . $user->display_name;
				break;

			case 'search':
				$title = $this->searchPrefix . ' ' . esc_html( get_search_query() );
				break;

			case '404':
				$title = $this->errorPrefix;
				break;

			case 'events':
				$title = function_exists( 'tribe_get_events_title' ) ? tribe_get_events_title() : '';
				break;

			default:
				$title = get_the_title( $this->post->ID );
				break;
		}

		return '<span class="breadcrumb-trail" property="v:title">' . $title . '</span>';
	}

	/**
	 * Adds the markup of a breadcrumb list item.
	 *
	 * @param string $title     The title of the breadcrumb.
	 * @param string $link      The URL of the breadcrumb.
	 * @param bool   $delimiter Display breadcrumb delimiter.
	 * @param bool   $hasTrail Trail markup.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function getBreadcrumbListItem( $title, $link = '', $delimiter = true, $hasTrail = false ): string {
		$delimiterMarkup = '';
		$trailMarkup     = '';

		// Set up the element attributes.
		$microdata    = 'typeof="v:Breadcrumb"';
		$microdataUrl = 'rel="v:url" property="v:title"';

		if ( $hasTrail ) {
			$trailMarkup = ' class="breadcrumb-trail"';
		}

		$breadcrumbContent = $trailMarkup . $title;

		// Link markup.
		if ( $link ) {
			$breadcrumbContent = '<a ' . $microdataUrl . ' href="' . $link . '">' . $breadcrumbContent . '</a>';
		}

		// If a delimiter should be added, do it.
		if ( $delimiter ) {
			$delimiterMarkup = '<span class="breadcrumb-delimiter">' . $this->delimiter . '</span>';
		}

		return '<span ' . $microdata . '>' . $breadcrumbContent . '</span>' . $delimiterMarkup;
	}
}
