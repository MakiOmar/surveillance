<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
spl_autoload_register(
	function ( $class ) {
		// Define the base directories for autoloading
		$baseDirs = array(
			SURV_THEME_DIR . '/http/controllers/',
			SURV_THEME_DIR . '/http/models/',
		);

		// Replace namespace separators with directory separators and append .php
		$relativePath = str_replace( '\\', '/', $class ) . '.php';

		// Loop through base directories to find the file
		foreach ( $baseDirs as $baseDir ) {
			$file = $baseDir . $relativePath;
            error_log($file);
			// Check if the file exists and include it
			if ( file_exists( $file ) ) {
				require_once $file;
				break; // Stop searching once the file is found
			}
		}
	}
);
