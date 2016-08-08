@extends('layouts.app')

@section('title', 'Reset Password')

@section('page')
<a href="{{ url('/login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a>
@endsection

@section('content')
<div class="container">
    <div class="col-sm-offset-3 col-sm-5">
        <div class="panel panel-default">
            <div class="panel-heading">Reset Password</div>
            <div class="panel-body">
                {!! Form::open(array('url' => route('resetPassword'), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'login')) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-8">
                        {{ Form::email('email', null, array('class'=>'form-control')) }}
                    </div>
                </div>
                <!-- Add Task Button -->
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6">
                        <button type="submit" class="btn btn-primary">
                        Send Password Reset Link
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection