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
			<p>Content for Device tab.</p>
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
