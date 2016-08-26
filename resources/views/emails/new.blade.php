@extends('layouts.email')

@section('content')
<h4 align="center">Welcome to Laravel Training </h4>
<p> Your account has been created in our website. Your login details are:</p>
<p> Email: {{ $data['email'] }} </p> 
<p> Password: {{ $data['password'] }} </p>
<p> Please change your password after signin. </p>
<p> Click on <a href="{{ url('/reset',$data['activation']) }}">{{ $data['activation'] }}</a> to activate your account.</p>
@endsection