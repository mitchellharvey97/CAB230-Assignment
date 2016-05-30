function display_map(locations, map_id) {
    //console.log(locations);

    //Script adapted from http://chrisltd.com/blog/2013/08/google-map-random-color-pins/
    //The script has been tweaked to enable the map locations to become clickable objects

    // Setup the different icons and shadows
    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    //Sourcing the icons from google's server
    var icons = [
        iconURLPrefix + 'red-dot.png',
        iconURLPrefix + 'green-dot.png',
        iconURLPrefix + 'blue-dot.png',
        iconURLPrefix + 'ltblue-dot.png',
        iconURLPrefix + 'orange-dot.png',
        iconURLPrefix + 'purple-dot.png',
        iconURLPrefix + 'pink-dot.png',
        iconURLPrefix + 'yellow-dot.png'
    ]
    var iconsLength = icons.length;

    //Pretty Standard setting up of maps and default values 
    //Some options such as the Zoom and positioning elements have been removed as the function autoCenter() centers the map for us
    //Also have disable the may type and street view icon to make the page a bit cleaner and remove clutter
    var map = new google.maps.Map(document.getElementById(map_id), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        streetViewControl: false,
        panControl: false
    });

    var info_window = new google.maps.InfoWindow({
        maxWidth: 200
    });

    var markers = new Array();

    var iconCounter = 0;

    // Add the markers and info windows to the map
    for (var i = 0; i < locations.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: icons[iconCounter],
            zoom: 10
        });

        markers.push(marker);

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                info_window.setContent(locations[i][0]);
                info_window.open(map, marker);
            }
        })(marker, i));

        iconCounter++;
        // We only have a limited number of possible icon colors, so we may have to restart the counter if we have too many
        //Could have used a mod function instead
        if (iconCounter >= iconsLength) {
            iconCounter = 0;
        }
    }

    function autoCenter() {
        //  Create a new viewpoint bound
        var bounds = new google.maps.LatLngBounds();
        //  Go through each...
        for (var i = 0; i < markers.length; i++) {
            bounds.extend(markers[i].position);
        }
        //  Fit these bounds to the map
        //If there is only one location, the auto center code bugs out and zooms too much so hard code zoom values
        if (locations.length == 1) {
            map.setCenter(bounds.getCenter());
            map.setZoom(14);
        }
        else {
            map.fitBounds(bounds);
        }
    }
    autoCenter();
}