<?php
/**
 * Surveillance devices partial
 *
 * @package Surveillance
 */

defined( 'ABSPATH' ) || die;

?>
<div class="container mt-4">
	<table class="table table-striped table-bordered">
		<thead class="thead-dark">
			<tr>
				<th>Device Name</th>
				<th>Insertion date</th>
				<th>Device Days</th>
				<?php if ( empty( $_GET['show'] ) || 'details-only' !== $_GET['show'] ) { ?>
				<th>Actions</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $surveillances_devices ) ) : ?>
				<?php foreach ( $surveillances_devices as $device ) : ?>
					<tr>
						<td><?php echo esc_html( $device['device_name'] ); ?></td>
						<td><?php echo esc_html( $device['created_at'] ); ?></td>
						<td><?php echo esc_html( $device['device_days'] ); ?></td>
						<?php if ( empty( $_GET['show'] ) || 'details-only' !== $_GET['show'] ) { ?>
						<td>
							<?php if ( ! $device['ended_at'] ) { ?>
							<!-- Example action buttons -->
							<button 
								class="btn btn-sm btn-danger" 
								hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=end_device' ) ); ?>"
								hx-vals=
								'{
								"surveillance_device_id": "<?php echo esc_js( $device['surveillance_device_id'] ); ?>",
								"end_device": "<?php echo esc_js( wp_create_nonce( 'end_device_nonce' ) ); ?>"
								}'
								hx-confirm="Are you sure you want to end this device?"
								hx-target="this"
								hx-swap="outerHTML"
								hx-indicator="#maglev-loading-indicator"
							>
								End Device
							</button>
							<?php } ?>
							<button 
								class="btn btn-sm btn-warning" 
								>
								bundle care
							</button>
						</td>
						<?php } ?>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="4" class="text-center">No devices found.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
