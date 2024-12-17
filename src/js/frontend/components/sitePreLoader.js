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

	const hidePreloader = () => {
		vars.preLoader.fadeOut(700);
	};

	const showPreloader = () => {
		vars.preLoader.find('.logo').css('--progress-width', '0%');
		vars.preLoader.fadeIn(300);
	};

	let lastClickedLink = null;

	// Event listener to track clicks on document
	$(document).on('click', (event) => {
		const link = $(event.target).closest('a');

		if (link.length > 0) {
			lastClickedLink = link.attr('href');
		}
	});

	const shouldShowPreloader = (
		event,
		excludeProtocols = ['tel:', 'mailto:', '#']
	) => {
		if (lastClickedLink) {
			if (
				excludeProtocols.some((protocol) =>
					lastClickedLink.startsWith(protocol)
				)
			) {
				lastClickedLink = null;

				return false;
			}
		}

		return true;
	};

	const exclude = [
		'tel:',
		'mailto:',
		'#',
		'javascript:',
		'ftp:',
		'sms:',
		'whatsapp:',
	];

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
				setTimeout(hidePreloader, 700);
			}
		}, 20);

		$(window).on('beforeunload', (event) => {
			if (shouldShowPreloader(event, exclude)) {
				showPreloader();
			}
		});

		setTimeout(() => {
			$(window).on('pageshow', hidePreloader);
		}, 2000);
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

			$(window).on('beforeunload', (event) => {
				if (shouldShowPreloader(event, exclude)) {
					showPreloader();
				}
			});

			setTimeout(() => {
				$(window).on('pageshow', hidePreloader);
			}, 2000);
		});
	}
};
