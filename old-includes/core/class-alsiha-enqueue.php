<?php
/**
 * Main enqueue Class.
 *
 * This class registers all scripts & styles required for Alsiha Theme.
 *
 * @package Al-Siha
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Enqueue Class.
 *
 * @since  1.0.0
 */
class Alsiha_Enqueue {

	/**
	 * Accumulates scripts.
	 *
	 * @access protected
	 * @var array
	 *
	 * @since  1.0.0
	 */
	protected $enqueues = array();

	/**
	 * Method to register scripts.
	 *
	 * @access protected
	 * @return void|class
	 *
	 * @since  1.0.0
	 */
	protected function register_scripts() {

		if ( empty( $this->enqueues ) ) {
			return;
		}

		$wp_register_function = '';

		foreach ( $this->enqueues as $type => $enqueue ) {
			$wp_register_function = 'wp_register_' . $type;

			foreach ( $enqueue as $key ) {
				if ( isset( $key['load_in_footer'] ) ) {
					$load_in_footer = (bool) $key['load_in_footer'];
				} else {
					$load_in_footer = (bool) true;
				}

				$wp_register_function(
					isset( $key['handle'] ) ? $key['handle'] : '',
					isset( $key['asset_uri'] ) ? $key['asset_uri'] : '',
					isset( $key['dependency'] ) ? $key['dependency'] : array(),
					isset( $key['version'] ) ? $key['version'] : null,
					( 'style' === $type ) ? 'all' : $load_in_footer
				);
			}
		}

		return $this;
	}

	/**
	 * Method to enqueue scripts.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @return void|class
	 */
	protected function enqueue_scripts() {

		if ( empty( $this->enqueues ) ) {
			return $this;
		}

		$wp_enqueue_function = '';

		foreach ( $this->enqueues as $type => $enqueue ) {
			$wp_enqueue_function = 'wp_enqueue_' . $type;

			foreach ( $enqueue as $key ) {
				$wp_enqueue_function( $key['handle'] );
			}
		}

		return $this;
	}

	/**
	 * Method to enqueue styles only.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @return void
	 */
	protected function enqueue_only_styles() {

		if ( empty( $this->enqueues ) ) {
			return;
		}

		foreach ( $this->enqueues as $type => $enqueue ) {
			if ( 'style' === $type ) {
				foreach ( $enqueue as $key ) {
					wp_enqueue_style( $key['handle'] );
				}
			}
		}
	}

	/**
	 * Method to localize script.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @param array $args Localize args.
	 * @return void
	 */
	protected function localize( array $args ) {
		\wp_localize_script(
			$args['handle'],
			$args['js_object'],
			$args['vars']
		);
	}
}
