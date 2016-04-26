window.onload = function() {
test_database_connection()
load_script();
}




//test_database_connection()

function test_database_connection(){
	
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      console.log(xhttp.responseText);
    }
  };
  xhttp.open("GET", "http://cab230.local/common_files/database_api.php?q=all_names", true);
  xhttp.send();
  
  
  
	
}




var search_bar;

var parent;

var sample_options = ["Value1", "value2", "Value3", "value11", "A New One", "SomethingRandom", "This Time With Value in Middle"];


function load_script(){
search_bar = document.getElementById("search_value");
    parent = document.getElementById("main_search");
//Add the keyup event to get the value;
search_bar.onkeyup = function() {user_input()};

}

function user_input(){
	//A slightly complex process of getting the text from a passed text box and returning the
	//Top 4 before passing it onto the add suggestion function
	cleanup_suggestions();
	
	if (search_bar.value){
	add_suggestions(get_search_results(search_bar.value));
	}
}

function cleanup_suggestions(){
	var curr_suggestions = document.getElementsByClassName('suggestion_holder')
		if (curr_suggestions[0]){
			parent.removeChild(curr_suggestions[0]);
	}	
}

function add_suggestions(top_suggestions){
		console.log(top_suggestions);

	
	//Create Holder for suggestions
	var suggestion_holder = document.createElement('span');
	suggestion_holder.innerHTML = '<ul class ="suggestion"></li>';	
	suggestion_holder.classList.add("suggestion_holder");
	parent.insertBefore(suggestion_holder, search_bar.nextSibling)
	

	
	for (x in top_suggestions){
	add_suggestion_li(suggestion_holder, top_suggestions[x]);
	}
	
	
}

function add_suggestion_li(parent, text){
		var li = document.createElement("li");
  li.appendChild(document.createTextNode(text));
  parent.appendChild(li);
	
}

function get_search_results(search_string){
var matches = sample_options.filter( function(value){ return regex_contains_search(search_string, value )});
 //Only return the first 4 (Stop page getting too long)
 matches = matches.splice(0,4);
 return matches;		
}

function regex_contains_search(compareTo, value ){
    var regex_contain = new RegExp('.*' + compareTo.toLowerCase() + '.*');
    return regex_contain.test(value.toLowerCase());
}

