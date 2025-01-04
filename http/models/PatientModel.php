<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

class PatientModel extends AbstractModel {

	protected $table    = 'surv_patient';
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
	 * Device fields
	 *
	 * @return mixed
	 */
	public function deviceFields() {
		return $this->hasMany( PatientDeviceField::class, 'patient_id', 'id' );
	}
	public function surveillances() {
		return $this->hasMany(SurveillanceModel::class, 'patient_id', 'id');
	}
	
}
