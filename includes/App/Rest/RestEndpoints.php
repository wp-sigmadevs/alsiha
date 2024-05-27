<?php
/**
 * Rest Class: RestAPI Custom Endpoint.
 *
 * This class initializes REST API and creates custom endpoints.
 *
 * @package SigmaDevs\AlSiha
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\AlSiha\App\Rest;

use WP_Error;
use WP_REST_Response;
use SigmaDevs\AlSiha\Common\{
	Abstracts\Base,
	Traits\Singleton,
	Functions\Helpers
};

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Rest Class: RestAPI Custom Endpoint.
 *
 * @since 1.0.0
 */
class RestEndpoints extends Base {
	/**
	 * Singleton trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * The prefix for the API.
	 *
	 * @var string API_PREFIX
	 * @since 1.0.0
	 **/
	const API_PREFIX = 'sd/signature';

	/**
	 * API Version.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected $version = 'v1';

	/**
	 * This class is only being instantiated if REST_REQUEST is defined
	 * in the requester as requested in the Bootstrap class
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 * @see Bootstrap::registerServices
	 * @see Requester::isRest()
	 */
	public function register() {
		if ( class_exists( 'WP_REST_Server' ) ) {
			add_action( 'rest_api_init', [ $this, 'addThemeApiEndpoint' ] );
		}
	}

	/**
	 * Returns the namespace for the API request.
	 *
	 * @return string
	 * @since 1.0.0
	 **/
	public function getNamespace() {
		$version = empty( $this->version ) ? 'v1' : $this->version;

		return self::API_PREFIX . '/' . $version;
	}

	/**
	 * Sends a REST response with an error status.
	 *
	 * @param string $error The error message to be included in the response.
	 * @param array  $errorData An optional array of additional error data.
	 * @param int    $code The HTTP status code to be returned in the response.
	 *
	 * @return WP_REST_Response
	 * @since 1.0.0
	 **/
	protected function sendError( $error, $errorData = [], $code = 200 ) {
		$resData = [
			'success' => false,
			'message' => $error,
		];

		if ( ! empty( $errorData ) ) {
			$resData['data'] = $errorData;
		}

		$response = new WP_REST_Response( $resData );
		$response->set_status( $code );

		return rest_ensure_response( $response );
	}

	/**
	 * Sends a REST response with success status, data, and message.
	 *
	 * @param array  $data The data to be included in the response.
	 * @param string $message The message to be included in the response.
	 *
	 * @return WP_REST_Response
	 * @since 1.0.0
	 **/
	protected function sendResponse( $data = [], $message = '' ) {
		$resData = [
			'success' => true,
			'data'    => $data,
			'message' => $message,
		];

		$response = new WP_REST_Response( $resData );

		return rest_ensure_response( $response );
	}

	/**
	 * Add Endpoint for Demo Data.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function addThemeApiEndpoint() {
		$this->addDemoEndpoint();
	}

	/**
	 * Add Demo Route.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function addDemoEndpoint() {
		register_rest_route(
			$this->getNamespace(),
			'/import/list',
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'demoCallback' ],
				'permission_callback' => [ $this, 'permission' ],
			]
		);
	}

	/**
	 * Checks whether user has permission to manage options.
	 *
	 * @return true|WP_Error
	 * @since 1.0.0
	 */
	public function permission() {
		$hasPermission = current_user_can( 'manage_options' );

		if ( ! $hasPermission ) {
			return new WP_Error(
				'authentication_error',
				esc_html__( 'Sorry, you are not allowed to do that!', 'alsiha' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Demo Callback.
	 *
	 * @return WP_REST_Response
	 * @since 1.0.0
	 */
	public function demoCallback() {
		$demoConfig = [];

		return $this->sendResponse( $demoConfig, esc_html__( 'Data is ready to fetch', 'alsiha' ) );
	}
}
