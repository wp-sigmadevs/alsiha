/**
 * Handles the header search functionality, including opening the search modal and
 * closing it when clicking on the overlay or close button.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */

/* global alsihaFrontendParams */

export const tempOGImageAjax = ($) => {
	$('body').on(
		'click',
		'.elementor-slideshow__share-links a:not(:last)',
		(e) => {
			e.preventDefault();
			const pageId = $('body').data('post-id');
			const imageSrc = $(e.currentTarget)
				.closest('.elementor-lightbox')
				.find('.elementor-lightbox-item img')
				.attr('src');

			if (!pageId || !imageSrc) {
				return;
			}

			$.ajax({
				url: alsihaFrontendParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'set_temp_og_image',
					page_id: pageId,
					image_src: imageSrc,
					[alsihaFrontendParams.nonceId]:
						alsihaFrontendParams.sd_alsiha_nonce,
				},
				success(response) {
					if (response.success) {
						console.log('Temporary OG image set.');

						let shareUrl = $(e.currentTarget).attr('href');
						const version = Date.now();

						shareUrl +=
							(shareUrl.includes('?') ? '&' : '?') +
							'fbrefresh=' +
							version;

						// Redirect to the anchor href
						window.open(shareUrl, '_blank');
					} else {
						console.warn('Error:', response.data);
					}
				},
				error() {
					console.error('AJAX request failed');
				},
			});
		}
	);
};
