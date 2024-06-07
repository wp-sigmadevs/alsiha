/**
 * Customizer preview JS.
 */

/* global jQuery */

'use strict';

import {SigmaCustomizer} from "./classes/SigmaCustomizer";

/**
 * Initializes the SigmaCustomizer class on DOM ready event.
 *
 * @param {jQuery} $ - jQuery object
 */
(($) => {
	/**
	 * Calls the `domReady()` method of the `sigmaCustomizer` object
	 * when the DOM is ready
	 */
	$(document).ready(() => {
		new SigmaCustomizer();
	});
})(jQuery);
