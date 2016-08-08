@extends('layouts.app')

@section('title', 'dashboard')

@section('content')
<h2 align="center">Hello, {{ Auth::user()->role_id == 1 ? 'Admin' : 'User' }}</h2>
<div class="container">
    <div class="col-sm-offset-3 col-sm-5">
        <div class="panel panel-default">
            <div class="panel-body">
                @if(session('access'))
                <div class="alert alert-danger">
                    {{ session('access') }}
                </div>
                @endif
                <ol>
                    @if(Auth::user()->role_id == 1)
                       <li><a class="btn btn-primary col-xs-4" href="{{ url('datatables') }}">User Status</a></li>
                       <br>
                       <li><a class="btn btn-info col-xs-4" href="{{ url('list') }}">User</a></li>
                       <br>
                       <li><a class="btn btn-danger col-xs-4" href="{{ url('newUser') }}">Add New User</a></li>
                       <br>
                       <li><a class="btn btn-success col-xs-4" href="{{ url('panel') }}">Admin Panel</a></li>
                    @else
                       <li><a class="btn btn-primary col-xs-4" href="{{ url('datatables') }}">User Status</a></li>
                       <br>
                       <li><a class="btn btn-info col-xs-4" href="{{ url('list') }}">User</a></li>
                       <br>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection