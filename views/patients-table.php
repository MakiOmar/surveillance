<?php
/**
 * Patients table view
 *
 * @package surv
 */

/**
 * Prevent direct access to the file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! empty( $patients ) ) : ?>
	<table class="table table-bordered table-hover align-middle text-center">
		<thead class="table-primary">
			<tr>
				<th>Patient Code</th>
				<th>Patient Full Name</th>
				<th>Gender</th>
				<th>Device Surveillance Days</th>
				<th>Under Surveillance?</th>
				<th>Creation Date</th>
				<th>Isolation</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $patients as $patient ) : ?>
				<tr>
					<td><?php echo esc_html( $patient->code ); ?></td>
					<td><?php echo esc_html( trim( $patient->first_name . ' ' . $patient->second_name . ' ' . $patient->last_name ) ); ?></td>
					<td><?php echo esc_html( $patient->gender ); ?></td>
					<td><?php echo esc_html( $patient->surveillance_days_count ); ?></td>
					<td><?php echo esc_html( 'under_surveillance' === $patient->status ? 'Yes' : 'No' ); ?></td>
					<td><?php echo esc_html( $patient->created_at ? $patient->created_at->format( 'Y-m-d' ) : '' ); ?></td>
					<td>No</td> <!-- Static for now -->
					<td>
						<button 
							class="btn btn-sm <?php echo esc_html( 'under_surveillance' === $patient->status ? 'btn-danger' : 'btn-success' ); ?>" 
							data-hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=toggle_surveillance_status' ) ); ?>" 
							data-hx-vals='{"id": "<?php echo esc_js( $patient->id ); ?>", "nonce": "<?php echo esc_js( wp_create_nonce( 'toggle_surveillance_status_nonce' ) ); ?>"}'
							data-hx-target="closest tr" 
							data-hx-swap="outerHTML"
							hx-indicator="#maglev-loading-indicator"
							hx-confirm="Are you sure?">
							<?php echo esc_html( 'under_surveillance' === $patient->status ? 'End' : 'Start' ); ?>
						</button>
						<?php
						//phpcs:disable
						if ( 'under_surveillance' === $patient->status ) {
							$line_list_url = esc_url( add_query_arg( 'patient', $patient->id, home_url( '/line-list' ) ) );
							$class         = '';
						} else {
							$line_list_url = '#';
							$class         = ' disabled';
						}
						?>
						<a class="btn btn-sm btn-warning<?php echo $class; ?>" href="<?php echo $line_list_url; ?>">Line list</a>
						<a 
							class="btn btn-sm btn-primary" 
							href="#"
							>
							Edit
						</a>
						<a 
							class="btn btn-sm btn-info" 
							href="<?php echo esc_url(
								add_query_arg(
									array(
										'patient' => $patient->id,
										'show'    => 'details-only',
									)
									, home_url( '/line-list' ) )
							); ?>"
							>
							Details
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Pagination -->
	<nav>
		<ul class="pagination justify-content-center">
			<?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
				<li class="page-item <?php echo ( $i === $current_page ) ? 'active' : ''; ?>">

					<a class="page-link" href="?page=<?php echo $i; //phpcs:disable ?>">
						<?php echo $i; ?>
					</a>
				</li>
			<?php endfor; //phpcs:enable ?>
		</ul>
	</nav>
<?php else : ?>
	<p>No patients found.</p>
<?php endif; ?>
