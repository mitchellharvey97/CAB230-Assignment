<!DOCTYPE html>
<html>
<head>
    <title>MyWiFind - Search Results</title>

	
	
	  <?php
	  
	    require("common_files/pages.php");
    require("common_files/logo.svg.php");

	
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
    <?php include 'common_files/header.php'; ?>

	<form action="post" location="<?php echo $home; ?>">
	Email Address:<input type="text"><br>
	Password:<input type="password"><br>
	<button value="submit" style="background-color:red;">Login </button><br>
	Don't Have an account?
	<a href = "<?php echo $sign_up?>">Sign up now</a>
	
    <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>
	
	