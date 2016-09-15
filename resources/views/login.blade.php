@extends('layouts.app')

@section('title', 'Login')

@section('page')
<a href="{{ url('/register') }}"><span class="glyphicon glyphicon-user"></span>Registration</a>
@endsection

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Login
            </div>
            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')
                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                @if(session('warning'))
                <div class="alert alert-danger">
                    {{ session('warning') }}
                </div>
                @endif
                <!-- New Task Form -->
                {!! Form::open(array('url' => route('dologin'), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'login')) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Task Name -->
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('email', null, array('class'=>'form-control')) }}
                    </div>
                </div>
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-6">
                        {{ Form::password('password', array('class'=>'form-control', 'id'=>'Password')) }}
                    </div>
                </div>
                <!-- Add Task Button -->
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-primary">
                        Login
                        </button>
                        <a class="btn btn-link" href="{{ url('/resetPassword') }}">Forgot Your Password?</a>
                    </div>
                </div>

                <hr>
                <p class="col-sm-offset-4">Or Connect with</p>

                <div class="row">
                    
                    <div class=" col-xs-4 col-sm-5">
                        <div  class="col-sm-offset-5">
                        <!-- Instagram Sign Up functionality-->
                            <a href="https://api.instagram.com/oauth/authorize/?client_id={{env('CLIENT_ID') }}&redirect_uri={{ env('REDIRECT_URI', '00') }}&response_type=code&scope=basic" target="_top" class="btn btn-danger">
                                <i class="fa fa-instagram"></i> 
                                Instagram
                            </a>
                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-5">
                        <!-- Facebook Sign Up functionality-->
                        <a href="redirect" class="btn btn-primary">
                            <i class="fa fa-facebook"></i> 
                            Facebook
                        </a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection 
