<?php
/**
 * Device 1 bundle care form
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
<table class="bundlecare">
	<thead>
		<tr>
			<th rowspan="2">Date</th>
			<th colspan="3">Hand Hygiene</th>
			<th colspan="3">Daily assessment of catheter necessity</th>
			<th colspan="3">Proper dressing choice</th>
			<th colspan="3">* Proper frequency of dressing change</th>
			<th colspan="3">** Proper replacement of administrative sets</th>
		</tr>
		<tr>
			<th>YES</th>
			<th>No</th>
			<th>N/A</th>
			<th>YES</th>
			<th>No</th>
			<th>N/A</th>
			<th>YES</th>
			<th>No</th>
			<th>N/A</th>
			<th>YES</th>
			<th>No</th>
			<th>N/A</th>
			<th>YES</th>
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
			<td><input type="radio" name="hand_hygiene" value="YES" required></td>
			<td><input type="radio" name="hand_hygiene" value="No"></td>
			<td><input type="radio" name="hand_hygiene" value="N/A"></td>
			<!-- Catheter Necessity -->
			<td><input type="radio" name="catheter_assessment" value="YES" required></td>
			<td><input type="radio" name="catheter_assessment" value="No"></td>
			<td><input type="radio" name="catheter_assessment" value="N/A"></td>
			<!-- Proper Dressing Choice -->
			<td><input type="radio" name="dressing_choice" value="YES" required></td>
			<td><input type="radio" name="dressing_choice" value="No"></td>
			<td><input type="radio" name="dressing_choice" value="N/A"></td>
			<!-- Frequency of Dressing Change -->
			<td><input type="radio" name="dressing_frequency" value="YES" required></td>
			<td><input type="radio" name="dressing_frequency" value="No"></td>
			<td><input type="radio" name="dressing_frequency" value="N/A"></td>
			<!-- Replacement of Administrative Sets -->
			<td><input type="radio" name="replacement_sets" value="YES" required></td>
			<td><input type="radio" name="replacement_sets" value="No"></td>
			<td><input type="radio" name="replacement_sets" value="N/A"></td>
		</tr>
	</tbody>
</table>
