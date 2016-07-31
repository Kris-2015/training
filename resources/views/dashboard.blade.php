@extends('layouts.app')

@section('title', 'dashboard')

@section('page')
<a href="/register"><span class="glyphicon glyphicon-user"></span>Registration</a>
@endsection

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">

                <h2 align="center">Hello, User</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
