<!DOCTYPE html>

<html>
	<head>
		<title>MyWiFind</title>
		<?php 
		$json = '[{"Wifi Hotspot Name":"7th Brigade Park, Chermside","Address":"Delaware St","Suburb":"Chermside","Latitude":"-27.37893000","Longitude":"153.0446100"},{"Wifi Hotspot Name":"Annerley Library Wifi","Address":"450 Ipswich Road","Suburb":"Annerley, 4103","Latitude":"-27.50942285","Longitude":"153.0333218"},{"Wifi Hotspot Name":"Ashgrove Library Wifi","Address":"87 Amarina Avenue","Suburb":"Ashgrove, 4060","Latitude":"-27.44394629","Longitude":"152.9870981"},{"Wifi Hotspot Name":"Banyo Library Wifi","Address":"284 St. Vincents Road","Suburb":"Banyo, 4014","Latitude":"-27.37396641","Longitude":"153.0783234"},{"Wifi Hotspot Name":"Booker Place Park","Address":"Birkin Rd & Sugarwood St","Suburb":"Bellbowrie","Latitude":"-27.56353000","Longitude":"152.8937200"},{"Wifi Hotspot Name":"Bracken Ridge Library Wifi","Address":"Corner Bracken and Barrett Street","Suburb":"Bracken Ridge, 4017","Latitude":"-27.31797261","Longitude":"153.0378735"},{"Wifi Hotspot Name":"Brisbane Botanic Gardens","Address":"Mt Coot-tha Rd","Suburb":"Toowong","Latitude":"-27.47724000","Longitude":"152.9759900"}]';
		$recieved_data = json_decode($json);

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
					<th>Latitude</th>
					<th>Longitude</th>
					<th>Distance From User</th>
				</tr>
	
				<?php
				$url = "http://www.plaecholder.com";
				$totalSearch = count($recieved_data);
					for($i = 0; $i < $totalSearch; $i++) {
						echo "<tr>";
							echo "<td><a href=" . $url . ">" . $recieved_data[$i]->{'Wifi Hotspot Name'} . "</a></td>";
							echo "<td>" . $recieved_data[$i]->{'Address'} . "</td>";
							echo "<td>" . $recieved_data[$i]->{'Suburb'} . "</td>";
							echo "<td>" . $recieved_data[$i]->{'Longitude'} . "</td>";
							echo "<td>" . $recieved_data[$i]->{'Latitude'} . "</td>";
							echo "<td>" . "Not Yet Implemented" . "</td>"; 
						echo "</tr>";
					}
				?>
				</table>
			</div>
			<?php include 'common_files/footer.php';?>		
		</div>
	</body>
	</html>