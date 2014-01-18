<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Google Trends</title>
	<link href="http://fonts.googleapis.com/css?family=Roboto:100,300,300italic,400,400italic,700,700italic" rel="stylesheet" type="text/css">
	<style>
		body, html {
			height:100%;
		}

		body, html, ul, li, h1, h2, h3, h4, h5, p {
			margin: 0;
			padding: 0;
		}

		body {
			font-size:16pt;
			font-family: Roboto, Arial, sans-serif;
			font-weight: 300;
			text-align:center;
			background-color:#555;
		}

		h1 {
			color: #fff;
			font-size: 16pt;
			font-family: Roboto, Arial, sans-serif;
			font-weight: 400;
		}

		p {
			color: #fff;
			font-size: 12pt;
			font-family: Roboto, Arial, sans-serif;
			font-weight: 300;
		}

		a {
			color:#aaa;
			text-decoration: none;
			-webkit-transition: color 0.1s ease-out; /* Saf3.2+, Chrome */
			-moz-transition: color 0.1s ease-out; /* Firefox 4+ */
			-ms-transition: color 0.1s ease-out; /* IE10+ */
			-o-transition: color 0.1s ease-out; /* Opera 10.5+ */
			transition: color 0.1s ease-out;
		}

		a:hover {
			color: #fff;
			text-decoration: none;
		}

		b {
			font-family: Roboto, Arial, sans-serif;
			font-weight: 700;
		}

		td {
			padding:0px;
			margin:0px;
		}

		.header {
			color: #fff;
			font-size: 36pt;
			font-weight: 100;
			padding:10px 0px 25px 10px;
			text-shadow: 0px 0px 10px #000;
		}

		.footer {
			color: #fff;
			font-size: 20pt;
			font-weight: 100;
			padding:25px 0px 10px 10px;
			text-shadow: 0px 0px 10px #000;
		}

		.trend-container {
			padding: 0px;
			margin: 0px;
			display: inline-block;
		}

		.trend-front, .trend-back {
			border-collapse: collapse;
			padding:0px;
			margin:0px;
			width:200px;
			height:200px;
			border-radius: 3px;
		}

		.trend-back {
			background-color:#333;
		}

		.trend-front td, .trend-back td {
			padding:0px;
			margin:0px;
			color:#fff;
			text-shadow:1px 1px 5px #000;
			text-align: center;
			text-transform: lowercase;
			vertical-align: middle;
		}

		.panel {
			width: 206px;
			height: 200px;
			position: relative;

			-webkit-perspective: 600px;
			-moz-perspective: 600px;
			perspective: 600px;
		}

		.panel .front {
			float: none;
			position: absolute;
			top: 0;
			left: 0;
			z-index: 900;
			width: inherit;
			height: inherit;

			-webkit-transform: rotateX(0deg) rotateY(0deg);
			-moz-transform: rotateX(0deg) rotateY(0deg);
			transform: rotateX(0deg) rotateY(0deg);

			-webkit-transform-style: preserve-3d;
			-moz-transform-style: preserve-3d;
			transform-style: preserve-3d;

			-webkit-backface-visibility: hidden;
			-moz-backface-visibility: hidden;
			backface-visibility: hidden;

			-webkit-transition: all .4s ease-in-out;
			transition: all .4s ease-in-out;
		}
		.panel.flip .front {
			z-index: 900;

			-webkit-transform: rotateY(180deg);
			-moz-transform: rotateY(180deg);
			transform: rotateY(180deg);
		}

		.panel .back {
			float: none;
			position: absolute;
			z-index: 800;
			width: inherit;
			height: inherit;

			-webkit-transform: rotateY(-180deg);
			-moz-transform: rotateY(-179deg);
			transform: rotateY(-179deg);

			-webkit-transform-style: preserve-3d;
			-moz-transform-style: preserve-3d;
			transform-style: preserve-3d;

			-webkit-backface-visibility: hidden;
			-moz-backface-visibility: hidden;
			backface-visibility: hidden;

			-webkit-transition: all .4s ease-in-out;
			transition: all .4s ease-in-out;
		}

		.panel.flip .back {
			z-index: 1000;

			-webkit-transform: rotateX(0deg) rotateY(0deg);
			-moz-transform: rotateX(0deg) rotateY(0deg);
			transform: rotateX(0deg) rotateY(0deg);
		}

	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script>
		$(document).ready(function(){

			var i = 0;

			$('.hover').each(function(){
				$(this).css('opacity',0).delay(i+=100).fadeTo(500, 1);
				
			});

			$('.hover').hover(function(){
				$(this).addClass('flip');
			},function(){
				$(this).removeClass('flip');
			});
		});
	</script>
</head>
<body>

	<div class="header">
		Google Trends
	</div>
<?php

	$crawldata = NULL;

	$debug = false;

	$url = "http://www.google.com/trends/hottrends/atom/hourly";


	if($debug) echo "Begin Crawl for $url<br>";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	if($debug) echo "Executing curl...<br>";

	$crawldata = curl_exec($ch);
	//echo curl_error($ch);
	curl_close($ch);

	if($debug) echo "Finished curl...<br>";

	if(!$crawldata){
		if($debug) echo "No crawl data returned!<br>";
	}

	$doc = new DOMDocument();
	$doc->loadHTML($crawldata);
	$xpath = new DOMXpath($doc);

	$trends = $xpath->query("//a");

	$google_colors = array(
		0 => '51, 119, 232',
		1 => '213, 15, 37',
		2 => '238, 178, 17',
		3 => '0, 153, 37'
	);
?>
<table style="border-collapse:collapse;margin:auto;">
	<tr style="padding:0;margin:0;">
	<?php for($i = 0; $i < $trends->length; $i++){
		$rank = $i + 1;
		$rand_goog = rand(0,3);?>
		<td style="padding:0;margin:0;">
			<div class="hover panel trend-container">
				<div class="front">
					<table class="trend-front" style="background-color:rgb(
						<?php echo $google_colors[$rand_goog]; ?>);"><tr><td>
						<?php echo $trends->item($i)->nodeValue;?>
					</td></tr></table>
				</div>
				<div class="back">
					<table class="trend-back"><tr><td>
							<p>search:</p>
							<p><a href="http://www.google.com/#q=<?php echo $trends->item($i)->nodeValue;?>">
								Google
							</p>
							<p><a href="http://search.yahoo.com/search?p=<?php echo $trends->item($i)->nodeValue;?>">
								Yahoo
							</p>
							<p><a href="http://www.bing.com/search?q=<?php echo $trends->item($i)->nodeValue;?>">
								Bing
							</p>
					</td></tr></table>
				</div>
			</div>
		</td>
	<?php if($i % 4 == 3) echo "</tr><tr>"; ?>
	<?php } ?>
	</tr>
</table>

	<div class="footer">
		Alex Johnson - <a href="http://winginit.net">http://winginit.net</a> - <a href="http://github.com/alexmj212/trends">Project on Github</a>
	</div>

</body>
</html>