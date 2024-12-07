<?php

use Dbout\WpOrm\Orm\AbstractModel;

/**
 * Class FormFieldOption
 *
 * Model for the `surv_form_field_options` table.
 */
class FormFieldOption extends AbstractModel {

	/**
	 * Define the table name (without the WordPress prefix).
	 *
	 * @var string
	 */
	protected $table = 'surv_form_field_options';

	/**
	 * Define the attributes for the model.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'field_id',
		'option_value',
		'created_at',
		'updated_at',
	);

	/**
	 * Define the relationship with the form field.
	 *
	 * @return object|null
	 */
	public function field() {
		return FormField::find( $this->field_id );
	}
}
