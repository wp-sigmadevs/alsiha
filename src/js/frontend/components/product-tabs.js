/**
 * Product tabs
 *
 * @param {Object} $
 */

export const rtsbProductTabs = ($) => {
	const tabTitle = '.rtsb-accordion-title';
	const tabContent = '.rtsb-product-accordion-content';

	$('.rtsb-product-tabs #rating')
		.hide()
		.before(
			'<p class="stars"> <span> <a class="star-1" href="#">1</a> <a class="star-2" href="#">2</a> <a class="star-3" href="#">3</a> <a class="star-4" href="#">4</a> <a class="star-5" href="#">5</a> </span> </p>'
		);
	$('.rtsb-product-tabs .woocommerce-tabs').trigger('init');
	$(tabContent).hide();

	const tabs = $('.rtsb-product-tabs');

	if (tabs.length > 0) {
		tabs.each((i, tab) => {
			$(tab).on('click', tabTitle, (e) => {
				const content = $(e.currentTarget).next(tabContent);

				if ($(e.currentTarget).hasClass('active')) {
					$(e.currentTarget).removeClass('active');
					$(e.currentTarget).next(tabContent).slideUp();
				} else {
					$(tabTitle).next(tabContent).slideUp();
					$(tabTitle).removeClass('active');
					content.slideDown();
					$(e.currentTarget).addClass('active');
				}
			});
		});

		// Open the first content item initially.
		$(tabTitle).first().trigger('click');
	}
};
