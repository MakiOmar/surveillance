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
$device_fields = array(
	1 => array(
		'name'   => 'Central Line',
		'fields' => array(
			array(
				'field_name' => 'site',
				'field_type' => 'radio',
				'required'   => true,
				'options'    => array( 'R Subclavian', 'R Jugular', 'R Femoral', 'L Subclavian', 'L Jugular', 'L Femoral' ),
			),
			array(
				'field_name' => 'type_of_Catheter',
				'field_type' => 'radio',
				'required'   => true,
				'options'    => array( 'Central Line', 'Arterial Line', 'Dialysis Catheter', 'PICC' ),
			),
			array(
				'field_name' => 'line_others',
				'field_type' => 'text',
				'required'   => false,
				'options'    => array(),
			),
			array(
				'field_name' => 'connected_at',
				'field_type' => 'datetime-local',
				'required'   => false,
				'options'    => array(),
			),
		),

	),
	2 => array(
		'name'   => 'Urinary Catheter',
		'fields' => array(
			array(
				'field_name' => 'catheter_type',
				'field_type' => 'radio',
				'required'   => true,
				'options'    => array( 'Indwelling catheter', 'Condom catheter' ),
			),
			array(
				'field_name' => 'connected_at',
				'field_type' => 'datetime-local',
				'required'   => false,
				'options'    => array(),
			),
		),

	),
	5 => array(
		'name'   => 'Adult Ventilator',
		'fields' => array(
			array(
				'field_name' => 'mode',
				'field_type' => 'text',
				'required'   => true,
				'options'    => array(),
			),
			array(
				'field_name' => 'connected_at',
				'field_type' => 'datetime-local',
				'required'   => false,
				'options'    => array(),
			),
		),
	),
	6 => array(
		'name'   => 'Pediatric Neonatal Ventilator',
		'fields' => array(
			array(
				'field_name' => 'mode',
				'field_type' => 'text',
				'required'   => true,
				'options'    => array(),
			),
			array(
				'field_name' => 'connected_at',
				'field_type' => 'datetime-local',
				'required'   => false,
				'options'    => array(),
			),
		),
	),
);

define( 'SURV_DEVICE_TYPES', wp_json_encode( $device_fields ) );
