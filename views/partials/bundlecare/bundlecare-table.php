<?php
/**
 * View: Bundle Care Table
 *
 * @package surv
 */

/**
 * Prevent direct access to the file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Check if there are any bundle care records.
if ( empty( $bundle_care_records ) ) {
	echo '<p>No data available to display.</p>';
	return;
}

// Initialize the table headers.
$headers = array();

// Process records to extract data and prepare headers.
$processed_records = array();
foreach ( $bundle_care_records as $bundle_care_record ) {
	// Decode the bundle_care JSON.
	$bundle_care_table = json_decode( $bundle_care_record->bundle_care, true );

	// Skip invalid or empty JSON.
	if ( ! is_array( $bundle_care_table ) || empty( $bundle_care_table ) ) {
		continue;
	}

	// Add created_at to the data.
	$bundle_care_table['created_at'] = $bundle_care_record->created_at;

	// Collect all unique headers.
	$headers = array_merge( $headers, array_keys( $bundle_care_table ) );

	// Store the processed record.
	$processed_records[] = $bundle_care_table;
}

// Ensure headers are unique.
$headers = array_unique( $headers );

// If no valid records, display a message.
if ( empty( $processed_records ) ) {
	echo '<p>No data available to display.</p>';
	return;
}
?>

<h3>Bundle Care Records</h3>
<table class="bundle-care-table" border="1" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
	<thead>
		<tr>
			<?php foreach ( $headers as $header ) : ?>
				<th style="padding: 8px; text-align: left; background-color: #f2f2f2;">
					<?php echo esc_html( ucwords( str_replace( '_', ' ', $header ) ) ); ?>
				</th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $processed_records as $record ) : ?>
			<tr>
				<?php foreach ( $headers as $header ) : ?>
					<td style="padding: 8px; text-align: left;">
						<?php echo esc_html( isset( $record[ $header ] ) ? $record[ $header ] : '-' ); ?>
					</td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
