<?php

// Set HTML ID
$html_id = "page_enhancements3";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Learn about what makes our website so special.">
	<meta name="keywords" content="flight, bookings, swinburne, luxury, travel, enhancements, html, css, javascript, code">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet"> 
	<title>Part 3 enhancements</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main id="main"> 
		<article id="article">
			<div id="article_intro">
				<h1>Part 3 Enhancements: PHP & MySQL</h1> 
				<p>In Part 3 of this assignment, I have added two major enhancements. These are:</p>
				<ol>
					<li><a href="#enhancement_1">Manger login / logout / password change functionality</a></li>
					<li><a href="#enhancement_2">Ascending / descending table sort functionality</a></li>
				</ol>
			</div>
			<!-- Note: In the proceeding sections, the content within <pre></pre> tags does not follow the natural indentation flow of this document. This is so the content within the <pre></pre> appears correctly in the browser. -->
			<section>
				<h2 id="enhancement_1">1. Manger login / logout / password change functionality</h2>
				<h3>Redirecting from the Manager page</h3>
				<p>The URL of 'Manager' link in the navigation bar is defined as 'manager.php'. However, when the user clicks this link, and the $_SESSION key 'authenticated' is not set (i.e. the user <em>is not</em> 'logged in'), they are redirected to the login page, 'authenticate.php'. Contrastingly, if the $_SESSION key 'authenticated' is set (i.e. the user <em>is</em> 'logged in'), the user can view the 'manager.php' page. The following code at the top of <a href="manager.php">manager.php</a> provides this functionality:</p>
				<div class="code" data-lang="PHP" title="PHP code">
					<pre><code>session_start();
if (!isset($_SESSION["authenticated"])) {
	header("location:authenticate.php");
	exit();
}</code></pre>
				</div>
				<h3>Logging in</h3>
				<p>After the redirect (providing the $_SESSION key 'authenticated' <em>is not</em> set), the user is is presented with a login form on <a href="authenticate.php">authenticate.php</a>. This is a simple form that checks the entered username and password against the entries in the 'managers' table in the database. The following query is used to validate the credentials:</p>
				<div class="code" data-lang="PHP" title="PHP code">
					<pre><code>$query = "SELECT username, password FROM managers WHERE BINARY username = '$username' AND BINARY password = '$password'";</code></pre>
				</div>
				<p><em>Note that 'BINARY' makes the query case sensitive.</em></p>
				<p>If valid credentials are submitted, the $_SESSION key 'authenticated' is set and the user is redirected to 'manager.php'. The contents of 'manager.php' are visible.</p>
				<h3>Password change</h3>
				<p>Apart from the table related forms on the <a href="manager.php">manager.php</a> page, there is also a password change submit button, which belongs to a simple form that redirects the user to <a href="password_change.php">password_change.php</a> (a hyperlink could have been used instead of the form / submit button, but the submit button matched the visual theme of the page).</p>
				<p>On <a href="password_change.php">password_change.php</a>, there is a form similar to that on the <a href="authenticate.php">authenticate.php</a> page, but there are two extra fields: 'New password' and 'Confirm new password'.</p>
				<p>Two queries are run on this page. Firstly, as in the authenticate.php page, the following query is used to validate the credentials:</p>
				<div class="code" data-lang="PHP" title="PHP code">
					<pre><code>$validate_user = "SELECT username, password FROM managers WHERE BINARY username = '$username' AND BINARY password = '$password'";</code></pre>
				</div>
				<p>And secondly, upon success of this query, providing the new password is 8 characters or more and has been entered twice in the 'New password' and 'Confirm new password' fields, the following update query is run:</p>
				<div class="code" data-lang="PHP" title="PHP code">
					<pre><code>$update_password = "UPDATE managers SET password = '$new_password' WHERE BINARY username = '$username' AND BINARY password = '$password'";</code></pre>
				</div>
				<p>This query will update the password in the managers table.</p>
				<h3>Logging out</h3>
				<p>Also on the <a href="manager.php">manager.php</a> page, there is a 'Logout' form submit button, which redirects the manager to the <a href="deauthenticate.php">deauthenticate.php</a> page. And yes, again a simple hyperlink could have been used instead of the form.</p>
				<p>The deauthenticate.php page is very simple. It clears the 'authenticated' $_SESSION key, and it redirects to the manager.php page, which, now that the $_SESSION key 'authenticated' is not set, will redirect to the authenticate.php page. The following code is used on the <a href="deauthenticate.php">deauthenticate.php</a> page:</p>
				<div class="code" data-lang="PHP" title="PHP code">
					<pre><code>session_start();
