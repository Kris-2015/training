@extends('layouts.app')

@section('title', 'Simple Map')

@section('css')
<style type="text/css">
    html, body{
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #map{
        height: 50%;
        width: 50%;
    }
</style>
@endsection

@section('content')

<h3>Location of {{ $residence[0]['first_name'] }} {{ $residence[0]['last_name'] }}</h3>
    
<input type="hidden" id="residence" value="{{ $residence[0]['street'] }},
    {{ $residence[0]['city'] }}, {{ $residence[0]['state'] }}, India">

<input type="hidden" id="office" value="{{ $office[0]['office_street'] }},
  {{ $office[0]['office_city'] }}, {{ $office[0]['office_state']}}">

<input type="hidden" id="usersName" value="{{ $residence[0]['first_name'] }}
    {{ $residence[0]['last_name'] }} }}">

<input type="hidden" id="empId" value="{{ $resdence[0]['userId'] }}">

<div id="map"></div>
<script type="text/javascript">
    function initMap() {
        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(28.543455, 77.217685);
        var mapOption = {
            zoom: 6,
            center: latlng
        }
       var map = new google.maps.Map(document.getElementById('map'), mapOption);
       geocodeAddress(geocoder, map);
    }

    function geocodeAddress(geocoder, resultsMap) {
       var id = $('#users').val();

       $.ajax({
        url:'map?user='+id,
        data:{
            user: id,
        },
        success: function(response){
            var res = $('#residence').val();
            var off = $("#office").val();
            console.log(res);
            console.log(off);
            var contentString = '<div id="content">'+
                '<div id="siteNotice">'+
                '</div>'+
                '<h1 id="firstHeading" class="firstHeading">'+id+'</h1>';
            var address = [res, off];
            for(var i=0; i<address.length; i++)
            {
               geocoder.geocode( {'address' : address[i]}, function(results, status) {
                    if(status === 'OK'){
                        resultsMap.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location,
                            title: "hello dear"
                        });
                    }
                    else{
                        console.log('Geocode was not successful for the following reason: ' + status);
                    }
               });
            }
        }
       });
    }
</script>
@endsection

@section('js-css')
<script  async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API') }}&callback=initMap"></script>
@endsection