<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

class SurveillanceDevicesModel extends AbstractModel {

	protected $table    = 'surveillance_devices';
	protected $fillable = array(
		'surveillance_id',
		'patient_id',
		'device_id',
		'line_list_configurations',
		'created_at',
		'ended_at',
	);

	/**
	 * Relation to the SurveillanceModel.
	 *
	 * @return mixed
	 */
	public function surveillance() {
		return $this->belongsTo( SurveillanceModel::class, 'surveillance_id', 'id' );
	}

	/**
	 * Relation to the PatientModel.
	 *
	 * @return mixed
	 */
	public function patient() {
		return $this->belongsTo( PatientModel::class, 'patient_id', 'id' );
	}

	/**
	 * Relation to the DeviceTypeModel.
	 *
	 * @return mixed
	 */
	public function device() {
		return $this->belongsTo( DeviceType::class, 'device_id', 'id' );
	}

	/**
	 * Get active surveillance device where `ended_at` is NULL for a specific surveillance.
	 *
	 * @param int $surveillance_id The ID of the surveillance.
	 * @return mixed|null The active surveillance device or null if none found.
	 */
	public static function getActiveDevice( $surveillance_id ) {
		try {
			return self::where( 'surveillance_id', $surveillance_id )
				->whereNull( 'ended_at' )
				->orderBy( 'created_at', 'desc' )
				->first();
		} catch ( Exception $e ) {
			// Handle any errors or exceptions.
			return null;
		}
	}
}
