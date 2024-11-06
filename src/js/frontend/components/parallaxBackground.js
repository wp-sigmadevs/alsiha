/**
 * Handles the section parallax background.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */
import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const parallaxBackground = ($, vars) => {
	if (!helpers.elementExists(vars.parallax)) {
		return false;
	}

	vars.parallax.each((i, el) => {
		const parallax = $(el);

		parallax.parallaxie({
			speed: 0.5,
			offset: 0,
		});
	});
};
