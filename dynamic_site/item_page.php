<!DOCTYPE html>

<html>
	<head>
		<title>MyWiFind</title>
		<?php 
		$wifiName = "Annerley Library Wifi";
		$wifiAddress = "450 Ipswich Road";
		$wifiSuburb = "Annerley 4103";
		$wifiLat = "-27.50942285";
		$wifiLng = "153.0333218";
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
    zoom:5,
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
			<div id="googleMap" style="width:500px;height:300px;"></div>
			<?php include 'common_files/footer.php';?>		
		</div>
	</body>
	</html>