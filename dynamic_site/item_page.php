<!DOCTYPE html>

<html>
	<head>
		<title>MyWiFind</title>
		<?php 
		$json = '[{"Wifi Hotspot Name":"7th Brigade Park, Chermside","Address":"Delaware St","Suburb":"Chermside","Latitude":"-27.37893000","Longitude":"153.0446100"},{"Wifi Hotspot Name":"Annerley Library Wifi","Address":"450 Ipswich Road","Suburb":"Annerley, 4103","Latitude":"-27.50942285","Longitude":"153.0333218"},{"Wifi Hotspot Name":"Ashgrove Library Wifi","Address":"87 Amarina Avenue","Suburb":"Ashgrove, 4060","Latitude":"-27.44394629","Longitude":"152.9870981"},{"Wifi Hotspot Name":"Banyo Library Wifi","Address":"284 St. Vincents Road","Suburb":"Banyo, 4014","Latitude":"-27.37396641","Longitude":"153.0783234"},{"Wifi Hotspot Name":"Booker Place Park","Address":"Birkin Rd & Sugarwood St","Suburb":"Bellbowrie","Latitude":"-27.56353000","Longitude":"152.8937200"},{"Wifi Hotspot Name":"Bracken Ridge Library Wifi","Address":"Corner Bracken and Barrett Street","Suburb":"Bracken Ridge, 4017","Latitude":"-27.31797261","Longitude":"153.0378735"},{"Wifi Hotspot Name":"Brisbane Botanic Gardens","Address":"Mt Coot-tha Rd","Suburb":"Toowong","Latitude":"-27.47724000","Longitude":"152.9759900"}]';
		$recieved_data = json_decode($json);
		
		
		$id = $_GET["id"];
		$wifiName = $recieved_data[$id]->{'Wifi Hotspot Name'};
		$wifiAddress = $recieved_data[$id]->{'Address'};
		$wifiSuburb = $recieved_data[$id]->{'Suburb'};
		$wifiLat = $recieved_data[$id]->{'Latitude'};
		$wifiLng = $recieved_data[$id]->{'Longitude'};
		echo"<script src='http://maps.googleapis.com/maps/api/js'></script>";
		


		#Links for Style Sheets and scripts to include
$scripts = array("js/form_validate.js", "js/home_page.js", "js/geolocation.js" );
$css = array("css/style.css");
//"js/suggestion.js",
require("common_files/logo.svg.php");

	foreach ($scripts as $script){              #Link all Script Files
		echo "<script src='".$script."'></script>\n";
	}
	foreach ($css as $script){                  #Link All CSS Files
		echo "<link href='".$script."' rel='stylesheet'>\n";
	}
	
echo "<script>
	function initialize() { 
    var mapProp = {
    center:new google.maps.LatLng(" . $wifiLat . ", " . $wifiLng . " ),
    zoom:20,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
   var map=new google.maps.Map(document.getElementById('googleMap'),mapProp);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>";
    ?>
	
	</head>
	
	<body>
		<div id="wrapper">
			<?php include 'common_files/header.php';?>

			<?php 
			echo "<div class = 'location_details'>";
				echo "<div id = 'location_name'>" . $wifiName . "</div>";
				echo "<div id = 'street_address'>" . $wifiAddress . " , " . $wifiSuburb . "</div>";
				
			echo	"</div>";			
			?>
			<div id="googleMap" style="width:650px;height:450px;"></div>
			<?php include 'common_files/footer.php';?>		
		</div>
	</body>
	</html>