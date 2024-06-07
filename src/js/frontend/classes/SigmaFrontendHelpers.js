/**
 * Frontend Helpers class.
 */
export class SigmaFrontendHelpers {
	/**
	 *Initializes tooltips for an element.
	 *
	 * @function
	 * @param {jQuery} $element - The jQuery object for the element.
	 * @param {string} position - The position of the tooltip.
	 */
	tooltips = ($element, position) => {
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
	};

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
	ajaxAction = (
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
	};
}
