//Define Global Variables for easy access
var place_names = [];
var search_bar;
var parent;
var radio_buttons = [];
var text_box_search;
var rating_search;
var location_search;

//Load Scripts before the window is loaded
document.onload = function(){
	add_external_scripts();
	extra_file();
}

//On the window Load - after the Document Has been loaded and external scripts are included
window.onload = function() {
console.log("Script Loaded")

add_page_events();
parent = document.getElementById("main_search");
get_place_names() //Populate place name array for future use
}


function add_external_scripts(){
	console.log("Adding External");
	var js = document.createElement("script");

js.type = "text/javascript";
js.src = "js/suggestion.js";

document.body.appendChild(js);
}

function add_page_events(){

//Define the Global variables
text_box_search = document.getElementById("text_search");
rating_search = document.getElementById("rating_search");
location_search = document.getElementById("geo_location_search");

search_bar = document.getElementById("search_value");
radio_buttons.push(document.getElementById("search_by_name"));
radio_buttons.push(document.getElementById("search_by_suburb"));

//Add the events
search_bar.onkeyup = function() {user_input()};
text_box_search.onclick = function() {search_button_clicked("text_search")};
rating_search.onclick = function() {search_button_clicked("rating_search")};
location_search.onclick = function() {search_button_clicked("geo_location_search")};	
}

function search_button_clicked(source){
	//If the user clicks on a place name then they can skip the results page and go straight to the item page

	
	//if the user searches via the search bar
	if (source == "suggestion" || source == "text_search"){
	var search_value = search_bar.value;
		if (radio_buttons[0].checked){
			if (source == "suggestion"){
				//GO straight to results
				
			}
			else{
			//Searching By Name
			search_value  = "Name - " + search_value;
			}
		}
		else{
			search_value  = "Suburb - " + search_value;
		}
	}
	else if (source == "rating_search"){
		//Searching By Rating
		var rating = document.querySelector('input[name = "enterRating"]:checked').value;
		console.log(rating);
		search_value = "Rating Search: " + rating;
	}
	else if (source == "geo_location_search"){		
		search_value = "Geo Location Search";
	}
	
	
	alert(search_value);
	
}

function suggestion_clicked(suggestion){
search_bar.value = suggestion.innerHTML;
search_button_clicked("suggestion");
}


function get_place_names(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      //console.log(xhttp.responseText);
	  place_names = JSON.parse(xhttp.responseText)
	  if (place_names.length > 0){console.log("Place Names Retrieved Successfully");
	  extract_place_names();
	  }
    }
  };
  xhttp.open("GET", "common_files/database_api.php?q=all_names", true);
  xhttp.send();
}

//Function to convert json to array
function extract_place_names(){
	for (x in place_names){
		place_names[x] = place_names[x]['Wifi Hotspot Name'];
	}
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
	//Create Holder for suggestions - ONLY IF THERE ARE SUGGESTIONS
	if (top_suggestions.length > 0){
		var suggestion_holder = document.createElement('span');
		suggestion_holder.innerHTML = '<ul class ="suggestion"></li>';	
		suggestion_holder.classList.add("suggestion_holder");
		parent.insertBefore(suggestion_holder, search_bar.nextSibling)
		for (x in top_suggestions){
			add_suggestion_li(suggestion_holder, top_suggestions[x]);
		}
	}
}

function add_suggestion_li(parent, text){
		var li = document.createElement("li");
  li.appendChild(document.createTextNode(text));
  li.onclick = function () {
    suggestion_clicked(li);
};
  parent.appendChild(li);
	}

function get_search_results(search_string){
var matches = place_names.filter( function(value){ return regex_contains_search(search_string, value )});
 //Only return the first 4 (Stop page getting too long)
 matches = matches.splice(0,4);
 return matches;		
}

function regex_contains_search(compareTo, value ){
    var regex_contain = new RegExp('.*' + compareTo.toLowerCase() + '.*');
    return regex_contain.test(value.toLowerCase());
}

