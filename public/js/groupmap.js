/**
 * Name: GroupMap js  file 
 * Purpose: Mark user as per official address 
 * Package: public/js
 * Created On: 2nd Sept, 2016
 * Author: msfi-krishnadev
*/


// Deaclaring global variable
var address = [], id = [], user_name = [], map_data = [] ;
var map, geocoder, latlng;

var groupmap = {

    /*
     * Function which contains all DOM event function
     *
     * @param: void
     * @return: void
    */
    global : function() {
        $(document).on("change", "#pac-input", function() {

            var search_data = $(this).val();
            
            // Check if there is any search query.              
            if ( ! search_data) {
                
                // return empty if there search data is empty
                return;
            } else {
                // Perform search operation
                groupmap.initAutocomplete();
            }
        });

        $(document).on('click', '#user_location', function() {
            $('#user_map').modal();

            try {
                $('#user_map .modal-body').css({
                  'height' : $(window).height() - 180
                });
            } catch (err) {

            }

            groupmap.initMap();
        });
    },
    
    /**
     *Function to initialise the google map
     *
     * @param void
     * @return void
     */
    initMap : function() {

        if (typeof geocoder == 'undefined') {
            //instantiate the Geocoder class
            geocoder = new google.maps.Geocoder();    
        }
        

        //defining the co-ordinate of India
        if (typeof latlng == 'undefined') {
            latlng = new google.maps.LatLng(28.49957, 77.11718);
        }
        
        //map region with zoom level and coorinates
        var mapOption = {
            zoom: 6,
            center: latlng
        }

        //Requesting google map api with map option,then printing the map in div 
        if (typeof map == 'undefined') {
            map = new google.maps.Map(document.getElementById('map_canvas'), mapOption);
        }

        map.setTilt(60);

        //calling the geocodeAddress function with map for printing the marker
        groupmap.geocodeAddress(geocoder, map);
    },

    /**
     *Function for setting up marker and generate info message for user
     *
     * @param geocoder, map
     * @return void
     */
    geocodeAddress : function(geocoder, resultsMap) {

        //json data of page
        var user_data = json_data.data;
        
        $.ajax({
            url: 'datatables',
            success: function(response) {

                //Local Variables
                var i;
                var street, city, state;
                var emp_name;
                var marker;

                // Remove the previously added data
                address = []; 
                id = []; 
                user_name = []; 
                //map_data = []

                //type of address
                var type = "Office";

                // taking an empty array and index for users details
                var contentList = [], currentMarkerRef = 0;

                // Iterating user's address, id and name
                for (var i = 0; i < user_data.length; i++) {
                    street = user_data[i].street;
                    city = user_data[i].city;
                    state = user_data[i].state;

                    address.push( street + ',' + city + ',' + state + ',India' );
                    id.push( json_data.data[i].id );
                    user_name.push( json_data.data[i].first_name + ' ' + json_data.data[i].last_name );
                }

                map_data = { "User_Id" : id, "Address" : address, "User_Name" : user_name };
              
                // Iterating to add user details in array
                for (var j = 0; j < address.length; j++) {
                    contentList.push(
                        '<div id="content">' +
                        '<div id="siteNotice"></div>' +
                        '<h4 id="firstHeading" class="firstHeading">' + user_name[j] + '</h4>' +
                        '<div class="bodyContent">' +
                        '<p> <strong>EID: </strong>' + id[j] + '<br>' +
                        '<strong>' + type + ': </strong>' + address[j] + '</p>' +
                        '</div>' +
                        '</div>'
                    );
                }
                
                // Instantiate the infowindow object
                var infowindow = new google.maps.InfoWindow(), marker, k;

                // Iteration to mark user based on address
                for (var k = 0; k < map_data.Address.length; k++) {

                    geocoder.geocode({
                        'address': map_data.Address[k]
                    }, function(results, status) {

                        // checking whether status code is OK or not 
                        if (status === 'OK') {
                            resultsMap.setCenter(results[0].geometry.location);
                            
                            // Put the marker on the respective location
                            var marker = new google.maps.Marker({
                                map: resultsMap,
                                position: results[0].geometry.location,
                                title: map_data.User_Name[currentMarkerRef]
                            });

                            // Bind event for on clicking the marker to show user details
                            google.maps.event.addListener( marker, 'click',( function(marker, k, currentMarkerRef, contentList) {
                                return function() {
                                    infowindow.setContent(contentList[currentMarkerRef]);
                                    infowindow.open(map, marker);
                                }
                            }) (marker, k, currentMarkerRef, contentList));

                            // Increment the index of next user details
                            currentMarkerRef++;
                        } else {
                           console.log('Geocode was not successful for the following reason: ' + status);
                        }
                    });
                }
            }
       });
    },

    /**
     *Function for searching
     *
     * @param search data
     * @return void
     */
    initAutocomplete: function() {


        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
    }
};

groupmap.global();