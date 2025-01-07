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
		$device_id              = isset( $_POST['device_id'] ) ? intval( $_POST['device_id'] ) : false;
		$surveillance_device_id = isset( $_POST['surveillance_device_id'] ) ? intval( $_POST['surveillance_device_id'] ) : false;
		if ( ! $device_id ) {
			$this->jsonResponse( array( 'error' => 'Invalid device.' ), 500 );
		}

		if ( ! $surveillance_device_id ) {
			$this->jsonResponse( array( 'error' => 'Invalid surveillance.' ), 500 );
		}
		$this->loadView(
			'partials/bundlecare/form',
			array(
				'surveillance_device_id' => $surveillance_device_id,
				'device_id'              => $device_id,
			)
		);
		die;
	}
	/**
	 * Insert a surveillance device bundle using HTMX
	 *
	 * Abstracted to handle any form dynamically by JSON encoding all submitted fields.
	 *
	 * @return void
	 */
	public function insertBundleCareHandler() {

		check_ajax_referer( 'insertbundlecare_nonce', '_wpnonce' );

		$surveillance_device_id = isset( $_POST['surveillance_device_id'] ) ? intval( $_POST['surveillance_device_id'] ) : false;

		if ( ! $surveillance_device_id ) {
			$this->jsonResponse( array( 'error' => 'Invalid surveillance device ID.' ), 500 );
		}

		// Collect all submitted fields dynamically.
		$bundle_care_values = array();

		foreach ( $_POST as $key => $value ) {
			// Skip reserved keys or unnecessary fields.
			if ( in_array( $key, array( '_wpnonce', 'action', 'surveillance_device_id', 'date' ), true ) ) {
				continue;
			}

			// Sanitize each field and add it to the bundle care data.
			$bundle_care_values[ $key ] = is_array( $value ) ? array_map( 'sanitize_text_field', $value ) : sanitize_text_field( $value );
		}
		try {
			// Use the model to create the new bundle care entry.
			$bundle_care = new SurveillanceDeviceBundle();
			$create      = array(
				'surveillance_devices_id' => $surveillance_device_id,
				'bundle_care'             => wp_json_encode( $bundle_care_values ),
			);
			if ( ! empty( $_POST['date'] ) ) {
				$create['created_at'] = sanitize_text_field( wp_unslash( $_POST['date'] ) );
			}
			$bundle_care->create( $create );

			$this->jsonResponse( array( 'success' => 'Bundle care data inserted successfully.' ), 200 );
		} catch ( Exception $e ) {
			$this->jsonResponse( array( 'error' => $e->getMessage() ), 500 );
		}
	}
}
