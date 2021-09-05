<?php

// Let's only make this page available to logged in users
// Redirect to login page if not logged in
session_start();
if (!isset($_SESSION["authenticated"])) {
	header("location:authenticate.php");
	exit();
}

// Get common functions
require_once("common_functions.php");

// Set default username as empty
$username = "";

// Initialise some variables...
$bad_credentials = false;
$database_error = false;
$password_too_short = false;
$password_mismatch = false;
$password_changed = false;

// If a POST request was made, submit the query
if (isset($_POST["username"])) {
	$username = sanitise_input($_POST["username"]);
	$password = sanitise_input($_POST["password"]);
	$new_password = sanitise_input($_POST["new_password"]);
	$confirm_new_password = sanitise_input($_POST["confirm_new_password"]);
	$validate_user = "SELECT username, password FROM managers WHERE BINARY username = '$username' AND BINARY password = '$password'";
	require_once ("settings.php");
	$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
	if ($conn) {
		$validated_user = mysqli_query($conn, $validate_user);
		if ($validated_user) {
			if (mysqli_num_rows($validated_user)  > 0) {
				if (strlen($new_password) < 8) {
					$password_too_short = true;
				} elseif ($new_password != $confirm_new_password) {
					$password_mismatch = true;
				} else {
					$update_password = "UPDATE managers SET password = '$new_password' WHERE BINARY username = '$username' AND BINARY password = '$password'";
					$updated_password = mysqli_query($conn, $update_password);
					if ($updated_password) {
						$password_changed = true;
					} else {
						$database_error = true;
					}
				}
			} else {
				$bad_credentials = true;
			}
			mysqli_free_result($validated_user);
		} else {
			$database_error = true;
		}
		mysqli_close($conn);
	} else {
		$database_error = true;
	}
}

// Set HTML ID
$html_id = "page_password_change";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="manager password change page">
	<meta name="keywords" content="manager password change page">
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
			<form method="post" id="change_password" class="authenticate">
				<fieldset>
					<legend>Change Password</legend>
					<p><label for="username">Username</label><input type="text" name="username" id="username" value="<?php echo !$password_changed ? $username : ""; ?>"></p>
					<p><label for="password">Current Password</label><input type="password" name="password" id="password"></p>
					<p><label for="new_password">New Password</label><input type="password" name="new_password" id="new_password"></p>
					<p><label for="confirm_new_password">Confirm New Password</label><input type="password" name="confirm_new_password" id="confirm_new_password"></p>
					<p><input type="submit" name="password_change" value="Change Password"></p>
					<p><a href="manager.php">Back</a></p>
				</fieldset>
			</form>
			<?php if ($database_error): ?>
				<p><strong>There was an error accessing the database.</strong></p>
			<?php endif; ?>
			<?php if ($bad_credentials): ?>
				<p><strong>Username or password not found.</strong></p>
			<?php endif; ?>
			<?php if ($password_mismatch): ?>
				<p><strong>New password was not correctly confirmed.</strong></p>
			<?php endif; ?>
			<?php if ($password_too_short): ?>
				<p><strong>New password must be at least 8 characters.</strong></p>
			<?php endif; ?>
			<?php if ($password_changed): ?>
				<p><strong>Password successfully changed.</strong></p>
			<?php endif; ?>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>