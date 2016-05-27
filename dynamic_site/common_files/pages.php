<?php
//A collection of variables containing the page url for the requested page
//This will allow for ease of updating a page site wide
//Also a link to "web_root" which is a local file (environment unique) which contains the root path
//of the server. E.g to compensate for multiple sites on one server.
//For example one local dev file is located at "http://localhost/cab230/site/dynamic_site/" whereas the submission server
//is located at http://something/n9453270
// It would be possible to access the file via the request url, but my local server is configured with a hosts file allowing access
//via http://cab230 but the serer does not contain the same hosts file.
require("local_config/web_root.php");

$home = 'index.php';
$sign_up = 'signup.php';
$results = 'results.php';
$item = 'item_page.php';
$login = 'login.php';
$logout = 'logout.php';
$add_review = 'process_review.php';
$verify_user = "user_verification.php";
$api = $web_root . 'common_files/database_api.php';
?>