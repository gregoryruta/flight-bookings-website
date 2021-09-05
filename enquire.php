<?php

// Set HTML ID
$html_id = "page_enquire";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Contact us to book a flight.">
	<meta name="keywords" content="flight, bookings, swinburne, luxury, travel, contact, booking">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet">
	<script src="scripts/part2.js"></script>
	<script src="scripts/enhancements.js"></script>
	<title>Make a booking</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>   
		<article>
			<div id="article_intro">
				<h1>Make a booking</h1>
			</div>
			<form id="form" action="payment.php" novalidate>
				<p>DO NOT ENTER YOUR REAL DETAILS BELOW!<br>INSTEAD, JUST MAKE SOMETHING UP.<br>THIS WEBSITE IS FOR DEMONSTRATION PURPOSES ONLY!</p>
				<fieldset class="half_paragraphs">
					<legend>Name</legend>
					<p>
						<label for="first_name">First Name</label>
						<input type="text" name="first_name" id="first_name" pattern="^[A-Za-z]{1,25}$" maxlength="25" title="Please enter letters only. Maximum 25 characters allowed." required>
					</p><!-- Comment removes whitespace between inline-block elements
				 --><p>
						<label for="last_name">Last Name</label> 
						<input type="text" name="last_name" id="last_name" pattern="^[A-Za-z]{1,25}$" maxlength="25" title="Please enter letters only. Maximum 25 characters allowed." required>
					</p>
				</fieldset>
				<fieldset class="half_paragraphs">
					<legend>Address</legend>
					<p>
						<label for="street_address">Street Address</label>
						<input type="text" name="street_address" id="street_address" pattern="^[A-Za-z0-9 ]{1,40}$" maxlength="40" title="Please enter letters, numbers and spaces only. Maximum of 40 characters allowed." required>
					</p><!-- Comment removes whitespace between inline-block elements
				 --><p>
						<label for="suburb_town">Suburb / Town</label>
						<input type="text" name="suburb_town" id="suburb_town" pattern="^[A-Za-z ]{1,20}$" maxlength="20" title="Please enter letters and spaces only. Maximum of 20 characters allowed." required>
					</p>
					<p>
						<label for="state">State</label>
						<select name="state" id="state" required>
							<option value="">Please Select</option>	
							<option value="VIC">VIC</option>			
							<option value="NSW">NSW</option>
							<option value="QLD">QLD</option>
							<option value="NT">NT</option>
							<option value="WA">WA</option>
							<option value="SA">SA</option>
							<option value="TAS">TAS</option>
							<option value="ACT">ACT</option>
						</select>
					</p><!-- Comment removes whitespace between inline-block elements
				 --><p>
						<label for="postcode">Post Code</label>
						<input type="text" name="postcode" id="postcode" pattern="[0-9]{4}" maxlength="4" title="Please enter numbers only. Must be 4 digits in length." required>
					</p>
				</fieldset>
				<fieldset class="half_paragraphs">
					<legend>Phone & Email</legend>
					<p>
						<label for="phone">Phone</label>
						<input type="text" name="phone" id="phone" pattern="[0-9]{10}" maxlength="10" title="Please enter numbers only. Must be 10 digits in length." placeholder="04XXXXXXXX" required>
					</p><!-- Comment removes whitespace between inline-block elements
				 --><p>
						<label for="email">Email</label>
						<input type="email" name="email" id="email" title="Please enter a valid email address." required>
					</p>
				</fieldset>
				<fieldset>
					<legend>Preferred Contact Method</legend>
					<p class="radio_or_checkbox">
						<label><input type="radio" name="preferred_contact" value="email" checked>Email</label>
					</p>
					<p class="radio_or_checkbox">
						<label><input type="radio" name="preferred_contact" value="post">Post</label>
					</p>
					<p class="radio_or_checkbox">
						<label><input type="radio" name="preferred_contact" value="phone">Phone</label>
					</p>
				</fieldset>
				<fieldset id="origin_destination" class="half_paragraphs">
					<legend>Origin & Destination</legend>
					<p>
						<label for="origin">Origin</label>
						<select name="origin" id="origin" required>
							<option value="">Please Select</option>	
							<!-- Options are added with Javascript -->
						</select>
					</p><!-- Comment removes whitespace between inline-block elements
				 --><p>
						<label for="destination">Destination</label>
						<select name="destination" id="destination" required>
							<option value="">Please Select</option>	
							<!-- Options are added with Javascript -->
						</select>
					</p>
				</fieldset>
				<fieldset>
					<legend>Flight Option</legend>
					<p>
						<label for="option">Flight Option</label>
						<select name="option" id="option" required>
							<option value="">Please Select</option>	
							<!-- Options are added with Javascript -->
						</select>
					</p>
				</fieldset>
				<fieldset id="extras">
					<legend>Extras</legend>
					<!-- Extras are added with Javascript -->
				</fieldset>
				<fieldset>
					<legend>Number of Tickets</legend>
					<p>
						<label for="tickets">Number of tickets (maximum of 8)</label>
						<input type="text" name="tickets" id="tickets" pattern="[1-8]" maxlength="1" title="Please enter a number between 1 and 8." required>
					</p>
				</fieldset>
				<fieldset>
					<legend>Additional Comments</legend>
					<p><label for="comments">Please enter any aditional comments</label>
						<textarea name="comments" id="comments" placeholder="Enter text here..."></textarea>
					</p>
				</fieldset>
				<input type="submit" value="Pay Now">
				<input type="reset" value="Reset Form">
			</form>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>