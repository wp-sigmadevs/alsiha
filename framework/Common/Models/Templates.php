<?php
/**
 * Model Class: Templates
 *
 * This class is responsible for loading frontend templates.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace SigmaDevs\Sigma\Common\Models;

/**
 * Class: Templates
 *
 * @package ThePluginName\App\Backend
 * @since 1.0.0
 */
class Templates {
	/**
	 * Internal use only: Store located template paths.
	 *
	 * @var array
	 */
	private $path_cache = [];

	/**
	 * Retrieve a template part, modified version of:
	 *
	 * @url https://github.com/GaryJones/Gamajo-Template-Loader
	 *
	 * @param string $slug Template slug.
	 * @param string $name Optional. Template variation name. Default null.
	 * @param array  $args Optional. Template args. Default empty.
	 * @param bool   $load Optional. Whether to load template. Default true.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function get( $slug, $name = null, $args = [], $load = true ) {
		// Execute code for this part.
		do_action( 'get_template_part_' . $slug, $slug, $name, $args );
		do_action( 'sd/sigma/get_template_part_' . $slug, $slug, $name, $args );

		// Get files names of templates, for given slug and name.
		$templates = $this->getFileNames( $slug, $name, $args );

		// Return the part that is found.
		return $this->locate( $templates, $load, false, $args );
	}

	/**
	 * Given a slug and optional name, create the file names
	 * of templates, modified version of:
	 *
	 * @url https://github.com/GaryJones/Gamajo-Template-Loader
	 *
	 * @param string $slug Template slug.
	 * @param string $name Template variation name.
	 * @param array  $args Template args.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	protected function getFileNames( $slug, $name, $args ) {
		$templates = [];

		if ( isset( $name ) ) {
			$templates[] = $slug . '-' . $name . '.php';
		}

		$templates[] = $slug . '.php';

		/**
		 * Allow template choices to be filtered.
		 *
		 * The resulting array should be in the order of most specific first,
		 * to the least specific last.
		 * e.g. 0 => recipe-instructions.php, 1 => recipe.php
		 *
		 * @param array $templates Names of template files that should be looked for, for given slug and name.
		 * @param string $slug Template slug.
		 * @param string $name Template variation name.
		 * @since 1.0.0
		 */
		return apply_filters( 'sd/sigma/get_template_part', $templates, $slug, $name, $args );
	}


	/**
	 * Retrieve the name of the highest priority template file that exists, modified version of:
	 *
	 * @url https://github.com/GaryJones/Gamajo-Template-Loader
	 *
	 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
	 * inherit from a parent theme can just overload one file. If the template
	 * is not found in either of those, it looks in the theme-compat
	 * folder last.
	 *
	 * @param string|array $templateNames Template file(s) to search for, in order.
	 * @param bool         $load If true the template file will be loaded if it is found.
	 * @param bool         $requireOnce Whether to require_once or require. Default true. Has no effect if $load is false.
	 * @param array        $args Template args.
	 * @return string The template filename if one is located.
	 * @since 1.0.0
	 */
	public function locate( $templateNames, $load = false, $requireOnce = true, $args = [] ) {
		// Use $templateNames as a cache key - either first element of array or the variable itself if it's a string.
		$cacheKey = is_array( $templateNames ) ? $templateNames[0] : $templateNames;

		// If the key is in the cache array, we've already located this file.
		if ( isset( $this->path_cache[ $cacheKey ] ) ) {
			$located = $this->path_cache[ $cacheKey ];
		} else {
			// No file found yet.
			$located = false;

			// Remove empty entries.
			$templateNames = array_filter( (array) $templateNames );
			$templatePaths = $this->getPaths();

			// Try to find a template file.
			foreach ( $templateNames as $templateName ) {
				// Trim off any slashes from the template name.
				$templateName = ltrim( $templateName, '/' );

				// Try locating this template file by looping through the template paths.
				foreach ( $templatePaths as $template_path ) {
					if ( file_exists( $template_path . $templateName ) ) {
						$located = $template_path . $templateName;
						// Store the template path in the cache.
						$this->path_cache[ $cacheKey ] = $located;
						break 2;
					}
				}
			}
		}

		if ( $load && $located ) {
			load_template( $located, $requireOnce, $args );
		}

		return $located;
	}

	/**
	 * Return a list of paths to check for template locations,
	 * modified version of:
	 *
	 * @url https://github.com/GaryJones/Gamajo-Template-Loader
	 *
	 * Default is to check in a child theme (if relevant) before a parent theme, so that themes which inherit from a
	 * parent theme can just overload one file. If the template is not found in either of those, it looks in the
	 * theme-compat folder last.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	protected function getPaths() {
		$themeDirectory = trailingslashit( sd_alsiha()->getData()['ext_template_folder'] );

		$filePaths = [
			10  => trailingslashit( get_template_directory() ) . $themeDirectory,
			100 => sd_alsiha()->templatesPath(),
		];

		// Only add this conditionally, so non-child themes don't redundantly check active theme twice.
		if ( get_stylesheet_directory() !== get_template_directory() ) {
			$filePaths[1] = trailingslashit( get_stylesheet_directory() ) . $themeDirectory;
		}

		/**
		 * Allow ordered list of template paths to be amended.
		 *
		 * @param array $var Default is directory in child theme at index 1, parent theme at 10, and plugin at 100.
		 * @since 1.0.0
		 */
		$filePaths = apply_filters( 'sd/sigma/template_paths', $filePaths );

		// Sort the file paths based on priority.
		ksort( $filePaths, SORT_NUMERIC );

		return array_map( 'trailingslashit', $filePaths );
	}
}
