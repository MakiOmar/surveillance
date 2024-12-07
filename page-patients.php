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

<?php
get_footer(); // Include the footer.php template part.
