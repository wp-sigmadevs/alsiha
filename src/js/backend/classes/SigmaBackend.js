/**
 * A class that handles backend functionality.
 *
 * @class SigmaBackend
 */

import { sigmaAjaxSelect } from "../components/ajaxSelect";

export class SigmaBackend {
	/**
	 * Constructor for SigmaBackend class
	 */
	constructor() {
		this.$ = jQuery;
	}

	/**
	 * Initializes the SigmaBackend class when the DOM is ready.
	 *
	 * @function
	 */
	domReady = () => {
		this.initElementorAjaxSelect();
	};

	initElementorAjaxSelect = () => {
		$(document).on('sd_sigma_elementor_ajax_event', (event, obj) => sigmaAjaxSelect(event, obj, this.$));
	}

}
