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

	// Detect if it's a mobile device
	const isMobile = window.matchMedia('(max-width: 767px)').matches;

	if (isMobile) {
		let progress = 0;

		const interval = setInterval(() => {
			progress += 1;
			vars.preLoader
				.find('.logo')
				.css('--progress-width', `${progress}%`);

			// Once progress reaches 100%
			if (progress >= 100) {
				clearInterval(interval);
				setTimeout(() => {
					vars.preLoader.fadeOut(700);
				}, 700);
			}
		}, 20);

		$(window).on('beforeunload', () => {
			vars.preLoader.find('.logo').css('--progress-width', 0);
			vars.preLoader.fadeIn(300);
		});
	} else {
		// Dynamic asset-based loader for desktop
		let totalAssets = 0;
		let loadedAssets = 0;
		let progress = 0;

		const updateProgressBar = () => {
			progress = (loadedAssets / totalAssets) * 100;
			vars.preLoader
				.find('.logo')
				.css('--progress-width', progress + '%');

			if (progress >= 100) {
				setTimeout(() => {
					vars.preLoader.fadeOut(700);
				}, 700);
			}
		};

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
	}
};
