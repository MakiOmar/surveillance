<?php
/**
 * Patients page
 *
 * @package surv
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); // Include the header.php template part.
?>
<div class="container mt-5">
<h2 class="text-center mb-4">Patient Surveillance Table</h2>
	<div class="table-responsive">
	<?php
		$controller = new PatientController();
		$controller->fetchPatients();
	?>
	</div>
</div>
<script>
	document.addEventListener(
		"htmx:confirm",
		function(e) {
			e.preventDefault()
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
</script>

<?php
get_footer(); // Include the footer.php template part.
