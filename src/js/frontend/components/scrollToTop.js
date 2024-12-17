/**
 * Handles the scroll to top action.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */
import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const scrollToTop = ($, vars) => {
	if (!helpers.elementExists(vars.toTop)) {
		return false;
	}

	const $progressPath = vars.toTop.find('path');
	const pathLength = $progressPath[0].getTotalLength();
	$progressPath.css({
		transition: 'none',
		WebkitTransition: 'none',
		strokeDasharray: `${pathLength} ${pathLength}`,
		strokeDashoffset: pathLength,
	});
	$progressPath[0].getBoundingClientRect();
	$progressPath.css({
		transition: 'stroke-dashoffset 10ms linear',
		WebkitTransition: 'stroke-dashoffset 10ms linear',
	});

	updateProgress(vars, $progressPath, pathLength);

	vars.window.on('scroll', () => {
		updateProgress(vars, $progressPath, pathLength);

		if (vars.window.scrollTop() > 50) {
			vars.toTop.addClass('active');
		} else {
			vars.toTop.removeClass('active');
		}
	});

	vars.toTop.on('click', (event) => {
		event.preventDefault();

		$('html, body').animate(
			{
				scrollTop: 0,
			},
			800
		);

		return false;
	});
};

/**
 * Updates the scroll progress indicator.
 *
 * @param {Object} vars          - Variables.
 * @param {Object} $progressPath - The jQuery object for the progress path element.
 * @param {number} pathLength    - The total length of the progress path.
 */
export const updateProgress = (vars, $progressPath, pathLength) => {
	const scroll = vars.window.scrollTop();
	const height = vars.document.height() - vars.window.height();
	const progress = pathLength - (scroll * pathLength) / height;

	$progressPath.css('strokeDashoffset', progress);
};
