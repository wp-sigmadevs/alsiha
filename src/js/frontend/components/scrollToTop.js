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

	const progressPath = document.querySelector('.scroll-wrap path');
	const pathLength = progressPath.getTotalLength();
	progressPath.style.transition = progressPath.style.WebkitTransition =
		'none';
	progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
	progressPath.style.strokeDashoffset = pathLength;
	progressPath.getBoundingClientRect();
	progressPath.style.transition = progressPath.style.WebkitTransition =
		'stroke-dashoffset 10ms linear';
	const updateProgress = function () {
		const scroll = $(window).scrollTop();
		const height = $(document).height() - $(window).height();
		const progress = pathLength - (scroll * pathLength) / height;
		progressPath.style.strokeDashoffset = progress;
	};
	updateProgress();
	$(window).scroll(updateProgress);
	const offset = 50;
	const duration = 10;
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > offset) {
			$('.scroll-wrap').addClass('active-scroll');
		} else {
			$('.scroll-wrap').removeClass('active-scroll');
		}
	});
	vars.toTop.on('click', function (event) {
		event.preventDefault();
		$('html, body').animate(
			{
				scrollTop: 0,
			},
			duration
		);
		return false;
	});
};
