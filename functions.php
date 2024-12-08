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
require_once SURV_THEME_DIR . '/includes/fields.php';
require_once SURV_THEME_DIR . '/autoload.php';
require_once SURV_THEME_DIR . '/routes/ajax-actions.php';

add_filter(
	'editable_roles',
	function ( $roles ) {
		// Specify the roles you want to hide.
		$roles_to_hide = array( 'subscriber', 'contributor', 'author', 'editor' );

		foreach ( $roles_to_hide as $role ) {
			if ( isset( $roles[ $role ] ) ) {
				unset( $roles[ $role ] );
			}
		}

		return $roles;
	}
);

add_action(
	'wp_login',
	function ( $user_login, $user ) {
		// Check if the user has the 'nurse' role.
		if ( in_array( 'nurse', (array) $user->roles, true ) ) {
			// Redirect to 'start-surv' page.
			wp_safe_redirect( home_url( '/start-surv' ) );
			exit;
		}
	},
	10,
	2
);

/**
 * Redirect users to the wp-login.php page if they are not logged in.
 * Prevents unauthorized access to protected pages.
 *
 * @return void
 */
function redirect_to_wp_login_if_not_logged_in() {
	// Check if the user is not logged in and not already on the login page.
	if ( ! is_user_logged_in() && ! is_page( 'wp-login.php' ) ) {
		// Redirect to the wp-login.php page.
		wp_safe_redirect( wp_login_url() );
		exit; // Stop further script execution after the redirect.
	}
}
add_action( 'template_redirect', 'redirect_to_wp_login_if_not_logged_in' );
