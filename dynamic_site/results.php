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

    //Don't run this if it is a location search as the url will be missing the parameters'
    if ($search_type != "geo_location") {
        $search_value = $_GET['value'];
        $request['search_value'] = $search_value;
    }

    $request['request'] = "search";
    $request['search_type'] = $search_type;
    $received_data = make_sql_request($request);

    #Links for Style Sheets and scripts to include
    $scripts = array("http://maps.google.com/maps/api/js", "js/maps.js");
    $css = array("css/style.css");

    foreach ($scripts as $script) {#Link all Script Files
        echo "<script src='" . $script . "'></script>\n";
    }
    foreach ($css as $style_sheet) {  #Link All CSS Files
        echo "<link href='" . $style_sheet . "' rel='stylesheet'>\n";
    }

    //if it is a geo location search then do a heap of stuff
    if ($search_type == "geo_location") {
        $geo_location = true;

        $user_lat = $_GET['lat'];
        $user_lon = $_GET['lon'];
        foreach ($received_data as $hotspot_loc) {
            $distance_from_user = calculate_distance($hotspot_loc->{'Latitude'}, $hotspot_loc->{'Longitude'});
            $hotspot_loc->{'distance'} = $distance_from_user;
        }
        $received_data = sort_array($received_data, $_GET['radius']);

    } else {
        $geo_location = false;
    }

    function sort_array($unsorted, $max_value)
    {
        $returned_value = array();
        foreach ($unsorted as $item) {
            if ($item->{'distance'} <= $max_value) {
                $pos = find_index_in_order($returned_value, $item->{'distance'});
                $returned_value = insertArrayIndex($returned_value, $item, ($pos));
            }
        }
        return $returned_value;
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

    function insertArrayIndex($array, $new_element, $index)
    {
        $start = array_slice($array, 0, $index);
        $end = array_slice($array, $index);
        $start[] = $new_element;
        return array_merge($start, $end);
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

                <?php if ($geo_location) { //If it is a geo location search then add the distance field to the array
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

            $totalSearch = count($received_data);
            for ($i = 0; $i < $totalSearch; $i++) {
                $wifi_name = $received_data[$i]->{'Wifi Hotspot Name'};
                $wifi_address = $received_data[$i]->{'Address'};
                $wifi_suburb = $received_data[$i]->{'Suburb'};
                $wifi_lat = $received_data[$i]->{'Latitude'};
                $wifi_lon = $received_data[$i]->{'Longitude'};

                echo "<tr>";
                echo "<td><a href='$item?q=$wifi_name'>$wifi_name</a></td>";
                echo "<td>$wifi_address</td>";
                echo "<td>$wifi_suburb</td>";

                if ($geo_location) {
                    $distance = $received_data[$i]->{'distance'};
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
        foreach ($received_data as $each_loc) {
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

    <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>