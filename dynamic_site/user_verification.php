<?php

require("common_files/database_connect.php");
require("common_files/pages.php");


$form_source = $_POST['form_type'];

//Collect email and password as it is required for both


$user['email'] = $_POST['email'];
$user['password'] = $_POST['password'];



$register = false;
//Get extra data for the user login page
if ($form_source == "Register") {
    global $user;
    global $_POST;
    $register = true;
    $user['f_name'] = $_POST['f_name'];
    $user['l_name'] = $_POST['l_name'];
    $user['age'] = $_POST['age'];
    $user['gender'] = $_POST['gender'];
    $user['excitement'] = $_POST['excitment'];
    $user['profile_color'] = substr($_POST['profile_color'], 1); //Stripping # From front
}

if ($register) {
    $error = false;
    $error_fields = array();

    echo "<h1>Values Recieved:</h1>";
    print_r($user);
    echo "<br>";

    foreach ($user as $key => $value) {
        if ($error_info['message'] = error($key, $value)) {
            $error_info['message'] = "Goofed Up";
            $error_info['field'] = $key;
            array_push($error_fields, $error_info);
            $error = true;
        }
        echo "$key: $value<br>\n";
    }

    //Just error Logging
    if ($error) {
        echo("<br><h1>oops, someone stuffed up</h1>");
        foreach ($error_fields as $errors) {
            print $errors['message'] . "with field " . $errors['field'] . "<br>";
        }
    } else {
        print "<br><h1>No Errors!!!!</h1>";

        $request_data['user'] = $user;
        //  $request_data['user']['password'] = $request_data['user']['password'][0]; //Only pass one password as they have been checked to be the same
        $request_data['request'] = "add_user";
        if (user_unique()) {
            $request_data['user']['password'] = password_hash($request_data['user']['password'], PASSWORD_DEFAULT);

            make_sql_request($request_data);
            //if all is good, go to the home page
			login_success("signup");
             echo "Success";
        } else {
           	echo "Fail";
            echo "<script> window.location.assign('$sign_up?q=error'); </script>";
//            echo "That email address is already in use";
        }
    }


} else {
    //	global $user;
    $request_data['request'] = "user_verify";
    $request_data['email'] = $user['email'];
    $request_data['password'] = $user['password'];

    print_r($request_data);

    if (make_sql_request($request_data)) {
        //echo "Success";
		login_success("login");
    } else {
        //echo "fail";
      //  echo "<script> window.location.assign('$login?q=fail'); </script>";
    };


}


function user_unique()
{
    global $user;
    $request_data['request'] = "user_verify";
    $request_data['email'] = $user['email'];
    return !make_sql_request($request_data);
}

function out_of_bounds($val, $min, $max)
{
    if ($val < $min || $val > $max) {
        return true;
    } else {
        return false;
    }
}


function login_success($msg){
	global $user;
	global $home;
	   ob_start();
   session_start();
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = $user['email'];   
   
   echo "<br>Session<br>";
	print_r($_SESSION);
	
	
    echo "<script> window.location.assign('$home?q=$msg'); </script>";
	
	
	
}


function error($key, $value)
{
    if (empty($value)) {
        return "$key value is empty, ";
    }


    if ($key == "age" || $key == "excitement") {
        print "Integer Checking, ";
        $re = "/[^0-9]+/";
        $matches = null;
        preg_match($re, $value, $matches);

        if (!empty($matches)) {
            return ("Non Numerical Input found, ");
        }

        if ($key == "age") {
            $age_min = 1;
            $age_max = 99;
            if (out_of_bounds($value, $age_min, $age_max)) {
                return ("Age out of bounds, ");
            }
        }

        if ($key == "excitement") {
            $excitement_min = 1;
            $excitements_max = 10;
            if (out_of_bounds($value, $excitement_min, $excitements_max)) {
                return ("Excitement out of bounds, ");
            }
        }
    }

    if ($key == "gender") {
        if ($value == "m" || $value == "f" || $value == "o") {
        } else {
            return ("Gender not correct, ");
        }
    }
    return false;
}

?>

