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
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php foreach ( $devicesWithFields as $deviceData ) : ?>
						<?php
						$device = $deviceData['device'];
						$fields = $deviceData['fields'];
						?>

						<h3><?php echo esc_html( $device->label ); ?></h3>

						<?php foreach ( $fields as $fieldData ) : ?>
							<?php
							$field   = $fieldData['field'];
							$options = $fieldData['options'];
							?>

							<div class="form-group">
								<label for="field_<?php echo esc_attr( $field->id ); ?>">
									<?php echo esc_html( $field->field_name ); ?>
									<?php if ( $field->required ) : ?>
										<span style="color: red;">*</span>
									<?php endif; ?>
								</label>

								<?php if ( $field->field_type === 'text' ) : ?>
									<input
										type="text"
										name="fields[<?php echo esc_attr( $device->id ); ?>][<?php echo esc_attr( $field->id ); ?>]"
										id="field_<?php echo esc_attr( $field->id ); ?>"
										class="form-control"
										required="<?php echo esc_attr( $field->required ? 'true' : 'false' ); ?>"
									>
								<?php elseif ( $field->field_type === 'radio' ) : ?>
									<?php foreach ( $options as $option ) : ?>
										<div class="form-check">
											<input
												type="radio"
												name="fields[<?php echo esc_attr( $device->id ); ?>][<?php echo esc_attr( $field->id ); ?>]"
												id="field_<?php echo esc_attr( $field->id . '_' . $option->id ); ?>"
												value="<?php echo esc_attr( $option->option_value ); ?>"
												class="form-check-input"
											>
											<label
												class="form-check-label"
												for="field_<?php echo esc_attr( $field->id . '_' . $option->id ); ?>"
											>
												<?php echo esc_html( $option->option_value ); ?>
											</label>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					<?php endforeach; ?>

					<button type="submit" class="btn btn-primary">Save</button>
				</form>
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
