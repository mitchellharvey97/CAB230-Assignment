<!DOCTYPE html>

<html>
	<head>
		<title>MyWiFind</title>
		<?php 
		#Links for Style Sheets and scripts to include
$scripts = array("js/form_validate.js");
$css = array("css/style.css");

require("common_files/logo.svg.php")

?>

 <?php

	foreach ($scripts as $script){              #Link all Script Files
		echo "<script src='".$script."'></script> \n";
	}
	foreach ($css as $script){                  #Link All CSS Files
		echo "<link href='".$script."' rel='stylesheet'> \n";
	}

    ?>
	</head>
	<body>
	
	</body>
			<div id="wrapper">
			<?php include 'common_files/header.php';?>	


		<form id ="main_form">
			<input type ="text" name ="search_value" id = "search_value"><br>
		Search By:
    <input type="radio" name="search_type" value="name" checked>Name
    <input type="radio" name="search_type" value="suburb">Suburb<br>


		<a href = "results_page.html"><input type="button" value="Lets Go">	</a>
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
	</html>