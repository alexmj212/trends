<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Hot Google Trends</title>
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
			font-weight: 100;
			text-align:center;
			background-color:#333;
		}

		h1 {
			color: #fff;
			font-size: 16pt;
			font-family: Roboto, Arial, sans-serif;
			font-weight: 700;
		}

		p {
			color: #fff;
			font-size: 12pt;
			font-family: Roboto, Arial, sans-serif;
			font-weight: 100;
		}

		a {
			color:#fff;
			text-decoration: none;
			-webkit-transition: color 0.1s ease-out; /* Saf3.2+, Chrome */
			-moz-transition: color 0.1s ease-out; /* Firefox 4+ */
			-ms-transition: color 0.1s ease-out; /* IE10+ */
			-o-transition: color 0.1s ease-out; /* Opera 10.5+ */
			transition: color 0.1s ease-out;
		}

		a:hover {
			color: #bbb;
			text-decoration: none;
		}

		b {
			font-family: Roboto, Arial, sans-serif;
			font-weight: 700;
		}

		.header {
			color: #fff;
			font-size: 36pt;
			padding:10px 0px 25px 10px;
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
		}

		.trend-front td, .trend-back td {
			padding:0px;
			margin:0px;
			color:#fff;
			text-shadow:0px 0px 10px #222;
			width:200px;
			height:200px;
			text-align: center;
		}

		.trend-front td {
			text-transform: lowercase;
			vertical-align: middle;
		}

		.trend-back td {
			vertical-align: top;
		}

		.panel {

			width: 200px;
			height: 200px;
			position: relative;

			-webkit-perspective: 600px;
			-moz-perspective: 600px;
			perspective: 600px;
		}
		/* -- make sure to declare a default for every property that you want animated -- */
		/* -- general styles, including Y axis rotation -- */
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

			/* -- transition is the magic sauce for animation -- */
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
			-moz-transform: rotateY(-179deg); /* setting to 180 causes an unnatural-looking half-flip */
			transform: rotateY(-179deg);

			-webkit-transform-style: preserve-3d;
			-moz-transform-style: preserve-3d;
			transform-style: preserve-3d;

			-webkit-backface-visibility: hidden;
			-moz-backface-visibility: hidden;
			backface-visibility: hidden;

			/* -- transition is the magic sauce for animation -- */
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
	<script>
	$.get("http://www.google.com/trends/hottrends/atom/hourly", function (data) {
		alert(data);
	}
	</script>
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

	<?php for($i = 0; $i < $trends->length; $i++){
		$rank = $i + 1;
		$rand_goog = rand(0,3);
		$rand = mt_rand() / mt_getrandmax() + 0.33;?>
	<div class="hover panel trend-container">
		<div class="front">
			<table class="trend-front" style="background-color:rgba(
				<?php echo $google_colors[$rand_goog]; ?>,<?php echo $rand; ?>);"><tr><td>
				<?php echo $trends->item($i)->nodeValue;?>
			</td></tr></table>
		</div>
		<div class="back">
			<table class="trend-back" style="background-color:#555;"><tr><td>
				<h1><a href="http://www.google.com/#q=<?php echo $trends->item($i)->nodeValue;?>">
					<?php echo $trends->item($i)->nodeValue;?></a></h1>
					<p><a href="http://www.google.com/#q=<?php echo $trends->item($i)->nodeValue;?>">
						Search Google
					</p>
					<p><a href="http://search.yahoo.com/search?p=<?php echo $trends->item($i)->nodeValue;?>">
						Search Yahoo
					</p>
			</td></tr></table>
		</div>
	</div>
<?php } ?> 
</div>


</body>
</html>