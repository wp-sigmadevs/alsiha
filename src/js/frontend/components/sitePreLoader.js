/**
 * Site Pre-loader.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */
import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const sitePreLoader = ($, vars) => {
	if (!helpers.elementExists(vars.preLoader)) {
		return false;
	}

	let totalAssets = 0;
	let loadedAssets = 0;
	let progress = 0;

	/**
	 * Update the progress bar.
	 */
	const updateProgressBar = () => {
		progress = (loadedAssets / totalAssets) * 100;
		vars.preLoader.find('.logo').css('--progress-width', progress + '%');

		// When progress reaches 100%
		if (progress >= 100) {
			setTimeout(() => {
				vars.preLoader.fadeOut(700);
			}, 700);
		}
	};

	/**
	 * Track assets (images, styles, scripts, fonts).
	 */
	const trackAssets = () => {
		const elementsToTrack = $('img');
		totalAssets = elementsToTrack.length;

		elementsToTrack.each((i, el) => {
			if (el.complete) {
				loadedAssets++;
				updateProgressBar();
			} else {
				$(el).on('load', () => {
					loadedAssets++;
					updateProgressBar();
				});
			}
		});

		// Track font loading
		if (document.fonts && document.fonts.ready) {
			document.fonts.ready.then(() => {
				totalAssets++;
				loadedAssets++;

				updateProgressBar();
			});
		}
	};

	$(document).ready(() => {
		trackAssets();

		$(window).on('load', () => {
			loadedAssets = totalAssets;
			updateProgressBar();

			setTimeout(() => {
				loadedAssets = 0;
			}, 2000);
		});

		$(window).on('beforeunload', () => {
			vars.preLoader.find('.logo').css('--progress-width', 0);
			vars.preLoader.fadeIn(300);
		});
	});
};
