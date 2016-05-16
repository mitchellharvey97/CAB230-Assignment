<!DOCTYPE html>

<html>
<head>
    <title>MyWiFind</title>
    <?php
    #Links for Style Sheets and scripts to include
    $script_folder = "js";
    $scripts = array("$script_folder/suggestion.js", "$script_folder/form_validate.js", "$script_folder/home_page.js");
    $css = array("css/style.css");
    //"js/suggestion.js",
    require("common_files/logo.svg.php");
    require("common_files/database_connect.php");
	
	$request['request'] = "all_suburb";	
	 $received_data = make_sql_request($request);
	 
	 print_r($received_data[0]->{'Suburb'});
	 
    foreach ($scripts as $script) {              #Link all Script Files
        echo "<script src='" . $script . "'></script>\n";
    }
    foreach ($css as $script) {                  #Link All CSS Files
        echo "<link href='" . $script . "' rel='stylesheet'>\n";
    }

    ?>
</head>
<body>

<div id="wrapper">
    <?php include 'common_files/header.php'; ?>
	
    <form id="main_search">
        Search By name: <br>
		<input type="text" name="search_value" id="search_value"><br>
        <input type="button" value="Lets Go" id="text_search">
    </form>

	<br>
	
	<form id="suburb_drop_form">
	Or, Select a suburb from the list
	
	<select id = "suburb_list">
	<?php
	
	foreach ($received_data as $suburb){
		$suburb_name = $suburb->{'Suburb'};
		echo"<option value=\"$suburb_name\">$suburb_name</option>";		
	}
	?>
</select>

	<input type="button" value="Search" id="suburb_search">
	
	
	
	</form>
	
    <br>
    <form id="rating_search_form">
        Or, Search by Rating
        <?php

        for ($x = 1; $x <= 5; $x++) {
            //Make the highest rated checked - Just to prevent an error with no submission, and who
            //wouldn't want the best
            if ($x == 5) {
                $checked = "checked";
            } else {
                $checked = '';
            }
            echo("<input type='radio' name='enterRating' $checked value='$x'>$x");
        }
        ?>

        <input type="button" value="Lets Gooo" id="rating_search">
    </form>


    <form id="geolocation_search">
        Find the nearest Wifi Hotspot
        <input type="button" value="Lets Go" id="geo_location_search">

    </form>


    <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>