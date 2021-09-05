<?php

// Redirect to login page if not logged in
session_start();
if (!isset($_SESSION["authenticated"])) {
	header("location:authenticate.php");
	exit();
}

// Get common functions
require_once("common_functions.php");

// Initialise $update and $database_error variables
$database_updated = false;
$database_error = false;

// If an update query has been requested, it is set in $_POST
if (isset($_POST["update"])) {
	
	// Function: Process an update query
	function process_update_query($query) {
		require ("settings.php");
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
		if ($conn) {
			$result = mysqli_query($conn, $query);
			if ($result) {
				global $database_updated;
				$database_updated = true;
			} else {
				global $database_error;
				$database_error = true;
			}
			mysqli_close($conn);
		} else {
			global $database_error;
			$database_error = true;
		}
	}

	// If an 'update - order status' POST request was made, execute the query
	if ($_POST["update"] == "update_status") {
		$order_id = sanitise_input($_POST["order_id"]);
		$order_status = sanitise_input($_POST["order_status"]);
		$query = "UPDATE orders SET order_status = '$order_status' WHERE order_id = '$order_id'";
		process_update_query($query);
		$update = "Order #$order_id status has been updated to $order_status.";
	}

	// If an 'update - cancel order' POST request was made, execute the query
	if ($_POST["update"] == "cancel_order") {
		$order_id = sanitise_input($_POST["order_id"]);
		$query = "DELETE FROM orders WHERE order_id = '$order_id'";
		process_update_query($query);
		$update = "Order #$order_id has been cancelled.";
	}

}

// Initialise $successful_select_query and $results_found variables
$successful_select_query = false;
$results_found = false;

// If a select query has been requested, it is set in $_POST
if (isset($_GET["query_type"])) {

	// Function: Process a select query
	function process_select_query($query) {
		require ("settings.php");
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
		if ($conn) {
			$result = mysqli_query($conn, $query);
			if ($result) {
				global $successful_select_query;
				$successful_select_query = true;
				if (mysqli_num_rows($result) > 0) {
					global $results_found;
					$results_found = true;
					$rows = [];
					global $rows;
					while ($row = mysqli_fetch_assoc($result)) {
						$rows[] = $row;
					}
				}
				mysqli_free_result($result);
			} else {
				global $database_error;
				$database_error = true;
			}
			mysqli_close($conn);
		} else {
			global $database_error;
			$database_error = true;
		}
	}

	// Function: Check selected order status
	function selected_order_status($arg) {
		global $order_status;
		if ($arg == $order_status) {
			echo "selected";
		}
	}

	// If a 'view all orders' GET request was made, execute the query
	if ($_GET["query_type"] == "all_orders") {
		$order_column = $_GET["order_column"];
		$order_direction = $_GET["order_direction"];
		$query = "SELECT order_id, order_time, first_name, last_name, origin, destination, flight_option, extras, tickets, order_cost, order_status FROM orders ORDER BY $order_column $order_direction";
		process_select_query($query);
		$heading = "All Orders";
	}

	// If a 'view all orders by cost' GET request was made, execute the query
	if ($_GET["query_type"] == "all_orders_by_cost") {
		$order_column = $_GET["order_column"];
		$order_direction = $_GET["order_direction"];
		$query = "SELECT order_id, order_time, first_name, last_name, origin, destination, flight_option, extras, tickets, order_cost, order_status FROM orders ORDER BY $order_column $order_direction";
		process_select_query($query);
		$heading = "All Orders by Cost";
	}

	// If a 'view all pending' GET request was made, execute the query
	if ($_GET["query_type"] == "all_pending_orders") {
		$order_column = $_GET["order_column"];
		$order_direction = $_GET["order_direction"];
		$query = "SELECT order_id, order_time, first_name, last_name, origin, destination, flight_option, extras, tickets, order_cost, order_status FROM orders WHERE order_status = 'pending' ORDER BY $order_column $order_direction";
		process_select_query($query);
		$heading = "All Pending Orders";
	}

	// If a 'search name' GET request was made, execute the query
	if ($_GET["query_type"] == "search_name") {
		$order_column = $_GET["order_column"];
		$order_direction = $_GET["order_direction"];
		$first_name = sanitise_input($_GET["first_name"]);
		$last_name = sanitise_input($_GET["last_name"]);
		// If both first_name and last_name fields are empty, artificially mark the query as successful, with no results found.
		// We do this because otherwise all results would be returned from the database (LIKE '' matches every row).
		if (empty($first_name) && empty($last_name)) {
			$successful_select_query = true;
			$results_found = false;
		} else {
			$query = "SELECT order_id, order_time, first_name, last_name, origin, destination, flight_option, extras, tickets, order_cost, order_status FROM orders WHERE first_name LIKE '$first_name%' AND last_name LIKE '$last_name%' ORDER BY $order_column $order_direction";
			process_select_query($query);
		}
		$heading = "Search Results for First Name: \"$first_name\", Last Name: \"$last_name\"";
	}

	// If a 'search flight' GET request was made, execute the query
	if ($_GET["query_type"] == "search_flight") {
		$order_column = $_GET["order_column"];
		$order_direction = $_GET["order_direction"];
		$origin = sanitise_input($_GET["origin"]);
		$destination = sanitise_input($_GET["destination"]);
		// If both origin and destination fields are empty, artificially mark the query as successful, with no results found.
		// We do this because otherwise all results would be returned from the database (LIKE '' matches every row).
		if (empty($origin) && empty($destination)) {
			$successful_select_query = true;
			$results_found = false;
		} else {
			$query = "SELECT order_id, order_time, first_name, last_name, origin, destination, flight_option, extras, tickets, order_cost, order_status FROM orders WHERE origin = '$origin' AND destination = '$destination' ORDER BY $order_column $order_direction";
			process_select_query($query);
		}
		$heading = "Search Results for Origin: \"" . beautify($origin) . "\", Destination: \"" . beautify($destination) . "\"";
	}

	// Define the base url and query type for the URL query string
	define("BASE_URL", "manager.php");
	$query_type = $_GET["query_type"];

	// Function: Reverse the sorting order of a hyperlink, but only if the hyperlink's column is already being used to order the table (see enhancements3.php for more information)
	function reverse_order($hyperlink_order_column, $hyperlink_order_direction) {
		global $order_column;
		if ($order_column == $hyperlink_order_column) {
			return $hyperlink_order_direction == "ASC" ? "DESC" : "ASC";
		} else {
			return "ASC";
		}
	}

	// Function: Add relevent search parameters to the URL query string
	function search_parameters() {
		global $query_type;
		if ($query_type == "search_name") {
			global $first_name;
			global $last_name;
			return "&first_name=$first_name&last_name=$last_name";
		}
		if ($query_type == "search_flight") {
			global $origin;
			global $destination;
			return "&origin=$origin&destination=$destination";
		}
	}
	
}

