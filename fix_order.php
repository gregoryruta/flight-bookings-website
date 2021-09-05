<?php

// NOTE 1: While the form elements have HTML5 validation included (for future use), the form on this page is purposely set to "novalidate" for Part 3.
// NOTE 2: cancel_order_part3.js allows the user to cancel their order from this page.

// Start session
session_start();

// Redirect if page is accessed directly
if (!isset($_SESSION["first_name"])) {
	header("location:index.php");
	exit();
}

// Get common functions
require_once("common_functions.php");

// Get session values
$first_name = $_SESSION["first_name"];
$last_name = $_SESSION["last_name"];
$street_address = $_SESSION["street_address"];
$suburb_town = $_SESSION["suburb_town"];
$state = $_SESSION["state"];
$postcode = $_SESSION["postcode"];
$phone = $_SESSION["phone"];
$email = $_SESSION["email"];
$preferred_contact = $_SESSION["preferred_contact"];
$origin = $_SESSION["origin"];
$destination = $_SESSION["destination"];
$option = $_SESSION["option"];
$extras_arr = $_SESSION["extras"];
$tickets = $_SESSION["tickets"];
$comments = $_SESSION["comments"];
$err_msgs = $_SESSION["err_msgs"];

// If a total price was calculated on process_order.php, we can display pricing info on this page
if (isset($_SESSION["total_price"])) {
	$base_price = $_SESSION["base_price"];
	$subtotal_base_price = $_SESSION["subtotal_base_price"];
	$option_price = $_SESSION["option_price"];
	$subtotal_option_price = $_SESSION["subtotal_option_price"];
	$extras_individual_pricing = $_SESSION["extras_individual_pricing"];
	$subtotal_extras_individual_pricing = $_SESSION["subtotal_extras_individual_pricing"];
	$total_price = $_SESSION["total_price"];
} else {
	$total_price = false;
}

// Destroy session
// Not necessary, as $_SESSION key-value pair will be overwritten in process_order.php,
// but I think it is good practice to delete them nonetheless.
session_destroy();

// Function: Check selected state
function selected_state($arg) {
	global $state;
	if ($arg == $state) {
		return "selected";
	}
}

// Function: Check checked preferred contact
function checked_preferred_contact($arg) {
	global $preferred_contact;
	if ($arg == $preferred_contact) {
		return "checked";
	}
}

// Function: Check selected origin
function selected_origin($arg) {
	global $origin;
	if ($arg == $origin) {
		return "selected";
	}
}

// Function: Check selected destination
function selected_destination($arg) {
	global $destination;
	if ($arg == $destination) {
		return "selected";
	}
}

// Function: Check selected option
function selected_option($arg) {
	global $option;
	if ($arg == $option) {
		return "selected";
	}
}

// Function: Check checked extras
function checked_extras($arg) {
	global $extras_arr;
	if (!empty($extras_arr)) {
		foreach ($extras_arr as $extra) {
			if ($arg == $extra) {
				return "checked";
			}
		}
	}
}

