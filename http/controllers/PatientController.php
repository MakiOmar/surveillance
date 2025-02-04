<?php //phpcs:disable WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid, WordPress.Security.NonceVerification.Recommended
/**
 * Prevent direct access to the file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
//phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
use Carbon\Carbon;

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
		check_ajax_referer( 'insert_patient_nonce', 'insert_patient' );
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
				// phpcs:disable WordPress.PHP.DevelopmentFunctions.error_log_error_log
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
			$patient->surveillances()->create();
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
		// Verify the nonce.
		check_ajax_referer( 'toggle_surveillance_status_nonce', 'nonce' );
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
			$new_status = 'under_surveillance' === $patient->status ? 'surveillance_completed' : 'under_surveillance';
			// Update the latest surveillance with ended_at = NULL to the current datetime.
			$latest_surveillance = SurveillanceModel::getLatestActiveSurveillance( $patient->id );

			// If the new status is `under_surveillance`, insert a new row in the `surveillances` table.
			if ( 'under_surveillance' === $new_status ) {
				if ( $latest_surveillance ) {
					$this->jsonResponse( array( 'error' => 'Please end the latest surveillance process' ), 404 );
					return;
				} else {
					try {
						$patient->surveillances()->create();
						$patient->status = $new_status;
						$patient->save();
					} catch ( \Exception $e ) {
						// Handle exceptions and return an error response.
						$this->jsonResponse( array( 'error' => $e->getMessage() ), 500 );
					}
				}
			} elseif ( $latest_surveillance ) {
				try {
					$latest_surveillance->ended_at = current_time( 'mysql' ); // WordPress current datetime.
					$latest_surveillance->save();
					$patient->status = $new_status;
					$patient->save();
				} catch ( \Exception $e ) {
					// Handle exceptions and return an error response.
					$this->jsonResponse( array( 'error' => $e->getMessage() ), 500 );
				}
			}

			$this->setSurveillanceCountDays( $patient, $latest_surveillance );

			// Load the updated row view and pass the patient data to it.
			$this->loadView(
				'partials/patient-row',
				array(
					'patient' => $patient,
				)
			);
			exit;
		} catch ( Exception $e ) {
			// Handle exceptions and return an error response.
			$this->jsonResponse( array( 'error' => $e->getMessage() ), 500 );
		}
	}
	/**
	 * Set Surveillance Count Days
	 *
	 * @param object      $patient Patient object.
	 * @param object|null $latest_surveillance Latest surveillance objetc or null.
	 * @return void
	 */
	protected function setSurveillanceCountDays( &$patient, $latest_surveillance ) {
		if ( $latest_surveillance ) {
			$created_at   = Carbon::createFromFormat( 'Y-m-d H:i:s', $latest_surveillance->created_at );
			$current_time = Carbon::now(); // Get current time.

			// Calculate total hours between the two timestamps.
			$total_hours = $created_at->diffInHours( $current_time, false );

			// Calculate days and remaining hours.
			$days  = intdiv( $total_hours, 24 ); // Full days.
			$hours = $total_hours % 24;          // Remaining hours.

			// Store the result as a formatted string (e.g., "5 days, 3 hours").
			$patient->surveillance_days_count = "{$days} days, {$hours} hours";
		} else {
			// Default value if no surveillance is found.
			$patient->surveillance_days_count = '0 days, 0 hours';
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
			// Map patients to include the latest surveillance with ended_at = NULL or 0 if none.
			$patients_with_surveillance = $patients->map(
				function ( $patient ) {
					$latest_surveillance      = SurveillanceModel::getLatestActiveSurveillance( $patient->id );
					$patient->surveillance_id = $latest_surveillance ? $latest_surveillance->id : 0;

					$this->setSurveillanceCountDays( $patient, $latest_surveillance );

					return $patient;
				}
			);
			// Get the total number of records for pagination.
			$total_records = PatientModel::count();

			// Calculate the total number of pages.
			$total_pages = ceil( $total_records / $per_page );

			// Prepare the data to be passed to the view.
			$data = array(
				'patients'      => $patients_with_surveillance,
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
	/**
	 * Line list view
	 *
	 * Fetches all devices and their fields for a specific patient.
	 *
	 * @return void
	 */
	public function lineList() {
		// Get the patient ID from $_GET.
		$id = isset( $_GET['patient'] ) ? intval( $_GET['patient'] ) : 0;

		// Validate the ID.
		if ( $id <= 0 ) {
			echo '<p>Invalid patient ID provided.</p>';
			return;
		}

		// Fetch the patient record with related device fields by ID.
		$patient = PatientModel::with( 'surveillancesDevices.device' )->find( $id );

		// Check if the patient exists.
		if ( ! $patient ) {
			echo '<p>Patient not found.</p>';
			return;
		}
		if ( 'under_surveillance' !== $patient->status && ( empty( $_GET['show'] ) || 'details-only' !== $_GET['show'] ) ) {
			// Load the view and pass the data.
			$this->loadView(
				'error',
				array(
					'error_message' => 'Patient is not under surveillance.',
				)
			);
			return;
		}

		// Get the latest active surveillance.
		$active_surveillance = SurveillanceModel::getLatestActiveSurveillance( $patient->id );
		//phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		// Transform surveillancesDevices to include `device_days` as days and hours.
		$surveillancesDevices = $patient->surveillancesDevices->map(
			function ( $surveillance_device ) {
				$created_at = Carbon::parse( $surveillance_device->created_at );
				$now        = ! $surveillance_device->ended_at ? Carbon::now() : $surveillance_device->ended_at;

				$total_hours = $created_at->diffInHours( $now ); // Total difference in hours.
				$days        = intdiv( $total_hours, 24 ); // Calculate full days.
				$hours       = $total_hours % 24; // Remaining hours after full days.

				// Check if ended_at is null and there are no matching records in the bundle table for today.
				$status        = 'success'; // Default status.
				$missing_dates = array();
				$text          = 'light';
				if ( is_null( $surveillance_device->ended_at ) ) {
					$today = Carbon::today()->toDateString(); // Today's date in 'Y-m-d' format.

					$hasBundleCareToday = SurveillanceDeviceBundle::where( 'surveillance_devices_id', $surveillance_device->id )
						->whereDate( 'created_at', $today )
						->exists();
					if ( ! $hasBundleCareToday ) {
						$status = 'secondary';
					}
				}

				// Check for missing daily records if ended_at is null.
				if ( is_null( $surveillance_device->ended_at ) ) {
					$all_dates    = array(); // Store all dates from created_at to today.
					$current_date = $created_at->copy();

					while ( $current_date->lte( Carbon::today() ) ) {
						$all_dates[] = $current_date->toDateString();
						$current_date->addDay();
					}

					// Fetch existing record dates for this surveillance device.
					$existing_dates = SurveillanceDeviceBundle::where( 'surveillance_devices_id', $surveillance_device->id )
						->whereBetween( 'created_at', array( $created_at->toDateString(), Carbon::today()->toDateString() ) )
						->pluck( 'created_at' )
						->map( fn( $date ) => Carbon::parse( $date )->toDateString() )
						->toArray();

					// Calculate missing dates.
					$missing_dates = array_diff( $all_dates, $existing_dates );

					// If missing dates exist, set status to 'danger'.
					if ( ! empty( $missing_dates ) ) {
						$status = 'dark';
					}
				}

				return array(
					'device_name'            => $surveillance_device->device->label ?? 'Unknown',
					'created_at'             => $surveillance_device->created_at,
					'ended_at'               => $surveillance_device->ended_at,
					'device_days'            => "{$days} days and {$hours} hours", // Format as "X days, Y hours".
					'surveillance_device_id' => $surveillance_device->id,
					'device_id'              => $surveillance_device->device->id,
					'status'                 => $status, // Include status in the transformed data.
					'missing_dates'          => $missing_dates, // Include missing dates.
					'text'                   => $text, // Include missing dates.
				);
			}
		);

		// Load the view and pass the data.
		$this->loadView(
			'line-list',
			array(
				'patient'               => $patient,
				'device_fields'         => json_decode( SURV_DEVICE_TYPES, true ),
				'surveillance_id'       => $active_surveillance->id ?? null,
				'surveillances_devices' => $surveillancesDevices, // Pass transformed data.
			)
		);
	}
}