session_destroy();
header("location:manager.php");</code></pre>
				</div>
				<h3>Why is there no manager registration page?</h3>
				<p>This is meant to be a public facing website, and we don't want random people signing up as managers and viewing and deleting orders.</p>
			</section>
			<section>
				<h2 id="enhancement_2">2. Ascending / descending table sort functionality</h2>
				<h3>Where can this functionality can be found?</h3>
				<p>Once the manager is logged into the <a href="manager.php">manager.php</a> page, they can see 5 forms that are used to query the database. Three forms only contain a submit button: 'Display all orders', 'Display orders by cost' and 'Display all pending orders'. Two forms, 'Search Name' and 'Search Flights', each contain additional input fields. When any of these forms is submitted, providing that the query returns results, a table of results is displayed. By default, the results will be ordered by 'Order ID' (except when displaying results for 'Display orders by cost', where results are ordered by 'Order Cost' - a requirement for this assignment).</p>
				<p>My enchancement adds hyperlinks to the text in table header cells. When one of these hyperlinks is clicked, the page will reload and the same table will be displayed, but it will be ordered by the field matching the hyperlink that was cicked.</p>
				<p>By default, the table will be ordered in 'Ascending' order. When the same hyperlink is clicked again, it will be ordered in 'Descending' order. When another hyperlink is clicked, it will always firstly order results in 'Ascending' order.</p>
				<p>This functionality is fully implemeneted for all tables displayed on this page, except for 'Display orders by cost'. In the 'Display orders by cost' results table, only the 'Order Cost' title has a hyperlink, allowing the user to sort the table by 'Order Cost' in 'Ascending' or 'Descending' order.</p>
				<h3>How does it work?</h3>
				<p>All 'select' queries requested by <a href="manager.php">manager.php</a> are triggered by a GET request. A GET request generates a URL with a query string. For example, when the user clicks on 'Display all orders', this URL is generated:</p>
				<div class="code" data-lang="URL" title="URL">
					<pre><code>manager.php?query_type=all_orders&order_column=order_id&order_direction=ASC</code></pre>
				</div>
				<p>All forms that are used to query the database contain hidden fields that set the 'query_type', 'order_column' and 'order_direction' $_GET key-value pairs. This is what the 'Display all orders' form looks like:</p>
				<div class="code" data-lang="PHP" title="PHP">
					<pre><code>&lt;form method="get" class="single_button"&gt;
	&lt;input type="hidden" name="query_type" value="all_orders"&gt;
	&lt;input type="hidden" name="order_column" value="order_id"&gt;
	&lt;input type="hidden" name="order_direction" value="ASC"&gt;
	&lt;p&gt;&lt;input type="submit" value="Display all orders"&gt;&lt;/p&gt;
&lt;/form&gt;</code></pre>
				</div>
				<p>A search query has more fields for the relvent database query that needs to be made:</p>
				<div class="code" data-lang="PHP" title="PHP">
					<pre><code>&lt;form method="get" class="search"&gt;
	&lt;fieldset&gt;
		&lt;legend&gt;Search Name&lt;/legend&gt;
		&lt;input type="hidden" name="query_type" value="search_name"&gt;
		&lt;p&gt;&lt;label for="first_name"&gt;First Name&lt;/label&gt;&lt;input type="text" name="first_name" id="first_name"&gt;&lt;/p&gt;
		&lt;p&gt;&lt;label for="last_name"&gt;Last Name&lt;/label&gt;&lt;input type="text" name="last_name" id="last_name"&gt;&lt;/p&gt;
		&lt;input type="hidden" name="order_column" value="order_id"&gt;
		&lt;input type="hidden" name="order_direction" value="ASC"&gt;
		&lt;p&gt;&lt;input type="submit" value="Search Name"&gt;&lt;/p&gt;
	&lt;/fieldset&gt;
