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
<div class = "content">

    <form class = "login_form" method="post" action="<?php echo $verify_user; ?>">
        <span class = "tag">Email Address:</span><input type="text" name="email"><br>
        <span class = "tag">Password:</span><input type="password" name="password"><br>
        <button value="Login" name="form_type">Login</button>
        <br>
        Don't Have an account?
        <a href="<?php echo $sign_up ?>">Sign up now</a>

</div>
        <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>
	
	