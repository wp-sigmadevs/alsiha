/**
 * Review Form Star Product single page Product Tabs/Product Reviews Conflict fix
 *
 * @param {Object} $
 */

export const rtsbReviewFormStar = ($) => {
	setTimeout(function () {
		$('#respond').find('.stars').not(':first').remove();
	}, 100);
};
