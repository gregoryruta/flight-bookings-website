<?php

// Set HTML ID
$html_id = "page_enhancements2";

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
	<title>Part 2 enhancements</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main id="main"> 
		<article id="article">
			<div id="article_intro">
				<h1>Part 2 Enhancements: Javascript</h1> 
				<p><a href="scripts/part2.js">part2.js</a> contains code that enables this website to meet the minimum requirements of Assignment Part 2. Additionally, <a href="scripts/enhancements.js">enhancements.js</a> contains code that ehances this website beyond the mimimum requirements of Assignment Part 2. Both Javascript files contain code that employs techniques beyond what was covered in tutorials.</p>
				<p>In <a href="scripts/enhancements.js">enhancements.js</a>, there are two notable enhancements:</p>
				<ol>
					<li><a href="#enhancement_1">Dynamically generated product data</a></li>
					<li><a href="#enhancement_2">Dynamic conditional pricing based on user input</a></li>
				</ol>
			</div>
			<aside>
				<p>Note: you will notice in the following examples the use of beautify(input) and dollar(input) functions. These are globally accessible functions located in part2.js. The beautify(input) function will beautify a string (i.e. converts "north_america" to "North America"). The dollar(input) function will turn an integer into a decimal dollar value with thousands separators (i.e. converts "5000" to "$5,000.00").</p>
			</aside>
			<!-- Note: In the proceeding sections, the content within <pre></pre> tags does not follow the natural indentation flow of this document. This is so the content within the <pre></pre> appears correctly in the browser. -->
			<section>
				<h2 id="enhancement_1">1. Dynamically generated product data</h2>
				<p>In part 2 of the assignment, there are no hard-coded product prices in the HTML. Instead, pricing data and product names are stored as Javascript globally accessible arrays, located at the top of <a href="scripts/part2.js">part2.js</a>:</p>
				<div class="code" data-lang="Javascript" title="Javascript code">
					<pre><code>// Base pricing array
var base_pricing =	[
			["","africa", "asia", "antarctica", "australia", "europe", "north_america", "south_america"],
			["africa", 5000, 8000, 13000, 8000, 7000, 10000, 12000],
			["asia", 8000, 5000, 13000, 7000, 7000, 9000, 10000],
			["antarctica", 14000, 14000, 5000, 14000, 14000, 14000, 14000],
			["australia", 8000, 7000, 13000, 5000, 10000, 11000, 11000],
			["europe", 7000, 7000, 13000, 10000, 5000, 9000, 12000],
			["north_america", 10000, 9000, 13000, 11000, 9000, 5000, 10000],
			["south_america", 12000, 10000, 13000, 11000, 12000, 10000, 5000]
			];

// Option pricing array
var option_pricing =	[
			["cabin_seating", 0], // Cabin seating is the base price
			["private_cabin", 6000],
			["single_suite", 8000],
			["double_suite", 12000],
			];

// Extras pricing array
var extras_pricing =	[
			["shopping", 0],
			["pet_transport", 1000],
			["car_transport", 10000],
			["butler", 2000],
			];</code></pre>
				</div>
				<p>These arrays allow us to dynamically list products and their prices using Javascript. See the following examples:</p>
				<h3>Pricing tables</h3>
				<p>In the <a href="product.html">product.html</a> page, there are two pricing tables. One table displays <a href="product.html#base_pricing">base pricing</a>, the other displays <a href="product.html#option_pricing">option pricing</a>. Both tables are hardcoded in HTML, but they only contain table captions:</p>
				<div class="code" data-lang="HTML" title="HTML code">
					<pre><code>&lt;table id="base_pricing" class="pricing"&gt;
	&lt;caption&gt;Cabin Seating Pricing (valid until 30/08/20)&lt;/caption&gt;
	&lt;!-- Table is populated with Javascript --&gt;
&lt;/table&gt;

&lt;table id="option_pricing" class="pricing"&gt;
	&lt;caption&gt;Other flight options&lt;br&gt;(valid until 30/08/20)&lt;/caption&gt;
	&lt;!-- Table is populated with Javascript --&gt;
&lt;/table&gt;</code></pre>
				</div>
				<p>The table rows, headers and cells are dynamically created and populated with Javascript on page load. This is done by iterating through the relevant pricing array, and creating, modifying and inserting &lt;tr&gt;, &lt;th&gt; and &lt;td&gt; elements (and in the case of the base pricing table, &lt;colgroup&gt; and &lt;col&gt; elements, which are required for CSS purposes).</p>
				<p>The two functions used to respectively populate each table are defined and called in <a href="scripts/enhancements.js">enhancements.js</a>. They are named:</p>
				<div class="code" data-lang="Javascript" title="Javascript code">
					<pre><code>function populate_base_pricing_table() {
	// Javascript code goes here
}

