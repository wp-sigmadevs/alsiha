/**
 * Handles the header search functionality, including opening the search modal and
 * closing it when clicking on the overlay or close button.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */

import 'superfish';
import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const primaryNav = ($, vars) => {
	if (!helpers.elementExists(vars.mainMenu)) {
		return false;
	}

	primaryNavInit(vars);
	primaryNavSubmenuAction($, vars);
};

const primaryNavInit = (vars) => {
	vars.mainMenu.superfish({
		delay: 0,
		animation: { opacity: 'show' },
		animationOut: { opacity: 'hide' },
		speed: 'fast',
		autoArrows: false,
		disableHI: true,
	});
};

const primaryNavSubmenuAction = ($, vars) => {
	vars.document.on('mouseenter', '.sf-menu .sub-menu', (el) => {
		const menu = $(el.currentTarget);
		const child = $(el.currentTarget).find('ul');

		if (
			$(menu).offset().left + $(menu).width() + $(child).width() >
			$(window).width()
		) {
			$(child).css({ left: 'inherit', right: '100%' });
		}
	});
};
