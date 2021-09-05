<?php

// Set HTML ID
$html_id = "page_home";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Discover why every class is first class on the most luxurious airline ever.">
	<meta name="keywords" content="flight, bookings, swinburne, luxury, travel, home">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet"> 
	<title>Swinburne Air flight bookings</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>
		<h1 id="splash_heading" class="splash_text">Swinburne Air</h1> 
		<span id="splash_span" class="splash_text">Let the journey begin</span>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>