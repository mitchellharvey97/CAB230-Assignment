<?php

function make_sql_request($requested, $source = "direct"){
	//added a source varaible as webcalls don't have permission to alter database data
	
	
if ($requested == "all_names") {
    $sql = 'SELECT `Wifi Hotspot Name` FROM Wifi';
    $results = sql_query($sql);
} else if ($requested == "all_location_data") {
    $sql = "SELECT * FROM Wifi";
    $results = sql_query($sql);
} else if ($requested == 'wifi') {
//Get the name of the hotspot to return
    $hotspot_name = $_GET['name'];
    $sql = "SELECT * FROM Wifi WHERE `Wifi Hotspot Name` = '" . $hotspot_name . "'";
    $results = sql_query($sql);
} else if ($requested == "search") {
    $search_type = $_GET['search_type'];

    if ($search_type == "name") {


    } else if ($search_type == "suburb") {

    } else if ($search_type == "rating") {


    }

    print ("ITS A QUERY");

}
return $results;
}



function sql_query($query){


    require('./local_config/db_password.php'); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning
    $data_table = $databases['data_table']; //Change to a straight variable for simplicity

	$host = $databases["host"];
	$db_name = $databases['database'];

	$pdo = new PDO("mysql:host=$host;dbname=$db_name", $databases['username'], $databases['password']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try
{
$result = $pdo->query($query);

$result_data_store = array();

	foreach ($result as $data){
		array_push($result_data_store, $data);
	}
	return($result_data_store);	

}
catch (PDOException $e)
{
echo $e->getMessage();
}
	
	
}

//REMOVE BEFORE SUBMIT - LEGACY SYSTEM
//Main function to connect to the database, exucute query and return;
/*function sql_query($query)
{
    require('./local_config/db_password.php'); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning
    $data_table = $databases['data_table']; //Change to a straight variable for simplicity

//Make a connection
    $conn = new mysqli($databases['host'], $databases['username'], $databases['password'], $databases['database']);

    //Check connection
    if ($conn->connect_error) { //Display Connection error if any
        die(
            "Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($query);
    $result_data_store = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            //add each row to an array
            array_push($result_data_store, $row);
        }
    } else {
        return -1;
    }
    return $result_data_store;
    $conn->close(); //Close SQL Connection
}*/
