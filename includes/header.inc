<?php

/*
Filename: header.inc
Author: Gregory Ruta
Purpose: Header include file
Created: 20/05/2020
Last Modified: 01/06/2020
Credits: None
*/

$all_html_ids = ["page_home", "page_product", "page_enquire", "page_payment", "page_fix_order", "page_receipt", "page_database_connection_error", "page_about", "page_manager", "page_authenticate", "page_password_change", "page_enhancements", "page_enhancements2", "page_enhancements3"];

// For each HTML ID in the above array, generate a variable that is assigned
// a class name that indicates the page's status ("current" or "" (null))
// based on the current page's HTML ID.
for ($i = 0; $i < count($all_html_ids); $i++) { 
	$page_status = $all_html_ids[$i] . "_status";
	if ($all_html_ids[$i] == $html_id) {
		$$page_status = "current";
	} else {
		$$page_status = null;
	}
}

?>
<header>
	<a href="index.php" id="logo_link"><img src="images/logo.png" alt="Swinburne Air Logo" id="logo" width="41" height="35"></a>
	<div id="nav_container">
		<div id="navicon" title="navicon">
			<span title="navicon element"></span>
		</div>
		<nav>
			<a href="index.php" class="<?php echo $page_home_status; ?>">Home</a><!-- Comment removes whitespace between inline-block elements
		 --><a href="product.php" class="<?php echo $page_product_status; ?>">Service</a><!-- Comment removes whitespace between inline-block elements
		 --><a href="enquire.php" class="<?php echo $page_enquire_status, $page_payment_status, $page_fix_order_status, $page_receipt_status, $page_database_connection_error_status; ?>">Bookings</a><!-- Comment removes whitespace between inline-block elements
		 --><a href="about.php" class="<?php echo $page_about_status; ?>">About</a><!-- Comment removes whitespace between inline-block elements
		 --><a href="manager.php" class="<?php echo $page_manager_status, $page_authenticate_status, $page_password_change_status; ?>">Manager</a><!-- Comment removes whitespace between inline-block elements
		 --><a href="enhancements.php" class="<?php echo $page_enhancements_status; ?>">Enhancements #1</a><!-- Comment removes whitespace between inline-block elements
		 --><a href="enhancements2.php" class="<?php echo $page_enhancements2_status; ?>">Enhancements #2</a><!-- Comment removes whitespace between inline-block elements
		 --><a href="enhancements3.php" class="<?php echo $page_enhancements3_status; ?>">Enhancements #3</a>
		</nav>
	</div>
</header>