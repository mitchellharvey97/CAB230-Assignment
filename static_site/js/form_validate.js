var first_run = true;
var parent;


function validate_submission() {
    //Parent is the holder ID of the form
    parent = document.getElementById("main_form");

    console.log("Validating form")

    if (first_run) {
        first_run = false;
    }
    else {
        remove_error();
    }

    var mandatory_fields = [];
//Push Items to the array to enforce mandatory requirements
    mandatory_fields.push(["First name", "name"]);
    mandatory_fields.push(["Surname", "surname"]);
    mandatory_fields.push(["Email Address", "email_address"]);
	
	
    mandatory_fields.push(["Password", "password1"]);
    mandatory_fields.push(["Password", "password2"]);

    var error = false;
    for (var x = 0; x < mandatory_fields.length; x++) {
        if (!check_field(mandatory_fields[x][0], mandatory_fields[x][1])) {
			error = true;
        }
    }

    if (!check_password_match("password1", "password2")) {
        error = true;
    }

    if (error) {
        console.log("There is an error in the page");
		//window.location.href = "index.html";
    } else {
        console.log("All Systems GO, fire that nuke");
		window.location.href = "index.html";
    }
	
	
	
	
}

function check_password_match(field1, field2) {
    var pass1 = document.getElementById(field1);
    var pass2 = document.getElementById(field2);
    if (pass1.value == pass2.value) {
        console.log("Passwords the same");
		return true;
    }
    else {
        console.log("Passwords don't match");
        add_error("Passwords don't match", pass2);
    return false;
	}
}

function add_error(error_code, element_error) {

    var error_span = document.createElement('span');
    error_span.innerHTML = error_code;
    error_span.classList.add("error");
    parent.insertBefore(error_span, element_error.nextSibling)
}


function get_error() {
    var cur_error = document.getElementsByClassName('error');
    if (cur_error.length > 0) {
        return cur_error;
    }
    return false;
}

function remove_error() {
    while (get_error()) {
        parent.removeChild(get_error()[0])
    }
}

function check_field(name, field_name) {
    var field = document.getElementById(field_name);

var field_id = field.id;

    if (!field.value) {//Every Checked Field is mandatory
        add_error(name + " must not be blank", field)
        return false;
    }
	

if (field_id == "name" || field_id == "surname"){
	
	    var regex_email_collection = new RegExp(/([0-9\*]+)/gi)
        var provided_value = field.value;
        var results_array;
        var result_found = false;
        while ((results_array = regex_email_collection.exec(provided_value)) != null)
            result_found = true;

        if (result_found) {
            add_error("Please provide a valid Name", field)
        }
	
}

	

    if (field.type == "email") {
        var regex_email_collection = new RegExp(/(.+@.+)/gi)
        var provided_value = field.value;
        var results_array;
        var result_found = false;
        while ((results_array = regex_email_collection.exec(provided_value)) != null)
            result_found = true;

        if (!result_found) {
            add_error("Please provide a valid email address", field)
        }
    }

    return true; //If there are no errors, return true
}