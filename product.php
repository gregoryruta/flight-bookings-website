<?php

// Set HTML ID
$html_id = "page_product";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Discover what makes us the most exlusive airline ever.">
	<meta name="keywords" content="flight, bookings, swinburne, luxury, travel, service, pricing, testimonials">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet">
	<script src="scripts/part2.js"></script>
	<script src="scripts/enhancements.js"></script>
	<title>About our service</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>
		<article>
			<div id="article_intro">
				<h1>About our service</h1>
				<p>At Swinburne Air, we are revolutionising the way you travel. We are proud to offer a premium airline where all seats are first class. With a fleet of over 100 planes worldwide, we are the first choice for those wanting to travel in luxury. Our clients include celebrities, heads of state and anyone who is looking for a convenient alternative to owning a private jet.</p>
			</div>
			<aside id="testimonials">
				<h2>Testimonials</h2>
				<!-- As per W3C spec, <cite></cite> is not allowed in <blockquote></blockquote>. Instead, use <figure></figure> & <figcaption></figcaption> to relate the quote to its author. see https://www.w3.org/TR/html5-author/the-blockquote-element.html#the-blockquote-element -->
				<figure>
					<blockquote>
						<p>No, really, Swinburne Air is the best. I don't use my private jets anymore.</p>
					</blockquote>
					<figcaption>
						<cite>John Bravolta</cite>
					</figcaption>
				</figure>
				<figure>
					<blockquote>
						<p>Two thumbs up! Swinburne Air is the best airline ever.</p>
					</blockquote>
					<figcaption>
						<cite>Ronald Trump</cite>
					</figcaption>
				</figure>
				<figure>
					<blockquote id="blockquote_example">
						<p>I really like their service. Swinburne Air is my number one choice for travel.</p>
						<p>Their website is very good too!</p>
					</blockquote>
					<figcaption>
						<cite>Jim Berners-Lee</cite>
					</figcaption>
				</figure>
			</aside>
			<section>
				<h2>Flight Options</h2>
				<p>We offer four first class options:</p>
				<ol>
					<li>Cabin seating
						<ul>
							<li>Private space</li>
							<li>Plush extra-wide leather seat</li>
							<li>Unlimited drinks and meals</li>
							<li>Premium inflight entertainment</li>
						</ul>
					</li>
					<li>Private cabins
						<ul>
							<li>French designed luxury private room</li>
							<li>Plush extra-wide leather armchair</li>
							<li>Unlimited drinks and meals</li>
							<li>Premium inflight entertainment</li>
						</ul>
					</li>
					<li>Single suites
						<ul>
							<li>French designed luxury private room</li>
							<li>Single bed with Egyptian cotton sheets</li>
							<li>Plush extra-wide leather armchair</li>
							<li>Unlimited drinks and meals</li>
							<li>Premium inflight entertainment</li>
						</ul>
					</li>
					<li>Double suites
						<ul>
							<li>French designed luxury private room</li>
							<li>Double bed with Egyptian cotton sheets</li>
							<li>Two plush extra-wide leather armchairs</li>
							<li>Unlimited drinks and meals</li>
							<li>Premium inflight entertainment</li>
						</ul>
					</li>
				</ol>
			</section>
			<section>
				<h2>Worldwide Service</h2>
				<p>We service all 7 continents: Africa, Asia, Antarctica, Australia, Europe, North America and South America.</p>
			</section>
			<section id="flight_options_images">
				<h2>Images</h2>
				<div id="images_wrap">
					<figure>
						<img src="images/1st_class_seat.jpg" alt="First class seating" width="360" height="250">
						<figcaption>
							<span>Cabin seating</span>
							<span>Image source: <a href="https://www.singaporeair.com/saar5/images/flying-withus/cabins-new-first-class/private-space.jpg" target="_blank">singaporeair.com</a></span>
						</figcaption>
					</figure>
					<figure>
						<img src="images/1st_class_cabin.jpg" alt="First class individual cabin" width="360" height="250">
						<figcaption>
							<span>Private cabins</span>
							<span>Image source: <a href="https://www.singaporeair.com/saar5/images/flying-withus/suites/individual-cabins.jpg" target="_blank">singaporeair.com</a></span>
						</figcaption>
					</figure>
					<figure>
						<img src="images/1st_class_single_suite.jpg" alt="First class single suite" width="360" height="250">
						<figcaption>
							<span>Single suites</span>
							<span>Image source: <a href="https://www.singaporeair.com/saar5/images/flying-withus/cabins-NewA380/Suites/single-suites.jpg" target="_blank">singaporeair.com</a></span>
						</figcaption>
					</figure>
					<figure>
						<img src="images/1st_class_double_suite.jpg" alt="First class double suite" width="360" height="250">
						<figcaption>
							<span>Double suites</span>
							<span>Image source: <a href="https://www.singaporeair.com/saar5/images/flying-withus/cabins-NewA380/Suites/double-suites.jpg" target="_blank">singaporeair.com</a></span>
						</figcaption>
					</figure>
				</div>
			</section>
			<section>
				<h2>Optional Extras</h2>
				<p>Furthermore, we offer a variety of optional extras including, but not limited to:</p>
				<ul>
					<li>In-flight shopping</li>
					<li>Pet transport</li>
					<li>Car transport</li>
					<li>Personal butler</li>
				</ul>
				<p>If you are interested in any optional extras, please mention this when <a href="enquire.php">contacting us</a>. Should you have any additional requirements, we will do our best to accomodate them.</p>
			</section>
			<section>
				<h2>Pricing</h2>
				<p>Please see the following table for current Cabin Seating pricing. All prices are for one-way flights. All prices are in AUD.</p>
				<table id="base_pricing" class="pricing">
					<caption>Cabin Seating Pricing (valid until 30/08/20)</caption>
					<!-- Table is populated with Javascript -->
				</table>
				<p>Please see the following table for current pricing of our other flight options. All prices are <em>in addition</em> to the base Cabin Seating pricing. All prices are in AUD.</p>
				<table id="option_pricing" class="pricing">
					<caption>Other flight options<br>(valid until 30/08/20)</caption>
					<!-- Table is populated with Javascript -->
				</table>
			</section>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>