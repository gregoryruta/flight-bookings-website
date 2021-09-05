/*
Filename: enhancements.js
Author: Gregory Ruta
Target: product.html, enquire.html
Purpose: Enhancement Javascript for Assignment Part 2
Created: 13/04/2020
Last Modified: 30/04/2020
Credits: None
*/

"use strict";

// Function: Booking page (enquire.html) function
function product_page_enhancement() {
	
	// ENHANCEMENT #1: Function: Populate the base pricing table with data
	function populate_base_pricing_table() {
		// Base pricing table
		var base_pricing_table = document.getElementById("base_pricing");
		// Create and append new colgroup for base pricing table
		var new_colgroup = document.createElement('colgroup');
		new_colgroup.id = "colgroup_base_pricing";
		base_pricing_table.appendChild(new_colgroup);
		// Get new colgroup
		var colgroup = document.getElementById('colgroup_base_pricing');
		// Insert 1st row
		var row = base_pricing_table.insertRow(-1);
		// Insert 2 cells in first row
		var cell = document.createElement('th');
		cell.rowSpan = "2";
		cell.textContent = "Origin";
		row.appendChild(cell);
		var cell = document.createElement('th');
		cell.colSpan = "7";
		cell.textContent = "Destination";
		row.appendChild(cell);
		// Insert cols, rows and cells
		for (let i = 0; i < base_pricing.length; i++) {
			// Insert cols
			var col = document.createElement('col');
			colgroup.appendChild(col);
			// Insert rows
			var row = base_pricing_table.insertRow(-1);
			// Insert cells
			for (let j = 0; j < base_pricing[i].length; j++) {
				// Don't insert first Cell
				if (([i] == 0) && ([j] == 0)) {
					continue;
				}
				// Basic logic: If first row, insert heading cells with scope="col". Else, if first column, insert heading cells with scope="row". Else, insert normal cells.
				if ([i] == 0) {
					var cell = document.createElement('th');
					cell.scope = "col";
					cell.textContent = beautify(base_pricing[i][j]);
					row.appendChild(cell);
				} else if ([j] == 0) {
					var cell = document.createElement('th');
					cell.scope = "row";
					cell.textContent = beautify(base_pricing[i][j]);
					row.appendChild(cell);
				} else {
					var cell = row.insertCell(-1);
					cell.textContent = dollar(base_pricing[i][j]);
				}
			}
		}
	}

	// ENHANCEMENT #1: Function: Populate the option pricing table with data
	function populate_option_pricing_table() {
		// Option pricing table
		var option_pricing_table = document.getElementById("option_pricing");
		// Insert 1st row
		var row = option_pricing_table.insertRow(-1);
		// Insert 2 cells in first row
		var cell = document.createElement('th');
		cell.textContent = "Flight Option";
		row.appendChild(cell);
		var cell = document.createElement('th');
		cell.textContent = "Price per flight";
		row.appendChild(cell);
		// Insert cols, rows and cells
		for (let i = 0; i < option_pricing.length; i++) {
			// Insert rows
			var row = option_pricing_table.insertRow(-1);
			// Insert cells
			for (let j = 0; j < option_pricing[i].length; j++) {
				// Basic logic: If first row, insert heading cells with scope="col". Else, if first column, insert heading cells with scope="row". Else, insert normal cells.
				if ([j] == 0) {
					var cell = document.createElement('th');
					cell.scope = "row";
					cell.textContent = beautify(option_pricing[i][j]);
					row.appendChild(cell);
				} else {
					var cell = row.insertCell(-1);
					cell.textContent = "+" + dollar(option_pricing[i][j]);
				}
			}
		}
	}

	// Call functions
	populate_base_pricing_table();
	populate_option_pricing_table();
}

// Function: Booking page (enquire.html) function
function enquire_page_enhancement() {

	// ENHANCEMENT #1: Function: Add option elements to the origin and destination select elements
	function add_origin_destination_selections() {
		// 'Select' element for origin and destination
		var select_origin = document.getElementById("origin");
		var select_destination = document.getElementById("destination");
		// Create origin options
		for (let i = 1; i < base_pricing.length; i++) {
			var option = document.createElement('option');
			option.value = base_pricing[i][0];
			option.textContent = beautify(base_pricing[i][0]);
			select_origin.appendChild(option);
		}
		// Create destination options
		for (let i = 1; i < base_pricing[0].length; i++) {
			var option = document.createElement('option');
			option.value = base_pricing[0][i];
			option.textContent = beautify(base_pricing[0][i]);
			select_destination.appendChild(option);
		}
	}

	// ENHANCEMENT #2: Function: Dynamic conditional Origin-Destination pricing
	/* This function displays a price that changes based on two
	user-selected options (origin & destination). The price is
	calculated by the global calc_base_price(origin, destination)
	function in part2.js. The calc_base_price(origin, destination)
	function must remain in that part2.js as it is called in that
	file for purposes relating to the the core requirements of
	this assignment. */
	function live_origin_destination_price() {
		var container = document.getElementById("origin_destination");
		var origin = document.getElementById("origin").value;
		var destination = document.getElementById("destination").value;
		var paragraph_od_price = document.createElement("p");
		paragraph_od_price.id = "od_price";
		/* Basic logic: If origin and destination are selected,
		(firstly, if no paragraph is available, append a paragraph),
		then print the price in paragraph. 
		Else, if the paragraph exists, remove it. */
		if (origin && destination) {
			if (!document.getElementById("od_price")) {
				container.appendChild(paragraph_od_price);
			}
			document.getElementById("od_price").textContent = "Flight Price: " + dollar(calc_base_price(origin, destination));
		} else if (document.getElementById("od_price")) {
			container.removeChild(container.lastElementChild);
		}
	}

	// ENHANCEMENT #1: Function: Add option ements to the flight options select element
	function add_flight_options_selections() {
		// 'Select' element for options
		var select_option = document.getElementById("option");
		// Create options
		for (let i = 0; i < option_pricing.length; i++) {
			var option = document.createElement('option');
			option.value = option_pricing[i][0];
			option.textContent = beautify(option_pricing[i][0]) + " (+" + dollar(option_pricing[i][1]) + ")";
			select_option.appendChild(option);
		}
	}

	// ENHANCEMENT #1: Function: Add extras checkboxes
	function add_extras_checkboxes() {
		// Option pricing table
		var fieldset_extras = document.getElementById("extras");
		// Create extras
		for (let i = 0; i < extras_pricing.length; i++) {
			// Insert options
			var p = document.createElement('p');
			p.classList.add("radio_or_checkbox");
			var label = document.createElement('label');
			label.textContent = beautify(extras_pricing[i][0]) + " (+" + dollar(extras_pricing[i][1]) + ")";
			p.appendChild(label);
			var input = document.createElement('input');
			input.type = "checkbox";
			input.name = "extras[]";
			input.value = extras_pricing[i][0];
			label.insertBefore(input,label.firstChild);
			// First extra is checked by default
			i == 0 ? input.setAttribute("checked","checked") : false;
			fieldset_extras.appendChild(p);
		}
	}

	// Call functions and add event trigger
	add_origin_destination_selections();
	add_flight_options_selections();
	add_extras_checkboxes();
	document.getElementById("origin_destination").addEventListener("change", live_origin_destination_price);
}

// Function: Determine what page the user is on, and call the appropriate function.
function init_enhancement() {
	switch (document.documentElement.id) {
		case "page_product":
			product_page_enhancement();
			break;
		case "page_enquire":
			enquire_page_enhancement();
	}
}
window.addEventListener("load", init_enhancement);