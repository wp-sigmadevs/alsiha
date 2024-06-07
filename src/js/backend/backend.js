/**
 * Backend JS
 */

'use strict';

/**
 * Initializes the RtsbFrontend class and calls its methods on DOM ready and window load events
 *
 * @param {jQuery} $ - jQuery object
 */
(function ($) {
	const sigmaBackend = new SigmaFrontend();

	/**
	 * Calls the `domReady()` method of the `sigmaBackend` object when the DOM is ready
	 */
	$(document).ready(() => {
		sigmaBackend.domReady();
	});
})(jQuery);
