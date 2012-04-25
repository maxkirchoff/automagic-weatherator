<?php
	function cacheFetch($url, $age)
	{
		// directory in which to store cached files
		$cacheDir = "cachey/";

		// cache filename constructed from MD5 hash of URL
		$filename = $cacheDir.md5($url);

		// default to fetch the file
		$fetch = true;

		// but if the file exists, don't fetch if it is recent enough
		if (file_exists($filename))
		{
		  $fetch = (filemtime($filename) < (time()-$age));
		}

		// fetch the file if required
		if ($fetch)
		{
		  // shell to wget to fetch the file
		  exec("wget -N -O " . $filename . " \"" . $url . "\"");

		  // update timestamp to now
		  exec("touch " . $filename);
		}

		// return the cache filename
		return $filename;
	}

	  // fetch (if required)
	  $filename = cacheFetch("http://www.weather.gov/xml/current_obs/KPDX.xml", 300);

		$xml = simplexml_load_file($filename);

		// $information = $xml->xpath("/xml_api_reply/weather/forecast_information");

		$current = $xml->xpath("/current_observation");

		// $forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");

		// CURRENT ARRAY to STRING
		$currentstr = http_build_query($current);

		// FORECAST ARRAY to STRING
		// $forecaststr = http_build_query($forecast_list);

		// "SNOW" REGEX
		$snow = '/(?i)snow/';

		// MATRIX FOR CURRENT ONLY
		if (preg_match($snow, $currentstr))
		{
			$class = "yes";
			$answer = "Yes!";
			$long_answer = "Yes! COMMENCE PANIC!";
		}
		else
		{
			$class = "no";
			$answer = "No.";
			$long_answer = "No.";
		}
		//   MATRIX FOR CURRENT AND FORECAST
		/*
		if (preg_match($snow, $currentstr) && preg_match($snow, $forecaststr))
		{
			echo "Snow Today!!!!<br /><br /> and SNOW TOMORROW!";
		}
		else if (preg_match($snow, $currentstr) && !preg_match($snow, $forecaststr))
		{
			echo "SNOW TODAY!<br /><br />But none tomorrow....";
		}
		else if (!preg_match($snow, $currentstr) && preg_match($snow, $forecaststr))
		{
			echo "No snow today...<br /><br />BUT IT'S SNOWING TOMORROW!";
		}
		else
		{
			echo "No snow today AND no snow coming.";
		}
		*/
?>
<html>
    <head>
        <title>Is it snowing in Portland, Oregon?</title>
        <style>
        <!--
        body.yes {
        	background-color: red;
        }
        body.no {
        	background-color: green;
        }
        h1 { 
        	font-size: 250px;
 			color:white;
 			text-align: center;
 			margin-top: 100px;
        }
        -->
        </style>
    </head>
    <body class="<?php echo $class; ?>"> 
	<h1 class="<?php $class; ?>"><?php echo $answer; ?></h1>
	<p align="center" style="color: #fff; font-family: arial, helvetica, sans-serif; Font-size: 10px; font-weight: bold;">Made By: <a href="http://maxisnow.com" style="color: #FFF;">MaxIsNow.com</a> and <a href="http://stacybias.net/"  style="color: #FFF; a:hover:underline;">StacyBias.Net</a> (but mostly by Max.)</p>
    </body>
</html>
