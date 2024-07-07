/**
 * Handles the header search functionality, including opening the search modal and
 * closing it when clicking on the overlay or close button.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */

import { elementExists } from '../utils';

export const topBannerHeight = ($, vars) => {
	if (!elementExists(vars.topBannerSpacer)) {
		return false;
	}

	const headerHeight = vars.intelHeader[0].getBoundingClientRect().height;
	const viewportHeight = window.innerHeight;
	const bannerHeight = viewportHeight - headerHeight + 20;
	vars.topBannerSpacer.height(`${bannerHeight}px`);
};
