<?php

// Start session
session_start();

// Redirect if page is accessed directly
if (!isset($_SESSION["first_name"])) {
	header("location:index.php");
	exit();
}

// Destroy session
session_destroy();

// Set HTML ID
$html_id = "page_database_connection_error";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Database connection error.">
	<meta name="keywords" content="">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet"> 
	<title>Databse Connection Error</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>
		<article>
			<div id="article_intro">
				<h1>There was an error processing your order</h1>
			</div>
			<p>Please contact us for assistance.</p>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>