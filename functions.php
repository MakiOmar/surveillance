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


add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'surv',
			get_stylesheet_uri(),
			array(),
			wp_get_theme()->get( 'Version' )
		);
		// Enqueue Select2 CSS.
		wp_enqueue_style( 'select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css', array(), '4.1.0-rc' );

		// Enqueue Select2 JS.
		wp_enqueue_script( 'select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js', array( 'jquery' ), '4.1.0-rc', true );

		// Enqueue custom script to initialize Select2.
		wp_add_inline_script(
			'select2-js',
			'
        jQuery(document).ready(function($) {
            $("select").select2({
                placeholder: "Select an option",
                allowClear: true,
            });
        });
    '
		);
	}
);

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
		if ( in_array( 'anti-infection', (array) $user->roles, true ) || in_array( 'nurse', (array) $user->roles, true ) ) {
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
	if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] ) {
		return;
	}
	// Check if the user is not logged in and not already on the login page.
	if ( ! is_user_logged_in() && ! is_page( 'wp-login.php' ) ) {
		// Redirect to the wp-login.php page.
		wp_safe_redirect( wp_login_url() );
		exit; // Stop further script execution after the redirect.
	}
}
add_action( 'template_redirect', 'redirect_to_wp_login_if_not_logged_in' );


/**
 * Restrict access to the WordPress admin dashboard to administrators only.
 *
 * Redirects non-administrators to the home page or another specified page.
 *
 * @return void
 */
function restrict_dashboard_access() {
	if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] ) {
		return;
	}
	// Check if the current user is trying to access the admin dashboard.
	if ( is_admin() && ! current_user_can( 'manage_options' ) ) {
		// Redirect non-administrators to the home page.
		wp_safe_redirect( home_url( '/start-surv' ) );
		exit; // Stop further script execution after the redirect.
	}
}
add_action( 'admin_init', 'restrict_dashboard_access' );

add_action(
	'wp_footer',
	function () {
		?>
		<script type="text/javascript">
			document.addEventListener(
				"htmx:confirm",
				function(e) {
					if (!e.detail.target.hasAttribute('hx-confirm')) return
					e.preventDefault();
					Swal.fire({
						title: "Proceed?",
						text: `${e.detail.question}`,
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, proceed!',
						cancelButtonText: 'Cancel'
					}).then(function(result) {
						if (result.isConfirmed) e.detail.issueRequest(true) // use true to skip window.confirm
					})
				}
			);
			document.addEventListener("htmx:responseError", function (event) {
				const response = event.detail.xhr;
				
				// Check if the server returned JSON with an error message
				let errorMessage = "An error occurred.";
				try {
					const jsonResponse = JSON.parse(response.responseText);
					if (jsonResponse.error) {
						errorMessage = jsonResponse.error;
					}
				} catch (e) {
					// Fallback for non-JSON responses
					errorMessage = response.responseText || "An unexpected error occurred.";
				}

				// Display the error message (customize this as needed)
				Swal.fire({
					icon: "error",
					title: "Error",
					text: errorMessage,
				});
			});

			document.addEventListener("htmx:afterRequest", function (event) {
				if (event.detail.target.hasAttribute('hx-no-swal')) return;
				const response = event.detail.xhr;
				var reload;
				// Check if the server returned a success response
				if (response.status == 200 ) {
					let successMessage = "Operation completed successfully.";
					try {
						// Attempt to parse JSON if the response contains it
						const jsonResponse = JSON.parse(response.responseText);
						reload = jsonResponse.reload;
						if (jsonResponse.success) {
							successMessage = jsonResponse.success;
						}
					} catch (e) {
						// Fallback for non-JSON responses
						successMessage = "Operation completed.";
						reload = false;
					}

					// Display the success message (customize this as needed)
					Swal.fire({
						icon: "success",
						title: "Success",
						text: successMessage,
					}).then(function(result) {
						if (result.isConfirmed && reload ) location.reload();
					});
				}
			});


		</script>
		<?php
	}
);
