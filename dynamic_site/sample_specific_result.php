<?php

$place_name = $_GET['q'];

echo $place_name;

echo "<br>";

$hotspot = json_decode('[{"Wifi Hotspot Name":"Einbunpin Lagoon","Address":"Brighton Rd","Suburb":"Sandgate","Latitude":"-27.31947000","Longitude":"153.0682200"}]');

print_r($hotspot);