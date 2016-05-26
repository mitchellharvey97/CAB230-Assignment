<!DOCTYPE html>
<html>
<head>
    <title>MyWiFind - Search Results</title>

    <?php
    $logged_in = false;
    require("common_files/pages.php");
    require("common_files/database_connect.php");
    require("common_files/distance_calculate.php");
    require("common_files/helper_functions.php");

    $search_type = $_GET['searchtype'];

    if ($search_type != "geo_location") {
        $search_value = $_GET['value'];
        $request['search_value'] = $search_value;
    }


    $request['request'] = "search";

    $request['search_type'] = $search_type;


    $recieved_data = make_sql_request($request);

    //Clean the data
    foreach ($recieved_data as $place) {
        $place->{'Suburb'} = strip_postcode($place->{'Suburb'});
    }


    #Links for Style Sheets and scripts to include
    $scripts = array("http://maps.google.com/maps/api/js", "js/maps.js");
    $css = array("css/style.css");
    //"js/suggestion.js",

    foreach ($scripts as $script) {              #Link all Script Files
        echo "<script src='" . $script . "'></script>\n";
    }
    foreach ($css as $script) {                  #Link All CSS Files
        echo "<link href='" . $script . "' rel='stylesheet'>\n";
    }

    $geo_location = false;
    $rating = false;
    $rating_min = 0;

    if ($search_type == "geo_location") {
        $geo_location = true;

        $user_lat = $_GET['lat'];
        $user_lon = $_GET['lon'];
        foreach ($recieved_data as $hotspot_loc) {
            $distance_from_user = calculate_distance($hotspot_loc->{'Latitude'}, $hotspot_loc->{'Longitude'});
            $hotspot_loc->{'distance'} = $distance_from_user;
        }

        $recieved_data = sort_array($recieved_data, $_GET['radius']);

    }
    if ($search_type == "rating") {
        $rating = true;
        $rating_min = $_GET['value'];
    }


    function find_index_in_order($input_array, $item)
    {
        if (sizeof($input_array) == 0) {
            return 0;
        }

        $index = 0;
        for ($x = 0; $x < sizeof($input_array); $x++) {
            $index_distance = $input_array[$x]->{'distance'};
            if ($index_distance < $item) {
                $index++;
            } else {
                break;
            }
        }
        return $index;
    }


    ?>
</head>
<body>


<div id="wrapper">
    <?php include 'common_files/header.php'; ?>

    <div id="results">
        <table>
            <tr>
                <th>Hotspot Name</th>
                <th>Address</th>
                <th>Suburb</th>
                <th>Average Rating</th>

                <?php if ($geo_location) { //If it is a geolocation search then add the distance field to the array
                    echo "<th>Distance From User</th>";
                } ?>
            </tr>

            <?php


            function calculate_distance($place_lat, $place_lon)
            {
                global $user_lat;
                global $user_lon;
                return (find_distance($user_lat, $user_lon, $place_lat, $place_lon));
            }


            $totalSearch = count($recieved_data);
            for ($i = 0; $i < $totalSearch; $i++) {

                $wifi_name = $recieved_data[$i]->{'Wifi Hotspot Name'};
                $wifi_address = $recieved_data[$i]->{'Address'};
                $wifi_suburb = $recieved_data[$i]->{'Suburb'};
                $wifi_lat = $recieved_data[$i]->{'Latitude'};
                $wifi_lon = $recieved_data[$i]->{'Longitude'};

                $rating_request['request'] = "rating_average";
                $rating_request['place_name'] = $wifi_name;


                $wifi_rating = make_sql_request($rating_request);


                if (!$rating || ($rating && $wifi_rating >= $rating_min)) {

                    if ($wifi_rating < 0) {
                        $wifi_rating = "No Ratings yet";
                    }

                    echo "<tr>";
                    echo "<td><a href='$item?q=$wifi_name'>$wifi_name</a></td>";
                    echo "<td>$wifi_address</td>";
                    echo "<td>$wifi_suburb</td>";
                    echo "<td>$wifi_rating</td>";
                }

                if ($geo_location) {
                    $distance = $recieved_data[$i]->{'distance'};
                    echo "<td>$distance km</td>";
                }
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
        foreach ($recieved_data as $each_loc) {
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

    <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>