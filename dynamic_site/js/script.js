window.onload = function() {
load_script();
}


var search_bar;



var sample_options = ["Value1", "value2", "Value3", "value11", "A New One", "SomethingRandom", "This Time With Value in Middle"];

console.log(sample_options[0]);




function load_script(){
search_bar = document.getElementById("search_value");

//Add the keyup event to get the value;
search_bar.onkeyup = function() {user_input()};

}

function user_input(){
	report_search_value();
	
}


function report_search_value(){


	console.log("Value is: " + search_bar.value)
	

	var current_regex = new RegExp(/(.*val.*)/gi);

	
	matching_results = get_search_results(search_bar.value)
	
	console.log(matching_results);
	
}



function get_search_results(search_string){
var matches = sample_options.filter( function(value){ return regex_contains_search(search_string, value )});
 return matches;		
}

function regex_contains_search(compareTo, value ){
    var regex_contain = new RegExp('.*' + compareTo.toLowerCase() + '.*');
    return regex_contain.test(value.toLowerCase());
}

