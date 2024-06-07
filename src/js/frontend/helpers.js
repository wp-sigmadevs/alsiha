/**
 * A helper object that contains various utility functions
 *
 * @constant
 * @type {Object}
 */

export const rtsbFrontendHelpers = {
	/**
	 *Initializes tooltips for an element.
	 *
	 * @function
	 * @param {jQuery} $element - The jQuery object for the element.
	 * @param {string} position - The position of the tooltip.
	 */
	tooltips: ($element, position) => {
		let tooltipDirection = 's';

		switch (position) {
			case 'left':
				tooltipDirection = 'e';
				break;

			case 'right':
				tooltipDirection = 'w';
				break;

			case 'top':
				tooltipDirection = 's';
				break;

			case 'bottom':
				tooltipDirection = 'n';
				break;

			default:
				tooltipDirection = 's';
				break;
		}

		$element.tipsy({ fade: true, gravity: tooltipDirection, offset: 5, opacity: 1 });
	},

	/**
	 * Performs an AJAX action.
	 *
	 * @function
	 * @param {string}   ajaxUrl      - The URL for the AJAX request.
	 * @param {Object}   data         - The data to be sent with the AJAX request.
	 * @param {Function} onBeforeSend - The function to be called before the AJAX request is sent.
	 * @param {Function} onSuccess    - The function to be called when the AJAX request is successful.
	 * @param {Function} onError      - The function to be called when the AJAX request fails.
	 * @param {Object}   args         - Additional arguments to be passed to the callback functions.
	 */
	ajaxAction: (
		ajaxUrl,
		data,
		onBeforeSend,
		onSuccess,
		onError,
		args = {}
	) => {
		jQuery.ajax({
			url: ajaxUrl,
			data,
			type: 'POST',

			beforeSend() {
				onBeforeSend(args);
			},

			success(response) {
				onSuccess(response, args);
			},

			error() {
				onError(args);
			},
		});
	},

	/**
	 * Returns a loader HTML string.
	 *
	 * @function
	 */
	addLoader: () =>
		'<div class="rtsb-elements-loading rtsb-ball-clip-rotate">' +
		'<div></div>' +
		'</div>',

	/**
	 * Removes a loader from a container element.
	 *
	 * @function
	 * @param {jQuery} container - The jQuery object for the container element.
	 * @param {jQuery} loader    - The jQuery object for the loader element.
	 */
	removeLoader: (container, loader) => {
		const elementsToUnload = container.find(
			'.rtsb-content-loader, .rtsb-pagination-wrap, .rtsb-tab-filters'
		);
		elementsToUnload.removeClass('element-loading');
		container.find('.rtsb-pagination-wrap').removeClass('loading');

		const elementsLoading = loader.parent().find('.rtsb-elements-loading');
		elementsLoading.fadeOut(300, () => {
			elementsLoading.remove();
		});

		loader.removeClass('rtsb-pre-loader reduced-opacity exiting');
		loader.find('.swiper-wrapper').removeClass('rtsb-pre-loader');
	},
};
