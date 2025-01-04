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
			class="btn btn-sm <?php echo esc_html( 'under_surveillance' === $patient->status ? 'btn-danger' : 'btn-success' ); ?>"
			data-hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=toggle_surveillance_status' ) ); ?>" 
			data-hx-target="closest tr" 
			data-hx-swap="outerHTML"
			hx-indicator="#maglev-loading-indicator"
			data-hx-vals='{"id": "<?php echo esc_js( $patient->id ); ?>"}'
			>
			<?php echo esc_html( 'under_surveillance' === $patient->status ? 'End' : 'Start' ); ?>
		</button>
		<a class="btn btn-sm btn-warning" href="<?php echo esc_url( add_query_arg( 'patient', $patient->id, home_url( '/line-list' ) ) ); ?>">Line list</a>
	</td>
</tr>
