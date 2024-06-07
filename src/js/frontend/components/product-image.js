/**
 * Product Image Zoom
 *
 * @param {Object} $
 */
export const rtsbProductImage = ($) => {
	setTimeout(function () {
		const zoomIcon = $('.rtsb-product-images').attr('data-zoom-icon');

		if (!zoomIcon) {
			$('.rtsb-product-images')
				.find('.woocommerce-product-gallery__trigger, .rtwpvg-trigger')
				.remove();
		}

		$('.rtsb-product-images')
			.find('.woocommerce-product-gallery__trigger,.rtwpvg-trigger')
			.html(zoomIcon);
	}, 50);
};
