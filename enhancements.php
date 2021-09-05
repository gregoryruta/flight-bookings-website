<?php

// Set HTML ID
$html_id = "page_enhancements";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Learn about what makes our website so special.">
	<meta name="keywords" content="flight, bookings, swinburne, luxury, travel, enhancements, html, css, code">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet"> 
	<title>Part 1 enhancements</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main id="main"> 
		<article id="article">
			<div id="article_intro">
				<h1>Part 1 Enhancements: HTML & CSS</h1> 
				<p>This website contains a few enhacements that extend beyond the requirements of the assignment. These enhancements include the use of:</p>
				<ol>
					<li><a href="#enhancement_1">Pseudo elements and classes</a></li>
					<li><a href="#enhancement_2">Responsive design</a></li>
					<li><a href="#enhancement_3">Flexbox</a></li>
				</ol>
			</div>
			<!-- Note: In the proceeding sections, the content within <pre></pre> tags does not follow the natural indentation flow of this document. This is so the content within the <pre></pre> appears correctly in the browser. -->
			<section>
				<h2 id="enhancement_1">1. Pseudo elements and classes</h2>
				<h3>Navicon</h3>
				<p>The most noteable use of pseudo elements is in the <a href="#navicon">navicon</a>. The navicon plays an important role in the responsive design of this website and it is visible in the top-right corner when the screen width falls below 980px.</p>
				<p>There are a number of options that can be used to create a 3-line navicon, including using traditional images (like .jpg or .png), .svg images, or html elements. I used the html element approach as I find it the most flexible for styling purposes.</p>
				<p>Since we require three lines, we require 3 elements:</p>
				<p>The first element is an empty span element in the #navicon div. This is for the middle line. The second element, for the top line, is a pseudo element (#navicon::before) that sits before the span element. The third element, for the bottom line, is a pseudo element (#navicon::after) that sits after the span element.</p>
				<p>All three elements are individually, absolutely positioned relative to their parent, #navicon, to form the 3 layers of the navicon. The three layers are otherwise styled identically:</p>
				<div class="code" data-lang="HTML" title="HTML code">
					<pre><code>&lt;div id="navicon" title="navicon"&gt;
	&lt;span title="navicon element"&gt;&lt;/span&gt;
&lt;/div&gt;</code></pre>
				</div>
				<div class="code" data-lang="CSS" title="CSS code">
					<pre><code>#navicon {
	display: block;
	position: relative;
	height: 31px;
	width: 40px;
}

#navicon::before {
	content: '';
	top: 0px;
}

#navicon span {
	top: 12px;
}

#navicon::after {
	content: '';
	top: 24px;
}

#navicon span,
#navicon::before,
#navicon::after {
	position: absolute;
	left: 0;
	height: 4px;
	width: 100%;
	background-color: #FFF;
	border-radius: 5px;
}</code></pre>
				</div>
				<p>I could have done away with the span element altogether and styled the 3-line navicon with only one or two pseudo elements (by using box shadows or double borders), but my method provides more flexibility. For example, all three elements can be styled with 'border-radius' or, if I was inclined, individually animated. Another approach could have included the use of 3 span elements and no pseudo elements whatsoever.</p>
				<h3>Testimonials</h3>
				<p>I thought it would be an interesting exercise to combine both pseudo elements and pseudo classes to add quotation marks to the quoted paragraphs in the testimonial <a href="product.php#blockquote_example">blockquotes</a>. The CSS rules add quotation marks at the <em>beginning of the first paragraph</em> in the blockquote, and at the <em>end of the last paragraph</em> in the blockquote:</p>
				<div class="code" data-lang="HTML" title="HTML code">
					<pre><code>&lt;figure&gt;
	&lt;blockquote&gt;
		&lt;p&gt;First paragraph with no quotation marks.&lt;/p&gt;
		&lt;p&gt;Last paragraph with no quotation marks.&lt;/p&gt;
	&lt;/blockquote&gt;
	&lt;figcaption&gt;
		&lt;cite&gt;Author's name&lt;/cite&gt;
	&lt;/figcaption&gt;
&lt;/figure&gt;</code></pre>
				</div>
				<div class="code" data-lang="CSS" title="CSS code">
					<pre><code>#testimonials blockquote p:first-of-type::before {
	content: '"';
}

