@extends('layouts.app')

@section('title', 'Registration')

@section('page')
<a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a>
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
                     {!! Form::open(array('url' => route('do-register'), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'registration', 'files' => 'true')) !!}

                        <!-- Task Name -->
                        <div class="form-group">
                            {{ Form::label('firstname', 'First Name', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                {{ Form::text('firstname', null, array('class'=>'form-control','placeholder'=>'First Name')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('middlename', 'Middle Name', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                {{ Form::text('middlename', null, array('class'=>'form-control','placeholder'=>'Middle Name')) }}
                            </div>
                        </div>  
                        <div class="form-group">
                            {{ Form::label('lastname', 'Last Name', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                {{ Form::text('lastname', null, array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('prefix', 'Prefix', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                {{ Form::radio('prefix', 'Mr') }}Mr
                                {{ Form::radio('prefix', 'Mrs') }}Mrs
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('gender', 'Gender', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                {{ Form::radio('gender', 'Male') }}Male
                                {{ Form::radio('gender', 'Female') }}Female
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('dob', 'DOB', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                {{ Form::date('dob', null, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('marital_status', 'Marital Status', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                {{ Form::radio('marital_status', 'Single') }}Single
                                {{ Form::radio('marital_status', 'Married') }}Married
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Employment</label>
                            <div class="col-sm-6">
                                {{ Form::radio('employment', 'Employed') }}Employed
                                {{ Form::radio('employment', 'Unemployed') }}Unemployed
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('employer', 'Employer', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                               <!-- <input type="text" name="employer" id="employer" class="form-control" value="{{ old('name') }}"> -->
                               {{ Form::text('employer', null, array('class'=>'form-control','placeholder'=>'Employer')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                <!-- <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}"> -->
                                {{ Form::email('email', null, array('class'=>'form-control', 'placeholder'=>'xyz@gmail.com')) }}
                            </div>
                        </div>
                        <div class="form-group">
                           {{ Form::label('githubid', 'Github', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                <!-- <input type="text" name="githubid" id="githubid" class="form-control" value="{{ old('email') }}"> -->
                                {{ Form::text('githubid', null, array('class'=>'form-control','placeholder'=>'Github Id')) }}
                            </div>
                        </div>
                        <!--  -->
                        <div class="form-group">
                            {{ Form::label('password', 'Password', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                               <!--  <input type="password" name="password" id="password" class="form-control" value="{{ old('age') }}"> -->
                               {{ Form::password('password', array('class'=>'form-control', 'id'=>'Password', 'placeholder'=>'****')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('cpassword', 'Confirm Password', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-6">
                                {{ Form::password('cpassword',array('class'=>'form-control', 'id'=>'cpassword','placeholder'=>'****')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('image_upload', 'Image Upload', array('class' => 'control-label col-sm-3')) }}
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
                                <!-- <label class="control-label col-xs-2" for="homestreet">Street:</label> -->
                                {{ Form::label('homestreet', 'Street:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    <!-- <input type="text" class="form-control" id="homestreet" name="homestreet" placeholder="Street"> -->
                                    {{ Form::text('homestreet', null, array('class'=>'form-control','placeholder'=>'Street', 'maxlength'=>'30')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('homecity', 'City:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('homecity', null, array('class'=>'form-control','placeholder'=>'City','maxlength'=>'20')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('homestate', 'State:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::select('homestate', $state_list, null, ['class'=>'form-control'])  }}
                                </div>
                            </div>
                            <div class="form-group">     
                                {{ Form::label('homezip', 'Zip:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('homezip', null, array('class'=>'form-control','placeholder'=>'Zip', 'maxlength'=>'10')) }}
                                </div>
                            </div>
                            <div class="form-group">     
                                {{ Form::label('homemobile', 'Mobile:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('homemobile', null, array('class'=>'form-control','placeholder'=>'Mobile', 'maxlength'=>'10')) }}
                                </div>
                            </div>
                            <div class="form-group">     
                                {{ Form::label('homelandline', 'Landline:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('homelandline', null, array('class'=>'form-control','placeholder'=>'Landline', 'maxlength'=>'10')) }}
                                </div>
                            </div>
                            <div class="form-group">     
                                <!-- <label class="control-label col-xs-2" for="homefax">Fax:</label> -->
                                {{ Form::label('homefax', 'Fax:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('homefax', null, array('class'=>'form-control','placeholder'=>'Fax', 'maxlength'=>'10')) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h2><u>OFFICIAL ADDRESS</u></h2>
                            <div class="form-group">
                                <!-- <label class="control-label col-xs-2" for="officestreet">Street:</label> -->
                                {{ Form::label('officestreet', 'Street:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('officestreet', null, array('class'=>'form-control','placeholder'=>'Street','maxlength'=>'30')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('officecity', 'City:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('officecity', null, array('class'=>'form-control','placeholder'=>'City','maxlength'=>'20')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('officestate', 'State:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                   {{ Form::select('officestate', $state_list, null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">     
                                {{ Form::label('officezip', 'Zip:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('officezip', null, array('class'=>'form-control', 'placeholder'=>'Zip','maxlength'=>'10')) }}
                                </div>
                            </div>
                            <div class="form-group">     
                                {{ Form::label('officemobile', 'Mobile:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('officemobile', null, array('class'=>'form-control', 'placeholder'=>'Mobile','maxlength'=>'10')) }}
                                </div>
                            </div>
                            <div class="form-group">     
                                {{ Form::label('officelandline', 'Landline:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('officelandline', null, array('class'=>'form-control', 'placeholder'=>'Landline','maxlength'=>'10')) }}
                                </div>
                            </div>
                            <div class="form-group">     
                                {{ Form::label('officefax', 'Fax:', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-xs-8">
                                    {{ Form::text('officefax', null, array('class'=>'form-control', 'placeholder'=>'Fax','maxlength'=>'10')) }}
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
                                    <!-- <label class="control-label col-xs-3" for="extra">Extra Note:</label> -->
                                    {{ Form::label('extra', 'Extra Note:', array('class' => 'control-label col-sm-3')) }}
                                    <div class="col-xs-9">
                                       <!-- <textarea class="form-control" rows="5" id="comment" name="comment"></textarea> -->
                                       {{ Form::textarea('comment', null, array('class'=>'form-control', 'id'=> 'comment' ,'rows'=>'5')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="control-label col-xs-3" for="comm">Preferred Communication:</label>
                                <div class="col-xs-8">
                                    <!-- <label class="checkbox-inline"><input type="checkbox" name=
                                    "communication[]" value="mobile">Mobile</label> -->
                                    <label class="checkbox-inline">{{ Form::checkbox('communication[]', 'mobile') }}Mobile</label>
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
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Register
                                </button>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
