<?php
/**
 * Widget Class: FooterContactWidget
 *
 * This class registers and renders footer contact widget.
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
class FooterContactWidget extends Widgets {
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
		'title'        => 'Contact Us',
		'address'      => '',
		'phone'        => '',
		'email'        => '',
		'show_socials' => true,
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
			'classname'   => 'alsiha_footer_contact_widget',
			'description' => esc_html__( 'Displays contact information and social icons.', 'alsiha' ),
		];
		$control_ops = [];

		parent::__construct( 'footer-contact-widget', __( 'Alsiha Footer Contact', 'alsiha' ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @param array $args Default widget arguments.
	 * @param array $instance Settings for the current instance.
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) {
		$instance     = array_merge( $this->default_instance, $instance );
		$title        = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$address      = ! empty( $instance['address'] ) ? $instance['address'] : '';
		$phone        = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
		$email        = ! empty( $instance['email'] ) ? $instance['email'] : '';
		$show_socials = ! empty( $instance['show_socials'] );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
		<div class="footer-contact-wrapper">
			<div class="contact-body">
				<ul class="address">
					<?php if ( $address ) : ?>
						<li>
							<span><strong><?php esc_html_e( 'Address:', 'alsiha' ); ?></strong></span>
							<span><?php echo esc_html( $address ); ?></span>
						</li>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<li>
							<span><strong><?php esc_html_e( 'Phone:', 'alsiha' ); ?></strong></span>
							<span><a href="tel:<?php echo esc_attr( str_replace( '-', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></span>
						</li>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<li>
							<span><strong><?php esc_html_e( 'E-mail:', 'alsiha' ); ?></strong></span>
							<span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span>
						</li>
					<?php endif; ?>
				</ul>
			</div>
			<?php if ( $show_socials ) : ?>
				<div class="footer-socials">
					<?php echo do_shortcode( '[alsiha_social_icons]' ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
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
		$instance                 = array_merge( $this->default_instance, $old_instance );
		$instance['title']        = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['address']      = ! empty( $new_instance['address'] ) ? sanitize_text_field( $new_instance['address'] ) : '';
		$instance['phone']        = ! empty( $new_instance['phone'] ) ? sanitize_text_field( $new_instance['phone'] ) : '';
		$instance['email']        = ! empty( $new_instance['email'] ) ? sanitize_email( $new_instance['email'] ) : '';
		$instance['show_socials'] = ! empty( $new_instance['show_socials'] );

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
		$instance     = wp_parse_args( (array) $instance, $this->default_instance );
		$title        = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$address      = ! empty( $instance['address'] ) ? $instance['address'] : '';
		$phone        = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
		$email        = ! empty( $instance['email'] ) ? $instance['email'] : '';
		$show_socials = ! empty( $instance['show_socials'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'alsiha' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Address:', 'alsiha' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" type="text" value="<?php echo esc_attr( $address ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e( 'Phone:', 'alsiha' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'E-mail:', 'alsiha' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="email" value="<?php echo esc_attr( $email ); ?>">
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_socials ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_socials' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_socials' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_socials' ) ); ?>"><?php esc_html_e( 'Show Social Icons', 'alsiha' ); ?></label>
		</p>
		<?php
	}
}
