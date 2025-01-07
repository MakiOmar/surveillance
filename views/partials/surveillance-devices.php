<?php // phpcs:disable WordPress.Security.NonceVerification.Recommended
/**
 * Surveillance devices partial
 *
 * @package Surveillance
 */

defined( 'ABSPATH' ) || die;

?>
<div class="container mt-5">
	<h2 class="mb-4">Bundle Care Status</h2>
	<div class="row">
		<!-- Green square for today's bundle care is set -->
		<div class="col-md-4 d-flex align-items-center">
			<div class="bg-success text-white text-center rounded-circle" style="width: 30px; height: 30px; line-height: 30px; font-weight: bold;">G</div>
			<span class="ms-3">Bundle care is set</span>
		</div>
		<!-- Red square for missing bundle care for today -->
		<div class="col-md-4 d-flex align-items-center">
		<div class="bg-danger text-white text-center rounded-circle" style="width: 30px; height: 30px; line-height: 30px; font-weight: bold;">R</div>
		<span class="ms-3">Missing bundle care for today</span>
		</div>
		<!-- Black square for missing bundle care for other dates -->
		<div class="col-md-4 d-flex align-items-center">
		<div class="bg-dark text-white text-center rounded-circle" style="width: 30px; height: 30px; line-height: 30px; font-weight: bold;">B</div>
		<span class="ms-3">Missing bundle care for dates.</span>
		</div>
	</div>
	</div>
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
					<tr class="bg-<?php echo esc_attr( $device['status'] ); ?> text-<?php echo esc_attr( $device['text'] ); ?>">
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
								data-bs-target="#bundleCareModal"
								hx-no-swal="true"
								hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=get_bundlecare' ) ); ?>"
								hx-vals=
								'{
								"device_id": "<?php echo esc_js( $device['device_id'] ); ?>",
								"surveillance_device_id": "<?php echo esc_js( $device['surveillance_device_id'] ); ?>",
								"getbundlecare": "<?php echo esc_js( wp_create_nonce( 'getbundlecare_nonce' ) ); ?>"
								}'
								hx-target="#bundlecare-content"
								hx-swap="innerHTML"
								hx-indicator="#maglev-loading-indicator"
								>
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
				<?php
				if ( ! empty( $device['missing_dates'] ) ) {
					?>
						<div class="alert alert-danger" role="alert">
						You did't add the bundlecare for these dates: <?php echo esc_html( implode( '|', $device['missing_dates'] ) ); ?>
						</div>
						<?php
				}
				?>
			<div id="bundlecare-content" hx-no-swal="false"></div>
			</div>
		</div>
	</div>
</div>


