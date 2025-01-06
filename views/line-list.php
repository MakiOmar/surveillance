<?php
/**
 * Line list
 *
 * @package surv
 */

	// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<h2 class="text-center mb-4 p-1 bg-success text-white rounded">
	<?php echo esc_html( "({$patient->code}) - {$patient->first_name} {$patient->second_name} {$patient->last_name} - {$patient->gender} - {$patient->created_at} - {$patient->age}" ); ?>
</h2>
<div class="container mt-5">
<div class="row">
		<!-- Vertical Tabs Navigation -->
		<div class="col-3">
		<div class="nav flex-column nav-tabs ps-2" id="v-tabs" role="tablist" aria-orientation="vertical">
			<button class="nav-link active" id="device-tab" data-bs-toggle="tab" data-bs-target="#device" type="button" role="tab" aria-controls="device" aria-selected="true">Device</button>
			<button class="nav-link" id="event-tab" data-bs-toggle="tab" data-bs-target="#event" type="button" role="tab" aria-controls="event" aria-selected="false">Event</button>
			<button class="nav-link" id="cultures-tab" data-bs-toggle="tab" data-bs-target="#cultures" type="button" role="tab" aria-controls="cultures" aria-selected="false">Cultures</button>
			<button class="nav-link" id="signs-symptoms-tab" data-bs-toggle="tab" data-bs-target="#signs-symptoms" type="button" role="tab" aria-controls="signs-symptoms" aria-selected="false">Signs & Symptoms</button>
			<button class="nav-link" id="isolation-mdro-tab" data-bs-toggle="tab" data-bs-target="#isolation-mdro" type="button" role="tab" aria-controls="isolation-mdro" aria-selected="false">Isolation & MDRO</button>
			<button class="nav-link" id="antibiotic-tab" data-bs-toggle="tab" data-bs-target="#antibiotic" type="button" role="tab" aria-controls="antibiotic" aria-selected="false">Antibiotic</button>
			<button class="nav-link" id="surgery-tab" data-bs-toggle="tab" data-bs-target="#surgery" type="button" role="tab" aria-controls="surgery" aria-selected="false">Surgery</button>
		</div>
		</div>

		<!-- Vertical Tabs Content -->
		<div class="col-9">
		<div class="tab-content ps-2 bg-light-subtle" id="v-tabsContent">
			<div class="tab-pane fade show active" id="device" role="tabpanel" aria-labelledby="device-tab">
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
													<?php elseif ( 'date' === $field['field_type'] ) : ?>
														<input 
															type="date" 
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

				<div class="container mt-4">
					<table class="table table-striped table-bordered">
						<thead class="thead-dark">
							<tr>
								<th>Device Name</th>
								<th>Insertion date</th>
								<th>Device Days</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if ( ! empty( $surveillances_devices ) ) : ?>
								<?php foreach ( $surveillances_devices as $device ) : ?>
									<tr>
										<td><?php echo esc_html( $device['device_name'] ); ?></td>
										<td><?php echo esc_html( $device['created_at'] ); ?></td>
										<td><?php echo esc_html( $device['device_days'] ); ?></td>
										<td>
											<?php if ( ! $device['ended_at'] ) { ?>
											<!-- Example action buttons -->
											<button 
												class="btn btn-sm btn-danger" 
												hx-post="<?php echo esc_url( admin_url( 'admin-ajax.php?action=end_device' ) ); ?>"
												hx-vals=
												'{
												"surveillance_device_id": "<?php echo esc_js( $device['surveillance_device_id'] ); ?>",
												"end_device": "<?php echo esc_js( wp_create_nonce( 'end_device_nonce' ) ); ?>"
												}'
												hx-confirm="Are you sure you want to end this device?"
												hx-target="this"
												hx-swap="outerHTML"
												hx-indicator="#maglev-loading-indicator"
											>
												End Device
											</button>
											<?php } ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="4" class="text-center">No devices found.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>

			</div>

			<div class="tab-pane fade" id="event" role="tabpanel" aria-labelledby="event-tab">
			<p>Content for Event tab.</p>
			</div>
			<div class="tab-pane fade" id="cultures" role="tabpanel" aria-labelledby="cultures-tab">
			<p>Content for Cultures tab.</p>
			</div>
			<div class="tab-pane fade" id="signs-symptoms" role="tabpanel" aria-labelledby="signs-symptoms-tab">
			<p>Content for Signs & Symptoms tab.</p>
			</div>
			<div class="tab-pane fade" id="isolation-mdro" role="tabpanel" aria-labelledby="isolation-mdro-tab">
			<p>Content for Isolation & MDRO tab.</p>
			</div>
			<div class="tab-pane fade" id="antibiotic" role="tabpanel" aria-labelledby="antibiotic-tab">
			<p>Content for Antibiotic tab.</p>
			</div>
			<div class="tab-pane fade" id="surgery" role="tabpanel" aria-labelledby="surgery-tab">
			<p>Content for Surgery tab.</p>
			</div>
		</div>
		</div>
	</div>
</div>