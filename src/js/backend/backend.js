/**
 * Backend JS
 */

'use strict';

import { SigmaBackend } from './classes/SigmaBackend';

/**
 * Initializes the SigmaFrontend class and calls
 * its methods on DOM ready event.
 *
 * @param {jQuery} $ - jQuery object
 */
(($) => {
	const sigmaBackend = new SigmaBackend();

	/**
	 * Calls the `domReady()` method of the `sigmaBackend` object
	 * when the DOM is ready
	 */
	$(document).ready(() => {
		sigmaBackend.domReady();
	});
})(jQuery);
