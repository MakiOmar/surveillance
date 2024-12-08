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
	 * Get the associated field.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function field() {
		return $this->belongsTo( FormField::class, 'field_id', 'id' );
	}

	public function patient() {
		return $this->belongsTo( PatientModel::class, 'patient_id', 'id' );
	}

	public function device() {
		return $this->belongsTo( DeviceType::class, 'device_id', 'id' );
	}
}
