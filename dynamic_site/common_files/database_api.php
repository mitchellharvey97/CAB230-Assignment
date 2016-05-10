<?php
if ($_GET["q"]){
$urlrequested = $_GET["q"]; //Get the type of query
}
else {$urlrequested = null;}


require"database_connect.php";



//If there is a query in the url variables (It is an api request probably from Frontend JSON)
//Also pass the fact that it is a web call to the api
if ($urlrequested){$results = make_sql_request($urlrequested, "webcall");

//If the result variable has been set - display it, otherwise display an error code
if ($results) {
    echo json_encode($results);

} else 
{
    echo("Please provide arguments in the url **ADD HELP SCRIPT HERE MAYBE **");
}


}






?>