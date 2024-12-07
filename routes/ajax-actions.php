<?php
/**
 * Register custom AJAX actions.
 *
 * This file defines and registers AJAX actions that can be extended
 * using the `maglev_ajax_actions` filter.
 *
 * @package WordPress Maglev
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'wp_ajax_insert_patient', array( new PatientController(), 'insertPatient' ) );
