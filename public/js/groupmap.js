var address = [];
var id = [];
var user_name = [];
var map;

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

    //defining the cooridnate of India
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

/*function getData(){
    console.log(json.data);
    return json.data;
}*/

function geocodeAddress(geocoder, resultsMap) {

    
    var user_data = json.data;

    $.ajax({
       url: 'datatables',
       data: {
          user: id,
       },
       success: function(response) {

          
          var i;
          var street, city, state;
          var emp_name;
          var marker;

          for (var i = 0; i < user_data.length; i++) {
             street = json.data[i].street;
             city = json.data[i].city;
             state = json.data[i].state;

             address.push( street + ',' + city + ',' + state + ',India' );
             id.push( json.data[i].id );
             user_name.push( json.data[i].first_name + ' ' + json.data[i].last_name );
          }

          //type of address
          var type = "Office";

          var contentList = [],
             currentMarkerRef = 0;

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

          for (var k = 0; k < address.length; k++) {

             geocoder.geocode({
                'address': address[k]
             }, function(results, status) {
                if (status === 'OK') {
                   resultsMap.setCenter(results[0].geometry.location);

                   var infowindow = new google.maps.InfoWindow({
                      content: contentList[currentMarkerRef]
                   });

                   marker = new google.maps.Marker({
                      map: resultsMap,
                      position: results[0].geometry.location,
                      title: user_name[k]
                   });

                   marker.addListener('click', function() {
                      infowindow.open(map, marker);
                   });

                   currentMarkerRef++;
                } else {
                   console.log('Geocode was not successful for the following reason: ' + status);
                }
             });
          }
       }
   });
}