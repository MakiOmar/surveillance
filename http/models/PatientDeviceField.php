<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

class PatientDeviceField extends AbstractModel {

	protected $table = 'surv_patient_device_fields';
		/**
		 * Define the attributes for the model.
		 *
		 * @var array
		 */
	protected $fillable = array(
		'patient_id',
		'device_id',
		'field_id',
		'value',
		'created_at',
		'updated_at',
	);

	/**
	 * Get the associated patient.
	 *
	 * @return object|null
	 */
	public function patient() {
		return PatientModel::find( $this->patient_id );
	}

	/**
	 * Get the associated device.
	 *
	 * @return object|null
	 */
	public function device() {
		return DeviceType::find( $this->device_id );
	}

	/**
	 * Get the associated field.
	 *
	 * @return object|null
	 */
	public function field() {
		return FormField::find( $this->field_id );
	}
}