function populate_option_pricing_table() {
	// Javascript code goes here
}</code></pre>
				</div>
				<h3>Product names and pricing options</h3>
				<p>Similar to the pricing tables, all product related options in the <a href="enquire.html">enquire.html</a> page are dynamically generated on page load. The items that are generated are:</p>
				<ul>
					<li>The <a href="enquire.html#origin">origin</a> and <a href="enquire.html#destination">destination</a> select options in the <a href="enquire.html#origin_destination">origin & destination</a> fieldset.</li>
					<li>The priced flight <a href="enquire.html#option"> options</a> select options.</li>
					<li>The priced checkbox options in the <a href="enquire.html#extras">extras</a> fieldset.</li>
				</ul>
				<p>As per the pricing table content, similar iterations were used to display these options. The three functions used are defined and called in <a href="scripts/enhancements.js">enhancements.js</a>. They are named:</p>
				<div class="code" data-lang="Javascript" title="Javascript code">
					<pre><code>function add_origin_destination_selections() {
	// Javascript code goes here
}

function add_flight_options_selections() {
	// Javascript code goes here
}

function add_extras_checkboxes() {
	// Javascript code goes here
}</code></pre>
				</div>
				<h3>Why I chose this enhancement</h3>
				<p>The beauty of this enhancement is that it makes life easier for the website maintainer. In order to add a product, or change a price, it only needs to be done once and in one location - the relevant pricing array. All relevant HTML content will be generated based on the data in these arrays.</p>
			</section>
			<section>
				<h2 id="enhancement_2">2. Dynamic conditional pricing based on user input</h2>
				<p>Similar to the first enhancement, this enhancement makes use of the pricing arrays. However, this enhancement does not improve the website maintainer's experience. Instead, it uses the base pricing array to improve user experience.</p>
				<p>Both the <a href="enquire.html#origin">origin</a> and <a href="enquire.html#destination">destination</a> select elements in the <a href="enquire.html#origin_destination">origin & destination</a> fieldset each contain 7 selectable continent options. Both selections are interdependent and have the same 7 options, giving a total of 49 <em>unique</em> permutations (they are unique because a flight from Australia to Antarctica may differ in price to a flight from Antarctica to Australia - they are not the same thing).</p>
				<p>Abstractly speaking, the origin options represent the the continent headings on the y-axis of the  <a href="product.html#base_pricing">base pricing</a> table, and the destination options represent the continent headings on the x-axis of the <a href="product.html#base_pricing">base pricing</a> table.</p>
				<p>It would make for terrible user experience if the user had to navigate back to the product page to refer to the pricing table while selecting these options. Thus, I have implemented a live price indicator at the bottom of the <a href="enquire.html#origin_destination">origin & destination</a> fieldset.</p>
				<p>The price indicator appears only when options are selected in both of the <a href="enquire.html#origin">origin</a> and <a href="enquire.html#destination">destination</a> select elements. If neither has an option selected, or if only one has an option selected, then the indicator disappears. The indicator price will update when a new origin or destination is selected. Located in <a href="scripts/enhancements.js">enhancements.js</a>, the function (and event trigger) for displaying and hiding the indicator is:</p>
				<div class="code" data-lang="Javascript" title="Javascript code">
					<pre><code>function live_origin_destination_price() {

	var container = document.getElementById("origin_destination");
	var origin = document.getElementById("origin").value;
	var destination = document.getElementById("destination").value;
	var paragraph_od_price = document.createElement("p");
	paragraph_od_price.id = "od_price";
	
	/* Basic logic: If origin and destination are selected,
	(firstly, if no paragraph is available, append a paragraph),
	then print the price in paragraph. 
	Else, if the paragraph exists, remove it. */

	if (origin && destination) {
		if (!document.getElementById("od_price")) {
			container.appendChild(paragraph_od_price);
		}
		document.getElementById("od_price").textContent = "Flight Price: " + dollar(calc_base_price(origin, destination));
	} else if (document.getElementById("od_price")) {
		container.removeChild(container.lastElementChild);
	}
}

document.getElementById("origin_destination").addEventListener("change", live_origin_destination_price);</code></pre>
				</div>
				<p>As can be seen, the above function prints a price with the function call: calc_base_price(origin, destination). The calc_base_price(origin, destination) function returns a price based on the origin and destination selections. It is a globally accessible function that resides in <a href="scripts/part2.js">part2.js</a>. It is located in this file because it is required for calculating pricing on the payments page. This is what the function looks like:</p>
				<div class="code" data-lang="Javascript" title="Javascript code">
					<pre><code>function calc_base_price(origin, destination) {

	for (let i = 0; i &lt; base_pricing.length; i++) {
		if (origin === base_pricing[i][0]) {
			var row = i;
		}
	}

	for (let i = 0; i &lt; base_pricing[0].length; i++) {
		if (destination === base_pricing[0][i]) {
			var col = i;
		}
	}

	return base_pricing[row][col];
}</code></pre>
				</div>
				<p>As can be seen, the calc_base_price(origin, destination) function returns a price based on the (row, column) coordinates (i.e. (x, y) coordinates) of the origin and destination in the base pricing array (or abstractly speaking, the base pricing table).</p>
				<h3>Why I chose this enhancement</h3>
				<p>The beauty of this enhancement is that it makes life easier for the website user. In order to view the base price, the user only needs to select an origin and destination, as opposed to referring to the base pricing table on the product page.</p>
			</section>
			<aside>
				<em>Note: all enhancements on this page are self-inspired and self-designed. Any similarities to another author's content are purely coincidental.</em>
			</aside>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>