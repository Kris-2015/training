@extends('layouts.email')

@section('content')
<h4 align="center">Welcome to Laravel Training </h4>
<p>Click on <a href="{{ url('/reset',$key) }}">{{ $key }}</a> to change your password</p>{{ url('/reset',$key) }}
@endsection