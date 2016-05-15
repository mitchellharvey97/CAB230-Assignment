var place_names;
var parent;



function initialize_suggestions(place_source, parent_id){
	parent = document.getElementById(parent_id);
	get_place_names(place_source)
	
}



function get_place_names(place_source) {
    //The Function to retrieve place names from the specified file location
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            place_names = JSON.parse(xhttp.responseText)
            if (place_names.length > 0) {
                console.log("Place Names Retrieved Successfully");
                extract_place_names(place_names);
            }
        }
    };
    xhttp.open("GET", place_source, true);
    xhttp.send();

    //Function to convert json to array
    function extract_place_names(place_names) {
        for (var x in place_names) {
            place_names[x] = place_names[x]['Wifi Hotspot Name'];
        }
    }
}

function user_input(search_bar) {
    //A slightly complex process of getting the text from a passed text box and returning the
    //Top 4 before passing it onto the add suggestion function
    cleanup_suggestions();

    if (search_bar.value) {
        add_suggestions(get_search_results(search_bar.value));
    }

    function get_search_results(search_string) {
        function regex_contains_search(compareTo, value) {
            var regex_contain = new RegExp('.*' + compareTo.toLowerCase() + '.*');
            return regex_contain.test(value.toLowerCase());
        }

        var matches = place_names.filter(function (value) {
            return regex_contains_search(search_string, value)
        });
        //Only return the first 4 (Stop page getting too long)
        matches = matches.splice(0, 4);
        return matches;
    }


    function cleanup_suggestions() {
        var curr_suggestions = document.getElementsByClassName('suggestion_holder')
        if (curr_suggestions[0]) {
            parent.removeChild(curr_suggestions[0]);
        }
    }

    function add_suggestions(top_suggestions) {
        //Create Holder for suggestions - ONLY IF THERE ARE SUGGESTIONS
        if (top_suggestions.length > 0) {
            var suggestion_holder = document.createElement('span');
            suggestion_holder.innerHTML = '<ul class ="suggestion"></li>';
            suggestion_holder.classList.add("suggestion_holder");
            parent.insertBefore(suggestion_holder, search_bar.nextSibling)
            for (x in top_suggestions) {
                add_suggestion_li(suggestion_holder, top_suggestions[x]);
            }
        }
        function add_suggestion_li(parent, text) {
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(text));
            li.onclick = function () {
                suggestion_clicked(li);
            };
            parent.appendChild(li);
        }
    }
}