@extends('layouts.app')

@section('title', 'Reset Password')

@section('page')
<a href="{{ url('/login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a>
@endsection

@section('content')
<div class="container">
    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Reset Password</div>
            <div class="panel-body">
                {!! Form::open(array('url' => route('updatepassword'), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'login')) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-7">
                        {{ Form::email('email', null, array('class'=>'form-control')) }}
                    </div>
                </div>
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-7">
                        {{ Form::password('password', array('class'=>'form-control', 'id'=>'Password')) }}
                    </div>
                </div>
                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="cpassword" class="col-sm-4 control-label">Confirm Password</label>
                    <div class="col-sm-7">
                        {{ Form::password('cpassword', array('class'=>'form-control', 'id'=>'CPassword')) }}
                    </div>
                </div>
                <!-- Add Task Button -->
                <div class="form-group">
                    <div class="col-sm-offset-5 col-sm-6">
                        <button type="submit" class="btn btn-primary">
                        Reset Password
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection