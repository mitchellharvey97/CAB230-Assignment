<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["valid"]);
unset($_SESSION["timeout"]);

echo 'You have successfully logged out';
header('Refresh: 0; URL = index.php');
?>