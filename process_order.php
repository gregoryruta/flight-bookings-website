<?php

// Get common functions	
require_once("common_functions.php");

// Start session
session_start();

// Redirect if page is accessed directly
if (!isset($_POST["first_name"])) {
	header("location:index.php");
	exit();
}

// Retrieve POST data. But not all POST data.
// (Javascript generated pricing will not be retrieved)
$first_name = sanitise_input($_POST["first_name"]);
$last_name = sanitise_input($_POST["last_name"]);
$street_address = sanitise_input($_POST["street_address"]);
$suburb_town = sanitise_input($_POST["suburb_town"]);
$state = sanitise_input($_POST["state"]);
$postcode = sanitise_input($_POST["postcode"]);
$phone = sanitise_input($_POST["phone"]);
$email = sanitise_input($_POST["email"]);
$preferred_contact = sanitise_input($_POST["preferred_contact"]);
$origin = sanitise_input($_POST["origin"]);
$destination = sanitise_input($_POST["destination"]);
$option = sanitise_input($_POST["option"]);

// If there are any selected extras...
if (isset($_POST["extras"])) {
	
	/* The following two if-statements are a messy fix, but I could not forsee what 
	the requirements of Part 3 would be while working on Part 2, and I do not have
	the time to redo the Javascript and HTML from Part 2. */
	
	// Retrieve selected extras as a string from payment.php & convert to an array
	if (is_string($_POST["extras"])) {
		$extras_arr = array_filter(explode(",", $_POST["extras"]));
	}
	// Retrieve selected extras as an array from fix_order.php & leave as an array
	if (is_array($_POST["extras"])) {
		$extras_arr = $_POST["extras"];
	}
	// Sanitise selected extras
	for ($i = 0; $i < count($extras_arr); $i++) { 
		$extras_arr[$i] = sanitise_input($extras_arr[$i]);
	}
} else {
	$extras_arr =[];
}

$tickets = sanitise_input($_POST["tickets"]);
$comments = sanitise_input($_POST["comments"]);
$cc_type = sanitise_input($_POST["cc_type"]);
$cc_name = sanitise_input($_POST["cc_name"]);
$cc_number = sanitise_input($_POST["cc_number"]);
$cc_expiry = sanitise_input($_POST["cc_expiry"]);
$cc_cvv = sanitise_input($_POST["cc_cvv"]);

// Function: Validate postcode with state
function validate_postcode($state, $postcode) {
	$char0 = $postcode[0];
	if ($state === "VIC" && ($char0 === "3" || $char0 === "8")) {
		return true;
	}
	if ($state === "NSW" && ($char0 === "1" || $char0 === "2")) {
		return true;
	}
	if ($state === "QLD" && ($char0 === "4" || $char0 === "9")) {
		return true;
	}
	if ($state === "NT" && $char0 === "0") {
		return true;
	}
	if ($state === "WA" && $char0 === "6") {
		return true;
	}
	if ($state === "SA" && $char0 === "5") {
		return true;
	}
	if ($state === "TAS" && $char0 === "7") {
		return true;
	}
	if ($state === "ACT" && $char0 === "0") {
		return true;
	}
}

// Function: Validate a Visa card number
function validate_cc_visa($cc_number) {
	$first_number = $cc_number[0];
	$length = strlen($cc_number);
	if ($first_number === "4" && $length === 16) {
		return true;
	}
}

// Function: Validate a Mastercard card number
function validate_cc_mastercard($cc_number) {
	$first_2_numbers = substr($cc_number, 0, 2);
	$length = strlen($cc_number);
	if (preg_match("/51|52|53|54|55/", $first_2_numbers) && $length === 16) {
		return true;
	}
}

// Function: Validate an American Express card number
function validate_cc_american_express($cc_number) {
	$first_2_numbers = substr($cc_number, 0, 2);
	$length = strlen($cc_number);
	if (preg_match("/34|37/", $first_2_numbers) && $length === 15) {
		return true;
	}
}

