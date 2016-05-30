<?php
//A very basic page to log the user out
session_start();
unset($_SESSION["username"]);
unset($_SESSION["valid"]);
unset($_SESSION["timeout"]);
//Unset the variables for safety, then DESTROY everything
session_destroy();
echo 'You have successfully logged out';
header('Refresh: 0; URL = index.php?q=logout');
?>