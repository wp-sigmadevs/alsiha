/**
 * Sets the background image for elements.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */
import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const backgroundImage = ($, vars) => {
	if (!helpers.elementExists(vars.bgImage)) {
		return false;
	}

	$(vars.bgImage).each((_, el) => {
		const element = $(el);
		const img = element.data('bg-image');

		element.css({
			backgroundImage: 'url(' + img + ')',
		});
	});
};
