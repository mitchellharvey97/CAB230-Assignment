<?php
require("common_files/check_session.php");
require("common_files/pages.php");
require("common_files/database_connect.php");

$place_name = $_GET["q"];
//Get the data from the database connector and decode it to an object
$request['request'] = "wifi";
$request['place_name'] = $place_name;
$received_data = make_sql_request($request);

$wifiName = $received_data->{'Wifi Hotspot Name'};
$wifiAddress = $received_data->{'Address'};
$wifiSuburb = $received_data->{'Suburb'};
$wifiLat = $received_data->{'Latitude'};
$wifiLng = $received_data->{'Longitude'};
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $place_name; ?></title>

    <?php
    #Links for Style Sheets and scripts to include
    $scripts = array("../js/maps.js", "http://maps.google.com/maps/api/js?sensor=false");
    $css = array("../css/style.css");
    foreach ($scripts as $script) {#Link all Script Files
        echo "<script src='" . $script . "'></script>\n";
    }
    foreach ($css as $script) { #Link All CSS Files
        echo "<link href='" . $script . "' rel='stylesheet'>\n";
    }
    ?>

</head>

<body>
<div id="wrapper">
    <?php include 'common_files/header.php';
    echo '<div class = "content" itemscope itemtype="http://schema.org/Place">';

    echo "<div class = 'location_details'>";
    echo "<h1 itemprop='name'>" . $wifiName . "</h1>";
    echo "<h2>" . $wifiAddress . " , " . $wifiSuburb . "</h2>";
    echo "<div itemprop='geo' itemscope itemtype=http://schema.org/GeoCoordinates>";
    echo "<meta itemprop='latitude' content='$wifiLat' />
			<meta itemprop='longitude' content='$wifiLng' /></div>";
    echo "</div>";


    ?>
    <div id="location_map" class="map"></div>


    <div id="reviews">
        <h1>Reviews</h1>
        <?php
        $request['request'] = "rating_all";
        $request['place_name'] = $place_name;
        $rating_data = make_sql_request($request);


        function days_between($first, $second)
        {
            $datediff = $second - $first;
            return floor($datediff / (60 * 60 * 24));
        }

        if (sizeof($rating_data) < 1){
            echo "No reviews have been posted yet";

        }
        else{
        $request['request'] = "rating_average";
        $request['place_name'] = $wifiName;
        $avg_rating = make_sql_request($request);
        ?>
        <div itemprop="aggregateRating"
             itemscope itemtype="http://schema.org/AggregateRating">
            Rated <span itemprop="ratingValue"><?php echo $avg_rating ?></span>/5
            based on <span itemprop="reviewCount"><?php echo sizeof($rating_data) ?></span> customer reviews
        </div>

    <?php

    foreach ($rating_data as $rating){
    $request['request'] = 'user_rating_info';
    $request['email'] = $rating->{'user_email'};
    $user_info = make_sql_request($request);
    echo "<br><div class ='review'  itemprop='review' itemscope itemtype='http://schema.org/Review'>";

    $person_name = $user_info->{'f_name'} . " " . $user_info->{'l_name'};
    $person_email = $rating->{'user_email'};
    $person_gender = $user_info->{'gender'};
    $person_color = $user_info->{'profile_color'};
    $review_age = days_between(($rating->{'date'}), time());
    $review_rating = $rating->{'rating'};
    $member_for = days_between(($user_info->{'date_added'}), time());
    $number_reviews = $user_info->{'review_count'};
    $review_title = $rating->{'title'};
    $review_body = $rating->{'body'};
    ?>

        <div class='left'>
            <div class='profile_pict'>

                <?php
                user_profile($person_color, $person_gender); ?>
            </div>


            <div class="person_info">
                <?php echo "<span itemprop='author' itemscope itemtype='http://schema.org/Person'><span itemprop='name'>$person_name </span></span><br>
		Member for $member_for days<br>
		Number of reviews: $number_reviews
            </div>
        </div>

        <div class='right'>
            <h2 itemprop='name'>$review_title</h2>
			<span itemprop='reviewRating' itemscope itemtype='http://schema.org/Rating'>
						Rating: <span itemprop='ratingValue'>$review_rating</span>
						 <meta itemprop='worstRating' content = '1'>
						 <meta itemprop='bestRating' content = '5'>
				</span>, Posted $review_age days ago
	<p itemprop='reviewBody'>$review_body</p>
        </div>";
                echo "        <div class='clearfix'> </div>";
                echo "    </div> <!--End of review repeat-->";

                }
                }

                ?>


                <div class="add_review">
                    <?php
                    if ($logged_in) {
                        $user_email = $_SESSION['username'];

                        $review_status['request'] = 'user_already_posted';
                        $review_status['user'] = $user_email;
                        $review_status['place'] = $wifiName;

                        $user_already_posted = make_sql_request($review_status);

                        //	$user_already_reviewed = true;

                        if ($user_already_posted) {
                            echo "You can only post one review per location";
                        } else {
                            ?>
                            <form id="add_review" method="post" action="../<?php echo $add_review; ?>"
                                  oninput="x.value=parseInt(rating.value)">
                                <h2> Add Review</h2>
                                Title:<br>
                                <input type="text" required name="title" placeholder="Review Title"><br>

                                Review<br>
                                <textarea required name="body" placeholder="Review"> </textarea><br>
                                <br>
                                Rating:
                                <output name="x" for="rating"></output>
                                <br>
                                <input type="range" id="rating" name="rating" value="5" min=1 max=5>

                                <br><br>


                                <input type="hidden" name="userid" value="<?php echo $user_email; ?>">
                                <button value="<?php echo $wifiName; ?>" name="place">Submit Review
                                </button>
                            </form>

                            <?php
                        }
                    } else {
                        echo "You must be logged in to write a review. <a href='$login'>Login</a> or <a href = '$sign_up'> Create an account now</a>";
                    }
                    ?>
                </div>


                <!--Some Inline Scripting to allow php to add to the array - PHP gets rendered before Javascript, therefore it is possible to write javascript arrays with it-->
                <script>
                    var hotspot_locations = []
                    <?php  echo "hotspot_locations.push(['<h4>$wifiName</h4><br>',$wifiLat, $wifiLng]);";?>
                    display_map(hotspot_locations, "location_map");
                </script>
            </div>
        </div>
        <?php include 'common_files/footer.php'; ?>
    </div>
</body>
</html>
