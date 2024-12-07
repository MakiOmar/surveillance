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
					<td></td> <!-- Placeholder for Device Surveillance Days -->
					<td><?php echo esc_html( 'under_surveillance' === $patient->status ? 'Yes' : 'No' ); ?></td>
					<td><?php echo esc_html( $patient->created_at ? $patient->created_at->format( 'Y-m-d' ) : '' ); ?></td>
					<td>No</td> <!-- Static for now -->
					<td>
						<button 
							class="btn btn-sm btn-primary" 
							data-hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=toggle_surveillance_status' ) ); ?>" 
							data-hx-include="[name=id]" 
							data-hx-target="this" 
							data-hx-swap="innerHTML"
							hx-confirm="Are you sure?">
							<?php echo esc_html( 'under_surveillance' === $patient->status ? 'End' : 'Start' ); ?>
						</button>
						<input type="hidden" name="id" value="<?php echo esc_attr( $patient->id ); ?>">
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