// Set HTML ID
$html_id = "page_manager";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Manager page">
	<meta name="keywords" content="manager">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet">
	<title>Manager</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>   
		<article>
			<div id="article_intro">
				<h1>Manager</h1>
			</div>
			<form id="logout" action="deauthenticate.php" method="post">
				<input type="submit" value="Logout" />
			</form>
			<form id="password_change" action="password_change.php" method="post">
				<input type="submit" value="Change Password" />
			</form>
			<div id="selections">
				<form method="get" class="single_button">
					<input type="hidden" name="query_type" value="all_orders">
					<input type="hidden" name="order_column" value="order_id">
					<input type="hidden" name="order_direction" value="ASC">
					<p><input type="submit" value="Display all orders"></p>
				</form>
				<form method="get" class="single_button">
					<input type="hidden" name="query_type" value="all_orders_by_cost">
					<input type="hidden" name="order_column" value="order_cost">
					<input type="hidden" name="order_direction" value="ASC">
					<p><input type="submit" value="Display all orders by cost"></p>
				</form>
				<form method="get" class="single_button">
					<input type="hidden" name="query_type" value="all_pending_orders">
					<input type="hidden" name="order_column" value="order_id">
					<input type="hidden" name="order_direction" value="ASC">
					<p><input type="submit" value="Display all pending orders"></p>
				</form>
				<form method="get" class="search">
					<fieldset>
						<legend>Search Name</legend>
						<input type="hidden" name="query_type" value="search_name">
						<p><label for="first_name">First Name</label><input type="text" name="first_name" id="first_name"></p>
						<p><label for="last_name">Last Name</label><input type="text" name="last_name" id="last_name"></p>
						<input type="hidden" name="order_column" value="order_id">
						<input type="hidden" name="order_direction" value="ASC">
						<p><input type="submit" value="Search Name"></p>
					</fieldset>
				</form>
				<form method="get" class="search">
					<input type="hidden" name="query_type" value="search_flight">
					<fieldset>
						<legend>Search Flights</legend>
						<p>
							<label for="origin">Origin</label>
							<select name="origin" id="origin">
								<option value="">Please Select</option>	
								<option value="africa">Africa</option>
								<option value="asia">Asia</option>
								<option value="antarctica">Antarctica</option>
								<option value="australia">Australia</option>
								<option value="europe">Europe</option>
								<option value="north_america">North America</option>
								<option value="south_america">South America</option>
							</select>
						</p>
						<p>
							<label for="destination">Destination</label>
							<select name="destination" id="destination">
								<option value="">Please Select</option>	
								<option value="africa">Africa</option>
								<option value="asia">Asia</option>
								<option value="antarctica">Antarctica</option>
								<option value="australia">Australia</option>
								<option value="europe">Europe</option>
								<option value="north_america">North America</option>
								<option value="south_america">South America</option>
							</select>
						</p>
						<input type="hidden" name="order_column" value="order_id">
						<input type="hidden" name="order_direction" value="ASC">
						<p><input type="submit" value="Search Flights"></p>
					</fieldset>
				</form>
			</div>
			<div>
				<?php if ($database_error): ?>
					<p>There was an error accessing the database.</p>
				<?php endif; ?>
				<?php if ($database_updated): ?>
					<p><?php echo $update; ?></p>
				<?php endif; ?>
				<?php if ($successful_select_query): ?>
					<h2><?php echo $heading; ?></h2>
					<?php if ($results_found): ?>
						<table>
							<?php
							/* 
							The following if-else statement allows me to implement my ordering enhancement, and also meet the 
							requirements of this assignment. The requirements say that we must provide a table ordered
							by Cost, and there is no point providing sort hyperlinks (other than Cost ASC/DESC) when
							the table must be sorted by Cost.
							*/
							if ($query_type == "all_orders_by_cost"): ?>
							<tr>
								<th>Order ID</th>
								<th>Order Date</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Origin</th>
								<th>Destination</th>
								<th>Options</th>
								<th>Extras</th>
								<th>Tickets</th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=order_cost", "&order_direction=", reverse_order("order_cost", $order_direction); ?>">Order Cost</a></th>
								<th>Order Status</th>
								<th>Cancel Order</th>
							</tr>
							<?php else: ?>
							<tr>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=order_id", "&order_direction=", reverse_order("order_id", $order_direction); ?>">Order ID</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=order_time", "&order_direction=", reverse_order("order_time", $order_direction); ?>">Order Date</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=first_name", "&order_direction=", reverse_order("first_name", $order_direction); ?>">First Name</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=last_name", "&order_direction=", reverse_order("last_name", $order_direction); ?>">Last Name</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=origin", "&order_direction=", reverse_order("origin", $order_direction); ?>">Origin</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=destination", "&order_direction=", reverse_order("destination", $order_direction); ?>">Destination</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=flight_option", "&order_direction=", reverse_order("flight_option", $order_direction); ?>">Options</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=extras", "&order_direction=", reverse_order("extras", $order_direction); ?>">Extras</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=tickets", "&order_direction=", reverse_order("tickets", $order_direction); ?>">Tickets</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=order_cost", "&order_direction=", reverse_order("order_cost", $order_direction); ?>">Order Cost</a></th>
								<th><a href="<?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=order_status", "&order_direction=", reverse_order("order_status", $order_direction); ?>">Order Status</a></th>
								<th>Cancel Order</th>
							</tr>
							<?php endif; ?>
							<?php for ($i = 0; $i < count($rows); $i++): ?>
								<tr>
									<td><?php echo $rows[$i]["order_id"]; ?></td>
									<td><?php echo $rows[$i]["order_time"]; ?></td>
									<td><?php echo $rows[$i]["first_name"]; ?></td>
									<td><?php echo $rows[$i]["last_name"]; ?></td>
									<td><?php echo beautify($rows[$i]["origin"]); ?></td>
									<td><?php echo beautify($rows[$i]["destination"]); ?></td>
									<td><?php echo beautify($rows[$i]["flight_option"]); ?></td>
									<td><?php echo beautify($rows[$i]["extras"]); ?></td>
									<td><?php echo $rows[$i]["tickets"]; ?></td>
									<td><?php echo dollar($rows[$i]["order_cost"]); ?></td>
									<td>
										<?php $order_status = $rows[$i]["order_status"]; ?>
										<form method="post">
											<input type="hidden" name="update" value="update_status">
											<select name="order_status">
												<option value="PENDING" <?php selected_order_status("PENDING"); ?>>PENDING</option>	
												<option value="FULFILLED" <?php selected_order_status("FULFILLED"); ?>>FULFILLED</option>
												<option value="PAID" <?php selected_order_status("PAID"); ?>>PAID</option>
												<option value="ARCHIVED" <?php selected_order_status("ARCHIVED"); ?>>ARCHIVED</option>			
											</select>
											<br>
											<input type="hidden" name="order_id" value="<?php echo $rows[$i]["order_id"]; ?>">
											<input type="submit" value="Update">
										</form>
									</td>
									<td>
										<?php if ($order_status == "PENDING"): ?>
										<form method="post">
											<input type="hidden" name="update" value="cancel_order">
											<input type="hidden" name="order_id" value="<?php echo $rows[$i]["order_id"]; ?>">
											<input type="submit" value="Cancel">
										</form>
										<?php endif; ?>
									</td>
								</tr>
								<?php endfor; ?>
						</table>
					<?php else: ?>
						<p>No results found</p>
					<?php endif;
				endif; ?>
			</div>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>