// Set HTML ID
$html_id = "page_fix_order";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Fix Order page">
	<meta name="keywords" content="payment">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet">
	<script src="scripts/cancel_order_part3.js"></script>
	<title>Fix Order</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>   
		<article>
			<div id="article_intro">
				<h1>Fix Order</h1>
			</div>
			<h2>Input Errors</h2>
			<ul>
				<?php foreach ($err_msgs as $err_msg): ?>
					<li><?php echo $err_msg; ?></li>
				<?php endforeach; ?>
			</ul>
			<form id="form" method="post" action="process_order.php" novalidate>
				<p>DO NOT ENTER YOUR REAL DETAILS BELOW!<br>INSTEAD, JUST MAKE SOMETHING UP.<br>THIS WEBSITE IS FOR DEMONSTRATION PURPOSES ONLY!</p>
				<fieldset id="selections">
					<legend>Your Selections</legend>
					<p>
						<label for="first_name">First Name</label>
						<input type="text" name="first_name" id="first_name" pattern="^[A-Za-z]{1,25}$" maxlength="25" title="Please enter letters only. Maximum 25 characters allowed." value="<?php echo $first_name; ?>" required>
					</p>
					<p>
						<label for="last_name">Last Name</label>
						<input type="text" name="last_name" id="last_name" pattern="^[A-Za-z]{1,25}$" maxlength="25" title="Please enter letters only. Maximum 25 characters allowed." value="<?php echo $last_name; ?>" required>
					</p>
					<p>
						<label for="street_address">Street Address</label>
						<input type="text" name="street_address" id="street_address" pattern="^[A-Za-z0-9 ]{1,40}$" maxlength="40" title="Please enter letters, numbers and spaces only. Maximum of 40 characters allowed." value="<?php echo $street_address; ?>" required>
					</p>
					<p>
						<label for="suburb_town">Suburb / Town</label>
						<input type="text" name="suburb_town" id="suburb_town" pattern="^[A-Za-z ]{1,20}$" maxlength="20" title="Please enter letters and spaces only. Maximum of 20 characters allowed." value="<?php echo $suburb_town; ?>" required>
					</p>
					<p>
						<label for="state">State</label>
						<select name="state" id="state" required>
							<option value="" <?php echo selected_state(""); ?>>Please Select</option>	
							<option value="VIC" <?php echo selected_state("VIC"); ?>>VIC</option>			
							<option value="NSW" <?php echo selected_state("NSW"); ?>>NSW</option>
							<option value="QLD" <?php echo selected_state("QLD"); ?>>QLD</option>
							<option value="NT" <?php echo selected_state("NT"); ?>>NT</option>
							<option value="WA" <?php echo selected_state("WA"); ?>>WA</option>
							<option value="SA" <?php echo selected_state("SA"); ?>>SA</option>
							<option value="TAS" <?php echo selected_state("TAS"); ?>>TAS</option>
							<option value="ACT" <?php echo selected_state("ACT"); ?>>ACT</option>
						</select>
					</p>
					<p>
						<label for="postcode">Post Code</label>
						<input type="text" name="postcode" id="postcode" pattern="[0-9]{4}" maxlength="4" title="Please enter numbers only. Must be 4 digits in length." value="<?php echo $postcode; ?>" required>
					</p>
					<p>	
						<label for="phone">Phone</label>
						<input type="text" name="phone" id="phone" pattern="[0-9]{10}" maxlength="10" title="Please enter numbers only. Must be 10 digits in length." placeholder="04XXXXXXXX" value="<?php echo $phone; ?>" required>
					</p>
					<p>
						<label for="email">Email</label>
						<input type="email" name="email" id="email" title="Please enter a valid email address." value="<?php echo $email; ?>" required>
					</p>

					<p class="label">Contact Method</p>
					<p class="radios_or_checkboxes">
						<label><input type="radio" name="preferred_contact" value="email" <?php echo checked_preferred_contact("email"); ?>>Email</label>
						<label><input type="radio" name="preferred_contact" value="post" <?php echo checked_preferred_contact("post"); ?>>Post</label>
						<label><input type="radio" name="preferred_contact" value="phone" <?php echo checked_preferred_contact("phone"); ?>>Phone</label>
					</p>
					<p>
						<label for="origin">Origin</label>
						<select name="origin" id="origin" required>
							<option value="" <?php echo selected_origin(""); ?>>Please Select</option>	
							<option value="africa" <?php echo selected_origin("africa"); ?>>Africa</option>
							<option value="asia" <?php echo selected_origin("asia"); ?>>Asia</option>
							<option value="antarctica" <?php echo selected_origin("antarctica"); ?>>Antarctica</option>
							<option value="australia" <?php echo selected_origin("australia"); ?>>Australia</option>
							<option value="europe" <?php echo selected_origin("europe"); ?>>Europe</option>
							<option value="north_america" <?php echo selected_origin("north_america"); ?>>North America</option>
							<option value="south_america" <?php echo selected_origin("south_america"); ?>>South America</option>
						</select>
					</p>
					<p>
						<label for="destination">Destination</label>
						<select name="destination" id="destination" required>
							<option value="" <?php echo selected_destination(""); ?>>Please Select</option>	
							<option value="africa" <?php echo selected_destination("africa"); ?>>Africa</option>
							<option value="asia" <?php echo selected_destination("asia"); ?>>Asia</option>
							<option value="antarctica" <?php echo selected_destination("antarctica"); ?>>Antarctica</option>
							<option value="australia" <?php echo selected_destination("australia"); ?>>Australia</option>
							<option value="europe" <?php echo selected_destination("europe"); ?>>Europe</option>
							<option value="north_america" <?php echo selected_destination("north_america"); ?>>North America</option>
							<option value="south_america" <?php echo selected_destination("south_america"); ?>>South America</option>
						</select>
					</p>
					<p>
						<label for="option">Flight Option</label>
						<select name="option" id="option" required>
							<option value="">Please Select</option>	
							<option value="cabin_seating" <?php echo selected_option("cabin_seating"); ?>>Cabin Seating</option>
							<option value="private_cabin" <?php echo selected_option("private_cabin"); ?>>Private Cabin</option>
							<option value="single_suite" <?php echo selected_option("single_suite"); ?>>Single Suite</option>
							<option value="double_suite" <?php echo selected_option("double_suite"); ?>>Double Suite</option>
						</select>
					</p>
					<p class="label">Extras</p>
					<p class="radios_or_checkboxes">
						<label><input type="checkbox" name="extras[]" value="shopping" <?php echo checked_extras("shopping"); ?>>Shopping</label>
						<label><input type="checkbox" name="extras[]" value="pet_transport" <?php echo checked_extras("pet_transport"); ?>>Pet Transport</label>
						<label><input type="checkbox" name="extras[]" value="car_transport" <?php echo checked_extras("car_transport"); ?>>Car Transport</label>
						<label><input type="checkbox" name="extras[]" value="butler" <?php echo checked_extras("butler"); ?>>Butler</label>
					</p>
					<p>
						<label for="tickets">No. of tickets</label>
						<input type="text" name="tickets" id="tickets" pattern="[1-8]" maxlength="1" title="Please enter a number between 1 and 8." value="<?php echo $tickets; ?>" required>
					</p>
					<p>
						<label for="comments">Comments</label>
						<textarea name="comments" id="comments" placeholder="Enter text here..."><?php echo $comments; ?></textarea>
					</p>
				</fieldset>
				<h2>Order summary</h2>
				<?php if ($total_price): ?>
					<table id="total">
						<colgroup>
							<col>
							<col>
							<col>
							<col>
						</colgroup>
						<tr>
							<th>Qty</th>
							<th>Item</th>
							<th>Price</th>
							<th>Sub Total</th>
						</tr>
						<tr>
							<td><?php echo $tickets; ?></td>
							<td>Flight: <?php echo beautify($origin); ?> to <?php echo beautify($destination); ?></td>
							<td><?php echo dollar($base_price); ?></td>
							<td><?php echo dollar($subtotal_base_price); ?></td>
						</tr>
						<tr>
							<td><?php echo $tickets; ?></td>
							<td>Flight option: <?php echo beautify($option); ?></td>
							<td><?php echo dollar($option_price); ?></td>
							<td><?php echo dollar($subtotal_option_price); ?></td>
						</tr>
						<?php if (!empty($extras_arr)): for ($i = 0; $i < count($extras_arr); $i++): ?>
						<tr>
							<td><?php echo $tickets; ?></td>
							<td>Extra: <?php echo beautify($extras_arr[$i]); ?></td>
							<td><?php echo dollar($extras_individual_pricing[$i]); ?></td>
							<td><?php echo dollar($subtotal_extras_individual_pricing[$i]); ?></td>
						</tr>
						<?php endfor; endif; ?>
						<tr>
							<th colspan="3">Total Price</th>
							<td><?php echo dollar($total_price); ?></td>
						</tr>
					</table>
				<?php else: ?>
					<p>Pricing unavailable. Please see the above errors for more information.</p>
				<?php endif; ?>
				<h2>Pay now</h2>
				<fieldset>
					<legend>Credit Card Payment</legend>
					<p>DO NOT ENTER REAL CREDIT CARD DETAILS BELOW!<br>INSTEAD, JUST MAKE SOMETHING UP.<br>THIS WEBSITE IS FOR DEMONSTRATION PURPOSES ONLY!</p>
					<p>
						<label for="cc_type">Credit Card Type</label>
						<select name="cc_type" id="cc_type" required>
							<option value="">Please Select</option>	
							<option value="visa">Visa</option>			
							<option value="mastercard">Mastercard</option>
							<option value="american_express">American Express</option>
						</select>
					</p>
					<p>
						<label for="cc_name">Name on Credit Card</label>
						<input type="text" name="cc_name" id="cc_name" pattern="^[A-Za-z ]{1,40}$" maxlength="40" title="Please enter letters and spaces only. Maximum of 40 characters allowed." required>
					</p>
					<p>
						<label for="cc_number">Credit Card Number</label>
						<input type="text" name="cc_number" id="cc_number" pattern="^[0-9]{15,16}$" maxlength="16" title="Please enter numbers only. Must be 15 or 16 numbers in length." required>
					</p>
					<p>
						<label for="cc_expiry">Credit Card Expiry Date</label>
						<input type="text" name="cc_expiry" id="cc_expiry" pattern="^((0[1-9])|(1[0-2]))-([0-9]{2})$" maxlength="5" title="Please enter expiry date in the format MM-YY" placeholder="MM-YY" required>
					</p>
					<p>
						<label for="cc_cvv">Card Verification Value (CVV)</label>
						<input type="text" name="cc_cvv" id="cc_cvv" pattern="^[0-9]{3}$" maxlength="3" title="Please enter numbers only. Maximum of 3 numbers allowed." required>
					</p>
					<span id="warning">
						<?php if ($total_price): ?>
							<em><?php echo dollar($total_price); ?> will be charged to your card under the name 'Swinburne Air'.</em>
						<?php endif; ?>
					</span>
				</fieldset>
				<input type="submit" value="Check Out">
				<input type="reset" value="Cancel Order">
			</form>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>