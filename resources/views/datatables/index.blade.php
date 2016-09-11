@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('css/map.css') }}">
@endsection

@section('map')
    <li><a id="user_location" href="#"> Map </a></li>
@endsection

@section('content')
    {{ csrf_field() }}

    <input type="hidden" id="url" value="{!! url('datatables/data') !!}">

    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>DOB</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Action</th>
                <th>Status</th>
            </tr>    
        </thead>
    </table>
@endsection

@section('modal')
<!-- Profile Modal -->

<!-- making the map url in hidden input field -->
<input type="hidden" class="path" value="{{ url('map') }}">

<div id="profile" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content -->
        <div class="modal-content">
           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Profile Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-8" id="info">
                      <p id="profile_name"></p>
                      <p id="profile_dob"></p>
                      <p id="profile_gender"></p>
                      <p id="profile_prefix"></p>
                      <p id="profile_email"></p>
                      <p id="profile_github"></p>
                      <p id="marital_status"></p>
                      <p id="location"></p>
                    </div>
                    <div class="col-xs-3 profile_pic"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('github-modal')
<!-- Github Modal -->
<div id="github" class="modal fade" role="dialog">
       <div class="modal-dialog">
          <div class="modal-content gitinfo">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title git_name">Loading Github Profile  </h4>
             </div>
             <div class="modal-body git-modal">
                <div class="loader-container hidden">
                   <div id="loader"></div>
                </div>
                <div class="row github-container">
                 <div class="col-xs-5 image"></div>
                 <div class="col-xs-7">
                    <p id="git_login"> </p>
                    <p id="git_location"> </p>
                    <p id="git_repositories">  </p>
                    <p id="git_follower"> </p>
                    <p id="git_following"> </p>
                </div>
             </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('delete-modal')
<div id="delete" class="modal fade" role="dialog">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-body">
              <p>Are you sure, you want to delete user ?</p>        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default del" data-accept="yes">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
     </div>
</div>
@endsection

@section('user-map')
<div id="user_map" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> User Location </h4>
            </div>
            <div class="modal-body map-wrapper">
                <input id="pac-input" class="controls search-box" type="text" placeholder="Search">
                <div id="map_canvas"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-css')
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="//maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API') }}&libraries=places" id="google_map"></script>
<script src="{{ asset_timed('js/datatables.js') }}"></script>
<script src="{{ asset_timed('js/groupmap.js') }} " ></script>
<script src="{{ asset_timed('js/profile.js') }}"></script>
@endsection