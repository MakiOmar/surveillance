<?php //phpcs:disable WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Patient Model
 *
 * Represents the patient entity in the application.
 *
 * @package PluginNamespace
 */

// phpcs:disable WordPress.Files.FileName.NotHyphenatedLowercase
defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

/**
 * Class PatientModel
 *
 * Represents the patient model and its relationships.
 */
class PatientModel extends AbstractModel {

	/**
	 * The database table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'surv_patient';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array(
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
		'author_id',
	);

	/**
	 * Device fields relationship.
	 *
	 * Defines the relationship between a patient and their device fields.
	 *
	 * @return mixed
	 */
	public function deviceFields() {
		return $this->hasMany( PatientDeviceField::class, 'patient_id', 'id' );
	}

	/**
	 * Surveillances relationship.
	 *
	 * Defines the relationship between a patient and their surveillances.
	 *
	 * @return mixed
	 */
	public function surveillances() {
		return $this->hasMany( SurveillanceModel::class, 'patient_id', 'id' );
	}

	/**
	 * Surveillances devices relationship.
	 *
	 * Defines the relationship between a patient and their surveillance devices.
	 *
	 * @return mixed
	 */
	public function surveillancesDevices() {
		return $this->hasMany( SurveillanceDevicesModel::class, 'patient_id', 'id' );
	}
}
