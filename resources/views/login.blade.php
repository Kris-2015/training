@extends('layouts.app')

@section('title', 'Login')

@section('page')
<a href="/register"><span class="glyphicon glyphicon-user"></span>Registration</a>
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

                    <!-- New Task Form -->
                     {!! Form::open(array('url' => route('dologin'), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'login')) !!}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="email_id" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" name="email_id" id="email_id" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>  
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" id="password" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-primary">
                                    Login
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
