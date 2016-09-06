/**
 * Name: GroupMap js  file 
 * Purpose: Mark user as per official address 
 * Package: public/js
 * Created On: 2nd Sept, 2016
 * Author: msfi-krishnadev
*/


// Deaclaring global variable
var address = [], id = [], user_name = [], map_data = [] ;
var map, geocoder;

groupmap = {

    /**
     *Function to call modal with map
     *
     * @param void
     * return void
     */
    modal : function() {

        //Jquery event for modal call and initialise the google map
        $(document).off('click').on('click', '#user_location', function() {

            $('#user_map').modal();

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

        //instantiate the Geocoder class
        geocoder = new google.maps.Geocoder();

        //defining the co-ordinate of India
        var latlng = new google.maps.LatLng(28.543455, 77.217685);

        //map region with zoom level and coorinates
        var mapOption = {
           zoom: 6,
           center: latlng
        }

        //Requesting google map api with map option,then printing the map in div 
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOption);
        map.setTilt(45);

        //calling the geocodeAddress function with map for printing the marker
        this.geocodeAddress(geocoder, map);

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
        console.log(user_data);
        $.ajax({
           url: 'datatables',
           success: function(response) {

              //Local Variables
              var i;
              var street, city, state;
              var emp_name;
              var marker;

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

              console.log(map_data);
              
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

              // Iteration to mark user based on address
              for (var k = 0; k < map_data.Address.length; k++) {

                 geocoder.geocode({
                    'address': map_data.Address[k]
                 }, function(results, status) {

                    // checking whether status code is OK or not 
                    if (status === 'OK') {
                       resultsMap.setCenter(results[0].geometry.location);

                       // Put the marker on the respective location
                       marker = new google.maps.Marker({
                          map: resultsMap,
                          position: results[0].geometry.location,
                          title: map_data.User_Name[currentMarkerRef]
                       });

                       // Put infowindow on the respective marker
                       var infowindow = new google.maps.InfoWindow({
                          content: contentList[currentMarkerRef]
                       }), marker, k;

                       // Bind event for on clicking the marker to show user details
                       marker.addListener('click', function() {
                          infowindow.open(map, marker);
                       });

                       // Increment the index of next user details
                       currentMarkerRef++;
                    } else {
                       console.log('Geocode was not successful for the following reason: ' + status);
                    }
                 });
              }
           }
       });
    }
};

groupmap.modal();