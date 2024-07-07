/**
 * Utility functions for common tasks in the project.
 *
 * @module utils
 */

/**
 * Checks if a jQuery element exists (i.e., its length is greater than 0).
 *
 * @param {jQuery} $element - The jQuery element to check.
 * @return {boolean} True if the element exists, false otherwise.
 */
export const elementExists = ($element) => {
	return $element.length > 0;
};
