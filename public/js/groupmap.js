/**
 * Name: GroupMap js  file 
 * Purpose: Mark user as per official address 
 * Package: public/js
 * Created On: 2nd Sept, 2016
 * Author: msfi-krishnadev
*/

// Deaclaring global variable
var address = [];
var id = [];
var user_name = [];
var map;

//Jquery event for modal call and initialise the google map
$(document).off('click').on('click', '#user_location', function() {

    $('#user_map').modal();
    initMap();
});

/**
 *Function to initialise the google map
 *
 * @param void
 * @return void
 */
function initMap() {

    //instantiate the Geocoder class
    var geocoder = new google.maps.Geocoder();

    //defining the co-ordinate of India
    var latlng = new google.maps.LatLng(28.543455, 77.217685);

    //map region with zoom level and coorinates
    var mapOption = {
       zoom: 6,
       center: latlng
    }

    //Requesting google map api with map option,then printing the map in div 
    map = new google.maps.Map(document.getElementById('map_canvas'), mapOption);

    //calling the geocodeAddress function with map for printing the marker
    geocodeAddress(geocoder, map);
}

/**
 *Function for setting up marker and generate info message for user
 *
 * @param geocoder, map
 * @return void
 */
function geocodeAddress(geocoder, resultsMap) {

    //json data of page
    var user_data = json.data;

    $.ajax({
       url: 'datatables',
       data: {
          user: id,
       },
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
             street = json.data[i].street;
             city = json.data[i].city;
             state = json.data[i].state;

             address.push( street + ',' + city + ',' + state + ',India' );
             id.push( json.data[i].id );
             user_name.push( json.data[i].first_name + ' ' + json.data[i].last_name );
          }

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

          // Iteratioin to mark user based on address
          for (var k = 0; k < address.length; k++) {

             geocoder.geocode({
                'address': address[k]
             }, function(results, status) {

                // Search result is successful, mark the user
                if (status === 'OK') {
                   resultsMap.setCenter(results[0].geometry.location);

                   // Instantiate the InfoWindow for user details 
                   var infowindow = new google.maps.InfoWindow({
                      content: contentList[currentMarkerRef]
                   });

                   // Instantiate the Marker class for setting up the marker
                   marker = new google.maps.Marker({
                      map: resultsMap,
                      position: results[0].geometry.location,
                      title: user_name[k]
                   });

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