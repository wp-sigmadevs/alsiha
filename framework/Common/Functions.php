<?php
/**
 * Common Class: Functions.
 *
 * Main function class for external uses.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common;

use SigmaDevs\Sigma\Common\{
	Utils\Helpers,
	Abstracts\Base,
	Models\Templates,
	Models\Pagination,
	Abstracts\CustomizerBase,
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Common Class: Functions.
 *
 * @since 1.0.0
 */
class Functions extends Base {
	/**
	 * Retrieves a value from the cache, or sets it if not found.
	 *
	 * @param string   $cacheKey The cache key.
	 * @param callable $callback The callback to generate the data if not cached.
	 * @param mixed    ...$args  Additional arguments to pass to the callback.
	 *
	 * @return mixed
	 * @since  1.0.0
	 */
	private function getCachedData( string $cacheKey, callable $callback, ...$args ) {
		$cachedData = wp_cache_get( $cacheKey, 'sd_sigma' );

		if ( false !== $cachedData ) {
			return $cachedData;
		}

		$data = empty( $args ) ? call_user_func( $callback ) : call_user_func_array( $callback, $args );

		wp_cache_set( $cacheKey, $data, 'sd_sigma', HOUR_IN_SECONDS );

		return $data;
	}

	/**
	 * Retrieves a value from the static cache, or sets it if not found.
	 *
	 * @param string   $cacheKey The cache key.
	 * @param callable $callback The callback to generate the data if not cached.
	 * @param mixed    ...$args  Additional arguments to pass to the callback.
	 *
	 * @return mixed
	 * @since  1.0.0
	 */
	private static function staticCache( string $cacheKey, callable $callback, ...$args ) {
		static $cache = [];

		if ( isset( $cache[ $cacheKey ] ) ) {
			return $cache[ $cacheKey ];
		}

		$data = empty( $args ) ? call_user_func( $callback ) : call_user_func_array( $callback, $args );

		$cache[ $cacheKey ] = $data;

		return $data;
	}

	/**
	 * Get theme data by using sd_alsiha()->getData()
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function getData(): array {
		return $this->getCachedData( 'sd_sigma_theme_data', [ $this->theme, 'data' ] );
	}

	/**
	 * Get the theme version.
	 *
	 * @return int|string
	 * @since  1.0.0
	 */
	public function getVersion() {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			return time();
		}

