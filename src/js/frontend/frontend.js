/**
 * Frontend JS.
 */

'use strict';

import { SigmaFrontend } from './classes/SigmaFrontend';

/**
 * Initializes the SigmaFrontend class and calls its methods on DOM ready and window load events
 *
 * @function
 * @param {jQuery} $ - jQuery object
 */
(($) => {
	const sigmaFrontend = new SigmaFrontend();

	/**
	 * Calls the `domReady()` method of the `sigmaFrontend` object when the DOM is ready
	 *
	 * @function
	 */
	$(document).ready(() => {
		sigmaFrontend.domReady();
	});

	/**
	 * Calls the `domLoad()` method of the `sigmaFrontend` object when the window is loaded
	 *
	 * @function
	 */
	$(window).on('load', () => {
		sigmaFrontend.domLoad();
	});

	/**
	 * Calls the `domResize()` method of the `sigmaFrontend` object when the window is resized
	 *
	 * @function
	 */
	$(window).on('resize', () => {
		sigmaFrontend.domResize();
	});
})(jQuery);
