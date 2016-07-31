@extends('layouts.email')

@section('content')
<h4 align="center">Welcome to Laravel Training </h4>
<p>Click on <a href="http://laravel.local.com/activation/{{ $key }}">http://laravel.local.com/activation/{{ $key }}</a> to activate your account</p>
@endsection