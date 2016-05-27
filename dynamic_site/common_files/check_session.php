<?php 
 session_start();
$logged_in = false;

//	print_r($_SESSION);
	if (isset($_SESSION['valid']) && $_SESSION['valid']){
			$logged_in = true;
	}