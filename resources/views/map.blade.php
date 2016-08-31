@extends('layouts.app')

@section('title', 'Simple Map')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('css/map.css') }}">
@endsection

@section('content')
<h3>Location of {{ $office[0]['first_name'] }} {{ $office[0]['last_name'] }}</h3>

<input type="hidden" id="office" value="{{ $office[0]['street'] }},
    {{ $office[0]['city'] }}, {{ $office[0]['state'] }}, India">

<input type="hidden" id="residence" value="{{ $residence[0]['residence_street'] }},
  {{ $residence[0]['residence_city'] }}, {{ $residence[0]['residence_state']}}">

<input type="hidden" id="usersName" value="{{ $office[0]['first_name'] }}
    {{ $office[0]['last_name'] }}">

<input type="hidden" id="empId" value="{{ $office[0]['userId'] }}">

<div id="map"></div>
@endsection

@section('js-css')
<script  async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API') }}&callback=initMap"></script>
<script type="text/javascript" src="{{ url('js/map.js') }}"></script> 
@endsection