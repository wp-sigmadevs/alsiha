<?php
/**
 * Model Class: Pagination.
 *
 * This class handles the various pagination for the theme.
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
 * Model Class: Pagination
 *
 * @since 1.0.0
 */
class Pagination {
	/**
	 * Render Nav.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $renderNav = '';

	/**
	 * Custom query.
	 *
	 * @var   object
	 * @since 1.0.0
	 */
	private $custom = null;

	/**
	 * Posts Previous Text.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $prevText;

	/**
	 * Posts Next Text.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $nextText;

	/**
	 * Posts Previous Link.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $prevLink;

	/**
	 * Posts Next Link.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $nextLink;

	/**
	 * Method to render posts pagination markup.
	 *
	 * @param string $prev Previous Text.
	 * @param string $next Next Text.
	 * @param string $type Type of Pagination.
	 * @param string $custom Custom Object.
	 *
	 * @return Pagination|void
	 * @since  1.0.0
	 */
	public function postsNav( string $prev = '', string $next = '', string $type = 'posts', $custom = null ) {
		$this->prevText = $prev;
		$this->nextText = $next;
		$this->custom   = $custom;

		$this->prevLink = get_next_posts_link( $this->prevText );
		$this->nextLink = ( null !== $this->custom ) ? get_previous_posts_link( $this->nextText, $this->custom->max_num_pages ) : get_previous_posts_link( $this->nextText );

		if ( empty( $this->prevLink ) && empty( $this->nextLink ) ) {
			return $this;
		}

		$this->startPostNavRender()->renderFinalOutput( $type );
	}

	/**
	 * Method to render numbered posts pagination markup.
	 *
	 * @param string $prev Previous Text.
	 * @param string $next Next Text.
	 * @param string $type Type of Pagination.
	 * @param string $custom Custom Object.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function numberedPostsNav( string $prev = '', string $next = '', string $type = 'numbered_posts', $custom = null ) {
		$this->custom   = $custom;
		$this->prevText = $prev;
		$this->nextText = $next;

		$this->startNumberedPostsNavRender()->renderFinalOutput( $type );
	}

	/**
	 * Method to render single post pagination markup.
	 *
	 * @param string $prev Previous Text.
	 * @param string $next Next Text.
	 * @param bool   $title Show title.
	 * @param string $type Type of Pagination.
	 *
	 * @return Pagination|void
	 * @since  1.0.0
	 */
	public function singlePostNav( string $prev = '', string $next = '', bool $title = true, string $type = 'single_post' ) {
		$title          = ( $title ) ? '%title' : '';
		$this->prevText = sprintf( '%s %2$s', $prev, $title );
		$this->nextText = sprintf( '%2$s %s', $next, $title );
		$this->prevLink = get_previous_post_link( '%link', $this->prevText );
		$this->nextLink = get_next_post_link( '%link', $this->nextText );

		if ( empty( $this->prevLink ) && empty( $this->nextLink ) ) {
			return $this;
		}

		$this->startPostNavRender()->renderFinalOutput( $type );
	}

	/**
	 * Start of pagination Rendering.
	 *
	 * @return object
	 * @since  1.0.0
	 */
	private function startPostNavRender() {
		$this->renderNav .= $this->screenReaderText();
		$this->renderNav .= '<div class="nav-links pagination classic justify-content-between">';

		if ( $this->prevLink ) {
			$this->renderNav .= '<div class="nav-previous">' . $this->prevLink . '</div>';
		}

		if ( $this->nextLink ) {
			$this->renderNav .= '<div class="nav-next">' . $this->nextLink . '</div>';
		}

		$this->renderNav .= '</div><!-- .nav-links -->';

		return $this;
	}

	/**
	 * Start of numbered pagination Rendering.
	 *
	 * @return object
	 * @since  1.0.0
	 */
	private function startNumberedPostsNavRender() {
		global $wp_query;

		// Stop execution if there's only 1 page.
		if ( ( ( null !== $this->custom ) ? $this->custom->max_num_pages : $wp_query->max_num_pages ) <= 1 ) {
			return $this;
		}

		$current    = max( 1, absint( get_query_var( 'paged' ) ) );
		$pagination = paginate_links(
			[
				'base'      => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
				'format'    => '?paged=%#%',
				'current'   => $current,
				'total'     => ( null !== $this->custom ) ? $this->custom->max_num_pages : $wp_query->max_num_pages,
				'type'      => 'array',
				'prev_text' => $this->prevText,
				'next_text' => $this->nextText,
			]
		);

		if ( empty( $pagination ) ) {
			return $this;
		}

		$this->renderNav .= $this->screenReaderText();
		$this->renderNav .= '<ul class="pagination numbered mb-0 justify-content-center">';

		foreach ( $pagination as $key => $page_link ) {
			$this->renderNav .= '<li class="page-item paginated_link' . esc_attr( ( false !== strpos( $page_link, 'current' ) ) ? ' active' : '' ) . '">';
			$this->renderNav .= $page_link;
			$this->renderNav .= '</li>';
		}

		$this->renderNav .= '</ul><!-- .pagination -->';

		return $this;
	}

	/**
	 * Screen reader text.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function screenReaderText() {
		return '<h2 class="screen-reader-text">' . esc_html__( 'Post navigation', 'alsiha' ) . '</h2>';
	}

	/**
	 * Pagination Wrapper.
	 *
	 * @return object
	 * @since  1.0.0
	 */
	private function navWrapper() {
		$this->renderNav = '<nav id="post-navigation" class="navigation post-navigation" aria-label="' . esc_html__( 'Post navigation', 'alsiha' ) . '">' . $this->renderNav . '</nav><!-- #post-navigation -->';

		return $this;
	}

	/**
	 * Pagination Output Markup.
	 *
	 * @param string $type Nav type.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function outputNav( string $type ) {
		echo apply_filters( "sigmadevs/sigma/{$type}_nav", $this->renderNav ); // phpcs:ignore WordPress.Security.EscapeOutput
	}

	/**
	 * Pagination Output Final Markup.
	 *
	 * @param string $type Nav type.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	private function renderFinalOutput( string $type ) {
		$this->navWrapper()->outputNav( $type );
	}
}
