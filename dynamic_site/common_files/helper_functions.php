<?php
//The file contains several helper functions used throughout the project

//A helper function to clean the horribly inconsistent data supplied in the database
function strip_postcode($input)
{
    for ($x = 0; $x <= 9; $x++) {
        $input = str_replace("$x", "", $input);
    }
    //An attempt to normalize targeting special cases
    if ($input == "Brisbane City") {
        $input = "Brisbane";
    }
    if ($input == "Holland Park West") {
        $input = "Holland Park";
    }
    $input = str_replace(" park", " Park", $input);
    $input = str_replace(", ", "", $input);
    return $input;
}

function remove_duplicates($input, $key)
{
    //Not at all an efficient algorithm, really should be investigated to not be an x^2 problem
    //But doesn't really cause any issues due to the array only being ~50 items long
    $return_object = array();
    for ($x = 0; $x < sizeof($input); $x++) {
        //Check if the return object already contains the value
        if (!duplicate_entry($return_object, $key, $input[$x]->{"$key"}, $x)) {
            //if not, add it
            $place["$key"] = $input[$x]->{"$key"};
            array_push($return_object, $place);
        }
    }
    return $return_object;
}

function duplicate_entry($input, $key, $item, $index)
{
    //Don't Check the first one as it will not be already there
    if ($index == 0) {
        return false;
    }
    for ($x = 0; $x < sizeof($input); $x++) {
        //Don't check the item against itself obviously
        if ($x != $index && $item == $input[$x][$key]) {
            return true;
        }
    }
    return false;
}

//Sort an array with a specified max value (Used for locations within x km of person)
//If a max value is omitted, then just sort the array
function sort_array($unsorted, $max_value = null)
{
    $returned_value = array();

    foreach ($unsorted as $item) {
        if ($max_value == null || $item->{'distance'} <= $max_value) {
            $pos = find_index_in_order($returned_value, $item->{'distance'});
            $returned_value = insertArrayIndex($returned_value, $item, ($pos));
        }
    }
    return $returned_value;
}


//Insert a value into a pre existing array at $index
//PHP has no clean way of inserting at a given index so it a function was written to do just that
function insertArrayIndex($array, $new_element, $index)
{
    $start = array_slice($array, 0, $index);
    $end = array_slice($array, $index);
    $start[] = $new_element;
    return array_merge($start, $end);
}

//Using the various math websites for inspiration, a math equation was created to calculate the distance between points
//The value is rounded to 2 decimal places to prevent an obscurely long value being returned
function find_distance($lat1, $lon1, $lat2, $lon2)
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $km = $dist * 60 * 1.1515 * 1.609344;
    return round($km, 2, PHP_ROUND_HALF_UP);;
}

//Find the index of a specified item in an array - the "Distance" variable has been hard coded
//but it could be converted to a variable to suit multiple applications
function find_index_in_order($input_array, $item)
{
    if (sizeof($input_array) == 0) {
        return 0;
    }
    $index = 0;
    for ($x = 0; $x < sizeof($input_array); $x++) {
        $index_distance = $input_array[$x]->{'distance'};
        if ($index_distance < $item) {
            $index++;
        } else {
            break;
        }
    }
    return $index;
}

//Simply count the days between 2 unix time stamps
function days_between($first, $second)
{
    $date_diff = $second - $first;
    return floor($date_diff / (60 * 60 * 24));
}

//Check if a value is out of bounds
function out_of_bounds($val, $min, $max)
{
    if ($val < $min || $val > $max) {
        return true;
    } else {
        return false;
    }
}

//Check if a string matches a Regular Expression
function illegal_characters($re, $string)
{
    $matches = null;
    preg_match($re, $string, $matches);
    if (!empty($matches)) {
        return true;
    }
}
