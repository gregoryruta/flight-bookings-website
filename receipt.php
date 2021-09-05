<?php

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

// Convert array to string
$extras_str = implode(", ", $extras_arr);

$tickets = $_SESSION["tickets"];
$comments = $_SESSION["comments"];
$base_price = $_SESSION["base_price"];
$subtotal_base_price = $_SESSION["subtotal_base_price"];
$option_price = $_SESSION["option_price"];
$subtotal_option_price = $_SESSION["subtotal_option_price"];
$extras_individual_pricing = $_SESSION["extras_individual_pricing"];
$subtotal_extras_individual_pricing = $_SESSION["subtotal_extras_individual_pricing"];
$total_price = $_SESSION["total_price"];
$cc_type = $_SESSION["cc_type"];
$cc_name = $_SESSION["cc_name"];
$cc_number = $_SESSION["cc_number"];
$cc_expiry = $_SESSION["cc_expiry"];
$cc_cvv = $_SESSION["cc_cvv"];
$order_id = $_SESSION["order_id"];
$order_date = $_SESSION["order_date"];

// Destroy session
session_destroy();

// Function: Obfuscate a string.
// $show_last parameter defines how many characters are visible from the end of the string.
function obfuscate ($input, $show_last) {
	$hidden = "";
	for ($i = 0; $i < strlen($input) - $show_last; $i++) { 
		$hidden .= "*";
	}
	$visible = "";
	if ($show_last > 0) {
		$visible = substr($input, -$show_last);
	}
	return $hidden . $visible;
}

// Set HTML ID
$html_id = "page_receipt";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Receipt page">
	<meta name="keywords" content="receipt">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet">
	<script src="scripts/part2.js"></script>
	<title>Receipt</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>   
		<article>
			<div id="article_intro">
				<h1>Receipt</h1>
			</div>
			<section>
				<p>Order ID: &nbsp;<?php echo $order_id; ?></p>
				<p>Order Date: &nbsp;<?php echo $order_date; ?></p>
				<h2>Your selections</h2>
				<table id="summary">
					<colgroup>
						<col>
						<col>
					</colgroup>
					<tr>
						<th>First Name</th>
						<td><?php echo $first_name; ?></td>
					</tr>
					<tr>
						<th>Last Name</th>
						<td><?php echo $last_name; ?></td>
					</tr>
					<tr>
						<th>Street Address</th>
						<td><?php echo $street_address; ?></td>
					</tr>
					<tr>
						<th>Suburb / Town</th>
						<td><?php echo $suburb_town; ?></td>
					</tr>
					<tr>
						<th>State</th>
						<td><?php echo $state; ?></td>
					</tr>
					<tr>
						<th>Post Code</th>
						<td><?php echo $postcode; ?></td>
					</tr>
					<tr>
						<th>Phone</th>
						<td><?php echo $phone; ?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?php echo $email; ?></td>
					</tr>
					<tr>
						<th>Contact Method</th>
						<td><?php echo beautify($preferred_contact); ?></td>
					</tr>
					<tr>
						<th>Origin</th>
						<td><?php echo beautify($origin); ?></td>
					</tr>
					<tr>
						<th>Destination</th>
						<td><?php echo beautify($destination); ?></td>
					</tr>
					<tr>
						<th>Flight Option</th>
						<td><?php echo beautify($option); ?></td>
					</tr>
					<tr>
						<th>Extras</th>
						<td><?php echo beautify($extras_str); ?></td>
					</tr>
					<tr>
						<th>No. of Tickets</th>
						<td><?php echo $tickets; ?></td>
					</tr>
					<tr>
						<th>Comments</th>
						<td><?php echo $comments; ?></td>
					</tr>
					<tr>
						<th>Credit Card Type</th>
						<td><?php echo beautify($cc_type); ?></td>
					</tr>
					<tr>
						<th>Credit Card Name</th>
						<td><?php echo obfuscate($cc_name, 0); ?></td>
					</tr>
					<tr>
						<th>Credit Card Number</th>
						<td><?php echo obfuscate($cc_number, 4); ?></td>
					</tr>
					<tr>
						<th>Credit Card Expiry</th>
						<td><?php echo obfuscate($cc_expiry, 0); ?></td>
					</tr>
					<tr>
						<th>Credit Card CVV</th>
						<td><?php echo obfuscate($cc_cvv, 0); ?></td>
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
			</section>
			<p>Thank you for flying with Swinburne Air!</p>
			<p>To return to our home page, please <a href="index.php">click here</a>.</p>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>