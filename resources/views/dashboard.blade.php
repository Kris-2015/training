@extends('layouts.app')

@section('title', 'dashboard')

@section('page')
<a href="/register"><span class="glyphicon glyphicon-user"></span>Registration</a>
@endsection

@section('content')
	<h2 align="center">Hello, {{ Auth::user()->role_id == 1 ? 'Admin' : 'User' }}</h2>

    <div class="container">
        <div class="col-sm-offset-3 col-sm-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <ol>
                      @if(Auth::user()->role_id == 1)
                       <li><a class="btn btn-primary" href="{{ url('datatables') }}">User Status</a></li><br>
                       <li><a class="btn btn-info" href="{{ url('list') }}">User</a></li><br>
                       <li><a class="btn btn-danger" href="{{ url('register') }}">Add New User</a></li>
                     @else
                      <li><a class="btn btn-primary" href="{{ url('datatables') }}">User Status</a></li><br>
                      <li><a class="btn btn-info" href="{{ url('list') }}">User</a></li><br>
                     @endif
                    </ol>            
                </div>
            </div>
        </div>
    </div>
@endsection
