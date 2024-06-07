/**
 * Variable Products Add to cart
 *
 * @param {Object} event
 * @param {Object} variation
 */

export const rtsbVariationHandler = (event, variation) => {
	let cartBtn;
	const $this = event.data.$(event.currentTarget);
	const variationId = variation.variation_id;

	if (variationId) {
		cartBtn = getCartButton($this);

		if (cartBtn.length > 0) {
			if (cartBtn.hasClass('success')) {
				cartBtn.removeClass('success');
				rtsbVariationReset(event);
			}

			const textContainer = cartBtn.find('span.text');
			const cartText = textContainer.attr('data-cart-text');

			cartBtn.addClass('rtsb-add-to-cart-btn');
			cartBtn.attr('data-variation-id', variationId);
			textContainer.text(cartText);
		}
	}
};

export const rtsbVariationReset = (event) => {
	const $this = event.data.$(event.currentTarget);
	const cartBtn = getCartButton($this);
	const textContainer = cartBtn.find('span.text');
	const existingCartText = textContainer.attr('data-variable-text');

	cartBtn.removeClass('rtsb-add-to-cart-btn success loading');
	textContainer.text(existingCartText);
};

const getCartButton = ($element) =>
	$element
		.closest('.rtsb-product')
		.find('.rtsb-wc-add-to-cart-wrap .rtsb-action-btn');
