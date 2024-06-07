/**
 * Device check.
 *
 * @param {jQuery} $     - The jQuery object.
 * @param {number} width - Device width.
 */

export const rtsbDeviceBreak = ($, width) => {
	const screenWidth = $(window).width();

	return screenWidth <= width;
};
