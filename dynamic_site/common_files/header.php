<?php
require("images.php");
require("pages.php");
?>

<div id="header">
    <?php echo '<a href="' . $home . '">' . $logo . '</a>'; ?>
    <div id="titleblock">
        <h1>MyWiFind</h1>
    </div>
	<div id = "right">
	
	<?php 
	 if ($logged_in) {
	$request_data['request'] = "user_color_gender";
	$request_data['user'] = $_SESSION['username'];
	$person = make_sql_request($request_data);
	echo "<div class = 'profile'>";
	user_profile($person->{'profile_color'}, $person->{'gender'});
	echo " </div>";
	 }
	?>
    <div id="menu">
        <ul id="links">
            <li>
			<?php
                if ($logged_in) {
                    echo "<a class ='right' href='$logout'>Log Out</a>";
                } else {
                    echo "<a class ='right' href='$login'>Sign Up/ Login</a>";
                }


                ?></li>
            <li><a class ='left' href="<?php echo $home ?>">Home</a></li>
       
	
	   </ul>
    </div>
	</div>
</div>
