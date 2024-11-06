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
		handheldMenuWrapper: $('#masthead'),
		handheldMenu: $('#alsiha-mobile-menu'),
		handheldMenuOpenerClass: $('.handheld-menu-trigger'),
		handheldCloseBtn: $('.alsiha-menu-close'),
		intelHeader: $('.intelligent-header'),
		preLoader: $('.alsiha-site-preloader'),
		sectionTitle: $('.alsiha-section-title h2'),
		toTop: $('.alsiha-scroll-to-top'),
		headerSpace: $('.fixed-header-space'),
		overlay: $('.alsiha-body-overlay'),
		topBannerSpacer: $('.top-banner-spacer'),
		headerSearchModal: $('#header-search'),
		headerSearchTrigger: $('header .search-trigger'),
		bgImage: $('[data-bg-image]'),
		showcaseSlider: $('.sigma-showcase-slider'),
		parallax: $('.alsiha-parallax'),
		exists: (el) => el.length > 0,
	};
};
