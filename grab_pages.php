<?php

	$crawldata = NULL;

	$debug = false;;

	$url = "http://www.google.com/trends/hottrends/atom/hourly";

	unlink("google-trends.txt");
	$file = fopen("google-trends.txt", "w");

	$crawldata = get_page($url);

	fwrite($file,$crawldata);

	fclose($file);
	
	if(!$debug) {
		header('Location: http://winginit.net/trends');
	}

	function get_page($url = NULL){

		global $debug;

		if($debug) echo "Begin Crawl for $url<br>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		if($debug) echo "Executing curl...<br>";

		$data = curl_exec($ch);
		//echo curl_error($ch);
		curl_close($ch);

		if($debug) echo "Finished curl...<br>";

		return $data;
	}

?>
