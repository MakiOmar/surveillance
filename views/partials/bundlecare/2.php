<?php
/**
 * Device 2 bundle care
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
				<th colspan="3">Maintain catheters based on recommended guidelines*</th>
				<th colspan="3">Review urinary catheter necessity daily and remove promptly</th>
			</tr>
			<tr>
				<th>Y</th>
				<th>N</th>
				<th>N/A</th>
				<th>Y</th>
				<th>N</th>
				<th>N/A</th>
				<th>Y</th>
				<th>N</th>
				<th>N/A</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<input type="date" name="date">
				</td>
				<!-- Hand Hygiene -->
				<td><input type="radio" name="hand_hygiene" value="Y"></td>
				<td><input type="radio" name="hand_hygiene" value="N"></td>
				<td><input type="radio" name="hand_hygiene" value="N/A"></td>
				<!-- Maintain Catheters -->
				<td><input type="radio" name="maintain_catheters" value="Y"></td>
				<td><input type="radio" name="maintain_catheters" value="N"></td>
				<td><input type="radio" name="maintain_catheters" value="N/A"></td>
				<!-- Review Catheter Necessity -->
				<td><input type="radio" name="review_catheter" value="Y"></td>
				<td><input type="radio" name="review_catheter" value="N"></td>
				<td><input type="radio" name="review_catheter" value="N/A"></td>
			</tr>
		</tbody>
	</table>
	<button type="submit">Submit</button>
</form>