#testimonials blockquote p:last-of-type::after {
	content: '"';
}</code></pre>
				</div>
				<p>The advantage of adding the quotation marks in this manner, is that if we decide the quotes look better without quotation marks, all we have to do is delete or comment out the above two css rules; as opposed to manually deleting (potentially dozens) of quotation marks in the html.</p>
				<p>Furthermore, the <a href="#article">article</a> element includes padding, and if its last child had a bottom margin, there would be too much white-space at the bottom of the article. Thus, a pseudo class (:last-child) is used to target the last child of the article element to set its bottom margin to 0. Note, the '>' selector targets an immediate child of the parent:</p>
				<div class="code" data-lang="CSS" title="CSS code">
					<pre><code>article > *:last-child {
	margin-bottom: 0;
}</code></pre>
				</div>
				<h3>Code snippet containers</h3>
				<p>A pseudo element (::before) is also used to style the banner of the <a href="#example_code_snippet">code snippet containers</a> on this page. The code language name in the banner is obtained from the data-lang attribute:</p>
				<div id="example_code_snippet" class="code" data-lang="HTML" title="HTML code">
					<pre><code>&lt;div class="code" data-lang="HTML" title="HTML code"&gt;
	&lt;pre&gt;&lt;code&gt; &lt;!--Code snippet goes here--&gt; &lt;/code&gt;&lt;/pre&gt;
&lt;/div&gt;</code></pre>
				</div>
				<div class="code" data-lang="CSS" title="CSS code">
					<pre><code>.code {
	position: relative;
	padding-top: 2em;
	border-radius: 10px;
	color: gold;
	background-color: #000;
	font-family: monospace;
	margin-bottom: 1em;
	overflow: hidden;
}

