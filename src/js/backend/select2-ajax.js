/**
 * Elementor Select2 Ajax Control JS
 */

'use strict';

import { sigmaAjaxSelect } from './components/ajaxSelect';

/**
 * Initializes the SigmaFrontend class and calls
 * its methods on DOM ready event.
 *
 * @param {jQuery} $ - jQuery object
 */
(($) => {
	/**
	 * Called when the DOM is ready.
	 */
	$(document).ready(() => {
		initElementorAjaxSelect();
	});

	const initElementorAjaxSelect = () => {
		$(document).on('sd_sigma_elementor_ajax_event', (event, obj) =>
			sigmaAjaxSelect(event, obj)
		);
	};
})(jQuery);
