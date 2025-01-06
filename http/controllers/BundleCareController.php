<?php //phpcs:disable WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Prevent direct access to the file.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class PatientController
 *
 * Handles operations related to patient records.
 */
class BundleCareController extends BaseController {
	/**
	 * Get bundel care for a surveillance device
	 *
	 * @return void
	 */
	public function getBundleCareHandler() {
		check_ajax_referer( 'getbundlecare_nonce', 'getbundlecare' );
		$device_id = isset( $_POST['device_id'] ) ? intval( $_POST['device_id'] ) : 0;
		if ( ! $device_id ) {
			$this->jsonResponse( array( 'error' => 'Invalid device.' ), 500 );
		}
		$this->loadView( 'partials/bundlecare/' . $device_id );
		die;
	}
}
