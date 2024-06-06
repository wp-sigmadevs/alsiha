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
	protected string $suffix = '';

	/**
	 * Array to accumulate the scripts and styles.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected array $enqueues = [];

	/**
	 * Class Constructor.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function __construct() {
		parent::__construct();

		$this->suffix = '.min';
	}

	/**
	 * Register the scripts and styles.
	 *
	 * @return Enqueue
	 * @since  1.0.0
	 */
	protected function registerScripts(): Enqueue {
		// Bail if no scripts.
		if ( empty( $this->enqueues ) ) {
			return $this;
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
	 * Enqueue the scripts and styles.
	 *
	 * @return Enqueue
	 * @since  1.0.0
	 */
	protected function enqueueScripts(): Enqueue {

		if ( empty( $this->enqueues ) ) {
			return $this;
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
	 * @since  1.0.0
	 */
	protected function localize( array $args ): array {
		wp_localize_script(
			$args['handle'],
			$args['object'],
			$args['data']
		);
	}

	/**
	 * Accumulate the scripts and styles.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	protected function assets(): array {
		$this
			->getStyles()
			->getScripts();

		return $this->enqueues;
	}

	/**
	 * Accumulate the style list.
	 *
	 * @return Enqueue
	 * @since  1.0.0
	 */
	abstract protected function getStyles();

	/**
	 * Accumulate the script list.
	 *
	 * @return Enqueue
	 * @since  1.0.0
	 */
	abstract protected function getScripts();

	/**
	 * Enqueue the scripts and styles.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	abstract public function enqueue();
}
