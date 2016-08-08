@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('content')
    {{ csrf_field() }}
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
                      <p id="employer"></p>
                      <p id="employment"></p>
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

@push('scripts')
<script>
$('#users-table').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu:[2,5,10],
        ajax: '{!! url("datatables/data") !!}',
        columns: [
            { data: 'first_name', name: 'first_name' },
            { data: 'email', name: 'email' },
            { data: 'dob', name:'dob'},
            { data: 'created_at', name:'created_at'},
            { data: 'updated_at', name:'updated_at'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
            { data: 'status', name: 'status', orderable:false, searchable: false}
        ]
    });
</script>
@endpush

@section('js-css')
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/js/profile_modal.js') }}"></script>
@endsection