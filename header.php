<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
	<style>
	.surv-navbar {
		background-color: #343a40; /* Dark background */
		padding: 0.8rem 1rem;
	}
	.surv-navbar .nav-link {
		color: #ffffff; /* White text */
		transition: color 0.3s ease-in-out;
	}
	.surv-navbar .nav-link:hover {
		color: #1bc5bd; /* Custom hover color */
	}
	.surv-navbar .navbar-brand {
		color: #ffa800; /* Custom brand color */
		font-weight: bold;
		transition: color 0.3s ease-in-out;
	}
	.surv-navbar .navbar-brand:hover {
		color: #ffffff; /* Hover to white */
	}
	.surv-navbar-toggler {
		border-color: #ffa800; /* Custom toggler border color */
	}
	/* Custom background for the navigation container */
	.nav-tabs {
		background-color: #007bff; /* Blue background */
		padding: 10px;
		border-radius: 5px;
	}
	/* Styling for tabs */
	.nav-tabs .nav-link {
		color: #fff; /* White text */
		border: none;
		margin-bottom: 5px;
	}
	.nav-tabs .nav-link.active {
		background-color: #0056b3; /* Darker blue for active tab */
		color: #fff; /* White text */
	}
	.nav-tabs .nav-link:hover {
		background-color: #0056b3; /* Hover effect for tabs */
	}
	.custom-gray-div {
		background-color: #f8f9fa; /* Light gray */
		border-radius: 15px; /* Custom border radius */
		padding: 1.5rem;
		border: 1px solid #dee2e6; /* Light border color */
	}
	.alert{
		margin: 5px 0;
	}
	</style>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<nav class="navbar navbar-expand-lg surv-navbar">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Surveillance system</a>
			<button class="navbar-toggler surv-navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#survNavbar" aria-controls="survNavbar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="survNavbar">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="/start-surv">Add patient</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/patients">Patients</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Services</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Contact</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
