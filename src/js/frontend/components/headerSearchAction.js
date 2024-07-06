/**
 * Handles the header search functionality, including opening the search modal and
 * closing it when clicking on the overlay or close button.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */

export const headerSearchAction = ($, vars) => {
	// Trigger the search modal
	vars.headerSearchTrigger.on('click', (event) => {
		event.preventDefault();

		vars.headerSearchModal.add(vars.overlay).addClass('open');
		vars.headerSearchModal.find('input[type="search"]').focus();
	});

	// Handle click on the overlay or close button to close the modal
	$(vars.overlay)
		.add(vars.headerSearchModal.find('button.close'))
		.on('click', (event) => {
			if (
				$(event.currentTarget).hasClass('open') ||
				event.currentTarget.className === 'close'
			) {
				vars.headerSearchModal.add(vars.overlay).removeClass('open');
			}
		});
};
