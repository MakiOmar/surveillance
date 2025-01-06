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
								data-bs-toggle="modal" 
								data-bs-target="#bundleCareModal">
								Bundle Care
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
<!-- Modal -->
<div class="modal fade" id="bundleCareModal" tabindex="-1" aria-labelledby="bundleCareModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="bundleCareModalLabel">Bundle Care Details</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			<form>
				<table class="bundlecare">
					<thead>
						<tr>
							<th rowspan="2">Date</th>
							<th colspan="3">Hand Hygiene</th>
							<th colspan="3">Daily assessment of catheter necessity</th>
							<th colspan="3">Proper dressing choice</th>
							<th colspan="3">* Proper frequency of dressing change</th>
							<th colspan="3">** Proper replacement of administrative sets</th>
						</tr>
						<tr>
							<th>YES</th>
							<th>No</th>
							<th>N/A</th>
							<th>YES</th>
							<th>No</th>
							<th>N/A</th>
							<th>YES</th>
							<th>No</th>
							<th>N/A</th>
							<th>YES</th>
							<th>No</th>
							<th>N/A</th>
							<th>YES</th>
							<th>No</th>
							<th>N/A</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="date" name="date">
							</td>
							<!-- Hand Hygiene -->
							<td><input type="radio" name="hand_hygiene" value="YES"></td>
							<td><input type="radio" name="hand_hygiene" value="No"></td>
							<td><input type="radio" name="hand_hygiene" value="N/A"></td>
							<!-- Catheter Necessity -->
							<td><input type="radio" name="catheter_assessment" value="YES"></td>
							<td><input type="radio" name="catheter_assessment" value="No"></td>
							<td><input type="radio" name="catheter_assessment" value="N/A"></td>
							<!-- Proper Dressing Choice -->
							<td><input type="radio" name="dressing_choice" value="YES"></td>
							<td><input type="radio" name="dressing_choice" value="No"></td>
							<td><input type="radio" name="dressing_choice" value="N/A"></td>
							<!-- Frequency of Dressing Change -->
							<td><input type="radio" name="dressing_frequency" value="YES"></td>
							<td><input type="radio" name="dressing_frequency" value="No"></td>
							<td><input type="radio" name="dressing_frequency" value="N/A"></td>
							<!-- Replacement of Administrative Sets -->
							<td><input type="radio" name="replacement_sets" value="YES"></td>
							<td><input type="radio" name="replacement_sets" value="No"></td>
							<td><input type="radio" name="replacement_sets" value="N/A"></td>
						</tr>
					</tbody>
				</table>
				<button type="submit">Submit</button>
			</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>


