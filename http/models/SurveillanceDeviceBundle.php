<?php //phpcs:disable WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Surveillance Device Bundle Model
 *
 * @package PluginNamespace
 */

defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

/**
 * Class SurveillanceDeviceBundle
 *
 * Represents the surveillance device bundle model.
 */
class SurveillanceDeviceBundle extends AbstractModel {

	/**
	 * The database table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'surveillance_device_bundle';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'surveillance_devices_id',
		'bundle_care',
		'created_at',
	);

	/**
	 * Relationship: Surveillance Device
	 *
	 * Defines a relationship with the SurveillanceDevicesModel.
	 *
	 * @return mixed
	 */
	public function surveillanceDevice() {
		return $this->belongsTo( SurveillanceDevicesModel::class, 'surveillance_devices_id', 'id' );
	}
}
