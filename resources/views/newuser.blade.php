@extends('layouts.app')

@section('title', 'New User')

@section('content')
<div class="container">
    <div class="col-sm-offset-1 col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                Add User
            </div>
            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')
                <!-- New Task Form -->
                {!! Form::open(array('url' => route('add_user'), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'registration', 'files' => 'true')) !!}
                {{ csrf_field() }}
                
                <div class="form-group">
                    {{ Form::label('firstname', 'First Name', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::text('firstname', null , array('class'=>'form-control text_alpha','placeholder'=>'First Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('lastname', 'Last Name', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::text('lastname', null, array('class'=>'form-control text_alpha', 'placeholder'=>'Last Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('email', null, array('class'=>'form-control', 'id'=>'email','placeholder'=>'xyz@gmail.com')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('password', 'Password', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::password('password', array('class'=>'form-control', 'id'=>'Password', 'placeholder'=>'****')) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-5 col-sm-6">
                        <button type="submit" class="btn btn-primary btn-lg">
                        Add 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection