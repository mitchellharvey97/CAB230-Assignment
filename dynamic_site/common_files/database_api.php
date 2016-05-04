<?php
$requested = $_GET["q"]; //Get the type the user wanted


require('./local_config/db_password.php'); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning
$data_table = $databases['data_table']; //Change to a straight variable for simplicity

//Make a connection
$conn = new mysqli($databases['host'], $databases['username'], $databases['password'], $databases['database']);

 //Check connection
if ($conn->connect_error) { //Display Connection error if any
    die(
	"Connection failed: " . $conn->connect_error);
}


$all_names = array("Person1");
array_push($all_names, "Person 2");
array_push($all_names, "Place 1");
array_push($all_names, "Value 1");
array_push($all_names, "Value 11");
array_push($all_names, "Value 2");





if ($requested == "all_names"){
	$sql = 'SELECT `Wifi Hotspot Name` FROM Wifi';
	$results = sql_query($sql);
echo json_encode($results);	

}
else if ($requested == "all_location_data"){
//	print "All Location data comming right up, hang tight <br>";	
	$sql = "SELECT * FROM Wifi";

	
	$results = sql_query($sql);	
	
	echo json_encode($results);
	
	
}

else{
	print("Please provide arguments in the url **ADD HELP SCRIPT HERE MAYBE **");
	
}


function sql_query($query){
			global $conn;
			$result = $conn->query($query);
			$result_data_store = array();
			if ($result->num_rows > 0) {
     // output data of each row
		while($row = $result->fetch_assoc()) {
			//add each row to an array
			array_push($result_data_store, $row);
     }
} else {
     return -1;
}
return $result_data_store;	
}



$conn->close(); //Close SQL Connection

?>




