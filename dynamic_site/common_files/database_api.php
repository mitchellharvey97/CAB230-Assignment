<?php
//Collect Data Call and work out what to do with it


//$recieved_data = json_decode($_POST['json']);


$requested = $_GET["q"];


require('../local_config/db_password.php'); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning
$data_table = $databases['data_table']; //Change to a straight variable for simplicity

//Make a connection
//$conn = new mysqli($databases['host'], $databases['username'], $databases['password'], $databases['database']);

// Check connection
/*if ($conn->connect_error) { //Display Connection error if any
    die(
	"Connection failed: " . $conn->connect_error);
}
*/

$all_names = array("Person1");
array_push($all_names, "Person 2");
array_push($all_names, "Place 1");
array_push($all_names, "Value 1");
array_push($all_names, "Value 11");
array_push($all_names, "Value 2");





if ($requested == "all_names"){
echo json_encode($all_names);

	//get_search_list();
	
}


function get_search_list(){
	global $data_table;	
	global $conn;

		 
	   $sql ='SELECT * FROM ' . $data_table;
	 
	 
	 
$return_array = []; //initalize array to return;
/*    foreach ($conn->query($sql) as $row) {
		array_push($return_array, $row);
		print_r $row;
		echo ("<br>");
    }
	*/return $return_array;	
	
}





//$stmt->close();
//$conn->close(); //Close SQL Connection

?>




