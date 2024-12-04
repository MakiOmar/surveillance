<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use Dbout\WpOrm\Models\Model;
use TenQuality\WP\QueryBuilder\QueryBuilder;

class PatientController extends BaseController {

	public function insertPatient( $data ) {
		$data = $_POST;
		// Validate all required fields
		$requiredFields = array(
			'code',
			'status',
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

		foreach ( $requiredFields as $field ) {
			if ( empty( $data[ $field ] ) ) {
				error_log( $field );
				$this->jsonResponse( array( 'error' => "Missing required field: {$field}" ), 400 );
				return;
			}
		}

		try {
			$patient = new PatientModel();
			// Insert sanitized data using the ORM
			$patient->code               = sanitize_text_field( $data['code'] );
			$patient->status             = sanitize_text_field( $data['status'] );
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
			// Save the data
			$patient->save();

			// Return success response
			$this->jsonResponse( array( 'message' => 'Patient inserted successfully' ), 201 );
		} catch ( Exception $e ) {
			// Return error response
			$this->jsonResponse( array( 'error' => $e->getMessage() ), 500 );
		}
	}
}
