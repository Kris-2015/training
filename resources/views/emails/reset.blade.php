@extends('layouts.email')

@section('content')
<h4 align="center">Welcome to Laravel Training </h4>
<p>Click on <a href="http://laravel.local.com/reset/{{ $key }}">http://laravel.local.com/reset/{{ $key }}</a> to change your password</p>
@endsection