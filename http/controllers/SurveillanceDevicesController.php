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

	/**
	 * Handle HTMX request to connect a device.
	 */
	public function connect_device_handler() {
		check_ajax_referer( 'connect_device', 'connect_device_nonce' );
		$_req = $_POST;

		// Retrieve form data from the POST request.
		$patient_id      = isset( $_req['patient_id'] ) ? intval( $_req['patient_id'] ) : 0;
		$device_id       = isset( $_req['device_id'] ) ? intval( $_req['device_id'] ) : 0;
		$surveillance_id = isset( $_req['surveillance_id'] ) ? intval( $_req['surveillance_id'] ) : 0;
		// Check if a record already exists with ended_at = NULL.
		$already_connected = SurveillanceDevicesModel::whereNull( 'ended_at' )
		->where( 'patient_id', $patient_id )
		->exists(); // Check if such a record exists.

		if ( $already_connected ) {
			$this->jsonResponse(
				array( 'error' => 'This patient is already on another device, please disconnect first.' ),
				403
			);
			return;
		}

		// Collect all fields data into a JSON structure.
		$fields_data = $_req;
		unset(
			$fields_data['patient_id'],
			$fields_data['device_id'],
			$fields_data['surveillance_id'],
			$fields_data['action'],
			$fields_data['connected_at'],
			$fields_data['connect_device_nonce']
		);

		$line_list_configurations = wp_json_encode( $fields_data );

		try {
			// Check if a record already exists with ended_at = NULL.
			$existing_device = SurveillanceDevicesModel::where( 'patient_id', $patient_id )
			->where( 'surveillance_id', $surveillance_id )
			->where( 'device_id', $device_id )
			->whereNull( 'ended_at' )
			->first();

			if ( $existing_device ) {
				$this->jsonResponse( array( 'error' => 'The device is already connected for this patient' ), 403 );
				return;
			}

			// Use the SurveillanceDevicesModel to create a new record.
			$device                           = new SurveillanceDevicesModel();
			$device->surveillance_id          = $surveillance_id;
			$device->patient_id               = $patient_id;
			$device->device_id                = $device_id;
			$device->line_list_configurations = $line_list_configurations;

			if ( ! empty( $_req['connected_at'] ) ) {
				$device->created_at = $_req['connected_at'];
			}

			$device->save();

			$this->jsonResponse(
				array(
					'success' => 'The device is connected successfully',
					'reload'  => true,
				),
				200
			);
		} catch ( Exception $e ) {
			$this->jsonResponse( array( 'error' => esc_html( $e->getMessage() ) ), 403 );
			return;
		}

		die();
	}
}
