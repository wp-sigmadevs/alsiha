/**
 * Handles the header search functionality, including opening the search modal and
 * closing it when clicking on the overlay or close button.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */

import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const headerPlaceholderSpace = ($, vars) => {
	if (!helpers.elementExists(vars.intelHeader)) {
		return false;
	}

	const intHeight = vars.intelHeader[0].getBoundingClientRect().height;
	vars.headerSpace.height(intHeight);
};
