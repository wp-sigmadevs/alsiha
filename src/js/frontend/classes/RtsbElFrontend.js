/**
 * A class that handles frontend functionality for RTSB Elementor widgets.
 */

import { rtsbFrontendHelpers as helpers } from '../helpers';

/**
 * A class that handles frontend functionality for RTSB Elementor widgets.
 */
export class RtsbElFrontend {
	/**
	 * Creates a new instance of the RtsbElFrontend class.
	 *
	 * @param {jQuery} $ - The jQuery object.
	 */
	constructor($) {
		/**
		 * The jQuery object.
		 *
		 * @type {jQuery}
		 */
		this.$ = $;

		/**
		 * The container elements.
		 *
		 * @type {jQuery}
		 */
		this.containers = $('.rtsb-elementor-container');

		this.init();
	}

	/**
	 * Initializes the RTSB Elementor widgets on the page.
	 *
	 * @function
	 */
	init() {
		this.containers.each((i, el) => {
			const container = this.$(el),
				str = container.attr('data-layout'),
				isCarousel = container.find('.rtsb-carousel-slider');

			if (str) {
				this.addLoader(container);

				if (isCarousel.length) {
					this.initCarousel(container, isCarousel);
				} else {
					this.initImagesLoaded(container);
				}
			}
		});
	}

	/**
	 * Adds the loader element to the container if it doesn't already exist.
	 *
	 * @param {jQuery} container - The container element.
	 */
	addLoader(container) {
		const preLoader = container.find('.rtsb-pre-loader');

		if (preLoader.parent().find('.rtsb-elements-loading').length === 0) {
			preLoader.parent().append(helpers.addLoader());
		}
	}

	/**
	 * Initializes the carousel and removes the loader element when the slider is loaded.
	 *
	 * @param {jQuery} container  - The container element.
	 * @param {jQuery} isCarousel - The carousel element.
	 */
	initCarousel(container, isCarousel) {
		isCarousel.imagesLoaded(() => {
			isCarousel.rtsb_slider();

			this.$(document).on('rtsb_slider_loaded', () => {
				isCarousel.removeClass('slider-loading');
				isCarousel
					.addClass('rtsb-swiper-initialized')
					.find('.rtsb-gallery-slider')
					.addClass('rtsb-swiper-initialized');
				setTimeout(() => this.removeLoader(container), 300);
			});
		});
	}

	/**
	 * Removes the loader element when the images are loaded for non-carousel containers.
	 *
	 * @param {jQuery} container - The container element.
	 */
	initImagesLoaded(container) {
		container.imagesLoaded(() => {
			/**
			 * Remove Loading Animation
			 */
			this.removeLoader(container);
		});
	}

	/**
	 * Removes the loader element from the container.
	 *
	 * @param {jQuery}  container  - The container element.
	 * @param {boolean} isCarousel - Check if is carousel.
	 */
	removeLoader(container, isCarousel = false) {
		const loader = container.find('.rtsb-content-loader');

		setTimeout(() => {
			helpers.removeLoader(container, loader);
		}, 300);
	}
}
