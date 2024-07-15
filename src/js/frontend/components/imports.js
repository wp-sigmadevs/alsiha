/**
 * Module for managing imports in the project.
 *
 * This module centralizes all import statements for better organization
 * and clarity in the main project files.
 *
 * @module imports
 */

// Import statements for main file
import { initVars } from './variables';
import { headerSearchAction } from './headerSearchAction';
import { headerPlaceholderSpace } from './headerPlaceholderSpace';
import { topBannerHeight } from './topBannerHeight';
import { intelligentHeader } from './intelligentHeader';
import { primaryNav } from './primaryNav';

// Export all imported items
export {
	initVars,
	headerSearchAction,
	headerPlaceholderSpace,
	topBannerHeight,
	intelligentHeader,
	primaryNav,
};
