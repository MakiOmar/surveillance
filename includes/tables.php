<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Hook into theme activation
function create_surv_patient_table_on_activation() {
	global $wpdb;

	// Table name with the correct WordPress table prefix
	$table_name = $wpdb->prefix . 'surv_patient';
	$users_table = $wpdb->prefix . 'users'; // WordPress users table

	// Check if the table already exists
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
		// SQL to create the table
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `$table_name` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `code` varchar(20) NOT NULL UNIQUE,
            `status` text DEFAULT NULL,
            `first_name` text DEFAULT NULL,
            `second_name` text DEFAULT NULL,
            `last_name` text DEFAULT NULL,
            `age` bigint(20) DEFAULT NULL,
            `address` text DEFAULT NULL,
            `job` text DEFAULT NULL,
            `nationality` text DEFAULT NULL,
            `gender` text DEFAULT NULL,
            `identity` text DEFAULT NULL,
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

		// Include the upgrade script
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		// Execute the SQL query to create the table
		dbDelta( $sql );
	}
}

// Register the activation hook
add_action( 'after_switch_theme', 'create_surv_patient_table_on_activation' );
