//Helper function to calculate the distance between point 1 and point 2

function find_distance(lat1, lon1, lat2, lon2) {
    var p = 0.017453292519943295;    // Math.PI / 180
    var c = Math.cos;
    var a = 0.5 - c((lat2 - lat1) * p) / 2 +
        c(lat1 * p) * c(lat2 * p) *
        (1 - c((lon2 - lon1) * p)) / 2;

    return 12742 * Math.asin(Math.sqrt(a)); // 2 * R; R = 6371 km
}

var locations = [];

locations.push([-27.37893, 153.04461]);
locations.push([-27.50942285, 153.0333218]);
locations.push([-27.44394629, 152.9870981]);
locations.push([-27.37396641, 153.0783234]);


var my_location = [-27.5963595, 153.2905616]


for (x in locations) {
    var dist = find_distance(my_location[0], my_location[1], locations[x][0], locations[x][1]);
    console.log("Distance to point " + x + " is " + dist);
}