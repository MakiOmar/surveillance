<?php
/**
 * Helper functions for the surv_patient table.
 *
 * This file contains utility functions for managing the surv_patient table.
 *
 * @package SurvPatientHelpers
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Generate a unique numeric code for the surv_patient table.
 *
 * This function generates a unique numeric code in the format 'PAT-XXXXXX' where 'XXXXXX' is a
 * random 6-digit number. It ensures the generated code is unique within the surv_patient table.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @return string The unique code.
 */
function surv_generate_unique_code() {
	global $wpdb;

	do {
		// Generate a 6-digit random number.
		$code = 'PAT-' . str_pad( random_int( 0, 9999 ), 4, '0', STR_PAD_LEFT );

		// Check if the code already exists in the database.
		$exists = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->prefix}surv_patient WHERE code = %s",
				$code
			)
		);
	} while ( $exists > 0 );

	return $code;
}

