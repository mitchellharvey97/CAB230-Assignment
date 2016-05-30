<?php
//This file is only ever used by the predictive text for javascript on the home page - used to request the Wifi Names
$url_requested['request'] = $_GET["q"]; //Get the type of query

require "database_connect.php";

//If there is a query in the url variables (It is an api request probably from Frontend JSON)
//Also pass the fact that it is a web call to the api
$results = make_sql_request($url_requested, "webcall");

//If the result variable has been set - display it, otherwise display an error code
if ($results) {
    echo json_encode($results);
} else {
    echo("Please provide arguments in the url");
}
?>