<?php
// Create connection -- Using the credentials from external file
require('local_config/db_password.php'); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning
$data_table = $databases['data_table']; //Change to a straight variable for simplicity

//Make a connection
$conn = new mysqli($databases['host'], $databases['username'], $databases['password'], $databases['database']);

// Check connection
if ($conn->connect_error) { //Display Connection error if any
    die(
	"Connection failed: " . $conn->connect_error);
}

//Collect parameters
$filter = $_GET["filter"];	
$parameter = $_GET["par"];	


function get_search_list($filter_type, $filter_value){
	global $data_table;	
	global $conn;
if ($filter_type == 'suburb'){
		   	   $sql = 'SELECT * FROM '.$data_table.' WHERE ' . $data_table . '.Suburb like "%' . $filter_value . '%"';
	   }
	   else if ($filter_type == 'name'){
	   	  	  $sql = "SELECT * FROM ".$data_table. " WHERE `" . $data_table. "`.`Wifi Hotspot Name` like '%" . $filter_value . "%'";
	   }
		  else { 
	   $sql ='SELECT * FROM ' . $data_table;
	   }
$return_array = []; //initalize array to return;
    foreach ($conn->query($sql) as $row) {
		array_push($return_array, $row);
		//print_r $row;
		echo ("<br>");
    }
	return $return_array;	
	
}



function get_item_details($item_name){
	global $data_table;	
	global $conn;
		
	$sql = "SELECT * FROM ".$data_table. " WHERE `" . $data_table. "`.`Wifi Hotspot Name` = '" . $item_name . "'";

	   foreach ($conn->query($sql) as $row) {
		return $row;
    }
}

//Insert whatever Junk below to make up the page 
?>
<html>
<head>
<title>TEST PAGE?? </title>

</head>

<body>
UPDATRS?
<?php
echo "Filter Type: ". $filter;
echo "<br>";
echo "Parameter: ". $parameter;
echo "<br>";



$search_list = get_search_list($filter, $parameter);	

print_r($search_list[0]);	//need parameters in the url to work

echo "<br>";

$item = get_item_details($search_list[5]['Wifi Hotspot Name']);
print_r($item);	
	
	
	
?>

</body>

</html>


<?php


function testSql($conn) {
    $sql = 'SELECT * FROM Wifi WHERE Wifi.Suburb like "b%"';
    foreach ($conn->query($sql) as $row) {
        print "Hotspot Name : " . $row['Wifi Hotspot Name']. "<br>";
    }
	
}


$stmt->close();
$conn->close(); //Close SQL Connection
?>
