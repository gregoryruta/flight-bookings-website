<?php

// Set HTML ID
$html_id = "page_about";

?>
<!DOCTYPE html>
<html lang="en" id="<?php echo $html_id; ?>">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Learn about the creator of our website.">
	<meta name="keywords" content="flight, bookings, swinburne, luxury, travel, website, developer, gregory ruta">
	<meta name="author" content="Gregory Ruta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400&display=swap" rel="stylesheet"> 
	<title>About our web developer</title>
</head>
<body>
	<?php include_once("includes/header.inc"); ?>
	<main>  
		<article>
			<div id="article_intro">
				<h1>About me</h1>
			</div>
			<section>
				<h2>Basic Information</h2>
				<dl>
					<dt>Name:</dt><!-- Comment removes whitespace between inline-block elements
				 --><dd>Gregory Ruta</dd>
				 	<dt>Student ID:</dt><!-- Comment removes whitespace between inline-block elements
				 --><dd>xxxxxxxxx</dd>
					<dt>Course:</dt><!-- Comment removes whitespace between inline-block elements
				 --><dd>Bachelor of Computer Science</dd>
					<dt>Email:</dt><!-- Comment removes whitespace between inline-block elements
				 --><dd><a href="mailto:xxxxxxxxx@student.swin.edu.au">xxxxxxxxx@student.swin.edu.au</a></dd>
				</dl>
			</section>
			<section class="clearfix">
				<h2>My trip to Zhangjiajie</h2>
				<figure>
					<img src="images/me.jpg" alt="Photo of me" id="me" width="300" height="400">
					<figcaption>
						Me at the bottom of the 'Stairway to Heaven'.
					</figcaption>
				</figure>
				<p>In January 2020, I visited Zhangjiajie, located in the Hunan Province of China. Near Zhangjiajie, I visited a mountain called Tianmen Mountain, which is also known as Heaven's Gate Mountain.</p>
				<p>In order to get to the mountain, we took a bus from Zhangjiajie which was a 20 minute journey. We then took a cable car part way up the mountain. From there, it was a short walk to reach the 'Stairway to Heaven'.</p>
				<p>There are 999 steps to the top and it took me 8 minutes and 48 seconds to climb. The stairs were icy so it was quite slippery.</p>
				<p>At the top of the stairs, there were about half a dozen long, steep escalators which took us to the summit of the mountain.</p>
				<p>At the summit, it was very cold and everything was covered in ice. Luckily there were vendors selling hot ginseng tea and hot corn cobs.</p>
				<p>From the top of the mountain, we caught a cable car, which took us 8km back down into the heart of Zhangjiaje.</p>
			</section>
			<section>
				<h2>My timetable</h2>
				<table id="timetable">
					<caption>Timetable Semester 1, 2020</caption>
					<tr>
						<td></td>
						<th scope="col">Monday</th>
						<th scope="col">Tuesday</th>
						<th scope="col">Wednesday</th>
						<th scope="col">Thursday</th>
						<th scope="col">Friday</th>
					</tr>
					<tr>
						<th>08:30 - 09:30</th>
						<td rowspan="3" class="tne10006">TNE10006<br>Lab<br>ATC328</td>
						<td></td>
						<td rowspan="2" class="cos10009">COS10009<br>Lab<br>ATC625</td>
						<td></td>
						<td rowspan="2" class="tne10006">TNE10006<br>Lec<br>ATC101</td>
					</tr>
					<tr>
						<th>09:30 - 10:30</th>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th>10:30 - 11:30</th>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th>11:30 - 12:30</th>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th>12:30 - 13:30</th>
						<td></td>
						<td rowspan="2" class="cos10009">COS10009<br>Lec<br>ATC101</td>
						<td rowspan="2" class="cos10003">COS10003<br>Lec<br>ATC101</td>
						<td></td>
						<td rowspan="2" class="cos10003">COS10003<br>Tut<br>BA707</td>
					</tr>
					<tr>
						<th>13:30 - 14:30</th>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th>14:30 - 15:30</th>
						<td rowspan="2" class="cos10011">COS10011<br>Lec<br>ATC101</td>
						<td></td>
						<td></td>
						<td></td>
						<td rowspan="2" class="cos10009">COS10009<br>Wkshp<br>EN413</td>
					</tr>
					<tr>
						<th>15:30 - 16:30</th>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th>16:30 - 17:30</th>
						<td></td>
						<td></td>
						<td rowspan="2" class="cos10011">COS10011<br>Lab<br>BA404</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th>17:30 - 18:30</th>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</section>
		</article>
	</main>
	<?php include_once("includes/footer.inc"); ?>
</body>
</html>