<!DOCTYPE html>

<html>
<head>
    <title>MyWiFind</title>
    <?php
    require("common_files/check_session.php");

    #Links for Style Sheets and scripts to include
    $script_folder = "js";
    $scripts = array("$script_folder/suggestion.js", "$script_folder/form_validate.js", "$script_folder/home_page.js");
    $css = array("css/style.css");
    require("common_files/database_connect.php");
    require("common_files/helper_functions.php");

    $request['request'] = "all_suburb";
    $suburb_data = make_sql_request($request);

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

    if (isset($_GET['q'])) {
        if ($_GET['q'] == "login") {
            echo "<div id ='login_success'>Log in successful</div>";
        } else if ($_GET['q'] == "signup") {
            echo "<div id ='login_success'>Registration successful</div>";
        }
    }

    function display_button($id)
    {
        echo "<input type='button' value='Search' id='$id'>";
    }

    ?>
    <div class="content">
        <div id="home_page_forms">
            <form id="main_search">
                <div class="left" id="sugg_parent">
                    <input type="text" name="search_value" placeholder="Search By name" id="search_value">
                </div>

                <div class="right">
                    <?php display_button("text_search"); ?>
                </div>
                <div class='clearfix'></div>
            </form>

            <br>

            <form id="suburb_drop_form">
                <div class="left">
                    Or, Select a suburb from the list
                    <select id="suburb_list">
                        <?php

                        foreach ($suburb_data as $suburb) {
                            $suburb->{'Suburb'} = strip_postcode($suburb->{'Suburb'});
                        }

                        $suburb_data = remove_duplicates($suburb_data, "Suburb");

                        foreach ($suburb_data as $suburb) {

                            $suburb_name = $suburb['Suburb'];
                            echo "<option value=\"$suburb_name\">$suburb_name</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="right">
                    <?php display_button("suburb_search"); ?>
                </div>

                <div class='clearfix'></div>
            </form>

            <br>
            <form id="rating_search_form">
                <div class="left">
                    Or, Search by Rating
                    <?php

                    for ($x = 1; $x <= 5; $x++) {
                        //Make the highest rated checked - Just to prevent an error with no submission, and who
                        //wouldn't want the best
                        if ($x == 5) {
                            $checked = "checked";
                        } else {
                            $checked = '';
                        }
                        echo("<input type='radio' name='enterRating' $checked value='$x'>$x");
                    }
                    ?>
                </div>
                <div class="right">
                    <?php display_button("rating_search"); ?>
                </div>
                <div class='clearfix'></div>
            </form>

            <br>

            <form id="geolocation_search">
                <div class="left">
                    Find the nearest Wifi Hotspot to me
                </div>
                <div class="right">
                    <?php display_button("geo_location_search"); ?>
                </div>

                <div class='clearfix'></div>
            </form>

        </div>
    </div>

    <?php include 'common_files/footer.php'; ?>
</div>
</body>
</html>