<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
//phpcs:disable WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
/**
 * Base controller
 */
class BaseController {

	/**
	 * Json reponse
	 *
	 * @param mixed   $data Data.
	 * @param integer $status Status.
	 * @return void
	 */
	protected function jsonResponse( $data, $status = 200 ) {
		wp_send_json( $data, $status );
	}

	/**
	 * Load a view file and pass data to it.
	 *
	 * @param string $view The name of the view file (without `.php` extension).
	 * @param array  $data The data to pass to the view.
	 *
	 * @return void Includes the view file with data.
	 */
	protected function loadView( $view, $data = array() ) {
		load_view( $view, $data );
	}
}
