/**
 * Add to cart icon
 *
 * @param {Object} $
 */

export const rtsbAddCartIcon = ($) => {
	const cartWrpper = $('.has-cart-button');

	cartWrpper.each((i, el) => {
		const cartIcon = $(el).attr('data-cart-icon');
		const cartButton = $(el).find(
			'.product_type_grouped, .product_type_simple, .add_to_cart_button, .single_add_to_cart_button '
		);
		if (cartIcon) {
			cartButton.find('i').remove();
			cartButton.find('svg').remove();
			cartButton.find('img').remove();
			cartButton.prepend(cartIcon);
		}
	});
};
