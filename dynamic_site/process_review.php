<?php

require("common_files/database_connect.php");
require("common_files/pages.php");

echo "Processing review";


//print_r($_POST);

$review['request'] = "add_review";
$review['title'] = $_POST['title'];
$review['body'] = $_POST['body'];
$review['rating'] = $_POST['rating'];
$review['userid'] = $_POST['userid'];
$review['place'] = $_POST['place'];


//print_r($review);

make_sql_request($review);