<?php

/*
Filename: common_functions.php
Author: Gregory Ruta
Purpose: Contains common functions used by two or more of the following pages: process_order.php, fix_order.php, receipt.php, manager.php, authenticate.php, password_change.php
Created: 23/05/2020
Last Modified: 01/06/2020
Credits: None
*/

// Function: Sanitise input
function sanitise_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Function: Add dollar sign and thousands's comma separators.
function dollar($input) {
	$output = "$" . number_format($input, 2, ".", ",");
	return $output;
}

// Function: Beautify text (i.e. Will convert "north_america" to "North America")
function beautify($input) {
	$output = str_replace("_", " ", $input);
	$output = ucwords($output);
	return $output;
}

?>