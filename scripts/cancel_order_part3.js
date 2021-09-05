/*
Filename: cancel_order_part3.js
Author: Gregory Ruta
Target: fix_order.php
Purpose: Allows user to cancel their order on fix_order.php. For Assignment Part 3
Created: 23/05/2020
Last Modified: 01/06/2020
Credits: None
*/

"use-strict";

function init() {

	// Function: Cancel order
	function cancel_order() {
		sessionStorage.clear();
		window.location.replace("index.php");
	}

	document.getElementById("form").addEventListener("reset", cancel_order);

}

window.addEventListener("load", init);