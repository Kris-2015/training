@extends('layouts.app')

@section('title', 'Developers')

@section('page')
<a href="{{ url('/developers') }}"><span class="glyphicon glyphicon-log-in"></span> Developers</a>
@endsection

@section('content')
    <div class="col-sm-offset-2 col-sm-8">

        <!-- Show the error message -->
         @if(session('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
        @endif

        <!-- Developer Page infomation -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Developers Account
            </div>

            <div class="panel-body">

            <!-- Developer Form -->
            {!! Form::open(array('url' => route('new-client'), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'developer')) !!}  

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- Request App URL -->
                <div class="form-group">
                    <label for="app_uri" class="col-sm-3 control-label">Redirect URL: </label>
                    <div class="col-sm-6">
                        {{ Form::text('app_url', null, array('class'=>'form-control', 'id'=>'app_url')) }}
                    </div>
                </div>

                <!-- For registered User -->
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('email', null, array('class'=>'form-control')) }}
                    </div>
                </div>

                <!-- Add Task Button -->
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            Get Registered
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}    
            </div>
        </div>
    </div>
@endsection