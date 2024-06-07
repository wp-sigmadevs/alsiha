/**
 * Add to cart
 *
 * @param {Object} $
 */

/* global rtsbPublicParams, rtsbToastr, rtsbPublicParamsPro */

import { rtsbFrontendHelpers as helpers } from '../helpers';

export const rtsbAddToCart = ($, e) => {
	e.preventDefault();

	const self = $(e.currentTarget),
		productType = self.data('type') || 'simple',
		productId = self.data('id') || 0,
		variationId = self.attr('data-variation-id') || 0,
		quantity = 1;

	const data = {
		action: 'rtsb_ajax_add_to_cart',
		product_id: productId,
		quantity,
		type: productType,
		variation_id: variationId,
		__rtsb_wpnonce: rtsbPublicParams.__rtsb_wpnonce,
	};

	const before = () => {
		self.addClass('loading').removeClass('success');
		self.closest('.product-price-with-cart').addClass('loading');
	};

	const error = () => {
		self.removeClass('loading');
		self.closest('.product-price-with-cart').removeClass('loading');
		rtsbToastr.error('Security Error');
	};

	const success = (response) => {
		const fragments = response.fragments,
			browseTxt =
				'<a href="' +
				rtsbPublicParams.wcCartUrl +
				'">' +
				rtsbPublicParams.browseCartText +
				'</a>',
			addedTxt = rtsbPublicParams.addedToCartText;

		if (fragments) {
			$.each(fragments, function (key, value) {
				$(key).replaceWith(value);
			});

			self.addClass('success');

			const added = self.find('.text').attr('data-success');

			if (added.length > 0) {
				self.find('.text').text(added);
			}
		}

		self.removeClass('loading');
		setTimeout(
			() =>
				self.closest('.product-price-with-cart').removeClass('loading'),
			500
		);

		if (typeof rtsbPublicParamsPro !== 'undefined') {
			if (!rtsbPublicParamsPro.isMiniCartActive) {
				rtsbToastr.success(browseTxt, addedTxt);
			}
		} else {
			rtsbToastr.success(browseTxt, addedTxt);
		}

		$(document).trigger('added_to_cart');
		$(document.body).trigger('update_checkout');
	};

	helpers.ajaxAction(rtsbPublicParams.ajaxUrl, data, before, success, error);

	return false;
};

export const rtsbCartQuantity = ($) => {
	$('body').on('click', '.rtsb-quantity-plus, .rtsb-quantity-minus', (e) => {
		// Get current quantity values
		let qty, val, minVal;
		qty = $(e.currentTarget)
			.closest('.rtsb-quantity-box-group')
			.find('.qty');
		val = !qty.val() ? 0 : parseFloat(qty.val());
		minVal = 0;
		const max = parseFloat(qty.attr('max'));
		const min = parseFloat(qty.attr('min'));
		const step = parseFloat(qty.attr('step'));
		// Change the value if plus or minus
		if ($(e.currentTarget).is('.rtsb-quantity-plus')) {
			if (max && max <= val) {
				qty.val(max);
			} else {
				qty.val(val + step);
			}
		} else if (min && min >= val) {
			qty.val(min);
		} else if (val > minVal) {
			qty.val(val - step);
		}
		$('.qty').trigger('change');
		$(document).trigger('rtsb_cart_quantity_change');
	});
};
