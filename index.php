<?php
// We need us some simpleCache!
require('lib/simpleCache/simpleCache.php');
$cache = new SimpleCache();
$weather_feed = $cache->get_data('weather_feed', 'http://www.weather.gov/xml/current_obs/KPDX.xml', 60);

$weather_xml = simplexml_load_string($weather_feed);

$current = $weather_xml->xpath("/current_observation");

// CURRENT ARRAY to STRING
$current_str = http_build_query($current);

// "SNOW" REGEX
$snow = '/(?i)snow/';

// MATRIX FOR CURRENT ONLY
if (preg_match($snow, $current_str))
{
	$class = "yes";
	$answer = "Yes";
	$long_answer = "Yes! COMMENCE PANIC!";
}
else
{
	$class = "no";
	$answer = "No.";
	$long_answer = "No.";
}
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
