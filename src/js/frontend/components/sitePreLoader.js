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

	// let totalAssets = 0;
	// let loadedAssets = 0;
	//
	// const updateProgressBar = () => {
	// 	const progress = (loadedAssets / totalAssets) * 100;
	// 	vars.preLoader.find('.logo').css('--progress-width', progress + '%');
	// };
	//
	// // Start counting total assets (images, scripts, etc.)
	// $('img, script, link, style').each(function () {
	// 	totalAssets++;
	// });
	//
	// // Track when each asset is loaded
	// $('img, script, link').on('load', function () {
	// 	loadedAssets++;
	// 	updateProgressBar();
	// });
	//
	// // Once the document is fully loaded
	// $(window).on('load', function () {
	// 	updateProgressBar();
	//
	// 	vars.preLoader.fadeOut('fast');
	// });

	let totalAssets = 0;
	let loadedAssets = 0;
	let progress = 0;

// Function to update the progress bar
	const updateProgressBar = () => {
		progress = (loadedAssets / totalAssets) * 100;
		vars.preLoader.find('.logo').css('--progress-width', progress + '%');

		// When progress reaches 100%
		if (progress >= 100) {
			setTimeout(() => {
				vars.preLoader.fadeOut(700); // Fade out preloader
			}, 700);
		}
	};

// Function to track assets (images, styles, scripts, fonts)
	const trackAssets = () => {
		// Track images, styles, and scripts
		const elementsToTrack = $('img, link[rel="stylesheet"], script');

		// Add number of elements to totalAssets
		totalAssets = elementsToTrack.length;

		// Bind the load event to each element
		elementsToTrack.each(function () {
			if (this.complete) {
				loadedAssets++; // If the element is already loaded
				updateProgressBar();
			} else {
				$(this).on('load', function () {
					loadedAssets++; // Update when each element is loaded
					updateProgressBar();
				});
			}
		});

		// Track font loading
		if (document.fonts && document.fonts.ready) {
			document.fonts.ready.then(() => {
				totalAssets++; // Increment totalAssets for fonts
				loadedAssets++; // Font loading complete
				updateProgressBar();
			});
		}
	};

// Run the asset tracking when the document is ready
	$(document).ready(function () {
		trackAssets();

		// Also check the window load event to ensure all elements are loaded
		$(window).on('load', function () {
			loadedAssets = totalAssets; // If window has finished loading, set loaded assets to total
			updateProgressBar();
		});
	});

};
