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
    $user_table = $databases["user_table"];
    $database = $databases["database"];


    //added a source variable as web calls don't have permission to alter database data
    $requested = $data['request'];
    //print("Make SQL Request Success <br>");

    if ($requested == "all_names") {
        $sql = "SELECT `Wifi Hotspot Name` FROM $wifi_table";
        $results = sql_query($sql);
    } elseif ($requested == "all_suburb") {
        $sql = "SELECT DISTINCT `Suburb` FROM $wifi_table ORDER BY `Suburb`";
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
            $sql = "SELECT * FROM $wifi_table";
            $results = sql_query($sql);


        } else if ($search_type == "geo_location") {
            $sql = "SELECT * FROM $wifi_table";
            $results = sql_query($sql);
        }


    } else if ($requested == "add_user") {
        $email = $data['user']['email'];
        $f_name = $data['user']['f_name'];
        $l_name = $data['user']['l_name'];
        $age = $data['user']['age'];
        $gender = $data['user']['gender'];
        $excitment = $data['user']['excitment'];
        $profile_color = $data['user']['profile_color'];
        $password = $data['user']['password'];

        $sql = "INSERT INTO `$database`.`$user_table` (`email`, `f_name`, `l_name`, `Age`, `Gender`, `Excitment`, `Profile_Color`, `password`) VALUES ('$email', '$f_name', '$l_name', '$age', '$gender', '$excitment', '$profile_color', '$password')";

        print "<br>$sql<br>";

        sql_query($sql);
        return true;
    } else if ($requested == "user_verify") {
        $email = $data['email'];
        $password_check;
        if (isset($data['password'])) {
            $password = $data['password'];
            $password_check = " AND `password` = '$password'";
            print "It is a login Request";
        } else {
            //Unique Checker
        }
        $sql = "SELECT * FROM `$database`.`$user_table` WHERE `email` = '$email'" . $password_check;
        echo "<br>$sql<br>";
        $result = sql_query($sql);

        if (sizeof($result) > 0) { //Match Found
            return true;
        } else { //No Match Found
            return false;
        }
    }


    if (sizeof($results) <= 1) {
        return $results[0];
    } else {
        return $results;
    }

}


function sql_query($query, $search = true)
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

        if ($search) {

            foreach ($result as $data) {
                array_push($result_data_store, (object)$data);
            }
            return ($result_data_store);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}