<?php
/**
 * Widget Class: PortfolioPosts
 *
 * This class registers and renders selected portfolio posts.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Integrations\Widgets;

use SigmaDevs\Sigma\Common\{
	Traits\Singleton,
	Abstracts\Widgets
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Widget Class: SocialProfiles
 *
 * @since 1.0.0
 */
class PortfolioPosts extends Widgets {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Default instance.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected array $default_instance = [
		'title'      => '',
		'portfolios' => [],
	];

	/**
	 * Registers the class.
	 *
	 * This integration class is only being instantiated
	 * as requested in the Bootstrap class.
	 *
	 * @see Bootstrap::registerServices
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register(): void {
		$this->widgetName = get_class( $this );

		parent::register();
	}

	/**
	 * Sets up a new HTML widget instance.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$widget_ops  = [
			'classname'                   => 'widget_portfolio_posts',
			'description'                 => __( 'Displays selected portfolio posts.', 'alsiha' ),
			'customize_selective_refresh' => true,
		];
		$control_ops = [];

		parent::__construct( 'portfolio-posts-widget', __( 'Alsiha Fruits', 'alsiha' ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @param array $args Default widget arguments.
	 * @param array $instance Settings for the current instance.
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) {

		$instance   = array_merge( $this->default_instance, $instance );
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$portfolios = ! empty( $instance['portfolios'] ) ? $instance['portfolios'] : [];

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( ! empty( $portfolios ) ) {
			echo '<div class="alsiha-footer-featured-posts"><div class="row">';

			foreach ( $portfolios as $postId ) {
				$image = get_the_post_thumbnail_url( $postId, 'thumbnail' );
				$link  = get_permalink( $postId );

				echo '<div class="col-4 mb-4"><a href="' . esc_url( $link ) . '">';
				echo '<img src="' . esc_url( $image ) . '" class="img-fluid" alt="' . esc_attr( get_the_title( $postId ) ) . '">';
				echo '</a></div>';
			}

			echo '</div></div>';
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @param array $new_instance New settings for this instance.
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array $instance Settings to save or bool false to cancel saving.
	 * @since  1.0.0
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance               = array_merge( $this->default_instance, $old_instance );
		$instance['title']      = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['portfolios'] = ! empty( $new_instance['portfolios'] ) ? array_map( 'absint', $new_instance['portfolios'] ) : [];

		return $instance;
	}

	/**
	 * Outputs the HTML Code widget settings form.
	 *
	 * @param array $instance Current widget instance.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function form( $instance ): void {
		$instance   = wp_parse_args( (array) $instance, $this->default_instance );
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$portfolios = ! empty( $instance['portfolios'] ) ? $instance['portfolios'] : [];

		wp_enqueue_script( 'select2' );
		wp_enqueue_style( 'select2' );

		$portfolioPosts = get_posts(
			[
				'post_type'   => 'portfolios',
				'numberposts' => -1,
			]
		);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'alsiha' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'portfolios' ) ); ?>"><?php esc_html_e( 'Select Fruits:', 'alsiha' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'portfolios' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'portfolios' ) ); ?>[]" multiple="multiple" style="width: 100%;">
				<?php foreach ( $portfolioPosts as $post ) : ?>
					<option value="<?php echo esc_attr( $post->ID ); ?>" <?php selected( in_array( $post->ID, $portfolios, true ) ); ?>>
						<?php echo esc_html( $post->post_title ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<script>
			jQuery(document).ready(function($) {
				$('#<?php echo esc_attr( $this->get_field_id( 'portfolios' ) ); ?>').select2();
			});
		</script>
		<?php
	}
}