&lt;/form&gt;</code></pre>
				</div>
				<p>When one of the table hyperlinks is clicked, a query string URL is generated based on the previous GET request. For example, the following is an example of the generation of the 'Last Name' hyperlink (in a table header cell), which can be used to sort the table by 'Last Name':</p>
				<div class="code" data-lang="PHP" title="PHP">
					<pre><code>&lt;th&gt;&lt;a href="&lt;?php echo BASE_URL, "?query_type=", $query_type, search_parameters(), "&order_column=last_name", "&order_direction=", reverse_order("last_name", $order_direction); ?&gt;"&gt;Last Name&lt;/a&gt;&lt;/th&gt;</code></pre>
				</div>
				<p>Note: the functions search_parameters() and <span id="func_reverse_order">reverse_order($hyperlink_order_column, $hyperlink_order_direction)</span> were called in the code. search_parameters() is a simple function that, if the current page is displaying search results, will return the current search key-value pairs to include in the hyperlinks. We will address reverse_order($hyperlink_order_column, $hyperlink_order_direction) later.</p>
				<h3>So where do the variables used in the hyperlinks come from?</h3>
				<p>Firstly, we need to observe how we handle a GET request. Remember, there are 5 forms, so there are 5 possible values for $_GET["query_type"]. This is how an 'All Orders' request is processed:</p>
				<div class="code" data-lang="PHP" title="PHP">
					<pre><code>if ($_GET["query_type"] == "all_orders") {
	$order_column = $_GET["order_column"];
	$order_direction = $_GET["order_direction"];
	$query = "SELECT order_id, order_time, first_name, last_name, origin, destination, flight_option, extras, tickets, order_cost, order_status FROM orders ORDER BY $order_column $order_direction";
	process_select_query($query);
	$heading = "All Orders";
}</code></pre>
				</div>
				<p>The $order_column and $order_direction variables are used to construct the query. The process_select_query($query) function attempts to retrieve the results from the database. And the $heading variable is used to display a results heading above the table.</p>
				<p>After the 5 'if ($_GET["query_type"] == ... )' tests, we now have enough information to set the $query_type variable. We also define the BASE_URL constant here:</p>
				<div class="code" data-lang="PHP" title="PHP">
					<pre><code>define("BASE_URL", "manager.php");
$query_type = $_GET["query_type"];</code></pre>
				</div>
				<p>And now that we have the $order_column variable available to us, we can define <a href="#func_reverse_order">the function</a> that reverses the sort order direction from Ascending to Descending (and vice versa); BUT only if the order column (i.e. 'order_id', last_name', 'order_cost', etc) from the previous GET request matches the order column of the hyperlink being generated:</p> 
				<div class="code" data-lang="PHP" title="PHP">
					<pre><code>function reverse_order($hyperlink_order_column, $hyperlink_order_direction) {
	global $order_column;
	if ($order_column == $hyperlink_order_column) {
		return $hyperlink_order_direction == "ASC" ? "DESC" : "ASC";
	} else {
		return "ASC";
	}
}</code></pre>
				</div>
				<p>The result is that when a table is sorted by an order column and order direction, only that column's corresponding hyperlink will contain the opposite order direction to the direction in which the table is currently being ordered. All other order column hyperlinks will have the 'ASC' order direction set by default.</p>
			</section>
			<aside>
				<em>Note: all enhancements on this page are self-inspired and self-designed. Any similarities to another author's content are purely coincidental.</em>
			</aside>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>