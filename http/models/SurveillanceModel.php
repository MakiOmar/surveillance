<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

class SurveillanceModel extends AbstractModel {

	protected $table    = 'surveillances';
	protected $fillable = array(
		'patient_id',
		'ended_at',
	);

	/**
	 * Relation to the PatientModel.
	 *
	 * @return mixed
	 */
	public function patient() {
		return $this->belongsTo( PatientModel::class, 'patient_id', 'id' );
	}
	/**
	 * Get the latest active surveillance where `ended_at` is NULL for a specific patient.
	 *
	 * @param int $patient_id The ID of the patient.
	 * @return mixed|null The latest surveillance record or null if none found.
	 */
	public static function getLatestActiveSurveillance( $patient_id ) {

		try {
			// Fetch the latest surveillance record with `ended_at` as NULL for the given patient_id.
			return self::where( 'patient_id', $patient_id )
				->whereNull( 'ended_at' )
				->orderBy( 'created_at', 'desc' )
				->first();
		} catch ( Exception $e ) {
			// Handle any errors or exceptions.
			return null;
		}
	}
}
