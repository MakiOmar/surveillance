<?php
/**
 * Device 6 bundle care
 *
 * @package surv
 */

/**
 * Prevent direct access to the file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<form>
	<table class="bundlecare">
		<thead>
			<tr>
				<th rowspan="2">Date</th>
				<th colspan="3">Hand Hygiene</th>
				<th colspan="3">*Semi-recumbent position</th>
				<th colspan="3">*Mouth rinse with an appropriate solution</th>
				<th colspan="3">Appropriate ventilator circuit care</th>
				<th colspan="3">Daily assessment of readiness to extubate</th>
			</tr>
			<tr>
				<th>Yes</th>
				<th>No</th>
				<th>N/A</th>
				<th>Yes</th>
				<th>No</th>
				<th>N/A</th>
				<th>Yes</th>
				<th>No</th>
				<th>N/A</th>
				<th>Yes</th>
				<th>No</th>
				<th>N/A</th>
				<th>Yes</th>
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
				<td><input type="radio" name="hand_hygiene" value="Yes"></td>
				<td><input type="radio" name="hand_hygiene" value="No"></td>
				<td><input type="radio" name="hand_hygiene" value="N/A"></td>
				<!-- Semi-recumbent position -->
				<td><input type="radio" name="semi_recumbent" value="Yes"></td>
				<td><input type="radio" name="semi_recumbent" value="No"></td>
				<td><input type="radio" name="semi_recumbent" value="N/A"></td>
				<!-- Mouth rinse -->
				<td><input type="radio" name="mouth_rinse" value="Yes"></td>
				<td><input type="radio" name="mouth_rinse" value="No"></td>
				<td><input type="radio" name="mouth_rinse" value="N/A"></td>
				<!-- Ventilator circuit care -->
				<td><input type="radio" name="ventilator_care" value="Yes"></td>
				<td><input type="radio" name="ventilator_care" value="No"></td>
				<td><input type="radio" name="ventilator_care" value="N/A"></td>
				<!-- Readiness to extubate -->
				<td><input type="radio" name="readiness_extubate" value="Yes"></td>
				<td><input type="radio" name="readiness_extubate" value="No"></td>
				<td><input type="radio" name="readiness_extubate" value="N/A"></td>
			</tr>
		</tbody>
	</table>
	<button type="submit">Submit</button>
</form>
