<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

class DeviceType extends AbstractModel {

	protected $table    = 'surv_device_type';
	protected $fillable = array(
		'label',
	);
	/**
	 * Fields
	 *
	 * @return mixed
	 */
	public function fields() {
		return $this->hasMany( FormField::class, 'device_type_id', 'id' );
	}
}
