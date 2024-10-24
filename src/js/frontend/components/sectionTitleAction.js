/**
 * Handles the section title underline.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */
import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const sectionTitleAction = ($, vars) => {
	if (!helpers.elementExists(vars.sectionTitle)) {
		return false;
	}

	vars.sectionTitle.each((i, el) => {
		const words = $(el).text().split(' ');

		$(el)
			.empty()
			.html(() => {
				let result = '';
				for (let j = 0; j < words.length; j++) {
					if (j === 0 && words[j]) {
						result += '<span>' + words[j] + '</span>';
					} else if (words[j]) {
						result += ' <span>' + words[j] + '</span>';
					}
				}
				return result;
			});
	});
};
