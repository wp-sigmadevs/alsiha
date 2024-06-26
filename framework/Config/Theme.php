<?php
/**
 * Config Class: Theme.
 *
 * Theme data which are used through the theme, most of them are defined
 * by the style.css metadata. The data is being inserted in each class
 * that extends the Base abstract class.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Config;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Config Class: Theme.
 *
 * @since 1.0.0
 */
final class Theme {
	/**
	 * Get the theme data.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function data(): array {
		return array_merge(
			apply_filters(
				'sigmadevs/sigma/theme_data',
				$this->getThemeMetaData()
			),
			$this->getCustomData()
		);
	}

	/**
	 * Get custom data.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function getCustomData(): array {
		return [
			'settings'          => get_option( 'sd_alsiha_settings' ),
			'parent_theme_path' => wp_normalize_path( get_theme_file_path() ),
			'theme_path'        => get_template_directory(),
			'parent_theme_uri'  => trailingslashit( get_theme_file_uri() ),
			'theme_uri'         => get_template_directory_uri(),
			'assets'            => 'assets',
			'template_folder'   => 'templates',
			'theme_config_id'   => 'sigmadevs_sigma_theme',
		];
	}

	/**
	 * Get the theme metadata.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function getThemeMetaData(): array {
		$themeFile = get_stylesheet_directory() . '/style.css';

		return get_file_data(
			$themeFile,
			[
				'name'         => 'Theme Name',
				'version'      => 'Version',
				'uri'          => 'Theme URI',
				'text_domain'  => 'Text Domain',
				'domain_path'  => 'Domain Path',
				'namespace'    => 'Namespace',
				'required_php' => 'Requires PHP',
				'required_wp'  => 'Requires at least',
			]
		);
	}

	/**
	 * Get the theme path.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function parentThemePath(): string {
		return $this->data()['parent_theme_path'];
	}

	/**
	 * Get the theme URL.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function parentThemeUri(): string {
		return $this->data()['parent_theme_uri'];
	}

	/**
	 * Get the theme internal template path.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function templatePath(): string {
		return $this->data()['theme_path'] . '/' . $this->data()['template_folder'];
	}

	/**
	 * Get the theme assets URL.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function assetsUri(): string {
		return trailingslashit( $this->data()['parent_theme_uri'] . $this->data()['assets'] );
	}

	/**
	 * Get the theme settings.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function settings(): string {
		return $this->data()['settings'];
	}

	/**
	 * Get the theme version number.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function version(): string {
		return $this->data()['version'];
	}

	/**
	 * Get the theme name.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function name(): string {
		return $this->data()['name'];
	}

	/**
	 * Get the theme text domain.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function textDomain(): string {
		return $this->data()['text_domain'];
	}

	/**
	 * Get the theme language path.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function languagePath(): string {
		return $this->data()['domain_path'];
	}

	/**
	 * Get the theme required php version.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function requiredPhp(): string {
		return $this->data()['required_php'];
	}

	/**
	 * Get the theme required wp version.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function requiredWp(): string {
		return $this->data()['required_wp'];
	}

	/**
	 * Get the theme namespace.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function namespace(): string {
		return $this->data()['namespace'];
	}
}