// Function: Validate credit card expiry date
function validate_cc_expiry($cc_expiry) {
	$cc_expiry_mm = substr($cc_expiry, 0, 2) + 1; // Add a month to the entered value (12 becomes 13)
	$cc_expiry_yyyy = "20" . substr($cc_expiry, 3, 5);
	// Use date_create_from_format() because date_create() will not accept a month value of 13
	$cc_expiry_date = date_create_from_format("d-m-Y H-i-s-u","01-$cc_expiry_mm-$cc_expiry_yyyy 00-00-00-000000");
	// Deduct 1 second to bring is to the last second in the current month
	date_modify($cc_expiry_date, "-1 seconds");
	$todays_date = date_create();
	$future_date = date_modify(date_create(), "+8 years");
	if (($cc_expiry_date >= $todays_date) && ($cc_expiry_date <= $future_date)) {
		return true;
	}
}

// Create error message array
$err_msgs = [];

// Validate first name
if ($first_name == "") {
	$err_msgs[] = "You must enter your first name.";
} elseif (!preg_match("/^[A-Za-z]{1,25}$/", $first_name)) {
	$err_msgs[] = "Your first name may only contain letters. A maximum of 25 letters is allowed.";
}
// Validate last name

if ($last_name == "") {
	$err_msgs[] = "You must enter your last name.";
} elseif (!preg_match("/^[A-Za-z]{1,25}$/", $last_name)) {
	$err_msgs[] = "Your last name may only contain letters. A maximum of 25 letters is allowed.";
}

// Validate street address
if ($street_address == "") {
	$err_msgs[] = "You must enter your street address.";
} elseif (!preg_match("/^[A-Za-z0-9 ]{1,40}$/", $street_address)) {
	$err_msgs[] = "Your street address may only contain letters, numbers and spaces. A maximum of 40 characters is allowed.";
}

// Validate suburb/town
if ($suburb_town == "") {
	$err_msgs[] = "You must enter your suburb/town.";
} elseif (!preg_match("/^[A-Za-z ]{1,20}$/", $suburb_town)) {
	$err_msgs[] = "Your suburb/town may only contain letters. A maximum of 20 letters is allowed.";
}

// Validate state
$valid_state = false;
if ($state == "") {
	$err_msgs[] = "You must select your state.";
} else {
	$valid_state = true;
}

// Validate postcode
$valid_postcode = false;
if ($postcode == "") {
	$err_msgs[] = "You must enter your postcode.";
} elseif (!preg_match("/[0-9]{4}/", $postcode)) {
	$err_msgs[] = "Your postcode may only contain numbers. It must be 4 numbers in length.";
} else {
	$valid_postcode = true;
}

// If state and postcode are valid, validate their compatibility
if ($valid_state && $valid_postcode) {
	if (!validate_postcode($state, $postcode)) {
		$err_msgs[] = "There is a state and postcode mismatch.";
	}
}

// Validate phone
if ($phone == "") {
	$err_msgs[] = "You must enter your phone number.";
} elseif (!preg_match("/[0-9]{10}/", $phone)) {
	$err_msgs[] = "Your phone number may only contain numbers. It must be 10 numbers in length.";
}

// Validate email
if ($email == "") {
	$err_msgs[] = "You must enter your email address.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$err_msgs[] = "Your email address must be in the following format: abc@example.com";
}

// Validate origin
$valid_origin = false;
if ($origin == "") {
	$err_msgs[] = "You must select your origin continent.";
} else {
	$valid_origin = true;
}

// Validate destination
$valid_destination = false;
if ($destination == "") {
	$err_msgs[] = "You must select your destination continent.";
} else {
	$valid_destination = true;
}

// Validate flight option
$valid_option = false;
if ($option == "") {
	$err_msgs[] = "You must select your flight option.";
} else {
	$valid_option = true;
}

// Validate ticket qty
$valid_tickets = false;
if ($tickets == "") {
	$err_msgs[] = "You must enter a ticket quantity.";
} elseif (!preg_match("/[1-8]/", $tickets)) {
	$err_msgs[] = "Your ticket quantity must be between 1 and 8.";
} else {
	$valid_tickets = true;
}

