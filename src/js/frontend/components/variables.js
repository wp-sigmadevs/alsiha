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
		handheldCloseBtn: $('.alsiha-menu-close'),
		intelHeader: $('.intelligent-header'),
		preLoader: $('.alsiha-site-preloader'),
		toTop: $('.alsiha-scroll-to-top'),
		headerSpace: $('.fixed-header-space'),
		overlay: $('.alsiha-body-overlay'),
		topBannerSpacer: $('.top-banner-spacer'),
		headerSearchModal: $('#header-search'),
		headerSearchTrigger: $('header .search-trigger'),
		exists: (el) => el.length > 0,
	};
};
