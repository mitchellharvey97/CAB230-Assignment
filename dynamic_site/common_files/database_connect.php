<?php
$database_connection;

function make_sql_request($data, $passed_source = "direct")
{	
	global $database_connection;
	//Work out if the request is from the api or direct
    if ($passed_source == "direct") {
        $direct = true;
    } else {
        $direct = false;
    }

	//Set up database connection
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

    $database_connection = new PDO("mysql:host=$host;dbname=$db_name", $databases['username'], $databases['password']);
    $database_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //End of setting up database connection  
  
	
	
    $wifi_table = $databases["data_table"];
    $user_table = $databases["user_table"];
    $review_table = $databases["rating_table"];
    $database = $databases["database"];

	
    //added a source variable as web calls don't have permission to alter database data
    $requested = $data['request'];

    if ($requested == "all_names") {
		$prepared = $database_connection->prepare("SELECT `Wifi Hotspot Name` FROM $wifi_table");
		$results = sql_query_prepared($prepared);
		return $results;	
    }


	else if ($requested == "all_suburb") {
		$prepared = $database_connection->prepare("SELECT DISTINCT `Suburb` FROM $wifi_table ORDER BY `Suburb`");
		$results = sql_query_prepared($prepared);	
	//	print_r($results);
		return $results;	
    } 
	else if ($requested == "all_location_data") {
		$prepared = $database_connection->prepare("SELECT * FROM $wifi_table");
		$results = sql_query_prepared($prepared);
		return $results;	
		
    } else if ($requested == 'wifi') {
        //Get the name of the hotspot to return
        if ($direct) {
            $hotspot_name = $data['place_name'];
        } else {
            $hotspot_name = $_GET['name'];
        }

		$prepared = $database_connection->prepare("SELECT * FROM $wifi_table WHERE `Wifi Hotspot Name` = :place_name");
		$prepared->bindParam(':place_name', $hotspot_name);
		$results = sql_query_prepared($prepared);
		return $results[0];	
    }
	else if ($requested == "search") {

        if ($direct) {
            $search_type = $data['search_type'];
            if ($search_type != "geo_location") {
                $search_value = $data['search_value'];
            }

        } else {
            $search_type = $_GET['search_type'];
        }


        if ($search_type == "name") {
		$prepared = $database_connection->prepare("SELECT * FROM $wifi_table WHERE `Wifi Hotspot Name` LIKE :place_name");
		$search_value = "%$search_value%";
		$prepared->bindParam(':place_name', $search_value);
		$results = sql_query_prepared($prepared);
		return $results;	
        } 
		else if ($search_type == "suburb") {
		$prepared = $database_connection->prepare("SELECT * FROM $wifi_table WHERE `Suburb` LIKE :suburb_value");
		$search_value = "%$search_value%";
		$prepared->bindParam(':suburb_value', $search_value);
		$results = sql_query_prepared($prepared);
		return $results;	
        } 
		//Both Geo Location and Ratings are calculated in the results page so all data is needed to be returned
		else if ($search_type == "geo_location" || $search_type == "rating" ) {
			$all_data_request['request'] = "all_location_data";		
			return make_sql_request($all_data_request);
        }

    } 
	else if ($requested == "add_user") {
  		$prepared = $database_connection->prepare("INSERT INTO `$database`.`$user_table` (`email`, `f_name`, `l_name`, `Age`, `Gender`, `Excitment`, `profile_color`, `date_added`,`password`) VALUES (:email, :f_name, :l_name, :age, :gender, :excitment, :profile_color, :date_added, :password)");
		
		$prepared->bindParam(':email', $data['user']['email']);
		$prepared->bindParam(':f_name', $data['user']['f_name']);
		$prepared->bindParam(':l_name', $data['user']['l_name']);
		$prepared->bindParam(':age', $data['user']['age']);
		$prepared->bindParam(':gender', $data['user']['gender']);
		$prepared->bindParam(':excitment', $data['user']['excitment']);
		$prepared->bindParam(':profile_color', $data['user']['profile_color']);
		$prepared->bindParam(':password', $data['user']['password']);		
		$prepared->bindParam(':date_added', time());		
		
		$results = sql_query_prepared($prepared);
		return true;			
    } 
	
	else if ($requested == "user_verify") {
 		$prepared = $database_connection->prepare("SELECT * FROM `$database`.`$user_table` WHERE `email` = :email");
		
		$prepared->bindParam(':email', $data['email']);
		$result = sql_query_prepared($prepared);
		
		if (isset($data['password'])) { //We are logging in
  		if (sizeof($result) > 0) { //Don't bother checking if there is no result
				if (password_verify($data['password'], $result[0]->{'password'})) {
				return true;
			} else {
				return false;
			}
		}
		else {return false;}

        } else { //We are only looking for a user
            //Unique Checker

        if (sizeof($result) > 0) { //Match Found
            return true;
        } else { //No Match Found
            return false;
        }
        }
    }
	else if ($requested == "add_review") {
		$date =time();
		
		$prepared = $database_connection->prepare("INSERT INTO `$database`.`$review_table` (`hotspot_name`, `user_email`, `title`, `body`, `rating`, `date`) VALUES (:hotspot_name, :user_email, :title, :body, :rating, :date)");
		
		$prepared->bindParam(':hotspot_name', $data['place']);		
		$prepared->bindParam(':user_email', $data['userid']);		
		$prepared->bindParam(':title', $data['title']);
		$prepared->bindParam(':body', $data['body']);		
		$prepared->bindParam(':rating', $data['rating']);		
		$prepared->bindParam(':date', $date);		
		
		$results = sql_query_prepared($prepared);
		
		return true;	
	}
	else if ($requested == "rating_all"){
		$prepared = $database_connection->prepare("SELECT * FROM `$database`.`$review_table` WHERE `hotspot_name` = :hotspot_name ORDER BY `date` DESC");
		$prepared->bindParam(':hotspot_name', $data['place_name']);		
		$results = sql_query_prepared($prepared);
		
		return $results;
		
	}	
		else if ($requested == "rating_average"){
		$prepared = $database_connection->prepare("SELECT AVG(rating) AS 'rating' FROM `$database`.`$review_table` WHERE `hotspot_name`= :hotspot_name");
		$prepared->bindParam(':hotspot_name', $data['place_name']);		
		$results = sql_query_prepared($prepared);

		$results = floor($results[0]->{'rating'});

		if ($results < 1){
			$results = -1;
		}
		
		
		return $results;
		
	}	
	
	
	else if ($requested == "user_rating_info"){
		$prepared = $database_connection->prepare("SELECT f_name, l_name, profile_color, gender, date_added, age, excitment, COUNT(rating)AS review_count FROM `$database`.`$review_table`, `$database`.`$user_table` WHERE user_email = :email AND Members.email = Reviews.user_email");
		$prepared->bindParam(':email', $data['email']);		
		$results = sql_query_prepared($prepared);
		return $results[0];
		
	}	
	
	else if ($requested == "user_color_gender"){
		$prepared = $database_connection->prepare("SELECT profile_color, gender FROM `$database`.`$user_table` WHERE email = :email");
		$prepared->bindParam(':email', $data['user']);		
		$results = sql_query_prepared($prepared);
		return $results[0];
	}


    if (sizeof($results) <= 1) {
        return $results[0];
    } else {
        return $results;
    }	
}






function sql_query_prepared($prepared)
{
	try{
$prepared->execute();	
$results_store = $prepared->fetchAll();
if (sizeof($results_store > 1)){
        $result_data_store = array();
            foreach ($results_store as $data) {
                array_push($result_data_store, (object)$data);
            }
			return $result_data_store;
}
else {
	return $results_store;
} 
}
catch(Exception $e){
//	print_r($e);
	
}
}