<?php
/**
 * Displays header action buttons
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$images_uri = get_parent_theme_file_uri( 'assets/images/' );
?>

<div class="action-buttons d-none d-lg-block">
	<div class="buttons-wrapper">
		<ul class="list-inline d-flex align-items-center justify-content-end mb-0">
			<li class="list-inline-item wishlist-btn">
				<a class="d-block pos-r" href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() );?>">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'wishlist.svg' ); ?>" alt="<?php esc_html_e( 'Wishlist Button', 'maxx-fitness' ); ?>">
					<span class="wishlist-icon-num"><?php echo absint( yith_wcwl_count_all_products() ); ?></span>
				</a>
			</li>
			<li class="list-inline-item login-btn pos-r">
				<a class="d-block" href="">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'login.svg' ); ?>" alt="<?php esc_html_e( 'Login Button', 'maxx-fitness' ); ?>">
				</a>
				<div class="login-expanded">
					<ul class="popup-inner <?php echo is_user_logged_in() ? esc_attr( 'logged-in' ) : esc_attr( 'no-login' ); ?>">
						<?php
						if ( is_user_logged_in() ) {
							?>
							<li class="alsiha-account"><a href="/my-account/">Mein Konto</a></li>
							<li class="alsiha-orders"><a href="/my-account/orders/">Meine Bestellungen</a></li>
							<li class="alsiha-recently-viewed"><a href="/my-account/recently-viewed-products/">Kürzlich angesehen</a></li>
							<li class="alsiha-help"><a href="/service-formular/">Hilfe</a></li>
							<li class="alsiha-logout"><a href="<?php echo wp_logout_url( '/' ) ?>">Abmelden</a></li>
							<?php
						} else {
							?>
							<li class="alsiha-login"><a href="/my-account/">Anmeldung</a></li>
							<li class="alsiha-help"><a href="/service-formular/">Hilfe</a></li>
							<?php
						}
						?>
					</ul>
				</div>
			</li>
			<li class="list-inline-item cart-btn">
				<a class="d-block pos-r" href="#">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'cart.svg' ); ?>" alt="<?php esc_html_e( 'Cart Button', 'maxx-fitness' ); ?>">
					<span class="cart-icon-num"><?php echo absint( WC()->cart->get_cart_contents_count() ); ?></span>
				</a>
				<div class="cart-icon-products">
					<?php
					the_widget( 'WC_Widget_Cart' );
					?>
				</div>
			</li>
		</ul>
	</div><!-- .buttons-wrapper -->
</div><!-- .action-buttons -->

<div id="alsiha-menu-trigger" class="mobile-nav alsiha-menu-trigger d-block d-sm-block d-md-block d-lg-none text-right">
	<div class="primary-nav">
		<button id="alsiha-trigger-button" class="primary-nav-details">
			<span><?php echo esc_html__( 'Menu', 'maxx-fitness' ); ?></span>
			<i class="fa fa-bars"></i>
		</button>
	</div><!-- #primary-nav -->
</div><!-- #alsiha-menu-trigger -->
