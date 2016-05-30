<!DOCTYPE html>
<html>
<head>
    <title>MyWiFind - Sign Up</title>
    <?php

    require("common_files/check_session.php");
    require("common_files/database_connect.php");
    require("common_files/pages.php");
    $submit_error = false;
		
    if (isset($_POST['form_type'])) { //There is data getting posted to it

//Collect all the data into an object
        $user['email'] = $_POST['email'];
        $user['password'] = $_POST['password'];
        $user['f_name'] = $_POST['f_name'];
        $user['l_name'] = $_POST['l_name'];
        $user['age'] = $_POST['age'];
        $user['gender'] = $_POST['gender'];
        $user['excitement'] = $_POST['excitement'];
        $user['some_date'] = $_POST['some_date'];
        $user['profile_color'] = substr($_POST['profile_color'], 1); //Stripping # From front

		//Destroying the inputs for the php checker - commented out to put site functionality back to normal
		/*
		$user['email'] = "Nope";
        $user['password'] = $_POST['password'];
        $user['f_name'] = "Destroyer101";
        $user['l_name'] = "Alright";
        $user['age'] = "666";
        $user['gender'] = "d";
        $user['excitement'] = $_POST['excitement'];
        $user['some_date'] = "30/2/2016";
        $user['profile_color'] = "FFFFFFF"; //Stripping # From front
*/		
        $error_fields = array();

        foreach ($user as $key => $value) {
            if ($msg = error($key, $value)) {
                $error_info['field'] = $key;
                array_push($error_fields, $msg);
                $submit_error = true;
            }
        }

        if (!$submit_error) {
            $request_data['user'] = $user;
            $request_data['request'] = "add_user";
            if (user_unique()) {
                $request_data['user']['password'] = crypt($request_data['user']['password']);
                make_sql_request($request_data);
                //if all is good, go to the home page
                login_success("signup");
            } else {
                $submit_error = true;
                array_push($error_fields, "Email address has already been used, please use a unique email");
            }
        }
    }

    function login_success($msg)
    {
        global $user;
        global $home;
        ob_start();
        session_start();
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $user['email'];
        header("Refresh: 0; URL = $home?q=$msg");
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


    function illegal_characters($re, $string)
    {
        $matches = null;
        preg_match($re, $string, $matches);
        if (!empty($matches)) {
            return true;
        }
    }

    function error($key, $value)
    {
        if (empty($value)) {
            $field = $key;
            return "$field value is empty, ";
        }

        if ($key == "email") {
            $email_regex = "/^[a-z_\.0-9]+@[a-z_\.0-9]+/i";
            $matches = null;
            preg_match($email_regex, $value, $matches);
            if (empty($matches) || $matches[0] != $value) {
                return "Please provide a valid email";
            }
        }

        if ($key == "some_date") {
			$date_regex = "/^[0-9]{1,2}\/[0-9][012]{0,1}\/[12][0-9]{3}/i";
            $matches = null;
            preg_match($date_regex, $value, $matches);
		

		$return_string = "Please provide a valid date";
		
		$date = explode("/", $value);
		$date_error = false;
		$dd = $date[0];
		$mm = $date[1];
		$yyyy = $date[2];
		
		if ($dd <= 0 || $mm <=0  || $mm > 12 ||$yyyy <=0){
			return $return_string;
		}
		else{
			$max_days = cal_days_in_month(CAL_GREGORIAN, $mm, $yyyy);
			if ($dd > $max_days){
			return $return_string;				
			}
		}
		
            if (empty($matches) || $matches[0] != $value || $date_error) {
				echo "Last?";
                return $return_string;
            }
        }
        
		
		
		

        if ($key == "profile_color") {
            $re = "/[^a-f0-9]+/";
            if (illegal_characters($re, $value) || strlen($value) != 6) {
                return "Please provide a valid Profile Color";
            }
        }

        if ($key == "f_name" || $key == "l_name") {
            if ($key == "f_name") {
                $field = "First Name";
            } else {
                $field = "Last Name";
            }
            $re = "/[^a-zA-Z]+/";
            if (illegal_characters($re, $value)) {
                return "Please only use a-z and A-Z in the $field field";
            }
        }

        if ($key == "age" || $key == "excitement") {
            $re = "/[^0-9]+/";
            if ($key == "age") {
                $field = "age";
            } else {
                $field = "excitement";
            }
            if (illegal_characters($re, $value)) {
                return ("Please enter a numerical value only for $field");
            }
            if ($key == "age") {
                $age_min = 1;
                $age_max = 99;
                if (out_of_bounds($value, $age_min, $age_max)) {
                    return ("Age out of bounds");
                }
            }
            if ($key == "excitement") {
                $excitement_min = 1;
                $excitements_max = 10;
                if (out_of_bounds($value, $excitement_min, $excitements_max)) {
                    return ("Excitement out of bounds");
                }
            }
        }

        if ($key == "gender") {
            if ($value == "m" || $value == "f" || $value == "o") {
            } else {
                return ("Please Enter a valid Gender");
            }
        }
        return false;
    }

    #Links for Style Sheets and scripts to include
    $scripts = array("http://maps.google.com/maps/api/js", "js/maps.js");
    $css = array("css/style.css");

    foreach ($scripts as $script) {              #Link all Script Files
        echo "<script src='" . $script . "'></script>\n";
    }
    foreach ($css as $script) {                  #Link All CSS Files
        echo "<link href='" . $script . "' rel='stylesheet'>\n";
    }
    ?>

</head>
<body>
<div id="wrapper">
    <?php include 'common_files/header.php';
    if ($submit_error) {
        echo "<div id='error_message'>There where errors in the form<ul>";
        foreach ($error_fields as $error_text) {
            echo "<li>$error_text</li>";
        }
        echo "</ul></div>";
    }
    ?>
    <div class="content">
        <form id="user_register" method="post">
            <h1>Register for My WiFind</h1>
            <p>First Name:</p><input type="text" pattern="[A-Za-z]*" title="Please only use a-z and A-Z" id="f_name"
                                     name="f_name" required
                                     placeholder="First Name" <?php if ($submit_error) echo "value ='" . $_POST['f_name'] . "'"; ?>><br>

            <p>Last Name:</p><input type="text" pattern="[A-Za-z]*" title="Please only use a-z and A-Z" name="l_name"
                                    required
                                    placeholder="Last Name"<?php if ($submit_error) echo "value ='" . $_POST['l_name'] . "'"; ?>><br>

            <p>Age:</p><input type="number" min="1" max="99" name="age" required
                              placeholder="Age" <?php if ($submit_error) echo "value ='" . $_POST['age'] . "'"; ?>><br>

		  <p>Meaningful Date:</p><input type="date" name="some_date" required
                              placeholder="dd/mm/yyyy" pattern="[0-9]{1,2}\/[0-9][012]{0,1}\/[12][0-9]{3}" <?php if ($submit_error) echo "value ='" . $_POST['some_date'] . "'"; ?>><br>

            <p>Gender:</p><select id='gender' required name="gender">
                <option <?php if ($submit_error && $_POST['gender'] == "m") echo "selected='selected'" ?>value="m">Male
                </option>
                <option <?php if ($submit_error && $_POST['gender'] == "f") echo "selected='selected'" ?>value="f">Female
                </option>
                <option <?php if ($submit_error && $_POST['gender'] == "o") echo "selected='selected'" ?>value="o">Prefer not
                    to say
                </option>
            </select><br>

            <p>How excited for free wifi are you?</p>
            <input type="range" size="2" required name="excitement" min="1" max="10" value="<?php if ($submit_error) {
                echo $_POST['excitement'];
            } else {
                echo "5";
            } ?>"><br>

            <p>Profile Color:</p><input type="color" name="profile_color" pattern="[A-Fa-f0-9]{6}*" required
                                        value="<?php if ($submit_error) {
                                            echo $_POST['profile_color'];
                                        } else {
                                            echo "#00aa00";
                                        } ?>"><br>

            <p>Email Address:</p><input type="email" name="email" required
                                        placeholder="someone@example.com"<?php if ($submit_error) echo "value ='" . $_POST['email'] . "'"; ?>><br>

            <p>Password:</p><input type="password" name="password" required><br>

            <input type="submit" name="form_type" value="Register">
            <div class="clearfix"></div>
        </form>
    </div>
    <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>
	
	