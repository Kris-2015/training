@extends('layouts.app')

@section('title', 'dashboard')

@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">
        <div class=" col-sm-12">
            <table class="table table-bordered" id="user-table">
            	<thead>
            		<tr>
            		  <th>Name</th>
            		  <th>Gender</th>
            		  <th>DOB</th>
            		  <th>Email</th>
            		  <th>Marital Status</th>
            		  <th>Image</th>
            		  <th>City</th>
            		  <th>State</th>
                  <th>Official State</th>
                  <th>Official City</th>
            		  <th>Communication</th>
            		</tr>
            	</thead>
            	<tbody>
            	@foreach($information as $userlist)
          		  <tr>
          		    <td>{{$userlist['first_name'] . ' ' . $userlist['last_name']}}</td>
          		  	<td>{{ $userlist['gender'] }}</td>
          		  	<td>{{ $userlist['dob'] }}</td>
          		  	<td>{{ $userlist['email'] }}</td>
          		  	<td>{{ $userlist['marital_status'] }}</td>
          		  	<td><img src='upload/{{$userlist['image']}}' width='45' height='45'></td>
          		  	<td>{{ $userlist['city'] }}</td>
          		  	<td>{{ $userlist['state'] }}</td>
                    <td>{{ $userlist['office_city'] }}</td>
                    <td>{{ $userlist['office_state'] }}</td>
          		  	<td>{{ $userlist['type'] }}</td>
          		  </tr>
          		@endforeach
          		</tbody>
            </table>
        </div>
    </div>
@endsection
@section('js-css')
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
@endsection