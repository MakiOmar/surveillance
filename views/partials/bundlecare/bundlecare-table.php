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

// Decode the bundle_care JSON.
$bundle_care_json  = $bundle_care_record->bundle_care;
$bundle_care_table = json_decode( $bundle_care_json, true );
if ( ! is_array( $bundle_care_table ) || empty( $bundle_care_table ) ) {
	echo '<p>No data available to display.</p>';
	return;
}
$bundle_care_table['created_at'] = $bundle_care_record->created_at;
?>

<table class="bundle-care-table" border="1" style="width: 100%; border-collapse: collapse;">
	<thead>
		<tr>
			<?php foreach ( array_keys( $bundle_care_table ) as $key ) : ?>
				<th style="padding: 8px; text-align: left; background-color: #f2f2f2;">
					<?php echo esc_html( ucwords( str_replace( '_', ' ', $key ) ) ); ?>
				</th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php foreach ( $bundle_care_table as $value ) : ?>
				<td style="padding: 8px; text-align: left;">
					<?php echo esc_html( $value ); ?>
				</td>
			<?php endforeach; ?>
		</tr>
	</tbody>
</table>
