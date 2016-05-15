<?php
//Debug Data cuz cbf connecting to a database for it
		$recieved_data =(object)  json_decode('[{"Wifi Hotspot Name":"7th Brigade Park, Chermside","Address":"Delaware St","Suburb":"Chermside","Latitude":"-27.37893000","Longitude":"153.0446100"}]');//,{"Wifi Hotspot Name":"Annerley Library Wifi","Address":"450 Ipswich Road","Suburb":"Annerley, 4103","Latitude":"-27.50942285","Longitude":"153.0333218"},{"Wifi Hotspot Name":"Ashgrove Library Wifi","Address":"87 Amarina Avenue","Suburb":"Ashgrove, 4060","Latitude":"-27.44394629","Longitude":"152.9870981"},{"Wifi Hotspot Name":"Banyo Library Wifi","Address":"284 St. Vincents Road","Suburb":"Banyo, 4014","Latitude":"-27.37396641","Longitude":"153.0783234"},{"Wifi Hotspot Name":"Booker Place Park","Address":"Birkin Rd & Sugarwood St","Suburb":"Bellbowrie","Latitude":"-27.56353000","Longitude":"152.8937200"},{"Wifi Hotspot Name":"Bracken Ridge Library Wifi","Address":"Corner Bracken and Barrett Street","Suburb":"Bracken Ridge, 4017","Latitude":"-27.31797261","Longitude":"153.0378735"},{"Wifi Hotspot Name":"Brisbane Botanic Gardens","Address":"Mt Coot-tha Rd","Suburb":"Toowong","Latitude":"-27.47724000","Longitude":"152.9759900"}]');
	
	require("common_files/pages.php");
	require("common_files/database_connect.php");
?>

<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script src="js/maps.js"></script>
</head> 
<body>
  <div id="map" style="width: 500px; height: 400px;"></div>
  
  
  
	<!--Some Inline Scripting to allow php to add to the array - PHP gets rendered before Javascript, therefore it is possible to write javascript arrays with it-->
  <script>
       var hotspot_locations = []
  	<?php  
	  foreach ($recieved_data as $each_loc){
		$lon = ($each_loc->Longitude);
		$lat = ($each_loc->Latitude);
		$name = ($each_loc->{'Wifi Hotspot Name'});		
		  $result_page = $item . "?q=$name";
		  echo "hotspot_locations.push(['<h4>$name</h4><br><a href =\"$result_page\"> View Hotspot</a>',$lat, $lon])
	  ";
	}
	?>
	display_map(hotspot_locations, "map"); //Call the Display map command with the item locations, and the map ID
    </script>  
  
  
</body>
</html>