// Validate credit card type
$valid_cc_type = false;
if ($cc_type == "") {
	$err_msgs[] = "You must select your credit card type.";
} else {
	$valid_cc_type = true;
}

// Validate credit card name
if ($cc_name == "") {
	$err_msgs[] = "You must enter your credit card name.";
} elseif (!preg_match("/^[A-Za-z ]{1,40}$/", $cc_name)) {
	$err_msgs[] = "Your credit card name may only contain letters and spaces. A maximum of 40 characters is allowed.";
}

// Validate credit card number
$valid_cc_number = false;
if ($cc_number == "") {
	$err_msgs[] = "You must enter your credit card number.";
} elseif (!preg_match("/^[0-9]{15,16}$/", $cc_number)) {
	$err_msgs[] = "Your credit card number may only contain numbers. It must be 15 or 16 digits in length.";
} else {
	$valid_cc_number = true;
}

// If credit card type and number are valid, validate their compatibility
if ($valid_cc_type && $valid_cc_number) {
	switch($cc_type) {
		case "visa":
			if (!validate_cc_visa($cc_number)) {
				$err_msgs[] = "Invalid Visa number. It must be 16 digits long and start with a 4.";
			}
			break;
		case "mastercard":
			if (!validate_cc_mastercard($cc_number)) {
				$err_msgs[] = "Invalid Mastercard number. It must be 16 digits long and start with 51 through to 55.";
			}
			break;
		case "american_express":
			if (!validate_cc_american_express($cc_number)) {
				$err_msgs[] = "Invalid American Express number. It must be 15 digits long and start with 34 or 37.";
			}
	}
}

// Validate credit card expiry
if ($cc_expiry == "") {
	$err_msgs[] = "You must enter your credit card expiry date.";
} elseif (!preg_match("/^((0[1-9])|(1[0-2]))-([0-9]{2})$/", $cc_expiry)) {
	$err_msgs[] = "Your credit card expiry date must be in the format MM-YY.";
} elseif (!validate_cc_expiry($cc_expiry)) {
	$err_msgs[] = "Your credit card is either expired or the expiry date is more than 8 years from today.";
}

// Validate credit card CVV
if ($cc_cvv == "") {
	$err_msgs[] = "You must enter your credit card CVV number.";
} elseif (!preg_match("/^[0-9]{3}$/", $cc_cvv)) {
	$err_msgs[] = "Your credit card CVV number may only contain numbers. It must be 3 digits in length.";
}

// Set session key-value pairs
$_SESSION["first_name"] = $first_name;
$_SESSION["last_name"] = $last_name;
$_SESSION["street_address"] = $street_address;
$_SESSION["suburb_town"] = $suburb_town;
$_SESSION["state"] = $state;
$_SESSION["postcode"] = $postcode;
$_SESSION["phone"] = $phone;
$_SESSION["email"] = $email;
$_SESSION["preferred_contact"] = $preferred_contact;
$_SESSION["origin"] = $origin;
$_SESSION["destination"] = $destination;
$_SESSION["option"] = $option;
$_SESSION["extras"] = $extras_arr;
$_SESSION["tickets"] = $tickets;
$_SESSION["comments"] = $comments;

