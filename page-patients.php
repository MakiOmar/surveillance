<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); // Include the header.php template part.
?>
<div class="container mt-5">
<h2 class="text-center mb-4">Patient Surveillance Table</h2>
	<div class="table-responsive">
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
				<!-- Sample Row -->
				<tr>
					<td>PAT12345</td>
					<td>John Doe</td>
					<td>Male</td>
					<td></td> <!-- Empty for now -->
					<td>Yes</td>
					<td>2024-12-07</td>
					<td>No</td>
					<td>
						<!-- Placeholder for actions -->
						<button class="btn btn-sm btn-info">View</button>
						<button class="btn btn-sm btn-warning">Edit</button>
						<button class="btn btn-sm btn-danger">Delete</button>
					</td>
				</tr>
				<!-- Add more rows as needed -->
			</tbody>
		</table>
	</div>
</div>

<?php
get_footer(); // Include the footer.php template part.
