<?php







// Create connection -- Using the credentials from external file
require('local_config/db_password.php'); //Include the password file -- added as each dev environment will have different db details using git ignore files to prevent cloning
$data_table = $databases['data_table'];
$conn = new mysqli($databases['host'], $databases['username'], $databases['password'], $databases['database']);



// Check connection
if ($conn->connect_error) { //Display Connection error if any
    die(
	"Connection failed: " . $conn->connect_error);
}

//Collect parameters
$filter = $_GET["filter"];	
$parameter = $_GET["par"];	







//$stmt->close();
//$conn->close();


	function print_results($filter_type, $filter_value){
global $data_table;	
global $conn;
	if ($filter_type == 'suburb'){
		   
	   $sql = 'SELECT * FROM Wifi WHERE ' . $data_table . '.Suburb like "%' . $filter_value . '%"';
	   }
	   else if ($filter_type == 'name'){
	   	  
	   $sql = "SELECT * FROM ".$data_table. " WHERE `" . $data_table. "`.`Wifi Hotspot Name` like '%" . $filter_value . "%'";
	   }
		  else { 
	   $sql ='SELECT * FROM Wifis';
	   
	   }
	 
echo  $sql;
echo "var = ". $data_table;	 
echo "<ul>";



    foreach ($conn->query($sql) as $row) {
        print "<li> Hotspot Nameddd : " . $row['Wifi Hotspot Name']. "</li>
		";
    }
	
}




//Insert whatever Junk below to make up the page 
?>
<html>
<head>
<title>TEST PAGE?? </title>

</head>

<body>
<?php
echo "Filter Type: ". $filter;
echo "<br>";
echo "Parameter: ". $parameter;
echo "<br>";

//testSql($conn);


print_results($filter, $parameter);	
	

	
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
