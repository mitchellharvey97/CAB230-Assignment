<!DOCTYPE html>
<html>
	<head>
		<title>MyWiFind - Search Results</title>
		
		<?php 
		
		
		
		require("common_files/pages.php");
require("common_files/database_connect.php");
require("common_files/distance_calculate.php");
require("common_files/logo.svg.php");

$search_type = $_GET['searchtype'];
$search_value = $_GET['value'];

		
		
		$request['request'] = "search";
$request['search_type'] = $search_type;
$request['search_value'] = $search_value;
$recieved_data = make_sql_request($request);
			
		#Links for Style Sheets and scripts to include
$scripts = array("http://maps.google.com/maps/api/js", "js/maps.js");
$css = array("css/style.css");
//"js/suggestion.js",

	foreach ($scripts as $script){              #Link all Script Files
		echo "<script src='".$script."'></script>\n";
	}
	foreach ($css as $script){                  #Link All CSS Files
		echo "<link href='".$script."' rel='stylesheet'>\n";
	}

	if ($search_type == "geo_location"){
		$geo_location = true;
	}else{
	$geo_location = false;
	}
	
    ?>
	</head>
	<body>
	

	
	
		<div id="wrapper">
			<?php include 'common_files/header.php';?>

			<div id="results">
				<table>
				<tr>
					<th>Hotspot Name</th>
					<th>Address</th>
					<th>Suburb</th>
					<?php if ($geo_location){
					echo"<th>Distance From User</th>";
					 }?>
				</tr>
	
				<?php
				
				
				
$user_lat = -27.5963595;
$user_lon = 153.2905616;

    function calculate_distance($place_lat, $place_lon)
    {
        global $user_lat;
        global $user_lon;
        return (find_distance($user_lat, $user_lon, $place_lat, $place_lon));
    }			
				
				
			$totalSearch = count($recieved_data);
					for($i = 0; $i < $totalSearch; $i++) {
						
						$wifi_name = $recieved_data[$i]->{'Wifi Hotspot Name'};
						$wifi_address = $recieved_data[$i]->{'Address'};
						$wifi_suburb = $recieved_data[$i]->{'Suburb'};
						$wifi_lat = $recieved_data[$i]->{'Latitude'};
						$wifi_lon = $recieved_data[$i]->{'Longitude'};
						
						
						
						$url = "/cab230-assignment/dynamic_site/item_page.php?id=" . $i;
						echo "<tr>";
							echo "<td><a href=" . $url  . ">$wifi_name</a></td>";
							echo "<td>$wifi_address</td>";
							echo "<td>$wifi_suburb</td>";
							
							if ($geo_location) {echo "<td>" . calculate_distance($wifi_lat, $wifi_lon) . " km</td>"; }
						echo "</tr>";
					}
				?>
				</table>
			</div>
		
			
			  <div id="results_map" style="width: 500px; height: 400px;"></div>
  
  
  		<!--Some Inline Scripting to allow php to add to the array - PHP gets rendered before Javascript, therefore it is possible to write javascript arrays with it-->
  <script>
       var hotspot_locations = []
  	<?php  
	  foreach ($recieved_data as $each_loc){
		$lon = ($each_loc->Longitude);
		$lat = ($each_loc->Latitude);
		$name = ($each_loc->{'Wifi Hotspot Name'});		
		  $result_page = $item . "?q=$name";
		  echo "hotspot_locations.push([\"<h4>$name</h4><br><a href =\\\"$result_page\\\"> View Hotspot</a>\",$lat, $lon])
	  ";
	}
	?>
	display_map(hotspot_locations, "results_map"); //Call the Display map command with the item locations, and the map ID
    </script>  
  
			<?php include 'common_files/footer.php';?>		
		</div>
	</body>
	</html>