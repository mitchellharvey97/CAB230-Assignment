<?php

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
    $return_object = array();

    for ($x = 0; $x < sizeof($input); $x++) {
        if (!duplicate_entry($return_object, $key, $input[$x]->{"$key"}, $x)) {

            $place["$key"] = $input[$x]->{"$key"};
            array_push($return_object, $place);
        }
    }
    return $return_object;
}

function duplicate_entry($input, $key, $item, $index)
{
    if ($index == 0) {
        return false;
    }
    for ($x = 0; $x < sizeof($input); $x++) {

        if ($x != $index && $item == $input[$x][$key]) {
            return true;
        }
    }
    return false;
}


//Sort an array with a specified max value (Used for locations within x km of person)
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
function insertArrayIndex($array, $new_element, $index)
{
    $start = array_slice($array, 0, $index);
    $end = array_slice($array, $index);
    $start[] = $new_element;
    return array_merge($start, $end);
}


function find_distance($lat1, $lon1, $lat2, $lon2)
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $km = $dist * 60 * 1.1515 * 1.609344;
    return round($km, 2, PHP_ROUND_HALF_UP);;
}