@extends('layouts.app')

@section('content')
	@unless (empty($people))
		There are some people.
	@endunless

	@foreach($people as $person)
		<li>{{ $person }}</li>
	@endforeach
@stop