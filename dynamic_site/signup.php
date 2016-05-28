<!DOCTYPE html>
<html>
<head>
    <title>MyWiFind - Search Results</title>


    <?php

	require("common_files/check_session.php");

	
    $error = false;
    if (isset($_GET['q'])) {

        if ($_GET['q'] == "error") {
            $error = true;
        }
    }


    require("common_files/pages.php");


    #Links for Style Sheets and scripts to include
    $scripts = array("http://maps.google.com/maps/api/js", "js/maps.js");
    $css = array("css/style.css");
    //"js/suggestion.js",

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
    if ($error) {
        echo "<div id='error_message'>There where errors in the form<ul>
	<li>Email Address has already been used</li>
	</ul></div>";
    }
    ?>
	<div class = "content">


    <form id = "user_register" method="post" action="<?php echo $verify_user; ?>">
    <h1>Register for My WiFind</h1>
        <p>First Name:</p><input type="text" pattern="[A-Za-z]*" title = "Please only use a-z and A-Z" id="f_name" name="f_name" required placeholder="First Name"><br>
       
	   <p>Last Name:</p><input type="text" pattern="[A-Za-z]*" title = "Please only use a-z and A-Z" name="l_name" required placeholder="Last Name"><br>
       
	   <p>Age:</p><input type="number" min="1" max="99" name="age" required placeholder="Age"><br>
      
	  <p>Gender:</p><select id='gender' required name="gender">
            <option value="m">Male</option>
            <option value="f">Female</option>
            <option value="o">Prefer not to say</option>
        </select><br>
     
	   <p>How excited for free wifi are you?</p>
	   <input type="range" size="2" required name="excitment" min="1" max="10" value="5"><br>
       
       
	   <p>Profile Color:</p><input type="color" name="profile_color" pattern = "[A-Fa-f0-9]{6}*" required value="#00aa00"><br>
        
	   <p>Email Address:</p><input type="email" name="email" required placeholder="someone@example.com"><br>
	
	<p>Password:</p><input type="password" name="password" required><br>
        
		<input type="submit" name="form_type" value="Register">
		<div class = "clearfix"></div>
</form>
</div>
        <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>
	
	