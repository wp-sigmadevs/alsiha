/**
 * Handles the header search functionality, including opening the search modal and
 * closing it when clicking on the overlay or close button.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */

import Headroom from 'headroom.js';
import { elementExists } from '../utils';

export const intelligentHeader = ($, vars) => {
	if (!elementExists(vars.intelHeader)) {
		return false;
	}

	const options = {
		offset: {
			up: 50,
			down: 100,
		},
		tolerance: {
			up: 0,
			down: 5,
		},
		classes: {
			initial: 'iheader',
			pinned: 'iheader--pinned',
			unpinned: 'iheader--unpinned',
			top: 'iheader--top',
			notTop: 'iheader--not-top',
			bottom: 'iheader--bottom',
			notBottom: 'iheader--not-bottom',
			frozen: 'iheader--frozen',
		},
	};

	const headroom = new Headroom(vars.intelHeader.get(0), options);

	headroom.init();
};
