<!DOCTYPE html>
<html>
<head>
    <title>MyWiFind - Search Results</title>


    <?php
    $logged_in = false;
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

    Register for My WiFind<br>

    <form method="post" action="<?php echo $verify_user; ?>">
        First Name:
        <input type="text" id="f_name" name="f_name" required value="PersonFirst"><br>
        Last Name:
        <input type="text" name="l_name" required value="PersonLast"><br>
        Age:
        <input type="number" min="1" max="99" name="age" require value="21"><br>
        Gender:
        <select id='gender' require name="gender">
            <option value="m">Male</option>
            <option value="f">Female</option>
            <option value="o">Prefer not to say</option>
        </select><br>
        How excited for free wifi are you?
        Not very :(<input type="range" size="2" require name="excitment" min="1" max="10" value="5">Very :)!!! <br>
        Email Address:
        <input type="email" name="email" require value="mitch@me.com"><br>
        Profile Color:
        <input type="color" name="profile_color" require value="#ff0000"><br>
        Password:
        <input type="password" name="password" require><br>
        Repeat Password:
        <input type="submit" name="form_type" value="Register">

        <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>
	
	