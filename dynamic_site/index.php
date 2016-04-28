<!DOCTYPE html>

<html>
	<head>
		<title>MyWiFind</title>
		<?php 
		#Links for Style Sheets and scripts to include
$scripts = array("js/form_validate.js", "js/script.js");
$css = array("css/style.css");

require("common_files/logo.svg.php");

	foreach ($scripts as $script){              #Link all Script Files
		echo "<script src='".$script."'></script> \n";
	}
	foreach ($css as $script){                  #Link All CSS Files
		echo "<link href='".$script."' rel='stylesheet'> \n";
	}

    ?>
	</head>
	<body>
	
			<div id="wrapper">
			<?php include 'common_files/header.php';?>	


		

		<form id ="main_search">
				<input type ="text" name ="search_value" id = "search_value"><br>
				Search By:
					<input type="radio" name="search_type" value="name" id = "search_by_name" checked>Name
					<input type="radio" name="search_type" value="suburb" id = "search_by_suburb">Suburb 
				<input type="button" value="Lets Go">
		</form>
	
			
			<br>
			<br>
			<br>
		<form id = "rating_search">
		Or, Search by Rating
		
		<input type="radio" name="enterRating" value="1">1
						<input type="radio" name="enterRating" value="2">2
						<input type="radio" name="enterRating" value="3">3
						<input type="radio" name="enterRating" value="4">4
						<input type="radio" name="enterRating" value="5">5
		
		<input type="button" value="Lets Go">
		
		</form>
		
		
				<form id = "geolocation_search">
		Find the nearest Wifi Hotspot
		
		
		<input type="button" value="Lets Go">
		
		</form>
				
				



	
			<?php include 'common_files/footer.php';?>	
			</div>	
	</body>
	</html>