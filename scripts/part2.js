/*
Filename: part2.js
Author: Gregory Ruta
Target: product.php, enquire.php, payment.php
Purpose: Core Javascript for Assignment Part 2
Created: 13/04/2020
Last Modified: 01/06/2020
Credits: None
*/

"use strict";

// Part 3 functionality
var debug = true;

// Define some globally accessible functions

// Base pricing array
var base_pricing =	[
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
var option_pricing =	[
						["cabin_seating", 0], // Cabin seating is the base price
						["private_cabin", 6000],
						["single_suite", 8000],
						["double_suite", 12000],
						];

// Extras pricing array
var extras_pricing =	[
						["shopping", 0],
						["pet_transport", 1000],
						["car_transport", 10000],
						["butler", 2000],
						];

// Function: Calculate base price
function calc_base_price(origin, destination) {
	for (let i = 0; i < base_pricing.length; i++) {
		if (origin === base_pricing[i][0]) {
			var row = i;
		}
	}
	for (let i = 0; i < base_pricing[0].length; i++) {
		if (destination === base_pricing[0][i]) {
			var col = i;
		}
	}
	return base_pricing[row][col];
}

// Function: Calculate option price
function calc_option_price(option) {
	for (let i = 0; i < option_pricing.length; i++) {
		if (option === option_pricing[i][0]) {
			return option_pricing[i][1];
		}
	}
}

// Function: Calculate extra price
// Not called on this page, but may have use later...
function calc_extra_price(extra) {
	for (let i = 0; i < extras_pricing.length; i++) {
		if (extra === extras_pricing[i][0]) {
			return extras_pricing[i][1];
		}
	}
}

// Function: Add dollar sign and thousands's comma separators.
function dollar(input) {
	var usd = new Intl.NumberFormat("en-US", {style: 'currency', currency: 'USD'});
	var output = usd.format(input);
	return output;
}

// Function: Beautify text (i.e. Will convert "north_america" to "North America")
function beautify(input) {
	var output = input.toString();
	output = output.replace(/_/g, " ");
	output = output.replace(/,/g, ", ");
	output = output.replace(/\w\S*/g, function(word) {
		var first_letter = word.charAt(0);
		var rest_of_word = word.substr(1);
		var capitalised_word = first_letter.toUpperCase() + rest_of_word;
		return capitalised_word;
	});
	return output;
}

// Function: Booking page (enquire.php) function
function enquire_page() {

	// Function: Process form
	function process_form(e) {
		// Get input values
		var first_name = document.getElementById("first_name").value;
		var last_name = document.getElementById("last_name").value;
		var street_address = document.getElementById("street_address").value;
		var suburb_town = document.getElementById("suburb_town").value;
		var state = document.getElementById("state").value;
		var postcode = document.getElementById("postcode").value;
		var phone = document.getElementById("phone").value;
		var email = document.getElementById("email").value;
		var preferred_contact_nodes = document.getElementsByName("preferred_contact");	
		
		for (let i = 0; i < preferred_contact_nodes.length; i++) {
			if (preferred_contact_nodes[i].checked) {
				var preferred_contact = preferred_contact_nodes[i].value;
			}
		}

		var origin = document.getElementById("origin").value;
		var destination = document.getElementById("destination").value;
		var option = document.getElementById("option").value;
		var extras_nodes = document.getElementsByName("extras[]");
		var extras_arr = [];
		
		for (let i = 0; i < extras_nodes.length; i++) {
			if (extras_nodes[i].checked) {
				extras_arr.push(extras_nodes[i].value);
			}
		}

		var tickets = document.getElementById("tickets").value;
		var comments = document.getElementById("comments").value;

		// Function: Set session storage
		function set_session_storage() {
			sessionStorage.setItem("first_name", first_name);
			sessionStorage.setItem("last_name", last_name);
			sessionStorage.setItem("street_address", street_address);
			sessionStorage.setItem("suburb_town", suburb_town);
			sessionStorage.setItem("state", state);
			sessionStorage.setItem("postcode", postcode);
			sessionStorage.setItem("phone", phone);
			sessionStorage.setItem("email", email);
			sessionStorage.setItem("preferred_contact", preferred_contact);
			sessionStorage.setItem("origin", origin);
			sessionStorage.setItem("destination", destination);
			sessionStorage.setItem("option", option);
			sessionStorage.setItem("extras_arr", JSON.stringify(extras_arr));
			sessionStorage.setItem("tickets", tickets);
			sessionStorage.setItem("comments", comments);
		}

		// Function: Validate postcode with state
		function validate_postcode(state, postcode) {
			var char0 = postcode.charAt(0);
			if (state === "VIC" && (char0 === "3" || char0 === "8")) {
				return true;
			}
			if (state === "NSW" && (char0 === "1" || char0 === "2")) {
				return true;
			}
			if (state === "QLD" && (char0 === "4" || char0 === "9")) {
				return true;
			}
			if (state === "NT" && char0 === "0") {
				return true;
			}
			if (state === "WA" && char0 === "6") {
				return true;
			}
			if (state === "SA" && char0 === "5") {
				return true;
			}
			if (state === "TAS" && char0 === "7") {
				return true;
			}
			if (state === "ACT" && char0 === "0") {
				return true;
			}
		}

		// Function: Validate form
		function validate_form() {
			// If var "validated" remains true, the form will submit.
			// If it is tripped to false, the form will not submit.
			var validated = true;
			var errmsg = "The following errors have been detected:";

			// Validate the postcode
			if (!validate_postcode(state, postcode)) {
				validated = false;
				errmsg += "\n\n- State & postcode mismatch";
			}

			// Other validation tests can go here.
			
			switch (validated) {
				case true:
					set_session_storage();
					break;
				case false:
					e.preventDefault();
					alert(errmsg);
			}
		}

		// Part 3 functionality
		if (debug) {
			set_session_storage();
		} else {
			validate_form();
		}

	}
	document.getElementById("form").addEventListener("submit", process_form);
}

// Function: Payment page (payment.php) function
function payment_page() {
/*
	// Redirect and end function if no session storage is detected.
	// People should not be able to access this page directly.
	if (!sessionStorage.getItem("first_name")) {
		window.location.replace("index.php");
		return;
	}
*/
	// Get from session storage
	var first_name = sessionStorage.getItem("first_name");
	var last_name = sessionStorage.getItem("last_name");
	var street_address = sessionStorage.getItem("street_address");
	var suburb_town = sessionStorage.getItem("suburb_town");
	var state = sessionStorage.getItem("state");
	var postcode = sessionStorage.getItem("postcode");
	var phone = sessionStorage.getItem("phone");
	var email = sessionStorage.getItem("email");
	var preferred_contact = sessionStorage.getItem("preferred_contact");
	var origin = sessionStorage.getItem("origin");
	var destination = sessionStorage.getItem("destination");
	var option = sessionStorage.getItem("option");
	var extras_arr = JSON.parse(sessionStorage.getItem("extras_arr"));
	var tickets = sessionStorage.getItem("tickets");
	var comments = sessionStorage.getItem("comments");

	// Print user selections retrieved from session stoage
	document.getElementById("display_first_name").textContent = first_name;
	document.getElementById("display_last_name").textContent = last_name;
	document.getElementById("display_street_address").textContent = street_address;
	document.getElementById("display_suburb_town").textContent = suburb_town;
	document.getElementById("display_state").textContent = state;
	document.getElementById("display_postcode").textContent = postcode;
	document.getElementById("display_phone").textContent = phone;
	document.getElementById("display_email").textContent = email;
	document.getElementById("display_preferred_contact").textContent = beautify(preferred_contact);
	document.getElementById("display_origin").textContent = beautify(origin);
	document.getElementById("display_destination").textContent = beautify(destination);
	document.getElementById("display_option").textContent = beautify(option);
	document.getElementById("display_extras").textContent = beautify(extras_arr);
	document.getElementById("display_tickets").textContent = tickets;
	document.getElementById("display_comments").textContent = comments;

	// This is the price summary table.
	// Currently it only contains a row of headings.
	var total_table = document.getElementById("total");

	// Function: Prints a new row in the price summary table.
	function print_row(qty, description, price, subtotal) {
		var row = total_table.insertRow(-1);
		var cell = row.insertCell(-1);
		cell.textContent = qty;
		var cell = row.insertCell(-1);
		cell.textContent = description;
		var cell = row.insertCell(-1);
		cell.textContent = dollar(price);
		var cell = row.insertCell(-1);
		cell.textContent = dollar(subtotal);
	}

	// Set some variables, and print a row in the price summary table.
	var description = "Flight: " + beautify(origin) + " to " + beautify(destination);
	var base_price = calc_base_price(origin, destination);
	var subtotal_base_price = tickets*base_price;
	print_row(tickets, description, base_price, subtotal_base_price);

	// Set some variables, and print a row in the price summary table.
	var description = "Flight option: " + beautify(option);
	var option_price = calc_option_price(option);
	var subtotal_option_price = tickets*option_price;
	print_row(tickets, description, option_price, subtotal_option_price);

	// Create an array of the SELECTED extras and their prices
	var extras_priced_array = [];
	for (let i = 0; i < extras_arr.length; i++) {
		for (let j = 0; j < extras_pricing.length; j++) {
			if (extras_arr[i] === extras_pricing[j][0]) {
				extras_priced_array.push([extras_arr[i],extras_pricing[j][1]]);
			}
		}
	}

	// Set a subtotal variable for all selected extras, and iterate through the array of selected extras and their prices.
	// During each iteration, set some variables, and print a row in the price summary table.
	var subtotal_all_extras = 0;
	for (let i = 0; i < extras_priced_array.length; i++) {
		var description = "Extra: " + beautify(extras_priced_array[i][0]);
		var total_extras_line = tickets*extras_priced_array[i][1];
		print_row(tickets, description, extras_priced_array[i][1], total_extras_line);
		subtotal_all_extras += total_extras_line;
	}

	// As each table row was printed, a subtotal variable was created/modified.
	// Now we add them together to calculate the total price.
	var total_price = subtotal_base_price + subtotal_option_price + subtotal_all_extras;

	// Print a final row displaying the total price.
	var row = total_table.insertRow(-1);
	var cell = document.createElement('th');
	cell.textContent = "Total Price";
	cell.colSpan = 3;
	row.appendChild(cell);
	var cell = row.insertCell(-1);
	cell.textContent = dollar(total_price);

	// Generate warning text that warns the user that their card is about to be charged.
	var warning_text = "<em>" + dollar(total_price) + " will be charged to your card under the name 'Swinburne Air'.</em>";
	document.getElementById("warning").innerHTML = warning_text;

	// Assign hidden input field values
	document.getElementById("first_name").value = first_name;
	document.getElementById("last_name").value = last_name;
	document.getElementById("street_address").value = street_address;
	document.getElementById("suburb_town").value = suburb_town;
	document.getElementById("state").value = state;
	document.getElementById("postcode").value = postcode;
	document.getElementById("phone").value = phone;
	document.getElementById("email").value = email;
	document.getElementById("preferred_contact").value = preferred_contact;
	document.getElementById("origin").value = origin;
	document.getElementById("destination").value = destination;
	document.getElementById("option").value = option;
	document.getElementById("extras").value = extras_arr;
	document.getElementById("tickets").value = tickets;
	document.getElementById("comments").value = comments;
	document.getElementById("base_price").value = base_price;
	document.getElementById("option_price").value = option_price;
	document.getElementById("total_price").value = total_price;
	
	// Dynamically create hidden input fields based on the selected extras.
	for (let i = 0; i < extras_priced_array.length; i++) {
		var hidden_input = document.createElement("input");
		hidden_input.type = "hidden";
		hidden_input.name = "extra_price_" + extras_priced_array[i][0];
		hidden_input.value = extras_priced_array[i][1];
		document.getElementById("hidden_extra_price_inputs").appendChild(hidden_input);
	}

	// Function: Process credit card payment form
	function process_form(e) {
		// Get relevant input values
		var cc_type = document.getElementById("cc_type").value;
		var cc_number = document.getElementById("cc_number").value;
		var cc_expiry = document.getElementById("cc_expiry").value;

		// Function: Validate a Visa card number
		function validate_cc_visa(cc_number) {
			var first_number = cc_number.charAt(0);
			var length = cc_number.length;
			if (first_number === "4" && length === 16) {
				return true;
			}
		}

		// Function: Validate a Mastercard card number
		function validate_cc_mastercard(cc_number) {
			var first_2_numbers = cc_number.slice(0,2);
			var length = cc_number.length;
			if (first_2_numbers.match(/51|52|53|54|55/) && length === 16) {
				return true;
			}
		}

		// Function: Validate an American Express card number
		function validate_cc_american_express(cc_number) {
			var first_2_numbers = cc_number.slice(0,2);
			var length = cc_number.length;
			if (first_2_numbers.match(/34|37/) && length === 15) {
				return true;
			}
		}

		// Function: Set credit card expiry date limit
		function calc_future_date(today, years_ahead) {
			var year = today.getFullYear();
			var month = today.getMonth();
			var day = today.getDate();
			var hours = today.getHours();
			var minutes = today.getMinutes();
			var seconds = today.getSeconds();
			var milliseconds = today.getMilliseconds();
			var future_date = new Date(year + years_ahead, month, day, hours, minutes, seconds, milliseconds);
			return future_date;
		}

		// Function: Validate the card expiry date
		/* Note: The Date() object month counter starts at 0 (0=Jan, 1=Feb, etc).
		So, if we feed it the user-inputted month value (e.g. 01 for January),
		it will create a timestamp for the first moment of the next month
		(Febrary 1st instead of January 1st). That is fine, because we then 
		deduct 1 second, bringing the timestamp to the last second of the
		user-inputted month. */
		function validate_cc_expiry(cc_expiry) {
			var cc_expiry_mm = cc_expiry.slice(0,2);
			var cc_expiry_yyyy = "20" + cc_expiry.slice(3,5);
			var cc_expiry_date = new Date(cc_expiry_yyyy, cc_expiry_mm);
			cc_expiry_date.setSeconds(-1);
			var todays_date = new Date();
			var future_date = calc_future_date(todays_date, 8);
			if ((cc_expiry_date >= todays_date) && (cc_expiry_date <= future_date)) {
				return true;
			}
		}

		// Function: Validate form
		function validate_form() {
			// If var "validated" remains true, the form will submit.
			// If it is tripped to false, the form will not submit.
			var validated = true;
			var errmsg = "The following errors have been detected:";

			// Determine card type, then validate the card number
			switch(cc_type) {
				case "visa":
					if (!validate_cc_visa(cc_number)) {
						validated = false;
						errmsg += "\n\n- Invalid Visa number. Must be 16 digits long and start with a 4.";
					}
					break;
				case "mastercard":
					if (!validate_cc_mastercard(cc_number)) {
						validated = false;
						errmsg += "\n\n- Invalid Mastercard number. Must be 16 digits long and start with 51 through to 55.";
					}
					break;
				case "american_express":
					if (!validate_cc_american_express(cc_number)) {
						validated = false;
						errmsg += "\n\n- Invalid American Express number. Must be 15 digits long and start with 34 or 37.";
					}
			}

			// Validate the expiry date
			if (!validate_cc_expiry(cc_expiry)) {
				validated = false;
				errmsg += "\n\n- Credit Card is either expired or the expiry date is more than 8 years from today.";
			}

			// Other validation tests can go here.
			
			switch (validated) {
				case true:
					break;
				case false:
					e.preventDefault();
					alert(errmsg);
			}
		}

		// Part 3 functionality
		if (!debug) {
			validate_form();
		}

	}
	document.getElementById("form").addEventListener("submit", process_form);

	// Function: Cancel order
	function cancel_order() {
		sessionStorage.clear();
		window.location.replace("index.php");
	}
	document.getElementById("form").addEventListener("reset", cancel_order);
}

// Function: Determine what page the user is on, and call the appropriate function.
function init() {
	switch (document.documentElement.id) {
		case "page_enquire":
			enquire_page();
			break;
		case "page_payment":
			payment_page();
	}
}
window.addEventListener("load", init);