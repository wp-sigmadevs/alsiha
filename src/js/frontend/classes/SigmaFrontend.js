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
		this.headerPlaceholderSpace = imports.headerPlaceholderSpace;
		this.topBannerHeight = imports.topBannerHeight;
		this.intelligentHeader = imports.intelligentHeader;
		this.primaryNav = imports.primaryNav;
		this.handheldNav = imports.handheldNav;
		this.backgroundImage = imports.backgroundImage;
		this.showcaseSlider = imports.showcaseSlider;
		this.sitePreLoader = imports.sitePreLoader;
		this.sectionTitleAction = imports.sectionTitleAction;
		this.parallaxBackground = imports.parallaxBackground;
		this.scrollToTop = imports.scrollToTop;
		this.smoothScroll = imports.smoothScroll;
		this.tabTrack = imports.tabTrack;
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
		this.headerPlaceholderSpace(this.$, this.vars);
		this.topBannerHeight(this.$, this.vars);
		this.intelligentHeader(this.$, this.vars);
		this.primaryNav(this.$, this.vars);
		this.handheldNav(this.$, this.vars);
		this.backgroundImage(this.$, this.vars);
		this.showcaseSlider(this.$, this.vars);
		this.sitePreLoader(this.$, this.vars);
		this.sectionTitleAction(this.$, this.vars);
		this.parallaxBackground(this.$, this.vars);
		this.scrollToTop(this.$, this.vars);
		this.smoothScroll(this.$, this.vars);
		this.tabTrack(this.$, this.vars);
	};

	/**
	 * Initializes the SigmaFrontend class when the DOM is loaded.
	 *
	 * @function
	 */
	domLoad() {}

	/**
	 * Initializes the SigmaFrontend class when the DOM is resized.
	 *
	 * @function
	 */
	domResize() {
		this.headerPlaceholderSpace(this.$, this.vars);
		this.topBannerHeight(this.$, this.vars);
		this.primaryNav(this.$, this.vars);
	}
}
