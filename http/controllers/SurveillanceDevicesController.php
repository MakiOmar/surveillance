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
class SurveillanceDevicesController extends BaseController {

	/**
	 * Handle HTMX request to end a device.
	 */
	public function end_device_handler() {
		check_ajax_referer( 'end_device_nonce', 'end_device' );
		$surveillance_device_id = isset( $_POST['surveillance_device_id'] ) ? intval( $_POST['surveillance_device_id'] ) : 0;
		if ( ! $surveillance_device_id ) {
			$this->jsonResponse( array( 'error' => 'Invalid device.' ), 500 );
		}

		try {
			$device = SurveillanceDevicesModel::find( $surveillance_device_id );
			if ( ! $device ) {
				$this->jsonResponse( array( 'error' => 'Device not found.' ), 404 );
			}

			// Mark the device as ended.
			$device->ended_at = current_time( 'mysql' );
			$device->save();
			if ( ! $device ) {
				$this->jsonResponse( array( 'success' => '<td colspan="4" class="text-center text-muted">Device ended.</td>' ), 200 );
			}
		} catch ( Exception $e ) {
			$this->jsonResponse( array( 'error' => $e->getMessage() ), 500 );
		}
	}
}
