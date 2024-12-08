<?php
/**
 * DB Tables
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
 * Create the `surv_patient` table upon theme activation.
 *
 * This function checks if the table already exists and creates it if not.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function create_surv_patient_table() {
	global $wpdb;

	// Define table names with the correct WordPress table prefix.
	$table_name  = $wpdb->prefix . 'surv_patient';
	$users_table = $wpdb->prefix . 'users'; // WordPress users table.

	// Check if the table already exists.
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
		// SQL to create the table.
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `$table_name` (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`code` varchar(20) NOT NULL UNIQUE,
			`status` ENUM('under_surveillance', 'surveillance_completed') DEFAULT 'under_surveillance',
			`first_name` text DEFAULT NULL,
			`second_name` text DEFAULT NULL,
			`last_name` text DEFAULT NULL,
			`age` bigint(20) DEFAULT NULL,
			`address` text DEFAULT NULL,
			`job` text DEFAULT NULL,
			`nationality` text DEFAULT NULL,
			`gender` text DEFAULT NULL,
			`identity` text NOT NULL UNIQUE,
			`date_of_birth` text DEFAULT NULL,
			`date_of_admission` text DEFAULT NULL,
			`mobile_number` text DEFAULT NULL,
			`place_of_admission` text DEFAULT NULL,
			`entry` text DEFAULT NULL,
			`author_id` bigint(20) UNSIGNED DEFAULT NULL,
			`created_at` datetime DEFAULT NULL,
			`updated_at` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			CONSTRAINT `fk_author_id` FOREIGN KEY (`author_id`) REFERENCES `$users_table` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE
		) $charset_collate ENGINE=InnoDB;";

		// Include the upgrade script.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		// Execute the SQL query to create the table.
		dbDelta( $sql );
	}
}
/**
 * Create the `surv_device_type` table upon theme activation.
 *
 * This function checks if the table already exists and creates it if not.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function create_surv_device_type_table() {
	global $wpdb;

	// Define table names with the correct WordPress table prefix.
	$table_name = $wpdb->prefix . 'surv_device_type';

	// Check if the table already exists.
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
		// SQL to create the table.
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `$table_name` (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`label` varchar(20) NOT NULL,
			`created_at` datetime DEFAULT NULL,
			`updated_at` datetime DEFAULT NULL,
			PRIMARY KEY (`id`)
		) $charset_collate ENGINE=InnoDB;";

		// Include the upgrade script.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		// Execute the SQL query to create the table.
		dbDelta( $sql );
	}
}

/**
 * Create the `surv_patient_device_connections` table upon theme activation.
 *
 * This function checks if the table already exists and creates it if not.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function create_surv_patient_device_connections_table() {
	global $wpdb;

	// Define the table name with the correct WordPress table prefix.
	$table_name = $wpdb->prefix . 'surv_patient_device_connections';

	// Check if the table already exists.
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
		// SQL to create the table.
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `$table_name` (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`patient_id` bigint(20) UNSIGNED NOT NULL,
			`device_type_id` bigint(20) UNSIGNED NOT NULL,
			`connected_at` datetime DEFAULT NULL,
			`disconnected_at` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `patient_id` (`patient_id`),
			KEY `device_type_id` (`device_type_id`)
		) $charset_collate ENGINE=InnoDB;";

		// Include the upgrade script.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		// Execute the SQL query to create the table.
		dbDelta( $sql );
	}
}

/**
 * Create the `surv_form_fields` table upon theme activation.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function create_surv_form_fields_table() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'surv_form_fields';

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `$table_name` (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`device_type_id` bigint(20) UNSIGNED NOT NULL,
			`field_name` varchar(255) NOT NULL,
			`field_type` enum('text', 'textarea', 'dropdown', 'radio', 'checkbox') NOT NULL,
			`required` tinyint(1) NOT NULL DEFAULT 0,
			`created_at` datetime DEFAULT NULL,
			`updated_at` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `device_type_id` (`device_type_id`)
		) $charset_collate ENGINE=InnoDB;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}
}

/**
 * Create the `surv_form_field_options` table upon theme activation.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function create_surv_form_field_options_table() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'surv_form_field_options';

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `$table_name` (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`field_id` bigint(20) UNSIGNED NOT NULL,
			`option_value` varchar(255) NOT NULL,
			`created_at` datetime DEFAULT NULL,
			`updated_at` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `field_id` (`field_id`)
		) $charset_collate ENGINE=InnoDB;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}
}

/**
 * Create the `surv_patient_device_fields` table upon theme activation.
 *
 * This function checks if the table already exists and creates it if not.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function create_surv_patient_device_fields_table() {
	global $wpdb;

	// Define table name with the correct WordPress table prefix.
	$table_name = $wpdb->prefix . 'surv_patient_device_fields';

	// Check if the table already exists.
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
		// SQL to create the table.
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `$table_name` (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`patient_id` bigint(20) UNSIGNED NOT NULL,
			`device_id` bigint(20) UNSIGNED NOT NULL,
			`field_id` bigint(20) UNSIGNED NOT NULL,
			`value` text NOT NULL,
			`created_at` datetime DEFAULT CURRENT_TIMESTAMP,
			`updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `patient_device_index` (`patient_id`, `device_id`)
		) $charset_collate ENGINE=InnoDB;";

		// Include the upgrade script.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		// Execute the SQL query to create the table.
		dbDelta( $sql );
	}
}


/**
 * Tabels init
 *
 * @return void
 */
function surv_tables() {
	create_surv_patient_table();
	create_surv_patient_device_connections_table();
	create_surv_form_fields_table();
	create_surv_form_field_options_table();
	create_surv_patient_device_fields_table();
}

// Register the activation hook.
add_action( 'after_switch_theme', 'surv_tables' );
