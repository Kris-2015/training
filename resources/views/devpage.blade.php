@extends('layouts.app')

@section('title', 'Developers Information')

@section('page')
<a href="{{ url('/developers') }}"><span class="glyphicon glyphicon-log-in"></span> Developers</a>
@endsection

@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Developers Account
            </div>

            <div class="panel-body">
            
            <!-- Developer Form -->
            {!! Form::open(array('class' => 'form-horizontal','id'=>'developer')) !!}  

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- Request App URL -->
                <div class="form-group">
                    <label for="app_uri" class="col-sm-3 control-label">Redirect URL: </label>
                    <div class="col-sm-6">
                        {{ Form::text('app_url', $data['redirect_url'], array('class'=>'form-control', 'readonly')) }}
                    </div>
                </div>

                <!-- Client ID Input Field -->
                <div class="form-group">
                    <label for="client_id" class="col-sm-3 control-label">Client ID: </label>
                    <div class="col-sm-6">
                        {{ Form::text('client_id', $data['client id'], array('class'=>'form-control', 'readonly')) }}
                    </div>
                </div>

                <!-- Client Secret ID Input Field -->
                <div class="form-group">
                    <label for="secret" class="col-sm-3 control-label">Client Secret: </label>
                    <div class="col-sm-6">
                        {{ Form::text('secret', $data['secret_id'], array('class'=>'form-control', 'readonly')) }}
                    </div>
                </div>

            {!! Form::close() !!}    
            </div>
        </div>
    </div>
@endsection