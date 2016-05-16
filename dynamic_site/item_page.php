<?php
$place_name = $_GET["q"];

require("common_files/pages.php");
require("common_files/database_connect.php");
require("common_files/logo.svg.php");

$prefix = "../";
//Get the data from the database connector and decode it to an object
$request['request'] = "wifi";
$request['place_name'] = $place_name;
$received_data = make_sql_request($request);

$wifiName = $received_data->{'Wifi Hotspot Name'};
$wifiAddress = $received_data->{'Address'};
$wifiSuburb = $received_data->{'Suburb'};
$wifiLat = $received_data->{'Latitude'};
$wifiLng = $received_data->{'Longitude'};
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $place_name; ?></title>

    <?php
    #Links for Style Sheets and scripts to include
    $scripts = array("../js/maps.js", "http://maps.google.com/maps/api/js?sensor=false");
    $css = array("../css/style.css");
    foreach ($scripts as $script) {#Link all Script Files
        echo "<script src='" . $script . "'></script>\n";
    }
    foreach ($css as $script) { #Link All CSS Files
        echo "<link href='" . $script . "' rel='stylesheet'>\n";
    }
    ?>

</head>

<body>
<div id="wrapper">
    <?php include 'common_files/header.php';
    echo "<div class = 'location_details'>";
    echo "<div id = 'location_name'>" . $wifiName . "</div>";
    echo "<div id = 'street_address'>" . $wifiAddress . " , " . $wifiSuburb . "</div>";
    echo "</div>";
    ?>

    <div id="googleMap" style="width: 500px; height: 400px;"></div>

    <!--Some Inline Scripting to allow php to add to the array - PHP gets rendered before Javascript, therefore it is possible to write javascript arrays with it-->
    <script>
        var hotspot_locations = []
        <?php  echo "hotspot_locations.push(['<h4>$wifiName</h4><br>',$wifiLat, $wifiLng]);";?>
        display_map(hotspot_locations, "googleMap");
    </script>
    <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>
