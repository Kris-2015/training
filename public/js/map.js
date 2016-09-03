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
        zoom: 10,
        center: latlng
        }

        //Requesting google map api with map option,then printing the map in div 
        var map = new google.maps.Map(document.getElementById('map'), mapOption);

        //calling the geocodeAddress function with map for printing the marker
        geocodeAddress(geocoder, map);
    }

    function geocodeAddress(geocoder, resultsMap) {

    // get the employee id 
    var id = $('#empId').val();

        $.ajax({
        url: 'map',
        data: {
           user: id,
        },
        success: function(response) {
           var res = $('#residence').val();
           var off = $('#office').val();
           var user_name = $('#usersName').val();
           var i;

           //type of address
           var type = ["Residence", "Office"];
           var address = [res, off];

           var contentList = [],
              currentMarkerRef = 0;

           for (i = 0; i < address.length; i++) {
              contentList.push(
                 '<div id="content">' +
                 '<div id="siteNotice"></div>' +
                 '<h4 id="firstHeading" class="firstHeading">' + user_name + '</h4>' +
                 '<div class="bodyContent">' +
                 '<p> <strong>EID: </strong>' + id + '<br>' +
                 '<strong>' + type[i] + ': </strong>' + address[i] + '</p>' +
                 '</div>' +
                 '</div>'
              );
           }

           for (i = 0; i < address.length; i++) {

              geocoder.geocode({
                 'address': address[i]
              }, function(results, status) {
                 if (status === 'OK') {
                    resultsMap.setCenter(results[0].geometry.location);

                    var infowindow = new google.maps.InfoWindow({
                       content: contentList[currentMarkerRef]
                    });

                    var marker = new google.maps.Marker({
                       map: resultsMap,
                       position: results[0].geometry.location,
                       title: user_name
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