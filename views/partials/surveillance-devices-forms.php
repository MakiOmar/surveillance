<?php
/**
 * Surveillance devices forms partial
 *
 * @package Surveillance
 */

defined( 'ABSPATH' ) || die;

?>
<!-- horizontal Tabs Navigation -->
<div>
	<ul class="nav nav-tabs ps-2" id="v-tabs" role="tablist" aria-orientation="vertical">
		<?php foreach ( $device_fields as $device_type_id => $device_data ) : ?>
			<button 
				class="nav-link <?php echo 1 === $device_type_id ? 'active' : ''; ?>" 
				id="device-tab-<?php echo esc_attr( $device_type_id ); ?>" 
				data-bs-toggle="tab" 
				data-bs-target="#device-<?php echo esc_attr( $device_type_id ); ?>" 
				type="button" 
				role="tab"
				aria-controls="device-<?php echo esc_attr( $device_type_id ); ?>" 
				aria-selected="<?php echo 1 === $device_type_id ? 'true' : 'false'; ?>"
			>
				<?php echo esc_html( $device_data['name'] ); ?>
			</button>
		<?php endforeach; ?>
	</ul>
</div>

<!-- horizontal Tabs Content -->
<div>
	<div class="tab-content ps-2 bg-light-subtle" id="v-tabsContent">
		<?php foreach ( $device_fields as $device_type_id => $device_data ) : ?>
			<div 
				class="tab-pane fade <?php echo 1 === $device_type_id ? 'show active' : ''; ?>" 
				id="device-<?php echo esc_attr( $device_type_id ); ?>" 
				role="tabpanel" 
				aria-labelledby="device-tab-<?php echo esc_attr( $device_type_id ); ?>">
				<h3 class="mt-4"><?php echo esc_html( $device_data['name'] ); ?></h3>
				<form method="post" class="container" 
					hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=connect_device' ) ); ?>" 
					hx-swap="none"
					hx-indicator="#maglev-loading-indicator"
					hx-confirm="Are you sure?"
					>
					<div class="row custom-gray-div">
						<?php foreach ( $device_data['fields'] as $field ) : ?>
							<div class="col-md-4 mb-3">
								<div class="form-group">
									<label>
										<?php echo esc_html( ucfirst( str_replace( '_', ' ', $field['field_name'] ) ) ); ?>
										<?php if ( $field['required'] ) : ?>
											<span style="color: red;">*</span>
										<?php endif; ?>
									</label>
									<?php if ( 'text' === $field['field_type'] ) : ?>
										<input 
											type="text" 
											class="form-control" 
											name="<?php echo esc_attr( $field['field_name'] ); ?>" 
											<?php echo esc_attr( $field['required'] ? 'required' : '' ); ?>>
									<?php elseif ( 'datetime-local' === $field['field_type'] ) : ?>
										<input 
											type="datetime-local" 
											class="form-control" 
											name="<?php echo esc_attr( $field['field_name'] ); ?>" 
											<?php echo esc_attr( $field['required'] ? 'required' : '' ); ?>>
									<?php elseif ( 'radio' === $field['field_type'] ) : ?>
										<?php foreach ( $field['options'] as $option ) : ?>
											<div class="form-check">
												<input 
													type="radio" 
													class="form-check-input" 
													name="<?php echo esc_attr( $field['field_name'] ); ?>" 
													value="<?php echo esc_attr( $option ); ?>">
												<label class="form-check-label">
													<?php echo esc_html( $option ); ?>
												</label>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<input type="hidden" name="patient_id" value="<?php echo esc_attr( $patient->id ); ?>">
					<input type="hidden" name="device_id" value="<?php echo esc_attr( $device_type_id ); ?>">
					<input type="hidden" name="surveillance_id" value="<?php echo esc_attr( $surveillance_id ); ?>">
					<?php wp_nonce_field( 'connect_device', 'connect_device_nonce' ); ?>
					<button type="submit" class="btn btn-success mt-3">Connect</button>
				</form>

			</div>
		<?php endforeach; ?>
	</div>
</div>
