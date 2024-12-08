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
	</style>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