// If pricing can be calculated, calculate it & store relevant session key-value pairs
if ($valid_origin && $valid_destination && $valid_option && $valid_tickets) {

	// Base pricing array
	$base_pricing =	[
					["","africa", "asia", "antarctica", "australia", "europe", "north_america", "south_america"],
					["africa", 5000, 8000, 13000, 8000, 7000, 10000, 12000],
					["asia", 8000, 5000, 13000, 7000, 7000, 9000, 10000],
					["antarctica", 14000, 14000, 5000, 14000, 14000, 14000, 14000],
					["australia", 8000, 7000, 13000, 5000, 10000, 11000, 11000],
					["europe", 7000, 7000, 13000, 10000, 5000, 9000, 12000],
					["north_america", 10000, 9000, 13000, 11000, 9000, 5000, 10000],
					["south_america", 12000, 10000, 13000, 11000, 12000, 10000, 5000]
					];

	// Option pricing array
	$option_pricing =	[
						["cabin_seating", 0], // Cabin seating is the base price
						["private_cabin", 6000],
						["single_suite", 8000],
						["double_suite", 12000],
						];

	// Extras pricing array
	$extras_pricing =	[
						["shopping", 0],
						["pet_transport", 1000],
						["car_transport", 10000],
						["butler", 2000],
						];

	// Function: Calculate base price
	function calc_base_price($origin, $destination) {
		global $base_pricing;
		for ($i = 0; $i < count($base_pricing); $i++) {
			if ($origin === $base_pricing[$i][0]) {
				$row = $i;
			}
		}
		for ($i = 0; $i < count($base_pricing[0]); $i++) {
			if ($destination === $base_pricing[0][$i]) {
				$col = $i;
			}
		}
		return $base_pricing[$row][$col];
	}

	// Function: Calculate option price
	function calc_option_price($option) {
		global $option_pricing;
		for ($i = 0; $i < count($option_pricing); $i++) {
			if ($option === $option_pricing[$i][0]) {
				return $option_pricing[$i][1];
			}
		}
	}

	// Function: Calculate extra price
	function calc_extra_price($extra) {
		global $extras_pricing;
		for ($i = 0; $i < count($extras_pricing); $i++) {
			if ($extra === $extras_pricing[$i][0]) {
				return $extras_pricing[$i][1];
			}
		}
	}

	// Calculate base price & set session key-value pair
	$base_price = calc_base_price($origin, $destination);
	$_SESSION["base_price"] = $base_price;

	// Calculate subtotal base price & set session key-value pair
	$subtotal_base_price = $tickets * $base_price;
	$_SESSION["subtotal_base_price"] = $subtotal_base_price;

	// Calculate flight option price & set session key-value pair
	$option_price = calc_option_price($option);
	$_SESSION["option_price"] = $option_price;

	// Calculate subtotal option price & set session key-value pair
	$subtotal_option_price = $tickets * $option_price;
	$_SESSION["subtotal_option_price"] = $subtotal_option_price;

	// Define extras individual pricing and subtotal extras individual pricing arrays
	$extras_individual_pricing = [];
	$subtotal_extras_individual_pricing = [];

	// Define subtotal for all extras
	$subtotal_all_extras = 0;

	// Populate extras individual pricing and subtotal extras individual pricing arrays.
	// Increment subtotal for all extras
	for ($i = 0; $i < count($extras_arr); $i++) {
		$extra_price = calc_extra_price($extras_arr[$i]);
		$extras_individual_pricing[] = $extra_price;
		$subtotal_extras_individual_pricing[] = $tickets * $extra_price;
		$subtotal_all_extras += $tickets * $extra_price;
	}

	// Set extras individual pricing and subtotal extras individual session key-value pairs
	$_SESSION["extras_individual_pricing"] = $extras_individual_pricing;
	$_SESSION["subtotal_extras_individual_pricing"] = $subtotal_extras_individual_pricing;

	// Calculate total price
	$total_price = $subtotal_base_price + $subtotal_option_price + $subtotal_all_extras;

	// Set total price session key-value pair
	$_SESSION["total_price"] = $total_price;
}

// If there are validation errors, go to fix_order.php and terminate this script.
// exit() is critical here, as there is no proceeding 'else' statement (so as to tidy up the code).
if ($err_msgs) {
	$_SESSION["err_msgs"] = $err_msgs;
	header("location:fix_order.php");
	exit();
}

