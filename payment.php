<?php

// Set HTML ID
$html_id = "page_payment";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Payment page">
	<meta name="keywords" content="payment">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet">
	<script src="scripts/part2.js"></script>
	<title>Payment</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>   
		<article>
			<div id="article_intro">
				<h1>Payment</h1>
			</div>
			<section>
				<h2>Your selections</h2>
				<table id="summary">
					<colgroup>
						<col>
						<col>
					</colgroup>
					<tr>
						<th>First Name</th>
						<td id="display_first_name"></td>
					</tr>
					<tr>
						<th>Last Name</th>
						<td id="display_last_name"></td>
					</tr>
					<tr>
						<th>Street Address</th>
						<td id="display_street_address"></td>
					</tr>
					<tr>
						<th>Suburb / Town</th>
						<td id="display_suburb_town"></td>
					</tr>
					<tr>
						<th>State</th>
						<td id="display_state"></td>
					</tr>
					<tr>
						<th>Post Code</th>
						<td id="display_postcode"></td>
					</tr>
					<tr>
						<th>Phone</th>
						<td id="display_phone"></td>
					</tr>
					<tr>
						<th>Email</th>
						<td id="display_email"></td>
					</tr>
					<tr>
						<th>Contact Method</th>
						<td id="display_preferred_contact"></td>
					</tr>
					<tr>
						<th>Origin</th>
						<td id="display_origin"></td>
					</tr>
					<tr>
						<th>Destination</th>
						<td id="display_destination"></td>
					</tr>
					<tr>
						<th>Flight Option</th>
						<td id="display_option"></td>
					</tr>
					<tr>
						<th>Extras</th>
						<td id="display_extras"></td>
					</tr>
					<tr>
						<th>No. of Tickets</th>
						<td id="display_tickets"></td>
					</tr>
					<tr>
						<th>Comments</th>
						<td id="display_comments"></td>
					</tr>
				</table>
			</section>
			<section>
				<h2>Order summary</h2>
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
				</table>
			</section>
			<section>
				<h2>Pay now</h2>
				<form id="form" method="post" action="process_order.php" novalidate>
					<fieldset hidden>
						<input type="hidden" name="first_name" id="first_name">
						<input type="hidden" name="last_name" id="last_name">
						<input type="hidden" name="street_address" id="street_address">
						<input type="hidden" name="suburb_town" id="suburb_town">
						<input type="hidden" name="state" id="state">
						<input type="hidden" name="postcode" id="postcode">
						<input type="hidden" name="phone" id="phone">
						<input type="hidden" name="email" id="email">
						<input type="hidden" name="preferred_contact" id="preferred_contact">
						<input type="hidden" name="origin" id="origin">
						<input type="hidden" name="destination" id="destination">
						<input type="hidden" name="option" id="option">
						<input type="hidden" name="extras" id="extras">
						<input type="hidden" name="tickets" id="tickets">
						<input type="hidden" name="comments" id="comments">
						<input type="hidden" name="base_price" id="base_price">
						<input type="hidden" name="option_price" id="option_price">
						<div id="hidden_extra_price_inputs">
							<!-- These input fields will be dynamically generated based on user-selections -->
						</div>
						<input type="hidden" name="total_price" id="total_price">
					</fieldset>
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
						<span id="warning"></span>
					</fieldset>
					<input type="submit" value="Check Out">
					<input type="reset" value="Cancel Order">
				</form>
			</section>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>