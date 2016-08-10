@extends('layouts.email')

@section('content')
<h4 align="center">Welcome to Laravel Training </h4>
<p>Click on <a href="{{ url('/activation',$key) }}">{{ url($key) }}</a> to activate your account</p>
@endsection