		return $this->getCachedData( 'sd_sigma_theme_version', [ $this->theme, 'version' ] );
	}

	/**
	 * Get template data.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function templatesPath(): string {
		return $this->getCachedData( 'sd_sigma_template_path', [ $this->theme, 'templatePath' ] );
	}

	/**
	 * Get the template class.
	 *
	 * @return Templates
	 * @since  1.0.0
	 */
	public function templates(): Templates {
		return $this->getCachedData( 'sd_sigma_templates_instance', fn() => new Templates() );
	}

	/**
	 * Get the theme path.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function getThemePath(): string {
		return $this->getCachedData( 'sd_sigma_theme_path', [ $this->theme, 'parentThemePath' ] );
	}

	/**
	 * Get theme URI.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function getThemeUri(): string {
		return $this->getCachedData( 'sd_sigma_theme_uri', [ $this->theme, 'parentThemeUri' ] );
	}

	/**
	 * Get assets URI.
	 *
	 * @param string $path Asset file path.
	 * @param string $type Asset type.
	 * @param string $suffix Asset suffix.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function getAssetsUri( $path = '', $type = 'css', $suffix = '.css' ): string {
		$cacheKey = "sd_sigma_assets_uri_{$path}_{$type}_{$suffix}";

		return $this->getCachedData(
			$cacheKey,
			function () use ( $path, $type, $suffix ) {
				$assetsUri = $this->theme->assetsUri();

				if ( empty( $path ) ) {
					return $assetsUri;
				}

				return $assetsUri . $type . '/' . $path . $suffix;
			}
		);
	}

	/**
	 * Retrieves the navigation menu with caching.
	 *
	 * @param array $args Arguments for wp_nav_menu.
	 *
	 * @return string|null
	 * @since  1.0.0
	 */
	public function navMenu( array $args = [] ): ?string {
		$cacheKey = 'sd_sigma_nav_menu_' . $args['theme_location'];

		return $this->getCachedData( $cacheKey, [ $this, 'getNavMenu' ], $args );
	}

	/**
	 * Generates the navigation menu.
	 *
	 * @param array $args Arguments for wp_nav_menu.
	 *
	 * @return string|null
	 * @since  1.0.0
	 */
	private function getNavMenu( array $args ): ?string {
		$navArgs = Helpers::navMenuArgs( $args );

		// Render the menu.
		return wp_nav_menu( $navArgs );
	}

	/**
	 * Prints the HTML for the post's published and modified dates.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function postedOn(): void {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $this->getCachedData( 'sd_sigma_posted_on_html_' . get_the_ID(), [ $this, 'generatePostedOnHtml' ] );
	}

	/**
	 * Renders an image with specified attributes, using static caching.
	 *
	 * @param int    $attachmentId The ID of the image attachment to render.
	 * @param string $imageSize    The size of the image to display.
	 * @param string $imageClass   CSS class to apply to the image.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function renderImage( $attachmentId, $imageSize = 'full', $imageClass = 'wp-post-image' ) {
		$cacheKey = 'alsiha_render_image_' . $attachmentId . '_' . $imageSize;

		return self::staticCache(
			$cacheKey,
			function () use ( $imageClass, $attachmentId, $imageSize ) {
				$altText = trim( wp_strip_all_tags( get_post_meta( $attachmentId, '_wp_attachment_image_alt', true ) ) );

				echo wp_get_attachment_image(
					$attachmentId,
					$imageSize,
					false,
					[
						'class' => esc_attr( $imageClass ),
						'alt'   => esc_attr( $altText ),
					]
				);
			}
		);
	}

	/**
	 * Generates the HTML for the post's published and modified dates.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private function generatePostedOnHtml(): string {
		$timeString = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$timeString = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated visually-hidden" datetime="%3$s">%4$s</time>';
		}

		$timeString = sprintf(
			$timeString,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$postedOn = sprintf(
			/* translators: %s: post date. */
			_x( '<span class="screen-reader-text">Posted on</span>%s', 'post date', 'alsiha' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $timeString . '</a>'
		);

		if ( is_single() ) {
			$postedOn = sprintf(
				/* translators: %s: post date. */
				esc_html_x( 'Posted on %s', 'post date', 'alsiha' ),
				$timeString
			);
		}

		return '<span class="posted-on">' . $postedOn . '</span>';
	}

	/**
	 * Prints HTML with meta information for the current author.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function postedBy(): void {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'alsiha' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Displays the Post comments meta.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function commentsMeta(): void {
		$comments = '';

		if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
			$commentsNumber = get_comments_number_text( esc_html__( 'Click to Comment', 'alsiha' ), esc_html__( '1 Comment', 'alsiha' ), esc_html__( '% Comments', 'alsiha' ) );

			$comments = sprintf(
				'<span class="comments-link"><span class="screen-reader-text">%1$s</span><a href="%2$s">%3$s</a></span>',
				esc_html__( 'Posted comments', 'alsiha' ),
				esc_url( get_comments_link() ),
				$commentsNumber
			);
		}

		echo $comments; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Prints HTML with meta information for the current categories.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function postedIn(): void {
		$categories = get_the_category_list( ', ' );

		echo sprintf(
			'<span class="screen-reader-text">%1$s</span>%2$s',
			esc_html__( 'Posted in', 'alsiha' ),
			wp_kses( $categories, 'allow_content' )
		);
	}

	/**
	 * Header Image.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function headerImage(): void {
		if ( ! get_header_image() ) {
			return;
		}

		$header_image_url = get_header_image();

		echo 'style="background-image: url(' . esc_url( $header_image_url ) . ')"';
	}

	/**
	 * Displays Classic Pagination.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function classicPagination(): void {
		$prev = esc_html_x( '&laquo; Older Posts', 'Older Posts', 'alsiha' );
		$next = esc_html_x( 'Newer Posts &raquo;', 'Newer Posts', 'alsiha' );

		// Rendering Classic Pagination.
		( new Pagination() )->postsNav( $prev, $next );
	}

	/**
	 * Displays Numbered Pagination.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function numberedPagination(): void {
		$prev = esc_html_x( '&larr;', 'Older Posts', 'alsiha' );
		$next = esc_html_x( '&rarr;', 'Newer Posts', 'alsiha' );

		// Rendering Numbered Pagination.
		( new Pagination() )->numberedPostsNav( $prev, $next );
	}

	/**
	 * Displays Single Post Pagination.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function singlePostPagination(): void {
		$prev = esc_html_x( '&laquo;', 'Previous', 'alsiha' );
		$next = esc_html_x( '&raquo;', 'Next', 'alsiha' );

		// Rendering Single Post Pagination.
		( new Pagination() )->singlePostNav( $prev, $next );
	}

	/**
	 * Display Comment Form.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function commentForm(): void {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html5     = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

		// Comment Form fields.
		$author = '<div class="row">' .
				  '<div class="col-12 col-sm-12 col-md-4">' .
				  '<div class="comment-form-author">' .
				  '<fieldset>' .
				  '<input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name', 'alsiha' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
				  '</fieldset>' .
				  '</div>' .
				  '</div>';

		$email = '<div class="col-12 col-sm-12 col-md-4">' .
				 '<div class="comment-form-email">' .
				 '<fieldset>' .
				 '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="' . esc_html__( 'Email', 'alsiha' ) . ( $req ? ' *' : '' ) . '" ' . $aria_req . ' />' .
				 '</fieldset>' .
				 '</div>' .
				 '</div>';

		$url = '<div class="col-12 col-sm-12 col-md-4">' .
			   '<div class="comment-form-url">' .
			   '<fieldset>' .
			   '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_html__( 'Website', 'alsiha' ) . '" size="30" />' .
			   '</fieldset>' .
			   '</div>' .
			   '</div>';

		$cookies = '<div class="col-12 col-sm-12 col-md-12">' .
				   '<div class="comment-form-cookies-consent">' .
				   '<fieldset>' .
				   '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' .
				   '<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment', 'alsiha' ) . '</label>' .
				   '</fieldset>' .
				   '</div>' .
				   '</div>' .
				   '</div>';

		$comment_field = '<div class="comment-form-comment">' .
						 '<fieldset>' .
						 '<textarea id="comment" placeholder="' . esc_html_x( 'Comment', 'noun', 'alsiha' ) . ( $req ? ' *' : '' ) . '" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .
						 '</fieldset>' .
						 '</div>';

		// Building Comment Form args.
		$args = apply_filters(
			'sigmadevs/sigma/comment_form/args',
			[
				'fields'               => apply_filters(
					'alsiha_comment_form_fields',
					[
						'author'  => $author,
						'email'   => $email,
						'url'     => $url,
						'cookies' => $cookies,
					]
				),
				'comment_notes_before' => '',
				'comment_notes_after'  => '',
				'title_reply'          => esc_html__( 'Do you have something to say?', 'alsiha' ),
				'title_reply_to'       => esc_html__( 'Do you have something to say?', 'alsiha' ),
				'cancel_reply_link'    => esc_html__( 'Cancel comment', 'alsiha' ),
				'comment_field'        => $comment_field,
				'label_submit'         => esc_html__( 'Send', 'alsiha' ),
				'id_submit'            => 'submit_comment',
				'class_submit'         => 'default-btn',
			]
		);

		// The Comment Form.
		comment_form( $args );
	}

	/**
	 * Comment template.
	 *
	 * @param object $comment the comment object.
	 * @param array  $args the comment args.
	 * @param int    $depth the comment depth.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function commentCallback( $comment, $args, $depth ): void {
		?>
		<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
			<div class="comment-body">
				<div class="comment-media d-flex">
					<?php
					if ( ! empty( get_avatar( $comment ) ) ) {
						?>
						<div class="comment-author vcard d-none d-sm-block">
							<?php
							echo get_avatar(
								$comment,
								'128',
								'',
								sprintf( '%1$s %2$s', esc_html__( 'Avatar for', 'alsiha' ), get_comment_author() )
							);
							?>
						</div><!-- .comment-author -->
						<?php
					}
					?>

					<div class="comment-content">
						<?php
						// Comment Author link.
						printf(
							wp_kses_post( '<cite class="fn">%s</cite>' ),
							get_comment_author_link()
						);
						?>

						<div class="comment-text">
							<?php comment_text(); ?>
						</div>

						<?php
						if ( '0' === $comment->comment_approved ) {
							?>
							<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'alsiha' ); ?></em>
							<br />
							<?php
						}
						?>

						<div class="comment-meta commentmetadata flex-wrap">
							<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
								<time datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
									<?php
									/* translators: 1: comment date, 2: comment time */
									printf( esc_html__( '%1$s at %2$s', 'alsiha' ), get_comment_date(), get_comment_time() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									?>
								</time>
							</a>
							<?php
							edit_comment_link( esc_html__( '(Edit)', 'alsiha' ), '  ', '' );
							?>

							<div class="comment-reply">
								<?php
								comment_reply_link(
									array_merge(
										$args,
										[
											'depth'     => $depth,
											'max_depth' => $args['max_depth'],
										]
									)
								);
								?>
							</div>
						</div>
					</div><!-- .comment-content -->
				</div><!-- .comment-media -->
			</div><!-- .comment-body -->
			<?php
	}

	/**
	 * Advanced Custom Fields fallback.
	 *
	 * @param string $key Meta key.
	 * @param int    $postID Post ID.
	 * @param int    $formatValue Formatted value.
	 *
	 * @return mixed
	 * @since  1.0.0
	 */
	public function getField( $key, $postID = false, $formatValue = true ) {
		$cache_key = md5( wp_json_encode( [ $key, $postID, $formatValue ] ) );

		return self::staticCache(
			$cache_key,
			function () use ( $key, $postID, $formatValue ) {
				if ( function_exists( 'get_field' ) ) {
					return get_field( $key, $postID, $formatValue );
				} else {
					if ( false === $postID ) {
						global $post;

						$postID = $post->ID;
					}

					return get_post_meta( $postID, $key, true );
				}
			}
		);
	}

	/**
	 * Retrieves a theme option/settings value with caching.
	 *
	 * @param string $settingsKey The ID of the customizer control.
	 * @param bool   $isThemeMod Whether to check theme modifications.
	 *
	 * @return mixed The value of the setting, or the default value if not set.
	 * @since  1.0.0
	 */
	public function getOption( $settingsKey, $isThemeMod = true ) {
		$cacheKey = 'sd_sigma_' . $settingsKey . ( $isThemeMod ? '_theme_mod' : '_option' );

		return self::staticCache(
			$cacheKey,
			function () use ( $settingsKey, $isThemeMod ) {
				if ( $isThemeMod ) {
					$defaultValues = CustomizerBase::getDefaultValues();
					$defaultValue  = $defaultValues[ $settingsKey ] ?? '';

					return get_theme_mod( $settingsKey, $defaultValue );
				} else {
					return get_option( $settingsKey );
				}
			}
		);
	}
}
