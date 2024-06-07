/**
 * Elementor Frontend JS
 *
 * @param {Object} $
 */

import { rtsbFrontendHelpers as helpers } from '../helpers';

export const rtsbElFrontend = ($) => {
	$('.rtsb-elementor-container').each((i, el) => {
		const container = $(el),
			str = container.attr('data-layout'),
			preLoader = container.find('.rtsb-pre-loader'),
			loader = container.find('.rtsb-content-loader'),
			isCarousel = container.find('.rtsb-carousel-slider');

		if (str) {
			if (preLoader.find('.rtsb-spinner-overlay').length === 0) {
				preLoader.append(helpers.addLoader());
			}

			if (isCarousel.length) {
				isCarousel.imagesLoaded(() => {
					isCarousel.rtsb_slider();

					$(document).on('rtsb_slider_loaded', () => {
						isCarousel.removeClass('slider-loading');

						setTimeout(
							() => helpers.removeLoader(container, loader),
							300
						);
					});
				});
			} else {
				container.imagesLoaded(() => {
					helpers.removeLoader(container, loader);
				});
			}
		}
	});
};
