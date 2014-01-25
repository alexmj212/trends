<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Google Trends</title>
	<link 
		href="http://fonts.googleapis.com/css?family=Roboto:100,300,300italic,400,400italic,700,700italic" 
		rel="stylesheet" 
		type="text/css">
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
			-webkit-transition: color 0.5s ease-out; /* Saf3.2+, Chrome */
			-moz-transition: color 0.5s ease-out; /* Firefox 4+ */
			-ms-transition: color 0.5s ease-out; /* IE10+ */
			-o-transition: color 0.5s ease-out; /* Opera 10.5+ */
			transition: color 0.5s ease-out;
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

		.content {
			border-collapse:collapse;
			margin:auto;
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
			width: 203px;
			height: 197px;
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
	<!-- Piwik -->
	<script type="text/javascript">
	  var _paq = _paq || [];
	  _paq.push(["trackPageView"]);
	  _paq.push(["enableLinkTracking"]);

	  (function() {
	    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://winginit.net/piwik/";
	    _paq.push(["setTrackerUrl", u+"piwik.php"]);
	    _paq.push(["setSiteId", "7"]);
	    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
	    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<!-- End Piwik Code -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script>
		var i = 0;

		//An array with pretty colors (google sanctioned colors)
		var frontcolors = Array('#33B5E5','#AA66CC','#99CC00','#FFBB33','#FF4444');

		$.get( "google-trends.txt", function( file ) {

			//grab all the trends from the file
			var trends = $(file).find('a');

			//Start function to generate page
			createtrends(trends);

		});

		//loop through all the trends to produce them on the page
		function createtrends(trends){

			// save a copy of the cell we need
			var cloned = $('.trend-box:last');

			//initialize counter
			var counter = 1;

			$(trends).each(function(index) {

				//Pick a new color
				newcolor = frontcolors[Math.floor(Math.random()*frontcolors.length)];

				trendname = $(this).text();

				//We'll just modify the trend structure already present
				if(counter == 1){
					trend = cloned;
				} else {
					trend = cloned.clone();
				}

				//modify the table cell with the new trend
				$(trend).find('.trend').text ( trendname );
				$(trend).find('.trend').css('background-color',newcolor);
				$(trend).find('.google').attr('href','http://www.google.com/#q='+trendname);
				$(trend).find('.yahoo').attr('href','http://search.yahoo.com/search?p='+trendname);
				$(trend).find('.bing').attr('href','http://www.bing.com/search?q='+trendname);

				if(counter != 1) {
					//append it the last element or the row
					$('.trend-row:last').append(trend);
				}

				//start a new row after 4 trends
				if(!(counter % 4)){
					$('.body').append('</tr><tr class="trend-row">');
				}
				
				counter++; //increase the counter

				//fade effect
				$('.trend-box:last').css('opacity',0).delay(i+=100).fadeTo(500, 1)
			});
		}

		//Hover functions
		$(document).on("mouseover", ".panel", function(e) {
			$(this).addClass('flip');
		});
		$(document).on("mouseleave", ".panel", function(e) {
			$(this).removeClass('flip');
		});



	</script>
</head>
<body>

	<div class="header">
		Google Trends
	</div>

<table class="content">
	<tbody class="body">
		<tr class="trend-row">
			<td class="trend-box">
				<div class="hover panel trend-container">
					<div class="front">
						<table class="trend-front">
							<tr>
								<td class="trend">
								</td>
							</tr>
						</table>
					</div>
					<div class="back">
						<table class="trend-back">
							<tr>
								<td class="links">
									<p>search:</p>
									<p><a class="google" target="_blank" href="">
										Google
									</a></p>
									<p><a class="yahoo" target="_blank" href="">
										Yahoo
									</a></p>
									<p><a class="bing" target="_blank" href="">
										Bing
									</a></p>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
	<tbody>
</table>

	<div class="footer">
		Alex Johnson - 
		<a href="http://winginit.net">http://winginit.net</a> - 
		<a href="http://github.com/alexmj212/trends">Project on Github</a>
	</div>
</body>
</html>