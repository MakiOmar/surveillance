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
	<?php
		$controller = new PatientController();
		$controller->lineList();
	?>
</div>
<?php
get_footer(); // Include the footer.php template part.
