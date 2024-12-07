<?php
/**
 * Prevent direct access to the file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Dbout\WpOrm\Models\Model;
use TenQuality\WP\QueryBuilder\QueryBuilder;

/**
 * Class PatientController
 *
 * Handles operations related to patient records.
 */
class PatientController extends BaseController {

	/**
	 * Insert a new patient record.
	 *
	 * This function validates the input data, generates a unique code for the patient,
	 * sanitizes the input fields, and inserts a new patient record into the database.
	 *
	 * @param array $data The input data for the new patient.
	 *
	 * @return void Outputs a JSON response.
	 */
	public function insertPatient( $data ) {
		// Use $_POST as the data source.
		$data = $_POST;

		// List of required fields for validation.
		$required_fields = array(
			'first_name',
			'second_name',
			'last_name',
			'age',
			'address',
			'job',
			'nationality',
			'gender',
			'identity',
			'date_of_birth',
			'date_of_admission',
			'mobile_number',
			'place_of_admission',
			'entry',
		);

		// Validate all required fields.
		foreach ( $required_fields as $field ) {
			if ( empty( $data[ $field ] ) ) {
				error_log( $field ); // Log the missing field.
				$this->jsonResponse( array( 'error' => "Missing required field: {$field}" ), 400 );
				return;
			}
		}

		try {
			// Create a new patient model instance.
			$patient = new PatientModel();

			// Assign sanitized data to the model properties.
			$patient->code               = surv_generate_unique_code();
			$patient->first_name         = sanitize_text_field( $data['first_name'] );
			$patient->second_name        = sanitize_text_field( $data['second_name'] );
			$patient->last_name          = sanitize_text_field( $data['last_name'] );
			$patient->age                = intval( $data['age'] );
			$patient->address            = sanitize_text_field( $data['address'] );
			$patient->job                = sanitize_text_field( $data['job'] );
			$patient->nationality        = sanitize_text_field( $data['nationality'] );
			$patient->gender             = sanitize_text_field( $data['gender'] );
			$patient->identity           = sanitize_text_field( $data['identity'] );
			$patient->date_of_birth      = sanitize_text_field( $data['date_of_birth'] );
			$patient->date_of_admission  = sanitize_text_field( $data['date_of_admission'] );
			$patient->mobile_number      = sanitize_text_field( $data['mobile_number'] );
			$patient->place_of_admission = sanitize_text_field( $data['place_of_admission'] );
			$patient->entry              = sanitize_textarea_field( $data['entry'] );
			$patient->author_id          = intval( get_current_user_id() );

			// Save the data to the database.
			$patient->save();
			header( 'HX-Redirect: ' . site_url( '/patients' ) );
			// Return a success response.
			$this->jsonResponse( array( 'message' => 'Patient inserted successfully' ), 201 );
		} catch ( Exception $e ) {
			// Handle exceptions and return an error response.
			$this->jsonResponse( array( 'error' => $e->getMessage() ), 500 );
		}
	}

	/**
	 * Toggle the surveillance status of a patient.
	 *
	 * @return void Outputs a JSON response.
	 */
	public function toggleSurveillanceStatus() {
		// Use $_POST as the data source.
		$data = $_POST;

		// Validate the record ID.
		if ( empty( $data['id'] ) || ! is_numeric( $data['id'] ) ) {
			$this->jsonResponse( array( 'error' => 'Invalid record ID' ), 400 );
			return;
		}

		try {
			// Fetch the patient record by ID.
			$patient = PatientModel::find( intval( $data['id'] ) );

			if ( ! $patient ) {
				$this->jsonResponse( array( 'error' => 'Patient record not found' ), 404 );
				return;
			}

			// Toggle the status.
			$new_status      = $patient->status === 'under_surveillance' ? 'surveillance_completed' : 'under_surveillance';
			$patient->status = $new_status;

			// Save the updated status.
			$patient->save();

			// Return a success response with the new status.
			$this->jsonResponse(
				array(
					'status'  => $new_status,
					'message' => 'Status updated successfully',
				),
				200
			);
		} catch ( Exception $e ) {
			// Handle exceptions and return an error response.
			$this->jsonResponse( array( 'error' => $e->getMessage() ), 500 );
		}
	}

	/**
	 * Fetch paginated patients for display in a Bootstrap table.
	 *
	 * The output is handled by a separate view file.
	 *
	 * @return void Outputs the rendered view with paginated patient data.
	 */
	public function fetchPatients() {
		try {
			// Get the current page from the request, default to 1.
			$page = isset( $_GET['page'] ) ? max( 1, intval( $_GET['page'] ) ) : 1;

			// Define the number of records per page.
			$per_page = 50;

			// Calculate the offset for the query.
			$offset = ( $page - 1 ) * $per_page;

			// Fetch the paginated patient records.
			$patients = PatientModel::offset( $offset )
			->limit( $per_page )
			->get();

			// Get the total number of records for pagination.
			$total_records = PatientModel::count();

			// Calculate the total number of pages.
			$total_pages = ceil( $total_records / $per_page );

			// Prepare the data to be passed to the view.
			$data = array(
				'patients'      => $patients,
				'current_page'  => $page,
				'total_pages'   => $total_pages,
				'per_page'      => $per_page,
				'total_records' => $total_records,
			);
			// Load the view file and pass the data.
			$this->loadView( 'patients-table', $data );

		} catch ( Exception $e ) {
			// Handle exceptions and display an error message in the view.
			$this->loadView( 'error', array( 'error_message' => $e->getMessage() ) );
		}
	}
}
