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
import { handheldNav } from './handheldNav';
import { backgroundImage } from './backgroundImage';
import { showcaseSlider } from './showcaseSlider';

// Export all imported items
export {
	initVars,
	headerSearchAction,
	headerPlaceholderSpace,
	topBannerHeight,
	intelligentHeader,
	primaryNav,
	handheldNav,
	backgroundImage,
	showcaseSlider,
};
