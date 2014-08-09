(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-53468044-1', 'auto');
ga('send', 'pageview');

var i = 0;

//An array with pretty colors (google sanctioned colors)
var frontcolors = Array('#33B5E5','#AA66CC','#99CC00','#FFBB33','#FF4444');

$.get( "google-trends.txt", function( file ) {

	//grab all the trends from the file
	var trends = $(file).find('li');

	//Start function to generate page
	createtrends(trends);

});

//loop through all the trends to produce them on the page
function createtrends(trends){

	// save a copy of the cell we need
	var cloned = $('div.trend:last');

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

		$(trend).find('.marked').html('');
		if($(this).find('span').hasClass('Spicy')){
			$(trend).find('.marked').html('<i class="fa fa-bookmark"></i>');
		}

		//modify the table cell with the new trend
		$(trend).find('div.front .name').html(trendname);
		$(trend).find('div.front').css('background-color',newcolor);
		$(trend).find('a.google').attr('href','http://www.google.com/#q='+trendname);
		$(trend).find('a.yahoo').attr('href','http://search.yahoo.com/search?p='+trendname);
		$(trend).find('a.bing').attr('href','http://www.bing.com/search?q='+trendname);

		if(counter != 1) {
			//append it the last element or the row
			$('div.content:last').append(trend);
		}
		
		counter++; //increase the counter

		//fade effect
		$('.trend:last').css('opacity',0).delay(i+=100).fadeTo(500, 1);
	});
}

//Hover functions
$(document).on("mouseover", ".trend", function(e) {
	$(this).addClass('flip');
});
$(document).on("mouseleave", ".trend", function(e) {
	$(this).removeClass('flip');
});