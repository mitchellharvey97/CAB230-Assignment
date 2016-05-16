<?php
$direct;

function make_sql_request($data, $passed_source = "direct")
{
    global $direct;


    if ($passed_source == "direct") {
        $direct = true;
    } else {
        $direct = false;
    }

//Stuff around as the api call is made from web_root/common_files and other files are making the call from web_root
    if ($direct) {
        $path_to_pass = './common_files/local_config/db_password.php';
    } else {
        $path_to_pass = './local_config/db_password.php';
    }
    require($path_to_pass); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning

    $wifi_table = $databases["data_table"];


    //added a source variable as web calls don't have permission to alter database data
    $requested = $data['request'];
    //print("Make SQL Request Success <br>");

    if ($requested == "all_names") {
        $sql = "SELECT `Wifi Hotspot Name` FROM $wifi_table";
        $results = sql_query($sql);
    } else if ($requested == "all_location_data") {
        $sql = "SELECT * FROM $wifi_table";
        $results = sql_query($sql);
    } else if ($requested == 'wifi') {
        //Get the name of the hotspot to return
        if ($direct) {
            $hotspot_name = $data['place_name'];
        } else {
            $hotspot_name = $_GET['name'];
        }

        $sql = "SELECT * FROM $wifi_table WHERE `Wifi Hotspot Name` = '" . $hotspot_name . "'";
        $results = sql_query($sql);

    } else if ($requested == "search") {

        if ($direct) {
            $search_type = $data['search_type'];
            if ($search_type != "geo_location") {
                $search_value = $data['search_value'];
            }

        } else {
            $search_type = $_GET['search_type'];
        }


        if ($search_type == "name") {
            $sql = "SELECT * FROM $wifi_table WHERE `Wifi Hotspot Name` LIKE '%$search_value%'";
            $results = sql_query($sql);


        } else if ($search_type == "suburb") {

            $sql = "SELECT * FROM $wifi_table WHERE `Suburb` LIKE '%$search_value%'";
            $results = sql_query($sql);

        } else if ($search_type == "rating") {


        } else if ($search_type == "geo_location") {
            $sql = "SELECT * FROM $wifi_table";
            $results = sql_query($sql);
        }


    }
    if (sizeof($results) <= 1) {
        return $results[0];
    } else {
        return $results;
    }

}


function sql_query($query)
{
    global $direct;

//Stuff around as the api call is made from web_root/common_files and other files are making the call from web_root
    if ($direct) {
        $path_to_pass = './common_files/local_config/db_password.php';
    } else {
        $path_to_pass = './local_config/db_password.php';
    }

    require($path_to_pass); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning
    $data_table = $databases['data_table']; //Change to a straight variable for simplicity

    $host = $databases["host"];
    $db_name = $databases['database'];

    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $databases['username'], $databases['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $result = $pdo->query($query);

        $result_data_store = array();

        foreach ($result as $data) {
            array_push($result_data_store, (object)$data);
        }
        return ($result_data_store);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}