// If there are no validation errors, we have reached this point
// Now, connect to database and redirect to receipt.php:
require_once("settings.php");
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
$database_error = false;
// If a connection is established...
if ($conn) {
	// Check if table already exists
	$table_exists = mysqli_query($conn, "SELECT 1 FROM orders");
	// If the table doesn't exist, create it
	if (!$table_exists) {
		$create_table = "CREATE TABLE orders (
			order_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			order_status SET('ARCHIVED','FULFILLED','PAID','PENDING') NOT NULL,
			order_time DATETIME NOT NULL,
			first_name VARCHAR(25) NOT NULL,
			last_name VARCHAR(25) NOT NULL,
			street_address VARCHAR(40) NOT NULL,
			suburb_town VARCHAR(20) NOT NULL,
			state SET('ACT','QLD','NSW','NT','SA','TAS','VIC','WA') NOT NULL,
			postcode INTEGER(4) NOT NULL,
			phone VARCHAR(10) NOT NULL,
			email VARCHAR(255) NOT NULL,
			preferred_contact SET('email','phone','post') NOT NULL,
			origin VARCHAR(255) NOT NULL,
			destination VARCHAR(255) NOT NULL,
			flight_option VARCHAR(255) NOT NULL,
			extras VARCHAR(255),
			tickets TINYINT(1) NOT NULL,
			comments LONGTEXT,
			cc_type SET('american_express','mastercard','visa') NOT NULL,
			cc_name VARCHAR(255) NOT NULL,
			cc_number VARCHAR(16) NOT NULL,
			cc_expiry VARCHAR(255) NOT NULL,
			cc_cvv INTEGER(3) NOT NULL,
			base_price DECIMAL(10,2) NOT NULL,
			option_price DECIMAL(10,2) NOT NULL,
			extras_prices VARCHAR(255),
			order_cost DECIMAL(10,2) NOT NULL
			)";
		$table_created = @mysqli_query($conn, $create_table);
		// If the table couldn't be created, record an error
		if (!$table_created) {
			$database_error = true;
		}
	}

	// Create a date/time variable to insert into the table row
	$date_time = date_format(date_create(null, timezone_open("Australia/Melbourne")), "Y-m-d H:i:s");

	// Create an extras variable to insert into the table row.
	// This variable is a string containing the selected extras.
	$extras_str = implode(", ", $extras_arr);

	// Create an extras prices variable to insert into the table row.
	// This variable is a string containing the selected extras' prices.
	// The prices are in the same order as the extras variable.
	$extras_prices_str = implode(", ", $extras_individual_pricing);
	
	// The insert row query:
	$insert_row = "INSERT INTO orders (order_status, order_time, first_name, last_name, street_address, suburb_town, state, postcode, phone, email, preferred_contact, origin, extras, destination, flight_option, tickets, comments, cc_type, cc_name, cc_number, cc_expiry, cc_cvv, base_price, option_price, extras_prices, order_cost) VALUES ('PENDING', '$date_time', '$first_name', '$last_name', '$street_address', '$suburb_town', '$state', '$postcode', '$phone', '$email', '$preferred_contact', '$origin', '$extras_str', '$destination', '$option', '$tickets', '$comments', '$cc_type', '$cc_name', '$cc_number', '$cc_expiry', '$cc_cvv', '$base_price', '$option_price', '$extras_prices_str', '$total_price')";
	
	$row_inserted = mysqli_query($conn, $insert_row);

	// If the row was inserted, set some more session
	// key-value pairs and redirect to to receipt.php/
	// Else, record an error.
	if ($row_inserted) {
		$_SESSION["cc_type"] = $cc_type;
		$_SESSION["cc_name"] = $cc_name;
		$_SESSION["cc_number"] = $cc_number;
		$_SESSION["cc_expiry"] = $cc_expiry;
		$_SESSION["cc_cvv"] = $cc_cvv;
		$_SESSION["order_id"] = mysqli_insert_id($conn);
		$_SESSION["order_date"] = $date_time;
		header("location:receipt.php");
	} else {
		$database_error = true;
	}
	mysqli_close($conn);	
} else {
	// If connection could not be established, record an error
	$database_error = true;
}

// If any errors were detected, redirect to the database error page
if ($database_error) {
	header("location:database_connection_error.php");
}

?>