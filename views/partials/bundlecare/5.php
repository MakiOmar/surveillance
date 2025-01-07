<?php
/**
 * Device 5 Bundle Elements Form
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
			<th colspan="3">Elevation of the head of the bed to between 30 and 45 degrees</th>
			<th colspan="3">Daily "sedative interruption" & daily assessment of readiness to extubate</th>
			<th colspan="3">Peptic ulcer disease (PUD) prophylaxis</th>
			<th colspan="3">Deep venous thrombosis (DVT) prophylaxis (unless contraindicated)</th>
			<th colspan="3">Daily oral care with appropriate antiseptic solution</th>
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
			<!-- Elevation of the head of the bed -->
			<td><input type="radio" name="head_elevation" value="Yes"></td>
			<td><input type="radio" name="head_elevation" value="No"></td>
			<td><input type="radio" name="head_elevation" value="N/A"></td>
			<!-- Sedative interruption -->
			<td><input type="radio" name="sedative_interruption" value="Yes"></td>
			<td><input type="radio" name="sedative_interruption" value="No"></td>
			<td><input type="radio" name="sedative_interruption" value="N/A"></td>
			<!-- PUD prophylaxis -->
			<td><input type="radio" name="pud_prophylaxis" value="Yes"></td>
			<td><input type="radio" name="pud_prophylaxis" value="No"></td>
			<td><input type="radio" name="pud_prophylaxis" value="N/A"></td>
			<!-- DVT prophylaxis -->
			<td><input type="radio" name="dvt_prophylaxis" value="Yes"></td>
			<td><input type="radio" name="dvt_prophylaxis" value="No"></td>
			<td><input type="radio" name="dvt_prophylaxis" value="N/A"></td>
			<!-- Oral care -->
			<td><input type="radio" name="oral_care" value="Yes"></td>
			<td><input type="radio" name="oral_care" value="No"></td>
			<td><input type="radio" name="oral_care" value="N/A"></td>
		</tr>
	</tbody>
</table>
