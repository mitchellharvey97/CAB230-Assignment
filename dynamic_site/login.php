<!DOCTYPE html>
<html>
<head>
    <title>MyWiFind - Search Results</title>


    <?php
    $logged_in = false;

    $error = false;

    if (isset($_GET['q'])) {

        if ($_GET['q'] == "fail") {
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
        echo "<div id='error_message'>There where errors in your username or password<br>Please try again</div>";
    }
    ?>

    <form method="post" action="<?php echo $verify_user; ?>">
        Email Address:<input type="text" name="email"><br>
        Password:<input type="password" name="password"><br>
        <button value="Login" name="form_type" style="background-color:red;">Login</button>
        <br>
        Don't Have an account?
        <a href="<?php echo $sign_up ?>">Sign up now</a>

        <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>
	
	