.code::before {
	content: attr(data-lang);
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	line-height: 2em;
	padding-right: 10px;
	text-align: right;
	background-image: linear-gradient(to right, #fb6262, #633fc6);
	color: white
}

pre {
	overflow-x: scroll;
}

code {
	display: inline-block;
	padding: 2em;
}</code></pre>
				</div>
				<em>My code snippet containers were inspired by Chris Coyier's examples at <a href="https://css-tricks.com/considerations-styling-pre-tag/" target="_blank">CSS-Tricks</a>.</em>
			</section>
			<section>
				<h2 id="enhancement_2">2. Responsive design</h2>
				<h3>Viewport meta tag</h3>
				<p>I have optimised the website for use with a wide variety of mobile devices. Firstly, I have done this by including the following meta tag:</p>
				<div class="code" data-lang="HTML" title="HTML code">
					<pre><code>&lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;</code></pre>
				</div>
				<p>This tag tells the browser to set the width of the page to the screen width of the device, along with an initial zoom level of 1.0.</p>
				<h3>Avoiding fixed widths</h3>
				<p>An important design principle that I have implemented is avoiding fixed widths where possible. Take for example, the <a href="#main">main</a> element. The main element contains all content that is not in the header or the footer. Instead of setting the width to 980px, I have set its max-width to 980px instead:</p>
				<div class="code" data-lang="CSS" title="CSS code">
					<pre><code>main {
	max-width: 980px;
	width: 100%;
	margin: 0 auto;
}</code></pre>
				</div>
				<p>Since the body is a flex container, the 'width: 100%;' rule must be declarared for main, in order to expand it to 980px if its content is unable to make it do so. The purpose of this is to have a 980px wide main on all pages. Take for example, the <a href="enquire.php">enquire</a> page: the heading and form are too narrow to expand main to 980px.</p>
				<p>The 'margin: 0 auto;' rule centres main in the window.</p>
				<h3>Media queries</h3>
				<p>I have also used media queries that apply different CSS rules as the width and orientation of the screen changes. I have used the following media queries:</p>
				<div class="code" data-lang="CSS" title="CSS code">
					<pre><code>@media screen and (max-width: 980px) {

	/* CSS rules go here */

}

@media screen and (max-width: 767px) {

	/* CSS rules go here */

}

@media screen and (max-width: 479px) {

	/* CSS rules go here */

}

@media screen and (max-height: 550px) and (orientation:landscape) {

	/* CSS rules go here */

}

@media screen and (max-height: 450px) and (orientation:landscape) {

	/* CSS rules go here */

}</code></pre>
				</div>
				<p>There are many rules inside these media queries and it would be too exhaustive to list them all. In summary, the main changes that are made in each media query are:</p>
				<h4>@media screen and (max-width: 980px)</h4>
				<ul>
					<li>Significant changes to the <a href="#nav_container">navigation</a>. The navigation bar disapears and is replaced with a navicon. The navigation links can be accessed by hovering over the navicon.</li>
					<li>Changes to the splash <a href="index.php#splash_heading">heading</a> and <a href="index.php#splash_span">span</a> on the home page.</li>
					<li>Changes to the <a href="#footer">footer</a> where each column becomes a row. All footer text is now centre-aligned.</li>
					<li>Changes to the <a href="#article">article</a> element to account for the background image no longer being visible (apart from in the header and footer).</li>
				</ul>
				<h4>@media screen and (max-width: 767px)</h4>
				<ul>
					<li>Further changes to the splash text on the home page.</li>
					<li>Changes to the product page, including removing the float on the <a href="product.php#testimonials">aside</a> and adjusting the font size in the table.</li>
					<li>Changes to the enquire page, including adjusting the percentage widths of some <a href="enquire.php#form">form</a> elements.</li>
					<li>Changes to the <a href="about.php">about</a> page, including adjusting the percentage widths on the dd and dt elements, removing the float from the figure and adjusting the font size of my timetable.</li>
				</ul>
				<h4>@media screen and (max-width: 479px)</h4>
				<ul>
					<li>Further changes to those listed above.</li>
					<li>Adjusting the <a href="product.php#images_wrap">images</a> on the product page so they are now 'elastic'.</li>
				</ul>
				<h4>@media screen and (max-height: 550px) and (orientation:landscape),<br>@media screen and (max-height: 450px) and (orientation:landscape)</h4>
				<ul>
					<li>Changes to the splash text and main padding on the home page so that the page looks good in landscape mode on mobile devices.</li>
				</ul>
			</section>
			<section>
				<h2 id="enhancement_3">3. Flexbox</h2>
				<h3>Sticky footer</h3>
				<p>You will notice that on the <a href="index.php">home</a> page, the footer sticks to the bottom of the page, despite there being no visible content to push it down. Yet, on other pages, the footer extends below the visible page, pushed down by all of the content.</p>
				<p>In order to gain this functionaily on the home page, html and body are firstly given 100% heights. The body element is then set as a flex container and its flex direction is set to column. Finally, main is set so it is allowed to expand to the bottom of the window, until it hits the footer (with the flex-grow rule). In summary, this looks like:</p>
				<div class="code" data-lang="CSS" title="CSS code">
					<pre><code>html,
body {
	height: 100%;
}

body {
	display: flex;
	flex-direction: column;
}

main {
	flex-grow: 1;
}
</code></pre>
				</div>
				<p>The beauty of this solution is that the footer's height does not need to be specified - and I try to avoid fixed heights and widths wherever possible.</p>
				<h3>Footer columns</h3>
				<p>The <a href="#footer">footer</a> looks like it contains 3 equal colums, but it actually contains two colums (divs). Flexbox is used to create this effect. The footer is set as a flex container, and it is set to justify its content from its end (with the justify-content rule). By default, the flex-direction is set as 'row'. The divs are set to a width of 33.33% and their content is appropriately justifed:</p>
				<div class="code" data-lang="CSS" title="CSS code">
					<pre><code>footer {
	display: flex;
	justify-content: flex-end;
}

.footer_col {
	width: 33.33%;
}

.footer_col:nth-child(1) {
	text-align: center;
}

.footer_col:nth-child(2) {
	text-align: right;
}
</code></pre>
				</div>
				<p>While we could have done away with Flexbox and floated these colums to the right, this would have meant that the first column in our code, appears last on the screen, and vice-versa.</p>
			</section>
			<aside>
				<em>Note: apart from the code snippet containers, all other enhancements are self-inspired and self-designed. Any similarities to another author's content are purely coincidental.</em>
			</aside>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>