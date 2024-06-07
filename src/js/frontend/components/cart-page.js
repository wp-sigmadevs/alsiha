/**
 * Add to cart icon
 *
 * @param {Object} $
 */

export const rtsbCartTableResponsive = ($) => {
	const tableElement = $(
		'.rtsb-cart-table:not(.rtsb-table-horizontal-scroll-on-mobile)'
	);
	if (!tableElement.length > 0) {
		return;
	}
	const previousClickedNode = null;

	if (window.rtsbDeviceCheck(767)) {
		tableElement.off('click', 'td');
		rtsbResetTableStyles(tableElement);

		tableElement.on('click', 'td', (e) => {
			rtsbTableClickHandler($, e, previousClickedNode);
		});
	} else {
		rtsbTableDesktopBehavior(tableElement);
	}
};

const rtsbResetTableStyles = (table) => {
	const td = table.find(
		'td:not(.product-data, .product-name, .product-subtotal) '
	);
	const tdExtra = table.find(
		'td :is(.product-attributes-wrapper, .subtotal-action-button-wrapper)'
	);
	const tr = table.find('.woocommerce-cart-form__cart-item');

	td.hide();
	tdExtra.hide();
	tr.removeClass('active-row');
};

const rtsbTableClickHandler = ($, e, previousClickedNode) => {
	const currentTarget = $(e.currentTarget);
	const isSameNode = previousClickedNode === e.currentTarget;

	if (currentTarget.is('.product-data, .product-name, .product-subtotal')) {
		currentTarget
			.parent()
			.find('td:not(.product-data, .product-name, .product-subtotal)')
			.stop(true, true) // Add stop() here
			.slideToggle()
			.end()
			.find(
				'td:is(.product-data, .product-name, .product-subtotal) :is(.rtsb-product-image.show-on-mobile, .product-thumbnail.show-image-on-mobile, .product-attributes-wrapper, .subtotal-action-button-wrapper)'
			)
			.slideToggle()
			.end()
			.toggleClass('active-row');
		// rtsb-product-image.
		if (isSameNode && !currentTarget.hasClass('active-row')) {
			currentTarget
				.parent()
				.removeClass('active-row')
				.find('td:not(.product-data, .product-name, .product-subtotal)')
				.stop(true, true) // Add stop() here
				.slideUp()
				.end()
				.find(
					'td:is(.product-data, .product-name, .product-subtotal) :is(.rtsb-product-image.show-on-mobile, .product-thumbnail.show-image-on-mobile, .product-attributes-wrapper, .subtotal-action-button-wrapper )'
				)
				.slideUp();
		}

		previousClickedNode = isSameNode ? null : e.currentTarget;
	}
};

const rtsbTableDesktopBehavior = (table) => {
	table.off('click', 'td');
	table
		.find('td')
		.show()
		.end()
		.find(
			'td :is(.product-attributes-wrapper, .subtotal-action-button-wrapper )'
		)
		.show();
};
