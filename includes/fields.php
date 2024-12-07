<?php
/**
 * Form fields
 *
 * @package surv
 */

/**
 * Prevent direct access to the file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Insert required form fields upon theme activation if they are not already present.
 */
function insert_required_form_fields() {
	$fields = array(
		array(
			'device_type_id' => 1,
			'field_name'     => 'site',
			'field_type'     => 'radio',
			'required'       => 1,
			'options'        => array( 'R Subclavian', 'R Jugular', 'R Femoral', 'L Subclavian', 'L Jugular', 'L Femoral' ),
		),
		array(
			'device_type_id' => 1,
			'field_name'     => 'type_of_Catheter',
			'field_type'     => 'radio',
			'required'       => 1,
			'options'        => array( 'Central Line', 'Arterial Line', 'Dialysis Catheter', 'PICC' ),
		),
		array(
			'device_type_id' => 1,
			'field_name'     => 'line_others',
			'field_type'     => 'text',
			'required'       => 0,
			'options'        => array(),
		),
		array(
			'device_type_id' => 2,
			'field_name'     => 'catheter_type',
			'field_type'     => 'radio',
			'required'       => 1,
			'options'        => array( 'Indwelling catheter', 'Condom catheter' ),
		),

		array(
			'device_type_id' => 5,
			'field_name'     => 'ventilator',
			'field_type'     => 'text',
			'required'       => 1,
			'options'        => array(),
		),
	);

	foreach ( $fields as $fieldData ) {
		// Check if the field already exists.
		if ( ! FormField::fieldExists( $fieldData['device_type_id'], $fieldData['field_name'] ) ) {
			// Insert the field.
			$field                 = new FormField();
			$field->device_type_id = $fieldData['device_type_id'];
			$field->field_name     = $fieldData['field_name'];
			$field->field_type     = $fieldData['field_type'];
			$field->required       = $fieldData['required'];
			$field->created_at     = current_time( 'mysql' );
			$field->updated_at     = current_time( 'mysql' );
			$field->save();

			// Insert the options if the field type supports them.
			foreach ( $fieldData['options'] as $optionValue ) {
				$option               = new FormFieldOption();
				$option->field_id     = $field->id;
				$option->option_value = $optionValue;
				$option->created_at   = current_time( 'mysql' );
				$option->updated_at   = current_time( 'mysql' );
				$option->save();
			}
		}
	}
}

// Hook the function to theme activation.
add_action( 'after_switch_theme', 'insert_required_form_fields', 999 );
