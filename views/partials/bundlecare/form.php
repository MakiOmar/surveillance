<?php
/**
 * Bundel care form
 *
 * @package surv
 */

/**
 * Prevent direct access to the file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<form
	hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=insert_bundle_care' ) ); ?>"
	hx-swap="none"
	hx-indicator="#maglev-loading-indicator"
	hx-confirm="Are you sure?"
	>
	<?php load_view( 'partials/bundlecare/' . $device_id ); ?>
	<input type="hidden" name="surveillance_device_id" value="<?php echo esc_attr( $surveillance_device_id ); ?>">
	<?php wp_nonce_field( 'insertbundlecare_nonce', '_wpnonce' ); ?>
	<button type="submit" class="btn btn-success mt-2">Submit</button>
</form>
<?php load_view( 'partials/bundlecare/bundlecare-table', array( 'bundle_care_records' => $bundle_care_records ) ); ?>