<?php

use Dbout\WpOrm\Orm\AbstractModel;

/**
 * Class FormField
 *
 * Model for the `surv_form_fields` table.
 */
class FormField extends AbstractModel {

	/**
	 * Define the table name (without the WordPress prefix).
	 *
	 * @var string
	 */
	protected $table = 'surv_form_fields';

	/**
	 * Define the attributes for the model.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'device_type_id',
		'field_name',
		'field_type',
		'required',
		'created_at',
		'updated_at',
	);

	/**
	 * Define the relationship with form field options.
	 *
	 * @return array|object|null
	 */
	public function options() {
		return FormFieldOption::where( 'field_id', $this->id )->get();
	}

	/**
	 * Check if a field exists for the given device_type_id and field_name.
	 *
	 * @param int    $deviceTypeId
	 * @param string $fieldName
	 * @return bool
	 */
	public static function fieldExists( $deviceTypeId, $fieldName ) {
		return self::where( 'device_type_id', $deviceTypeId )
			->where( 'field_name', $fieldName )
			->exists();
	}
}
