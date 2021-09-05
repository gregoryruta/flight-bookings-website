<?php

// Get common functions
require_once("common_functions.php");

// Set default username as empty
$username = "";

// Initialise $bad_creddentials and $database_error variables
$bad_credentials = false;
$database_error = false;

// If a POST request was made, submit the query.
// (I could have used 'isset($_POST["username"]', but '$_SERVER["REQUEST_METHOD"] == "POST"' is sufficient)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = sanitise_input($_POST["username"]);
		$password = sanitise_input($_POST["password"]);
		$query = "SELECT username, password FROM managers WHERE BINARY username = '$username' AND BINARY password = '$password'";
		require_once ("settings.php");
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
		if ($conn) {
			$result = mysqli_query($conn, $query);
			if ($result) {
				if (mysqli_num_rows($result)  > 0) {
					// Log the user in
					session_start();
					$_SESSION["authenticated"] = true;
					header("location:manager.php");
				} else {
					$bad_credentials = true;
				}
				mysqli_free_result($result);
			} else {
				$database_error = true;
			}
			mysqli_close($conn);
		} else {
			$database_error = true;
		}
}

// Set HTML ID
$html_id = "page_authenticate";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="manager login page">
	<meta name="keywords" content="manager login page">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet">
	<title>Restricted Access</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>   
		<article>
			<div id="article_intro">
				<h1>Restricted Access</h1>
			</div>
			<form method="post" class="authenticate">
				<fieldset>
					<legend>Manager Login</legend>
					<p><label for="username">Username</label><input type="text" name="username" id="username" value="<?php echo $username; ?>"></p>
					<p><label for="password">Password</label><input type="password" name="password" id="password"></p>
					<p><input type="submit" name="login" value="Login"></p>
				</fieldset>
			</form>
			<?php if ($database_error): ?>
				<p>There was an error accessing the database.</p>
			<?php endif; ?>
			<?php if ($bad_credentials): ?>
				<p><strong>Username or password not found.</strong></p>
			<?php endif; ?>
			<p><em>For the person marking this assignment:<br>
			Username: "manager"<br>
			Password: "password"<br>
			Both username and password are case-sensitive.</em></p>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>