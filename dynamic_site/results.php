<!DOCTYPE html>
<html>
<head>
    <title>MyWiFind - Search Results</title>
    <?php
    require("common_files/check_session.php");
    require("common_files/pages.php");
    require("common_files/database_connect.php");
    require("common_files/helper_functions.php");
    $search_type = $_GET['searchtype'];
    if ($search_type != "geo_location") {
        $search_value = $_GET['value'];
        $request['search_value'] = $search_value;
    }

    $request['request'] = "search";
    $request['search_type'] = $search_type;
    $received_data = make_sql_request($request);

    if (sizeof($received_data) < 1) {
        $search_results = false;
    } else {
        $search_results = true;
    }

    //Clean the data
    foreach ($received_data as $place) {
        $place->{'Suburb'} = strip_postcode($place->{'Suburb'});
    }

    #Links for Style Sheets and scripts to include
    $scripts = array("http://maps.google.com/maps/api/js", "js/maps.js");
    $css = array("css/style.css");

    foreach ($scripts as $script) {#Link all Script Files
        echo "<script src='" . $script . "'></script>\n";
    }
    foreach ($css as $script) {#Link All CSS Files
        echo "<link href='" . $script . "' rel='stylesheet'>\n";
    }

    $geo_location = false;
    $rating = false;
    $rating_min = 0;

    if ($search_type == "geo_location") {
        $geo_location = true;

        $user_lat = $_GET['lat'];
        $user_lon = $_GET['lon'];

        function calculate_distance($place_lat, $place_lon)
        {
            global $user_lat;
            global $user_lon;
            return (find_distance($user_lat, $user_lon, $place_lat, $place_lon));
        }

        foreach ($received_data as $hotspot_loc) {
            $distance_from_user = calculate_distance($hotspot_loc->{'Latitude'}, $hotspot_loc->{'Longitude'});
            $hotspot_loc->{'distance'} = $distance_from_user;
        }

        $received_data = sort_array($received_data, $_GET['radius']);
    }
    if ($search_type == "rating") {
        $rating = true;
        $rating_min = $_GET['value'];
    }
    ?>
</head>
<body>

<div id="wrapper">
    <?php include 'common_files/header.php'; ?>

    <div id="content">
        <div id="results">
            <?php
            if ($search_results) {
                ?>
                <table id="result_table">
                    <tr>
                        <th>Hotspot Name</th>
                        <th>Address</th>
                        <th>Suburb</th>
                        <th>Average Rating</th>
                        <?php if ($geo_location) { //If it is a geolocation search then add the distance field to the array
                            echo "<th>Distance From User</th>";
                        } ?>
                        <th></th>
                    </tr>

                    <?php
                    $totalSearch = count($received_data);
                    for ($i = 0; $i < $totalSearch; $i++) {

                        $wifi_name = $received_data[$i]->{'Wifi Hotspot Name'};
                        $wifi_address = $received_data[$i]->{'Address'};
                        $wifi_suburb = $received_data[$i]->{'Suburb'};
                        $wifi_lat = $received_data[$i]->{'Latitude'};
                        $wifi_lon = $received_data[$i]->{'Longitude'};
						
                        $rating_request['request'] = "rating_average";
                        $rating_request['place_name'] = $wifi_name;
                        $wifi_rating = make_sql_request($rating_request);

                        if (!$rating || ($rating && $wifi_rating >= $rating_min)) {
                            if ($wifi_rating < 0) {
                                $wifi_rating = "No Ratings yet";
                            }
                            echo "<tr>
                <td>$wifi_name</td>
                <td>$wifi_address</td>
                <td>$wifi_suburb</td>
                <td>$wifi_rating</td>
                <td><div class ='view_place'><a href='$item?q=" . urlencode($wifi_name) . "'>View Details</a></div></td>
					
				";
                        }

                        if ($geo_location) {
                            $distance = $received_data[$i]->{'distance'};
                            echo "<td>$distance km</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>
            <?php } else {
                echo "<div id = 'no_results'>Sorry but your search provided no results.<br>
		<a href = '$home'>Go Back</a> and Search for something else?</div>";
            }
            ?>
        </div>

        <?php
        if ($search_results){
        ?>
        <div id="results_map" class="map"></div>

        <!--Some Inline Scripting to allow php to add to the array - PHP gets rendered before Javascript, therefore it is possible to write javascript arrays with it-->
        <script>
            var hotspot_locations = []
            <?php

            foreach ($received_data as $each_loc) {
                $lon = ($each_loc->Longitude);
                $lat = ($each_loc->Latitude);
                $name = ($each_loc->{'Wifi Hotspot Name'});
                $result_page = $item . "?q=$name";


                $rating_request['request'] = "rating_average";
                $rating_request['place_name'] = $name;
                $wifi_rating = make_sql_request($rating_request);

                if (!$rating || ($rating && $wifi_rating >= $rating_min)) {

                    echo "hotspot_locations.push([\"<h4>$name</h4><br><a href =\\\"$result_page\\\"> View Hotspot</a>\",$lat, $lon])
	  ";
                }
            }

            ?>
            display_map(hotspot_locations, "results_map"); //Call the Display map command with the item locations, and the map ID
        </script>

    </div>
<?php
}
include 'common_files/footer.php'; ?>
</div>
</body>
</html>