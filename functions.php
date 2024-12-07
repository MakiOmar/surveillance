<?php
/**
 * Surveillance theme
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Surveillance
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define theme constants.
define( 'SURV_THEME_DIR', get_template_directory() );
define( 'SURV_THEME_URL', get_template_directory_uri() );

// Include necessary files.
require_once SURV_THEME_DIR . '/helpers.php';
require_once SURV_THEME_DIR . '/includes/tables.php';
require_once SURV_THEME_DIR . '/autoload.php';
require_once SURV_THEME_DIR . '/routes/ajax-actions.php';
