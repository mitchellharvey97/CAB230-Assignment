<?php
//Start a new session and check if the user is logged in;
session_start();
$logged_in = false;
if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    $logged_in = true;
}