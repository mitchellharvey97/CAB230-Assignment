//Define Global Variables for easy access
var place_names = [];
var search_bar;
var radio_buttons = [];
var text_box_search;
var rating_search;
var location_search;

//On the window Load - after the Document Has been loaded and external scripts are included
window.onload = function () {
    console.log("Script Loaded")
    add_page_events();
    //parent = document.getElementById("main_search");
  	initialize_suggestions("../common_files/database_api.php?q=all_names", "main_search")
}

function add_page_events() {
//Define the Global variables
    text_box_search = document.getElementById("text_search");
    rating_search = document.getElementById("rating_search");
    location_search = document.getElementById("geo_location_search");

    search_bar = document.getElementById("search_value");
    radio_buttons.push(document.getElementById("search_by_name"));
    radio_buttons.push(document.getElementById("search_by_suburb"));

//Add the events
    search_bar.onkeyup = function () {
        user_input(search_bar);
    };
    text_box_search.onclick = function () {
        search_button_clicked("text_search")
    };
    rating_search.onclick = function () {
        search_button_clicked("rating_search")
    };
    location_search.onclick = function () {
        search_button_clicked("geo_location_search")
    };
}

function search_button_clicked(source) {
    //If the user clicks on a place name then they can skip the results page and go straight to the item page

	var search_page_prefix = "results.php?"
var result_query="";
var search_type;

result_page = null;
    //if the user searches via the search bar
    if (source == "suggestion" || source == "text_search") {
        var search_value = search_bar.value;
        if (radio_buttons[0].checked) {
            if (source == "suggestion") {
				
                //GO straight to results
				result_page = "item_page.php/?q=" + search_value
				}
            else {
                //Searching By Name
				search_type = "name";
				result_query = search_value;
                search_value = "Name - " + search_value;
            }
        }
        else {
				search_type = "suburb";
				result_query = search_value;
            search_value = "Suburb - " + search_value;
        }
    }
    else if (source == "rating_search") {
        //Searching By Rating
        var search_value = document.querySelector('input[name = "enterRating"]:checked').value;
				 search_type = "rating";
				result_query = search_value;
        search_value = "Rating Search: " + search_value;
    }
    else if (source == "geo_location_search") {
		 search_type = "geo_location";
        search_value = "Geo Location Search";
    }

	if (result_page != null){
		//if the user hasn't selected a drop down option
		document.location = result_page
	}
	else{
document.location = "results.php?" + "searchtype=" + search_type + "&value=" + result_query;
	}
    alert(search_value);

}

function suggestion_clicked(suggestion) {
    search_bar.value = suggestion.innerHTML;
    search_button_clicked("suggestion");
}



