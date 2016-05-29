<!DOCTYPE html>
<html>
<head>
    <title>MyWiFind - Search Results</title>


    <?php
    $logged_in = false;


    require("common_files/database_connect.php");
    require("common_files/pages.php");


    $error = false;

    if (isset($_POST['form_type'])) { //There is data getting posted to it
        //Collect username and pass data

        if (no_errors()) { //If email and password exist and there are no errors		
            $user['email'] = $_POST['email'];
            $user['password'] = $_POST['password'];

            $request_data['request'] = "user_verify";
            $request_data['email'] = $user['email'];
            $request_data['password'] = $user['password'];
            if (make_sql_request($request_data)) {
                login_success("login");
            } else {
                $error = true;
            };
        } else {
            $error = true;
        }
    }

    function no_errors()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            if ($email == "" || $email == null || $pass == "" || $pass == null) {
                return false;
            }
            return true;
        } else {
            return false;
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
        //    echo "<script> window.location.assign('$home?q=$msg'); </script>";
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

    if ($error) {
        echo "<div id='error_message'>There where errors in your username or password<br>Please try again</div>";
    }

    ?>
    <div class="content">
        <form class="login_form" method="post">
            <span class="tag">Email Address:</span><input type="email" name="email" required
                                                          placeholder="someone@example.com" <?php if ($error) echo "value ='" . $_POST['email'] . "'"; ?>><br>
            <span class="tag">Password:</span><input type="password" required name="password"><br>
            <button value="Login" name="form_type">Login</button>
            <br>
            <p> Don't Have an account? <a href="<?php echo $sign_up ?>">Sign up now</a></p>
        </form>
    </div>
    <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>
	
	