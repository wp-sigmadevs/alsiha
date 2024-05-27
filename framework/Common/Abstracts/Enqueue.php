<?php
/**
 * Abstract Class: Enqueue.
 *
 * The Enqueue class which can be extended by other
 * classes to registers all scripts & styles.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Abstracts;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Abstract Class: Enqueue.
 *
 * @since 1.0.0
 */
abstract class Enqueue extends Base {
	/**
	 * Holds script file name suffix.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected $suffix = null;

	/**
	 * Array to accumulate scripts and styles.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected $enqueues = [];

	/**
	 * Class Constructor.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();

		$this->suffix = '.min';
	}

	/**
	 * Register scripts and styles.
	 *
	 * @return void|$this
	 * @since 1.0.0
	 */
	protected function registerScripts() {
		// Bail if no scripts.
		if ( empty( $this->enqueues ) ) {
			return;
		}

		foreach ( $this->enqueues as $type => $enqueue ) {
			$registerFunction = '\wp_register_' . $type;

			foreach ( $enqueue as $key ) {
				$loadInFooter = $key['in_footer'] ?? true;

				$registerFunction(
					$key['handle'] ?? '',
					$key['asset_uri'] ?? '',
					$key['dependency'] ?? [],
					$key['version'] ?? null,
					( 'style' === $type ) ? 'all' : $loadInFooter
				);
			}
		}

		return $this;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @return void|$this
	 * @since 1.0.0
	 */
	protected function enqueueScripts() {

		if ( empty( $this->enqueues ) ) {
			return;
		}

		foreach ( $this->enqueues as $type => $enqueue ) {
			$enqueueFunction = 'wp_enqueue_' . $type;

			foreach ( $enqueue as $key ) {
				$enqueueFunction( $key['handle'] );
			}
		}

		return $this;
	}

	/**
	 * Localize script.
	 *
	 * @param array $args Localize args.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	protected function localize( array $args ) {
		wp_localize_script(
			$args['handle'],
			$args['object'],
			$args['data']
		);
	}

	/**
	 * Accumulate scripts and styles.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	protected function assets() {
		$this
			->getStyles()
			->getScripts();

		return $this->enqueues;
	}

	/**
	 * Accumulate styles list.
	 *
	 * @return Enqueue
	 * @since 1.0.0
	 */
	abstract protected function getStyles();

	/**
	 * Accumulate scripts list.
	 *
	 * @return Enqueue
	 * @since 1.0.0
	 */
	abstract protected function getScripts();

	/**
	 * Enqueue scripts and styles.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	abstract public function enqueue();
}
