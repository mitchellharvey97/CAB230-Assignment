<?php

$source;

function make_sql_request($data, $passed_source="direct"){
	global $source;
	
	
	$source = $passed_source;
	//added a source varaible as webcalls don't have permission to alter database data
	$requested = $data;//['request'];
	print("Make SQL Request Success <br>");
	
if ($requested == "all_names") {
    $sql = 'SELECT `Wifi Hotspot Name` FROM Wifi';
    $results = sql_query($sql);
} 

else if ($requested == "all_location_data") {
	print("Got to All Loc Data <br>");
    $sql = "SELECT * FROM Wifi";
    $results = sql_query($sql);
} 
else if ($requested == 'wifi') {
//Get the name of the hotspot to return
    $hotspot_name = $_GET['name'];
    $sql = "SELECT * FROM Wifi WHERE `Wifi Hotspot Name` = '" . $hotspot_name . "'";
    $results = sql_query($sql);
}
 else if ($requested == "search") {
    $search_type = $_GET['search_type'];

    if ($search_type == "name") {

    } else if ($search_type == "suburb") {

    } else if ($search_type == "rating") {


    }

    print ("ITS A QUERY");

}

print_r ($results);
return $results;

}



function sql_query($query){
global $source;
print("Into the Actual Request query <br>");

print($query);

print "Source is $source<br>";


//Stuff around as the api call is made from web_root/common_files and other files are making the call from web_root
if ($source == "direct"){$path_to_pass = './common_files/local_config/db_password.php';}
else {$path_to_pass = './local_config/db_password.php';}

    require($path_to_pass); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning
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
//print_r($result_data_store);
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
