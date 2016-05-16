<?php
require("logo.svg.php");
require("pages.php");
?>

<div id="header">
    <?php echo '<a href="' . $home . '">' . $logo . '</a>'; ?>
    <div id="titleblock">
        <h1>MyWiFind</h1>
    </div>
    <div id="menu">
        <ul id="links">
            <li><a href="<?php echo $login ?>">Sign Up/ Login</a></li>
            <li><a href="<?php echo $home ?>">Home</a></li>
        </ul>
    </div>
</div>