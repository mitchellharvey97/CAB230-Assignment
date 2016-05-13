 <HTML>
<HEAD>
<TITLE> Test Location List</TITLE>
</HEAD>
<BODY>
<?php

//Pull user location from URL
$user_lat = $_GET["lat"];
$user_lon = $_GET["lon"];



if ($user_lat == ""){
	print"Ya Goofed Up";
	$user_lat = -27.5963595;
}

if ($user_lon == ""){
	print"Ya Goofed Up again...";
	$user_lon = 153.2905616;
}

require("common_files/pages.php");
require("common_files/database_connect.php");

//Get the data from the api and decode it to an object
$wifi_hostspot_data_store = json_decode(file_get_contents($api . "?q=all_location_data"));


$request = "all_location_data";
$wifi_hostspot_data_store =make_sql_request($request);

print("Back in Loc List File <br>");
print_r($wifi_hostspot_data_store);


function find_distance($lat1, $lon1, $lat2, $lon2) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $km = $dist * 60 * 1.1515 * 1.609344;
  return $km;
}





add_distance_array();

function add_distance_array(){
global $wifi_hostspot_data_store;

function calculate_distance($location_array){
	global $user_lat;
	global $user_lon;
	return (find_distance($user_lat, $user_lon, $location_array->Latitude, $location_array->Longitude));
}

foreach ($wifi_hostspot_data_store as $hotspot){
			$dist = calculate_distance($hotspot);
			$hotspot->distance_from_user = $dist;
			print "The Distance between $hotspot->Suburb and the user is $hotspot->distance_from_user km<br>";
}
}




