/**
 * Handles smooth scrolling.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */
export const smoothScroll = ($, vars) => {
	// direct browser to top right away
	if (window.location.hash) {
		scroll(0, 0);

		setTimeout(function () {
			scroll(0, 0);
		}, 1);
	}

	const pageName = '/';

	if (vars.body.hasClass('home')) {
		$('a[href^="' + pageName + '#"]').on('click', (event) => {
			let target = $(event.currentTarget).attr('href');
			vars.body.removeClass('has-active-menu');
			vars.handheldMenu.removeClass('is-active');
			vars.overlay.removeClass('open');

			if (target.length) {
				event.preventDefault
					? event.preventDefault()
					: (event.returnValue = false);

				target = $(target.replace(pageName, ''));

				$('html, body').animate(
					{
						scrollTop: target.offset().top - 100,
					},
					600
				);
			}
		});
	}

	if (window.location.hash) {
		// smooth scroll to the anchor id
		$('html,body').animate(
			{
				scrollTop: $(window.location.hash).offset().top - 100,
			},
			1000
		);
	}
};
