<?php
/**
 * Displays header site search
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="site-search">
	<div class="search-bar">

		<!-- Product Search Form -->
		<form role="search" method="get" class="woocommerce-product-search pos-r" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="s"><?php esc_html_e( 'Enter Keyword...', 'alsiha' ); ?></label>
			<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Enter Keyword...', 'placeholder', 'alsiha' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Enter Keyword...', 'label', 'alsiha' ); ?>" />
			<input class="product-search-btn" type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'alsiha' ); ?>" />
			<input type="hidden" name="post_type" value="product" />
		</form>
	</div><!-- .search-bar -->
</div><!-- .site-search -->
