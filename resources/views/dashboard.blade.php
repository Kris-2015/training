@extends('layouts.app')

@section('title', 'dashboard')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset_timed('css/dropzone.css') }}">
@endsection

@section('content')
<h2 align="center">Hello, {{ Auth::user()->role_id == 1 ? 'Admin' : 'User' }}</h2>
<div class="container">
    <div class="col-sm-offset-3 col-sm-5">
        <div class="panel panel-default">
            <div class="panel-body">
            <!-- Bootstrap Alert to give message -->
                @if ( session('access') )
                    <div class="alert alert-danger">
                        {{ session('access') }}
                    </div>
                @elseif ( session('success') )
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>                  
                @elseif ( session('message') )
                    <div class="alert alert-primary">
                        {{ session('message') }}
                    </div>                  
                @endif

                <ol>
                    @if(Auth::user()->role_id == 1)
                       <li><a class="btn btn-primary col-xs-4" href="{{ url('datatables') }}">User Status</a></li>
                       <br>
                       <li><a class="btn btn-info col-xs-4" href="{{ url('list') }}">User</a></li>
                       <br>
                       <li><a class="btn btn-danger col-xs-4" href="{{ url('newuser') }}">Add New User</a></li>
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

    <div class="col-sm-offset-3 col-sm-5">
      <div class="panel panel-default">
        <div class="fallback">
          <form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="upload">
            {{ csrf_field() }}
            <div class="dz-preview dz-file-preview">
              <div class="dz-details">
                <div class="dz-filename"><span data-dz-name></span></div>
                <div class="dz-size" data-dz-size></div>
                  <img data-dz-thumbnail >
                </div>
                <div class="dz-progress">
                  <span class="dz-upload" data-dz-uploadprogress>
                  </span>
                </div>
                <div class="dz-progress">
                  <span class="dz-upload" data-dz-uploadprogress></span>
                </div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
              </div>
          </form>
        </div>
      </div>
    </div>

</div>
@endsection

@section('js-css')
<script type="text/javascript" src="{{ url('/js/dropzone.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/upload.js') }}"></script>
@endsection