<?php
/**
 * Patient row
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
<tr>
	<td><?php echo esc_html( $patient->code ); ?></td>
	<td><?php echo esc_html( trim( $patient->first_name . ' ' . $patient->second_name . ' ' . $patient->last_name ) ); ?></td>
	<td><?php echo esc_html( $patient->gender ); ?></td>
	<td></td> <!-- Placeholder for Device Surveillance Days -->
	<td><?php echo esc_html( 'under_surveillance' === $patient->status ? 'Yes' : 'No' ); ?></td>
	<td><?php echo esc_html( $patient->created_at ? $patient->created_at->format( 'Y-m-d' ) : '' ); ?></td>
	<td>No</td> <!-- Static for now -->
	<td>
		<button 
			class="btn btn-sm btn-primary" 
			data-hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=toggle_surveillance_status' ) ); ?>" 
			data-hx-target="closest tr" 
			data-hx-swap="outerHTML"
			data-hx-include="[name=id]">
			<?php echo esc_html( 'under_surveillance' === $patient->status ? 'End' : 'Start' ); ?>
		</button>
		<input type="hidden" name="id" value="<?php echo esc_attr( $patient->id ); ?>">
	</td>
</tr>