<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); // Include the header.php template part.
?>
<div class="container mt-5">
	<form 
		hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=insert_patient' ) ); ?>" 
		hx-swap="outerHTML"
		hx-indicator="#maglev-loading-indicator" 
		method="POST"
	>
		<div class="row mb-3">
			<div class="col-md-4">
				<label for="first_name" class="form-label">First Name</label>
				<input type="text" class="form-control" id="first_name" name="first_name" required>
			</div>
			<div class="col-md-4">
				<label for="second_name" class="form-label">Second Name</label>
				<input type="text" class="form-control" id="second_name" name="second_name" required>
			</div>
			<div class="col-md-4">
				<label for="last_name" class="form-label">Last Name</label>
				<input type="text" class="form-control" id="last_name" name="last_name" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4">
				<label for="age" class="form-label">Age</label>
				<input type="number" class="form-control" id="age" name="age" required>
			</div>
			<div class="col-md-4">
				<label for="address" class="form-label">Address</label>
				<input type="text" class="form-control" id="address" name="address" required>
			</div>
			<div class="col-md-4">
				<label for="job" class="form-label">Job</label>
				<input type="text" class="form-control" id="job" name="job" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4">
				<label for="nationality" class="form-label">Nationality</label>
				<input type="text" class="form-control" id="nationality" name="nationality" required>
			</div>
			<div class="col-md-4">
				<label for="gender" class="form-label">Gender</label>
				<select class="form-select" id="gender" name="gender" required>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
			<div class="col-md-4">
				<label for="identity" class="form-label">Identity</label>
				<input type="text" class="form-control" id="identity" name="identity" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-md-4">
				<label for="date_of_birth" class="form-label">Date of Birth</label>
				<input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
			</div>
			<div class="col-md-4">
				<label for="date_of_admission" class="form-label">Date of Admission</label>
				<input type="date" class="form-control" id="date_of_admission" name="date_of_admission" required>
			</div>
			<div class="col-md-4">
				<label for="mobile_number" class="form-label">Mobile Number</label>
				<input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-md-6">
				<label for="place_of_admission" class="form-label">Place of Admission</label>
				<input type="text" class="form-control" id="place_of_admission" name="place_of_admission" required>
			</div>
			<div class="col-md-6">
				<label for="entry" class="form-label">Entry</label>
				<div class="mb-3">
					<label class="form-label">Select entry</label>
					<div class="form-check d-inline-block me-3">
					<input class="form-check-input" type="radio" name="entry" id="icu" value="ICU" required>
					<label class="form-check-label" for="icu">ICU</label>
					</div>
					<div class="form-check d-inline-block me-3">
					<input class="form-check-input" type="radio" name="entry" id="picu" value="PICU">
					<label class="form-check-label" for="picu">PICU</label>
					</div>
					<div class="form-check d-inline-block me-3">
					<input class="form-check-input" type="radio" name="entry" id="nicu" value="NICU">
					<label class="form-check-label" for="nicu">NICU</label>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>

<?php
get_footer(); // Include the footer.php template part.
