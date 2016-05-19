<?php

    require("common_files/database_connect.php");
	

$user['f_name'] = $_POST['f_name'];
$user['l_name'] = $_POST['l_name'];
$user['age'] = $_POST['age'];
$user['gender'] = $_POST['gender'];
$user['excitment'] = $_POST['excitment'];
$user['email'] = $_POST['email'];
$user['profile_color'] = substr($_POST['profile_color'],1); //Stripping # From front
//$user['password1'] = $_POST['password1'];
//$user['password2'] = $_POST['password2'];
$user['password'] = array($_POST['password1'], $_POST['password2']);


//Breaking stuff

//$user['f_name'] = "My Name";
//$user['age'] = 123;
//$user['excitment'] = "3sa";
//$user['gender'] = "a";
	
//$user['password1'] = "pass";
//$user['password2'] = "pass";


//$user['password'] = array("pass", "pass");


			$error = false;
			$error_fields = array();
			
			echo"<h1>Values Recieved:</h1>";
			foreach ($user as $key => $value) {
				if ($error_info['message'] = error($key, $value)){
					//$error_info['message'] = "Goofed Up";
					$error_info['field'] = $key;
					
					array_push($error_fields, $error_info);
					$error = true;
				}
				echo "$key: $value<br>\n";
			}

			//Just error Logging
					if ($error){
						echo ("<br><h1>oops, someone stuffed up</h1>");
						foreach ($error_fields as $errors){
							print $errors['message'] . "with field " . $errors['field'] . "<br>";
						}
					}
					else{
						print "<br><h1>No Errors!!!!</h1>";
						$request_data['request'] = "add_user";
						$request_data['user'] = $user;
						make_sql_request($request_data);
					}					
		
			
			
			function error($key, $value){
				if ($key == "password"){ //Password variable works a little different
					echo "Pass1:". $value[0] . ", Pass2:".  $value[1] . ", ";
					if (empty($value[0])){
						return "Missing Password";					
					}					
					if ($value[0] != $value[1]){
						return"Passwords don't match";
					}
				}
						
			if (empty($value)){
					return "$key value is empty, ";
				}
				
				if ($key =="password1"){
					$pass1 = $value;
					$pass2 = $user['password2'];					
					
					if ($value != $pass2){
						return "Password Not Same, ";
					}
				}
				
			if ($key == "age" || $key == "excitment"){
				print "Integer Checking, ";
				$re = "/[^0-9]+/"; 
				$matches = null;
				preg_match($re, $value, $matches);
				
				if (!empty($matches)){
					return("Non Numerical Input found, ");
				}	
		
				if ($key == "age"){
					$age_min = 1; 
					$age_max = 99;
					
					if (out_of_bounds($value, $age_min, $age_max)){
						return ("Age out of bounds, ");
						}
				}
				
				if ($key == "excitment"){
					$excitment_min = 1; 
					$excitment_max = 10;	
					if (out_of_bounds($value, $excitment_min, $excitment_max)){
						return ("Exitment out of bounds, ");
					}
				}					
			}
			
			if ($key == "gender"){
				if ($value == "m" || $value == "f" || $value == "o"){}
				else{
					return ("Gender not correct, ");
				}
			}
				return false;			
			}

			
			function out_of_bounds($val, $min, $max){				
				if ($val < $min || $val > $max){
					return true;
				}
				else{
					return false;
				}
			}
			
?>

