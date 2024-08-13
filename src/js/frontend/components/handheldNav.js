/**
 * Handles the mobile menu functionality, including opening and closing the menu,
 * and managing submenu behavior.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */

import { SigmaHandheldMenu } from '../classes/SigmaHandheldMenu';
import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const handheldNav = ($, vars) => {
	if (!helpers.elementExists(vars.handheldMenu)) {
		return false;
	}

	handheldNavInit($, vars);
	handheldNavSubmenuAction($, vars);
};

const handheldNavInit = ($, vars) => {
	const handheldMenu = new SigmaHandheldMenu({
		wrapper: vars.handheldMenuWrapper,
		menu: vars.handheldMenu,
		menuOpenerClass: vars.handheldMenuOpenerClass,
		maskId: vars.overlay,
		closeBtn: vars.handheldCloseBtn,
	});

	const handheldMenuBtn = $('#alsiha-trigger-button');
	handheldMenuBtn.on('click', (e) => {
		e.preventDefault();
		handheldMenu.open();
	});
};

const handheldNavSubmenuAction = ($, vars) => {
	vars.handheldMenu.find('li a').each((i, el) => {
		if ($(el).next().length > 0) {
			$(el)
				.parent('li')
				.addClass('has-child')
				.append(
					'<a class="drawer-toggle" href="#"><i class="fa fa-angle-down"></i></a>'
				);
		}
	});

	// expands the dropdown menu on each click
	vars.handheldMenu.find('li .drawer-toggle').on('click', (e) => {
		e.preventDefault();
		$(e.currentTarget)
			.parent('li')
			.children('ul')
			.stop(true, true)
			.slideToggle(250);
		$(e.currentTarget).parent('li').toggleClass('open');
	});
};
