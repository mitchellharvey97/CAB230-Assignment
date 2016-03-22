<?php
require('local_config/db_password.php'); //Include the password file -- added as each dev environment will have different db details



// Create connection
$conn = new mysqli($databases['host'], $databases['username'], $databases['password'], $databases['database']);

// Check connection
if ($conn->connect_error) {
    die(
	"Connection failed: " . $conn->connect_error);
}






testSql($conn);



//$stmt->close();
$conn->close();




function testSql($conn) {
    $sql = 'SELECT * FROM Wifi WHERE Wifi.Suburb like "b%"';
    foreach ($conn->query($sql) as $row) {
        print "Hotspot Name : " . $row['Wifi Hotspot Name']. "<br>";
    }
	
}



for ($i = 0; $i < 10; $i++){
	echo "TESTING<br>";
	
}


?>
