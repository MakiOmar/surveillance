<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

class SurveillanceDeviceBundle extends AbstractModel {

	protected $table    = 'surveillance_device_bundle';
	protected $fillable = array(
		'surveillance_devices_id',
		'bundle_care',
	);

	/**
	 * Surveillance Device relationship
	 *
	 * @return mixed
	 */
	public function surveillanceDevice() {
		return $this->belongsTo( SurveillanceDevicesModel::class, 'surveillance_devices_id', 'id' );
	}
}
