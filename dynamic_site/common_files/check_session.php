<?php
session_start();
$logged_in = false;
if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    $logged_in = true;
}