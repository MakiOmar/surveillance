<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BaseController {

	protected function jsonResponse( $data, $status = 200 ) {
		wp_send_json( $data, $status );
	}
}
