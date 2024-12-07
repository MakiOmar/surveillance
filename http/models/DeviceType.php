<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Dbout\WpOrm\Orm\AbstractModel;

class DeviceType extends AbstractModel {

	protected $table    = 'jet_cct_device_type';
	protected $fillable = array(
		'label',
	);
}
