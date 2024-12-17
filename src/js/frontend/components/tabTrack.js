/**
 * Handles the tab track functionality
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */

import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const tabTrack = ($, vars) => {
	if (!helpers.elementExists(vars.tab)) {
		return false;
	}

	const filterTrackContainer = vars.tab.find('.elementor-tabs-wrapper');
	const wrapperClass = 'alsiha-tab-content';

	$('.elementor-tab-content').each((i, el) => {
		const element = $(el);

		if (!element.find(`.${wrapperClass}`).length) {
			element.children().wrapAll(`<div class="${wrapperClass}"></div>`);
		}
	});

	adjustTrack(
		$,
		filterTrackContainer,
		'.elementor-tab-title',
		'[aria-selected="true"]'
	);
};

/**
 * Helper function to adjust the track position
 *
 * @param {Object} $              - The jQuery object.
 * @param {jQuery} container      - The container element.
 * @param {string} trackSelector  - The CSS selector for trackable elements.
 * @param {string} activeSelector - The CSS selector for the currently active element.
 */
const adjustTrack = ($, container, trackSelector, activeSelector) => {
	const trackItemClass = 'alsiha-filter-track';
	const newChildDiv = $('<div>', { class: trackItemClass });
	container.append(newChildDiv);

	const track = container.find(trackSelector);
	const selectedTrack = track.filter(activeSelector);
	const trackItem = container.find(`.${trackItemClass}`);

	if (selectedTrack.length > 0) {
		const trackPosition = selectedTrack.position();

		trackItem.css({
			left: `${trackPosition.left}px`,
			width: `${selectedTrack.outerWidth()}px`,
		});
	} else {
		trackItem.css({ width: 0 });
	}

	container.on('click touchstart', trackSelector, (event) => {
		const target = $(event.currentTarget);
		const position = target.position();

		trackItem.css({
			left: `${position.left}px`,
			width: `${target.outerWidth()}px`,
		});
	});
};
