/**
 * A class that handles frontend functionality.
 *
 * @class SigmaFrontend
 */

import * as imports from '../components/imports';

export class SigmaFrontend {
	/**
	 * jQuery instance for DOM manipulation.
	 *
	 * @type {jQuery}
	 */
	$ = jQuery;

	/**
	 * Constructor for SigmaFrontend class.
	 * Initializes and imports necessary for functionality.
	 */
	constructor() {
		this.initializeImports();
		this.initializeVars();
	}

	/**
	 * Initialize imported functions.
	 *
	 * @function
	 */
	initializeImports = () => {
		this.initVars = imports.initVars;
		this.headerSearchAction = imports.headerSearchAction;
	};

	/**
	 * Initialize vars using initVars.
	 *
	 * @function
	 */
	initializeVars = () => {
		this.vars = this.initVars(this.$);
	};

	/**
	 * Initializes the SigmaFrontend class when the DOM is ready.
	 *
	 * @function
	 */
	domReady = () => {
		this.headerSearchAction(this.$, this.vars);
	};

	/**
	 * Initializes the SigmaFrontend class when the DOM is loaded.
	 *
	 * @function
	 */
	domLoad() {
		console.log('load');
	}

	/**
	 * Initializes the SigmaFrontend class when the DOM is resized.
	 *
	 * @function
	 */
	domResize() {}
}
