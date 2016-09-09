@extends('layouts.app')

@section('title', 'Registration')

@section('page')
<a href="{{ url('/login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a>
@endsection

@section('content')
<div class="container">
    <div class="col-sm-offset-1 col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                Registration
            </div>
            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')
                <!-- New Task Form -->
                @if(session('new'))
                    <div class="alert alert-info">
                        {{ session('new') }}
                    </div>
                @endif
                @if(session('problem'))
                <div class="alert alert-danger">
                    {{ session('problem') }}
                </div>
                @endif

                {!! Form::open(array('url' => route($route), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'registration', 'files' => 'true')) !!}
                {{ csrf_field() }}
                {{ Form::hidden('id', $users_info[0]['userId']) }}
               
                <!-- Task Name -->
                <div class="form-group">
                    {{ Form::label('firstname', 'First Name', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::text('firstname', $users_info[0]['first_name'], array('class'=>'form-control text_alpha','placeholder'=>'First Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('middlename', 'Middle Name', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::text('middlename', $users_info[0]['middle_name'], array('class'=>'form-control text_alpha','placeholder'=>'Middle Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('lastname', 'Last Name', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::text('lastname', $users_info[0]['last_name'], array('class'=>'form-control text_alpha', 'placeholder'=>'Last Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('prefix', 'Prefix', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::radio('prefix', 'Mr','selected') }}Mr
                        {{ Form::radio('prefix', 'Mrs') }}Mrs
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('gender', 'Gender', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::radio('gender', 'Male','selected') }}Male
                        {{ Form::radio('gender', 'Female') }}Female
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('dob', 'DOB', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::date('dob', $users_info[0]['dob'], array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('marital_status', 'Marital Status', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::radio('marital_status', 'Single','selected') }}Single
                        {{ Form::radio('marital_status', 'Married') }}Married
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Employment</label>
                    <div class="col-sm-6">
                        {{ Form::radio('employment', 'Employed','selected') }}Employed
                        {{ Form::radio('employment', 'Unemployed') }}Unemployed
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('employer', 'Employer', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::text('employer', $users_info[0]['employer'], array('class'=>'form-control text_alpha','placeholder'=>'Employer')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('email', $users_info[0]['email'], array('class'=>'form-control', 'id'=>'email','placeholder'=>'xyz@gmail.com')) }}
                    </div>
                    <div class="col-sm-3">
                        <p class="error" id="email_error"></p>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('githubid', 'Github', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::text('githubid', $users_info[0]['github_id'], array('class'=>'form-control','placeholder'=>'Github Id')) }}
                    </div>
                </div>
                @if ( !Auth::check())
                <div class="form-group password">
                    {{ Form::label('password', 'Password', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::password('password', array('class'=>'form-control', 'id'=>'Password', 'placeholder'=>'****')) }}
                    </div>
                </div>
                <div class="form-group confirm-password">
                    {{ Form::label('cpassword', 'Confirm Password', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::password('cpassword',array('class'=>'form-control', 'id'=>'cpassword','placeholder'=>'****')) }}
                    </div>
                </div>                                    
                @endif

                <div class="form-group">
                    {{ Form::label('image', 'Image Upload', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-6">
                        {{ Form::file('image') }}
                    </div>
                </div>
                <!-- Address -->
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">Address</div>
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <h2><u>RESIDENCE ADDRESS</u></h2>
                                <div class="form-group">
                                    {{ Form::label('homestreet', 'Street:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::text('homestreet', $users_info[0]['street'], array('class'=>'form-control','placeholder'=>'Street', 'maxlength'=>'30')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('homecity', 'City:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::text('homecity', $users_info[0]['city'], array('class'=>'form-control','placeholder'=>'City','maxlength'=>'20')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('homestate', 'State:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::select('homestate', $state_list, $users_info[0]['state'], ['class'=>'form-control'])  }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('homezip', 'Zip:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::number('homezip', $users_info[0]['zip'], array('class'=>'form-control','placeholder'=>'Zip', 'maxlength'=>'10')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('homemobile', 'Mobile:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::number('homemobile', $users_info[0]['mobile'], array('class'=>'form-control','placeholder'=>'Mobile', 'maxlength'=>'10')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('homelandline', 'Landline:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::number('homelandline', $users_info[0]['landline'], array('class'=>'form-control','placeholder'=>'Landline', 'maxlength'=>'10')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('homefax', 'Fax:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::number('homefax', $users_info[0]['fax'], array('class'=>'form-control','placeholder'=>'Fax', 'maxlength'=>'10')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h2><u>OFFICIAL ADDRESS</u></h2>
                                <div class="form-group">
                                    {{ Form::label('officestreet', 'Street:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::text('officestreet', $users_info[0]['office_street'], array('class'=>'form-control','placeholder'=>'Street','maxlength'=>'30')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('officecity', 'City:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::text('officecity', $users_info[0]['office_city'], array('class'=>'form-control','placeholder'=>'City','maxlength'=>'20')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('officestate', 'State:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::select('officestate', $state_list, $users_info[0]['office_state'], ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('officezip', 'Zip:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::number('officezip', $users_info[0]['office_zip'], array('class'=>'form-control', 'placeholder'=>'Zip','maxlength'=>'10')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('officemobile', 'Mobile:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::number('officemobile', $users_info[0]['office_mobile'], array('class'=>'form-control', 'placeholder'=>'Mobile','maxlength'=>'10')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('officelandline', 'Landline:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::number('officelandline', $users_info[0]['office_landline'], array('class'=>'form-control', 'placeholder'=>'Landline','maxlength'=>'10')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('officefax', 'Fax:', array('class' => 'control-label col-sm-2')) }}
                                    <div class="col-xs-8">
                                        {{ Form::number('officefax', $users_info[0]['office_fax'], array('class'=>'form-control', 'placeholder'=>'Fax','maxlength'=>'10')) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Extra Note and Communication -->
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">OTHER DETAILS</div>
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('extra', 'Extra Note:', array('class' => 'control-label col-sm-3')) }}
                                <div class="col-xs-9">
                                    {{ Form::textarea('comment', null, array('class'=>'form-control', 'id'=> 'comment' ,'rows'=>'5')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" for="comm">Preferred Communication:</label>
                                <div class="col-xs-8">
                                    <label class="checkbox-inline">{{ Form::checkbox('communication[]', 'mobile','checked') }}Mobile</label>
                                    <label class="checkbox-inline">{{ Form::checkbox('communication[]', 'email') }}Email</label>
                                    <label class="checkbox-inline">{{ Form::checkbox('communication[]', 'sms') }}SMS</label>
                                    <label class="checkbox-inline">{{ Form::checkbox('communication[]', 'others') }}Others</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Task Button -->
                <div class="form-group">
                    <div class="col-sm-offset-5 col-sm-6">
                        @if ($route == 'do-update')
                        <button type="submit" class="btn btn-primary btn-lg">
                            Update
                        </button>
                        @else
                        <button type="submit" class="btn btn-primary btn-lg">
                            Register
                        </button>
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection