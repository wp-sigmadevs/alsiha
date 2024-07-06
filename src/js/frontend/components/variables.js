/**
 * Init variables
 *
 * @param {jQuery} $ - The jQuery object.
 */

export const initVars = ($) => {
	return {
		window: $(window),
		document: $(document),
		body: $('body'),
		mainMenu: $('.sf-menu'),
		handheldMenu: $('.alsiha-handheld-menu'),
		intelHeader: $('.intelligent-header'),
		preLoader: $('.alsiha-site-preloader'),
		toTop: $('.alsiha-scroll-to-top'),
		headerSpace: $('.fixed-header-space'),
		overlay: $('.alsiha-body-overlay'),
		headerSearchModal: $('#header-search'),
		headerSearchTrigger: $('header .search-trigger'),
	};
};
